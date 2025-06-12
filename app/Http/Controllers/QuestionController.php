<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HasuraService;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    protected $hasura;

    public function __construct(HasuraService $hasura)
    {
        $this->hasura = $hasura;
    }
    public function create()
    {
        $query = '
            query {
                skillCategoryCatalog {
                    id
                    description
                }
            }
        ';

        $response = $this->hasura->query($query);

        if (isset($response['errors'])) {
            Log::error('Error al obtener los catalogos de categorías por habilidades desde Hasura:', $response['errors']);
            return redirect()->route('questions.list')->with('error', 'Hubo un problema al cargar las escuelas.');
        }

        $skillCategory = $response['data']['skillCategoryCatalog'] ?? [];

        return view('questions.crud_questions.create', compact('skillCategory'));
    }

    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|uuid',
            'description' => 'nullable|string',
            'question_number' => 'required|integer',
        ]);

        $createdBy = session('hasura_user_id');

        $mutation = '
            mutation insertQuestionsOne($object: QuestionsInsertInput!) {
                insertQuestionsOne(object: $object) {
                    id
                }
            }
        ';
        $variables = [
            'object' => [
                'description' => $validated['description'] ?? null,
                'categoryId' => $validated['category_id'],
                'questionNumber' => $validated['question_number'],
                'createdBy' => $createdBy,
                'active' => true,
            ],
        ];

        $response = $this->hasura->query($mutation, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al crear pregunta en Hasura:', $response['errors']);
            return redirect()->route('questions.create')->with('error', 'Hubo un problema al crear la pregunta.');
        }
        return redirect()->route('questions.list')->with('success', 'Pregunta creada exitosamente.');
    }

    public function listAllQuestions() 
    {
        $query = '
            query {
                questions {
                    id
                    description
                    active
                    skillCategoryCatalog {
                        id
                        description
                    }
                }
            }
        ';

        $response = $this->hasura->query($query);

        if (isset($response['errors'])) {
            Log::error('Error al obtener preguntas (listado completo) desde Hasura:', $response['errors']);
            return redirect()->back()->with('error', 'Hubo un problema al cargar la información de las preguntas.');
        }

        $questions = $response['data']['questions'] ?? [];

        return view('questions.crud_questions.list', compact('questions'));
    }

    public function detailQuestion($id)
    {
        $query = '
            query GetQuestion($id: uuid!){
                questionsByPk(id: $id) {
                    id
                    questionNumber
                    description
                    active
                    skillCategoryCatalog {
                        id
                        description
                    }
                }
            }
        ';

            $variables = ['id' => $id];
            $response = $this->hasura->query($query, $variables);

            if (isset($response['errors'])) {
                Log::error('Error al obtener detalle de la pregunta:', $response['errors']);
                return redirect()->route('questions.list')->with('error', 'Hubo un problema al cargar la información de la pregunta.');
            }

            $question = $response['data']['questionsByPk'] ?? null;

            if (!$question) {
                return redirect()->route('questions.list')->with('error', 'Hubo un problema al cargar la información de la pregunta.');
            }

            return view('questions.crud_questions.details', compact('question'));
    }

    public function editQuestion($id)
    {
        $query = '
            query ($id: uuid!) {
                questionsByPk(id: $id) {
                    id
                    questionNumber
                    description
                    categoryId
                    active
                }
                skillCategoryCatalog {
                    id
                    description
                }
            }
        ';

        $variables = ['id' => $id];

        $response = $this->hasura->query($query, $variables);

        if (isset($response['errors']) || !$response['data']['questionsByPk']) {
            Log::error('Error al obtener datos para edición:', $response['errors'] ?? []);
            return redirect()->route('questions.list')->with('error', 'Hubo un problema al cargar la información de la pregunta.');
        }

        $question = $response['data']['questionsByPk'];
        $skillCategoryCatalog = $response['data']['skillCategoryCatalog'];

        return view('questions.crud_questions.edit', compact('question', 'skillCategoryCatalog'));
    }

    public function updateQuestion(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|uuid',
            'description' => 'nullable|string',
            'question_number' => 'required|integer',
            'active' => 'required|boolean',
        ]);

        $updatedBy = session('hasura_user_id');

        $mutation = '
            mutation updateQuestions($id: uuid!, $changes: QuestionsSetInput!) {
                updateQuestionsByPk(pkColumns: {id: $id}, _set: $changes) {
                    id
                }
            }
        ';

        $variables = [
            'id' => $id,
            'changes' => [
                'description' => $validated['description'] ?? null,
                'categoryId' => $validated['category_id'],
                'questionNumber' => $validated['question_number'],
                'active' => (bool) $validated['active'],
                'updatedBy' => $updatedBy,
                'updatedAt' => now()->toIso8601String(),
            ],
        ];

        $response = $this->hasura->query($mutation, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al actualizar pregunta en Hasura:', $response['errors']);
            return redirect()->route('questions.edit', $id)->with('error', 'Hubo un problema al actualizar la pregunta.');
        }

        return redirect()->route('questions.details', ['id' => $id])->with('success', 'Pregunta actualizada exitosamente.');
    }

}
