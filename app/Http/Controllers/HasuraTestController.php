<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HasuraService;
use Illuminate\Support\Facades\Log;

class HasuraTestController extends Controller
{
    protected $hasura;

    public function __construct(HasuraService $hasura)
    {
        $this->hasura = $hasura;
    }

    public function showQuestions()
    {
        $query = '
            query {
                questions {
                    id
                    description
                }
            }
        ';

        $response = $this->hasura->query($query);

        $questions = $response['data']['questions'] ?? [];
        return view('test.test', compact('questions'));
    }
    public function saveAnswer(Request $request)
    {
        $questionId = $request->input('question_id');
        $selection = $request->input('selection');
        $surveyId = '00000000-0000-0000-0000-000000000001';
        $userId = '00000000-0000-0000-0000-000000000001';

        $mutation = '
            mutation InsertAnswer($input: UserQuestionAnswersInsertInput!) {
                insertUserQuestionAnswersOne(object: $input) {
                    id
                }
            }
        ';

        $variables = [
            'input' => [
                'questionId' => $questionId,
                //'surveyId' => $surveyId,
                'selection' => $selection,
                'createdBy' => $userId,
                // Opcional: 'createdAt' => now()->toIso8601String()
            ]
        ];

        $response = $this->hasura->query($mutation, $variables);

        if (isset($response['errors'])) {
            Log::error('Hasura mutation error:', $response['errors']);
            return response()->json(['success' => false, 'errors' => $response['errors']], 500);
        }
         Log::info('Entrando a saveAnswer', $request->all());

        return response()->json(['success' => true, 'data' => $response['data']]);
    }
}
