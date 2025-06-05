<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeepSeekService
{
    protected $endpoint;
    protected $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.deepseek.endpoint');
        $this->apiKey = config('services.deepseek.key');
    }

    public function chat($messages)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout(60) // <- Aquí se aumenta el timeout a 60 segundos
            ->post($this->endpoint, [
                'model' => 'deepseek-chat',
                'messages' => $messages,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            // Si falla pero responde con error HTTP
            \Log::error('DeepSeek responded with error: ' . $response->body());

            return [
                'choices' => [
                    ['message' => ['content' => 'Error de DeepSeek: respuesta inválida.']]
                ]
            ];

        } catch (\Exception $e) {
            // Si hay un timeout u otra excepción
            \Log::error("DeepSeek exception: " . $e->getMessage());

            return [
                'choices' => [
                    ['message' => ['content' => 'Error de conexión con DeepSeek.']]
                ]
            ];
        }
    }
}
