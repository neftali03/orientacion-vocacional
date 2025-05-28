<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HasuraService
{
    protected $endpoint;
    protected $adminSecret;

    public function __construct()
    {
        $this->endpoint = config('services.hasura.endpoint');
        $this->adminSecret = config('services.hasura.admin_secret');
    }

    public function query(string $query, array $variables = null): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Hasura-Admin-Secret' => $this->adminSecret,
        ])->post($this->endpoint, [
            'query' => $query,
            'variables' => $variables ?? new \stdClass(),
        ]);

        return $response->json();
    }
}
