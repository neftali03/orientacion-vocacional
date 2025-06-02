<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeepSeekService;

class DeepSeekController extends Controller
{
    public function test(DeepSeekService $deepSeek)
    {
        $messages = [
            ['role' => 'user', 'content' => 'Hola']
        ];

        $respuesta = $deepSeek->chat($messages);

        $respuestaTexto = $respuesta['choices'][0]['message']['content'] ?? 'No se obtuvo respuesta';

        return view('deepseek.resultado', [
            'respuesta' => $respuestaTexto,
        ]);
    }
}
