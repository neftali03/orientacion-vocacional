<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HasuraService;
use App\Services\DeepSeekService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DeepSeekController extends Controller
{
    protected $hasura;

    public function __construct(HasuraService $hasura)
    {
        $this->hasura = $hasura;
    }

    private function extraerJsonArray(string $texto): ?array
    {
        if (preg_match('/(\[.*\])/s', $texto, $matches)) {
            $json = $matches[1];
            $data = json_decode($json, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return null;
    }

    public function resultadoDesdeRespuestas(DeepSeekService $deepSeek)
    {
        $userId = session('hasura_user_id');

        if (!$userId) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Paso 1: Obtener puntajes por categoría
        $queryPuntajes = <<<GQL
            query ObtenerPuntajes(\$createdBy: uuid!) {
                userQuestionAnswers(
                    where: {
                        createdBy: { _eq: \$createdBy },
                        selection: { _eq: true }
                    }
                ) {
                    question {
                        skillCategoryCatalog {
                            description
                        }
                    }
                }
            }
        GQL;

        $response = $this->hasura->query($queryPuntajes, ['createdBy' => $userId]);

        $categoryScores = [];
        foreach ($response['data']['userQuestionAnswers'] as $answer) {
            $category = $answer['question']['skillCategoryCatalog']['description'] ?? 'Sin categoría';
            $categoryScores[$category] = ($categoryScores[$category] ?? 0) + 1;
        }

        // Paso 2: Obtener todas las carreras activas
        $queryCarreras = 'query { careers(where: {active: {_eq: true}}) { id name } }';
        $careersResponse = $this->hasura->query($queryCarreras);
        $careerMap = collect($careersResponse['data']['careers'])->pluck('id', 'name');
        $careerList = $careerMap->keys()->implode(", ");

        // Paso 3: Construir prompt para DeepSeek
        $puntajesTexto = collect($categoryScores)->map(fn ($score, $cat) => "- $cat: $score puntos")->implode("\n");
        $prompt = <<<TEXT
            Basado en estas puntuaciones CHASIDE:
            $puntajesTexto

            Y esta lista de carreras activas:
            $careerList

            Devuélveme las 3 carreras que más se asocian al usuario en función de las puntuaciones más altas obtenidas en CHASIDE.

            Por favor, solo responde con un arreglo JSON válido con exactamente 3 UUID (strings). Sin texto adicional, sin comentarios ni formato Markdown. 
            Ejemplo: ["uuid1", "uuid2", "uuid3"]
            No incluyas nada más.
            TEXT;

        $deepSeekResponse = $deepSeek->chat([
            ['role' => 'user', 'content' => $prompt]
        ]);

        $uuidJsonRaw = $deepSeekResponse['choices'][0]['message']['content'] ?? '';
        Log::info('Respuesta de DeepSeek:', ['raw' => $uuidJsonRaw]);

        $careerNombres = $this->extraerJsonArray($uuidJsonRaw);
        
        if (!$careerNombres) {
            Log::error('Respuesta de DeepSeek no es un JSON válido:', ['respuesta' => $uuidJsonRaw]);
            return response()->json(['error' => 'Formato inesperado en la respuesta de DeepSeek.'], 500);
        }

        $careerUuids = collect($careerNombres)
            ->map(fn ($nombre) => $careerMap->get($nombre))
            ->filter()
            ->take(3)
            ->values()
            ->all();

        if (count($careerUuids) === 0) {
            Log::error('No se pudo traducir ninguna carrera recomendada por DeepSeek.', [
                'careerNombres' => $careerNombres,
                'careerUuids' => $careerUuids,
                'careerMap_keys' => $careerMap->keys()->all(),
                'uuidJsonRaw' => $uuidJsonRaw,
            ]);

            return response()->json(['error' => 'No se pudo traducir ninguna carrera recomendada.'], 400);
        }

        if (count($careerNombres) > 3) {
            Log::warning('DeepSeek devolvió más de 3 carreras. Se tomarán solo las primeras 3.', [
                'careerNombres' => $careerNombres,
            ]);
        }

        Log::info('Puntajes CHASIDE del usuario:', $categoryScores);
        Log::info('Carreras activas disponibles:', $careerMap->toArray());
        Log::info('Prompt enviado a DeepSeek:', ['prompt' => $prompt]);

        // Paso 4: Obtener encuesta del usuario
        $querySurvey = <<<GQL
            query ObtenerEncuesta(\$userId: uuid!) {
                userSurvey(where: {userId: {_eq: \$userId}}, limit: 1, orderBy: {createdAt: DESC}) {
                    id
                }
            }
        GQL;

        $surveyResponse = $this->hasura->query($querySurvey, ['userId' => $userId]);
        $userSurveyId = $surveyResponse['data']['userSurvey'][0]['id'] ?? null;

        if ($userSurveyId) {
            $updateMutation = <<<GQL
                mutation GuardarDeepSeekResponse(\$id: uuid!, \$response: String!) {
                    updateUserSurveyByPk(pkColumns: {id: \$id}, _set: {deepseekResponse: \$response}) {
                        id
                    }
                }
            GQL;

            $this->hasura->query($updateMutation, [
                'id' => $userSurveyId,
                'response' => $uuidJsonRaw,
            ]);
        } else {
            Log::warning('No se encontró encuesta para guardar la respuesta de DeepSeek');
        }

        if (!$userSurveyId) {
            return response()->json(['error' => 'Encuesta no encontrada para el usuario.'], 404);
        }

        // Paso 5: Verificar si ya existen recomendaciones
        $checkQuery = <<<GQL
            query VerificarRecomendaciones(\$surveyId: uuid!) {
                userSurveyRecommendations(where: {userSurveyId: {_eq: \$surveyId}}) {
                    id
                    career {
                        id
                        name
                        description
                        portalUrl
                        itcaSchool {
                            name
                        }
                    }
                }
            }
        GQL;

        $existingRecs = $this->hasura->query($checkQuery, ['surveyId' => $userSurveyId]);
        $recs = $existingRecs['data']['userSurveyRecommendations'] ?? [];

        if (count($recs) > 0) {
            $carreras = collect($recs)->pluck('career')->all();
        } else {
            // Paso 6: Insertar recomendaciones
            $mutation = <<<GQL
                mutation InsertRecommendations(\$objects: [UserSurveyRecommendationsInsertInput!]!) {
                    insertUserSurveyRecommendations(objects: \$objects) {
                        returning {
                            career {
                                id
                                name
                                description
                                portalUrl
                                itcaSchool {
                                    name
                                }
                            }
                        }
                    }
                }
            GQL;

            $objects = collect($careerUuids)->map(fn ($uuid) => [
                'userSurveyId' => $userSurveyId,
                'careerId' => $uuid,
                'active' => true,
                'createdBy' => $userId,
            ])->toArray();

            $insertResponse = $this->hasura->query($mutation, ['objects' => $objects]);

            if (isset($insertResponse['errors'])) {
                Log::error('Error al insertar recomendaciones en Hasura:', $insertResponse['errors']);
                return response()->json(['error' => 'Error al guardar recomendaciones.'], 500);
            }

            $carreras = collect($insertResponse['data']['insertUserSurveyRecommendations']['returning'])
                ->pluck('career')
                ->all();
        }

        return view('deepseek.resultado', [
            'careers' => $carreras,
        ]);
    }

    public function enviarResultados(Request $request)
    {
        $userId = session('hasura_user_id');

        if (!$userId) {
            return back()->withErrors(['error' => 'Sesión inválida.']);
        }

        $queryEmail = <<<GQL
            query GetEmail(\$id: uuid!) {
                usersByPk(id: \$id) {
                    email
                }
            }
        GQL;
        $respEmail = $this->hasura->query($queryEmail, ['id' => $userId]);
        $contactEmail = $respEmail['data']['usersByPk']['email'] ?? null;
        
        if (!$contactEmail) {
            return back()->withErrors(['error' => 'No se encontró el correo del usuario.']);
        }

        // 2. Obtener ID de encuesta más reciente
        $queryEncuesta = <<<GQL
            query ObtenerEncuesta(\$userId: uuid!) {
                userSurvey(where: {userId: {_eq: \$userId}}, limit: 1, orderBy: {createdAt: DESC}) {
                    id
                }
            }
        GQL;
        $respEncuesta = $this->hasura->query($queryEncuesta, ['userId' => $userId]);
        $userSurveyId = $respEncuesta['data']['userSurvey'][0]['id'] ?? null;

        if (!$userSurveyId) {
            return back()->withErrors(['error' => 'Encuesta no encontrada.']);
        }

        // 3. Obtener recomendaciones
        $queryRecs = <<<GQL
            query ObtenerRecs(\$surveyId: uuid!) {
                userSurveyRecommendations(where: {userSurveyId: {_eq: \$surveyId}}) {
                    career {
                        name
                        description
                        portalUrl
                    }
                }
            }
        GQL;

        $respRecs = $this->hasura->query($queryRecs, ['surveyId' => $userSurveyId]);
        $careers = collect($respRecs['data']['userSurveyRecommendations'])->pluck('career')->all();

        if (empty($careers)) {
            return back()->withErrors(['error' => 'No hay recomendaciones para esta encuesta.']);
        }

        // 4. Enviar correo a dos destinatarios: usuario y copia
        $copiaCorreo = env('VOCATIONAL_EMAIL_COPY');

        Mail::send('emails.recomendaciones', ['careers' => $careers], function ($message) use ($contactEmail, $copiaCorreo) {
            $message->to($contactEmail)
                    ->cc($copiaCorreo)
                    ->subject('Tus recomendaciones de carrera');
        });

         // 5. Validar si ya se envió anteriormente
        $queryCheck = <<<GQL
            query CheckExistingMail(\$surveyId: uuid!) {
                userSurveyMail(where: {userSurveyId: {_eq: \$surveyId}}, limit: 1) {
                    id
                    sendTries
                }
            }
        GQL;

        $respCheck = $this->hasura->query($queryCheck, ['surveyId' => $userSurveyId]);
        $existingMail = $respCheck['data']['userSurveyMail'][0] ?? null;

        if ($existingMail) {
            // Ya existe: actualizar sendTries
            $updateMutation = <<<GQL
                mutation UpdateMailLog(\$id: uuid!, \$tries: Int!) {
                    updateUserSurveyMailByPk(pkColumns: {id: \$id}, _set: {sendTries: \$tries}) {
                        id
                        sendTries
                    }
                }
            GQL;

            $updateResponse = $this->hasura->query($updateMutation, [
                'id' => $existingMail['id'],
                'tries' => $existingMail['sendTries'] + 1,
            ]);

            Log::info('Actualizando intento de envío', ['response' => $updateResponse]);

        } else {
            // No existe: insertar nuevo
            $insertMutation = <<<GQL
                mutation InsertMailLog(\$obj: UserSurveyMailInsertInput!) {
                    insertUserSurveyMailOne(object: \$obj) {
                        id
                    }
                }
            GQL;

            $payload = [
                'userSurveyId' => $userSurveyId,
                'sendTries' => 1,
                'mailSentStatus' => 'enviado',
                'contactEmail' => $contactEmail,
                'active' => true,
                'createdBy' => $userId,
            ];

            Log::info('Enviando log de correo a Hasura', ['payload' => $payload]);
            $insertResponse = $this->hasura->query($insertMutation, ['obj' => $payload]);
            Log::info('Respuesta de Hasura al insertar correo', ['response' => $insertResponse]);
        }

        return back()->with('success', 'Correo enviado correctamente.');
    }
}
