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
    public function showCareers()
    {
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

        return view('degree.degree', compact('careers'));
    }
}
