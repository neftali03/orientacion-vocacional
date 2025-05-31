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
        $userId = session('hasura_user_id'); // o Auth::user()->id si está disponible
        if (!$userId) {
            return response()->json(['error' => 'Usuario no autenticado o sin hasura_user_id'], 401);
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
            return redirect()->route('index')->with('error', 'Error al guardar la encuesta.');
        }

        return redirect()->route('test')->with('success', 'Test de orientación vocacional.');
    }
}
