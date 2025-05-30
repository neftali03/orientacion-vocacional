<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HasuraService;
use Illuminate\Support\Facades\Log;

class CareerController extends Controller
{
    protected $hasura;

    public function __construct(HasuraService $hasura)
    {
        $this->hasura = $hasura;
    }
    public function showCareers(Request $request)
    {
        $search = $request->input('search');

        $query = '
            query {
                careers(where: {active: {_eq: true}}) {
                    id
                    name
                    description
                    itcaSchool {
                        id
                        name
                    }
                }
            }
        ';

        $response = $this->hasura->query($query);

        if (isset($response['errors'])) {
            Log::error('Error al obtener carreras desde Hasura:', $response['errors']);
            return response()->json(['success' => false, 'errors' => $response['errors']], 500);
        }

        $careers = $response['data']['careers'] ?? [];

        if ($search) {
            $careers = collect($careers)->filter(function ($career) use ($search) {
                return str_contains(strtolower($career['name']), strtolower($search)) ||
                    str_contains(strtolower($career['itcaSchool']['name'] ?? ''), strtolower($search));
            })->values()->all();
        }

        $groupedCareers = collect($careers)->groupBy(fn ($career) => $career['itcaSchool']['name'] ?? 'No asignada');

        return view('degree.degree', compact('groupedCareers', 'search'));
    }
    public function create()
    {
        $query = '
            query {
                itcaSchools {
                    id
                    name
                }
            }
        ';

        $response = $this->hasura->query($query);

        if (isset($response['errors'])) {
            Log::error('Error al obtener escuelas desde Hasura:', $response['errors']);
            return redirect()->route('degree.list')->with('error', 'No se pudieron cargar las escuelas.');
        }

        $schools = $response['data']['itcaSchools'] ?? [];

        return view('degree.crud_degree.create', compact('schools'));
    }
    public function storeCareer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'school_id' => 'required|uuid',
        ]);

        $createdBy = session('hasura_user_id');

        $mutation = '
            mutation insertCareersOne($object: CareersInsertInput!) {
                insertCareersOne(object: $object) {
                    id
                }
            }
        ';

        $variables = [
            'object' => [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'schoolId' => $validated['school_id'],
                'createdBy' => $createdBy,
                'active' => true,
            ],
        ];

        $response = $this->hasura->query($mutation, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al crear carrera en Hasura:', $response['errors']);
            return redirect()->route('degree.create')->with('error', 'Hubo un problema al crear la carrera.');
        }

        return redirect()->route('degree.list')->with('success', 'Carrera creada exitosamente.');
    }
    public function listAllCareers()
    {
        $query = '
            query {
                careers(where: {active: {_eq: true}}) {
                    id
                    name
                    active
                    itcaSchool {
                        id
                        name
                    }
                }
            }
        ';

        $response = $this->hasura->query($query);

        if (isset($response['errors'])) {
            Log::error('Error al obtener carreras (listado completo) desde Hasura:', $response['errors']);
            return redirect()->back()->with('error', 'No se pudieron cargar las carreras.');
        }

        $careers = $response['data']['careers'] ?? [];

        return view('degree.crud_degree.list', compact('careers'));
    }
    public function detailsCareer($id)
    {
        $query = '
        query GetCareer($id: uuid!) {
            careersByPk(id: $id) {
                id
                name
                description
                active
                itcaSchool {
                    id
                    name
                }
            }
        }
    ';

        $variables = ['id' => $id];

        $response = $this->hasura->query($query, $variables);

        if (isset($response['errors'])) {
            Log::error('Error al obtener detalle de la carrera:', $response['errors']);
            return redirect()->route('degree.list')->with('error', 'No se pudo cargar la información de la carrera.');
        }

        $career = $response['data']['careersByPk'] ?? null;

        if (!$career) {
            return redirect()->route('degree.list')->with('error', 'Carrera no encontrada.');
        }

        return view('degree.crud_degree.details', compact('career'));
    }
}
