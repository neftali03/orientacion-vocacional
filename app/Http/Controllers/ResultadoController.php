<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ResultadoController extends Controller
{
    public function mostrarResultados(Request $request)
    {
        // 🔹 1. Obtener userId desde Laravel (enviado por JS)
        $userId = $request->input('userId');

        // 🔹 2. Validar si viene userId
        if (!$userId) {
            return response('Falta userId', 400);
        }

        // 🔹 3. Llamar a Rasa para obtener puntajes por área
        $response = Http::post('http://localhost:5055/analizar-respuestas', [
            'userId' => $userId,
        ]);


        $puntajes = $response->successful()
            ? $response->json()['puntajes']
            : ['error' => 'No se pudo obtener puntuaciones'];

        // 🔹 4. Enviar puntajes a la vista
        return view('saludo', [
            'puntajes' => $puntajes,
        ]);
    }
}
