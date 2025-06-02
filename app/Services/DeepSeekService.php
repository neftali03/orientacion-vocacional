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
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->endpoint, [
            'model' => 'deepseek-chat',
            'messages' => $messages,
            'temperature' => 0.7,
        ]);


        dd([
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json(),
        ]);
    }
}
