<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HasuraService;
use Illuminate\Support\Facades\Log;

class SchoolsController extends Controller
{
    protected $hasura;

    public function __construct(HasuraService $hasura)
    {
        $this->hasura = $hasura;
    }

    public function create()
    {
        return view('institution.crud_institution.create');
    }

    public function storeSchools(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $createdBy = session('hasura_user_id');

        $mutation = '
            mutation insertItcaSchoolsOne($object: ItcaSchoolsInsertInput!) {
                insertItcaSchoolsOne(object: $object) {
                    id
                }
            }
        ';

        $variables = [
            'object' => [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'createdBy' => $createdBy,
                'active' => true,
            ],
        ];

        $response = $this->hasura->query($mutation, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al crear escuela en Hasura:', $response['errors']);
            return redirect()->route('institution.create')->with('error', 'Hubo un problema al crear la escuela.');
        }

        return redirect()->route('institution.list')->with('success', 'Escuela creada exitosamente.');
    }

    public function listAllSchools()
    {
        $query = '
            query {
                itcaSchools {
                    id
                    name
                    active
                }
            }
        ';

        $response = $this->hasura->query($query);

        if (isset($response['errors'])) {
            Log::error('Error al obtener escuelas (listado completo) desde Hasura:', $response['errors']);
            return redirect()->back()->with('error', 'Hubo un problema al cargar la información de las escuelas.');
        }

        $itcaSchools = $response['data']['itcaSchools'] ?? [];

        return view('institution.crud_institution.list', compact('itcaSchools'));
    }

    public function detailsSchools($id)
    {
        $query = '
        query GetSchools($id: uuid!) {
            itcaSchoolsByPk(id: $id) {
                id
                name
                description
                active
            }
        }
    ';

        $variables = ['id' => $id];

        $response = $this->hasura->query($query, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al obtener detalle de la escuela:', $response['errors']);
            return redirect()->route('institution.list')->with('error', 'Hubo un problema al cargar la información de la escuela.');
        }

        $itcaSchools = $response['data']['itcaSchoolsByPk'] ?? null;

        if (!$itcaSchools) {
            return redirect()->route('institution.list')->with('error', 'Hubo un problema al cargar la información de la escuela.');
        }

        return view('institution.crud_institution.details', compact('itcaSchools'));
    }

    public function editSchool($id)
    {
        $query = '
            query ($id: uuid!) {
                itcaSchoolsByPk(id: $id) {
                    id
                    name
                    description
                    active
                }
            }
        ';

        $variables = ['id' => $id];

        $response = $this->hasura->query($query, $variables);

        if (isset($response['errors']) || !$response['data']['itcaSchoolsByPk']) {
            Log::error('Error al obtener datos para edición:', $response['errors'] ?? []);
            return redirect()->route('institution.list')->with('error', 'Hubo un problema al cargar la información de la escuela.');
        }

        $itcaSchools = $response['data']['itcaSchoolsByPk'];

        return view('institution.crud_institution.edit', compact('itcaSchools'));
    }

    public function updateSchool(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active' => 'required',
        ]);

        $newActive = filter_var($validated['active'], FILTER_VALIDATE_BOOLEAN);

        if (!$newActive) {
            $checkQuery = '
                query ($schoolId: uuid!) {
                    careers(where: {schoolId: {_eq: $schoolId}, active: {_eq: true}}) {
                        id
                        name
                    }
                }
            ';

            $variablesCheck = ['schoolId' => $id];
            $checkResponse = $this->hasura->query($checkQuery, $variablesCheck);

            if (isset($checkResponse['errors'])) {
                Log::error('Error al verificar carreras activas antes de desactivar escuela:', $checkResponse['errors']);
                return redirect()->route('institution.edit', $id)
                    ->with('error', 'Hubo un problema al verificar dependencias de la escuela.');
            }

            $activeCareers = $checkResponse['data']['careers'] ?? [];

            if (!empty($activeCareers)) {
                Log::info('Carreras activas encontradas al intentar desactivar la escuela:', $activeCareers);
                return redirect()->route('institution.edit', $id)
                    ->with('error', 'No se puede desactivar la escuela porque tiene carreras activas asociadas.');
            }
        }

        $activeCareers = $checkResponse['data']['careers'] ?? [];

        $updatedBy = session('hasura_user_id');

        $mutation = '
            mutation updateItcaSchools($id: uuid!, $changes: ItcaSchoolsSetInput!) {
                updateItcaSchoolsByPk(pkColumns: {id: $id}, _set: $changes) {
                    id
                }
            }
        ';

        $variables = [
            'id' => $id,
            'changes' => [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'active' => $newActive,
                'updatedBy' => $updatedBy,
                'updatedAt' => now()->toIso8601String(),
            ],
        ];

        $response = $this->hasura->query($mutation, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al actualizar escuela en Hasura:', $response['errors']);
            return redirect()->route('institution.edit', $id)->with('error', 'Hubo un problema al actualizar la escuela.');
        }

        return redirect()->route('institution.details', ['id' => $id])->with('success', 'Escuela actualizada exitosamente.');
    }

}
