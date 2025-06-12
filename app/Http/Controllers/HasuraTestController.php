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
                questions(where: { active: { _eq: true } }) {
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
        $surveyId = session('survey_id');
        $userId = session('hasura_user_id');

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
                'surveyId' => $surveyId,
                'selection' => $selection,
                'createdBy' => $userId,
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
