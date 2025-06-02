<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HasuraService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserSurveyController extends Controller
{
    protected $hasura;

    public function __construct(HasuraService $hasura)
    {
        $this->hasura = $hasura;
    }

    public function store(Request $request)
    {
        $userId = session('hasura_user_id');
        if (!$userId) {
            return response()->json(['error' => 'Usuario no autenticado o sin hasura_user_id'], 401);
        }

        $query = '
            query CheckExistingSurvey($userId: uuid!) {
                inactive: userSurvey(where: {userId: {_eq: $userId}, active: {_eq: false}}, limit: 1) {
                    id
                }
                active: userSurvey(where: {userId: {_eq: $userId}, active: {_eq: true}}, limit: 1) {
                    id
                }
            }
        ';

        $variables = ['userId' => $userId];
        $checkResponse = $this->hasura->query($query, $variables);

        if (isset($checkResponse['errors'])) {
            Log::error('Error al verificar encuestas previas:', $checkResponse['errors']);
            return redirect()->route('index')->with('error', 'Error al verificar el estado de la encuesta. Contacte al administrador.');
        }

        $inactiveSurvey = $checkResponse['data']['inactive'][0] ?? null;
        $activeSurvey = $checkResponse['data']['active'][0] ?? null;

        if ($inactiveSurvey) {
            return redirect()->route('index')->with('info', 'Evaluación finalizada. Contacta al administrador si deseas repetirla.');
        }
        if ($activeSurvey) {
            return redirect()->route('index')->with('error', 'Debe contactar con el administrador para que le reinicie la evaluación.');
        }

        $mutation = '
            mutation InsertUserSurvey($object: UserSurveyInsertInput!) {
                insertUserSurveyOne(object: $object) {
                    id
                    userId
                    intakeDate
                    emailApproval
                    active
                    createdAt
                }
            }
        ';

        $variables = [
            'object' => [
                'userId' => $userId,
                'intakeDate' => now()->toDateString(),
                'emailApproval' => $request->input('email_approval', false),
                'active' => true,
                'createdBy' => $userId,
                'createdAt' => now()->toISOString(),
            ],
        ];

        $response = $this->hasura->query($mutation, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al insertar encuesta en Hasura:', $response['errors']);
            return redirect()->route('index')->with('error', 'Ha ocurrido un error inesperado, por favor contacte al administrador.');
        }

        $surveyId = $response['data']['insertUserSurveyOne']['id'];
        session(['survey_id' => $surveyId]);

        return redirect()->route('test')->with('success', 'Bienvenido a tu evaluación de orientación vocacional.');
    }
    public function deactivateSurvey()
    {
        $surveyId = session('survey_id');
        if (!$surveyId) {
            return response()->json(['error' => 'No hay encuesta activa'], 400);
        }

        $mutation = '
            mutation DeactivateSurvey($id: uuid!) {
                updateUserSurveyByPk(pkColumns: {id: $id}, _set: {active: false}) {
                    id
                    active
                }
            }
        ';

        $variables = ['id' => $surveyId];

        $response = $this->hasura->query($mutation, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al desactivar encuesta en Hasura:', $response['errors']);
            return response()->json(['error' => 'No se pudo desactivar la encuesta'], 500);
        }

        return response()->json(['success' => true]);
    }
}
