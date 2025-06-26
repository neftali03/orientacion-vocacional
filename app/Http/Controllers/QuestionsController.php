<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function questions()
    {
        $questions_answer = [
            [
                "question" => "¿Cómo inicio la evaluación?",
                "answer" => "Para comenzar la evaluación de orientación vocacional, haz clic en el botón 'Iniciar' que aparece en la pantalla principal.",
            ],
            [
                "question" => "¿Puedo modificar mis respuestas?",
                "answer" => "No, las respuestas no pueden modificarse. Si cometiste un error, por favor contacta al administrador enviando un correo a: administrador@itca.edu.sv.",
            ],
            [
                "question" => "¿Qué pasa si cierro sesión durante una evaluación?",
                "answer" => "Si cierras sesión durante la evaluación, deberás contactar al administrador para que reinicie la prueba y puedas repetirla.",
            ],
            [
                "question" => "¿La evaluación vocacional tiene límite de tiempo?",
                "answer" => "No, la evaluación vocacional no tiene un límite de tiempo. Sin embargo, te recomendamos realizarla en un ambiente tranquilo y sin distracciones para que puedas concentrarte mejor.",
            ],
            [
                "question" => "¿A quién debo contactar si tengo algún problema?",
                "answer" => "En caso de presentar algún problema, por favor contacta al administrador al correo: administrador@itca.edu.sv.",
            ],
            [
                "question" => "¿A dónde se enviarán mis resultados?",
                "answer" => "Tus resultados serán enviados a tu correo electrónico.",
            ],
            [
                "question" => "¿Debo pagar por utilizar este sitio web?",
                "answer" => "No, el uso de esta aplicación es completamente gratuito.",
            ],
            [
                "question" => "¿Las respuestas son de libre expresión?",
                "answer" => "No, el sitio web está diseñado para que solo puedas responder con 'Sí' o 'No'.",
            ],
            [
                "question" => "¿Al terminar mi evaluación puedo volver a hacerla?",
                "answer" => "No. Si ya has realizado la evaluación y deseas volver a hacerla, debes contactar al administrador para analizar tu caso.",
            ],
        ];
        return view('questions.questions', compact('questions_answer'));
    }
}
