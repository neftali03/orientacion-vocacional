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
                "answer" => "Haz clic en el botón 'Iniciar'; de esa forma podrás comenzar tu orientación vocacional.",
            ],
            [
                "question" => "¿Puedo modificar mis respuestas?",
                "answer" => "No. En caso de error, deberás contactar al administrador.",
            ],
            [
                "question" => "¿Qué pasa si cierro sesión durante una evaluación?",
                "answer" => "Deberás comenzar de nuevo tu evaluación vocacional.",
            ],
            [
                "question" => "¿La evaluación vocacional tiene límite de tiempo?",
                "answer" => "No, la evaluación vocacional no tiene límite de tiempo. Sin embargo, te recomendamos realizarla en un ambiente tranquilo y sin distracciones.",
            ],
            [
                "question" => "¿A quién debo contactar si tengo algún problema?",
                "answer" => "Si tienes algún problema, puedes contactar al administrador escribiendo a: correoAdmin@itca.edu.sv.",
            ],
            [
                "question" => "¿Por qué una contraseña temporal?",
                "answer" => "Para garantizar la privacidad de los usuarios que utilizan este sitio web.",
            ],
            [
                "question" => "¿Adónde se me enviarán mis resultados?",
                "answer" => "Tus resultados serán enviados a tu correo electrónico.",
            ],
            [
                "question" => "¿Debo pagar por utilizar este sitio web?",
                "answer" => "No, el uso de esta aplicación es totalmente gratuito.",
            ],
            [
                "question" => "¿Las respuestas son de libre expresión?",
                "answer" => "No, el sitio web está programado para que solo puedas contestar 'Sí' o 'No'.",
            ],
        ];
        return view('questions.questions', compact('questions_answer'));
    }
}
