<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HasuraService;
use App\Services\DeepSeekService;
use Illuminate\Support\Facades\Log;

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

    Por favor, solo responde con un arreglo JSON válido con exactamente 3 UUID (strings) de las carreras recomendadas, sin texto adicional, sin comentarios ni formato Markdown. 
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
            ->values()
            ->all();

        if (count($careerUuids) !== 3) {
            return response()->json(['error' => 'No se pudieron traducir todas las carreras.'], 400);
        }

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

}
