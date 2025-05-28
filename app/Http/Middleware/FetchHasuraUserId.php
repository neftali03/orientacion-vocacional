<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\HasuraService;

class FetchHasuraUserId
{
    protected $hasura;

    public function __construct(HasuraService $hasura)
    {
        $this->hasura = $hasura;
    }

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $email = $user?->getAttribute('email');

        if ($email) {
            $query = '
                query GetUserIdByEmail($email: String!) {
                    users(where: {email: {_eq: $email}}) {
                        id
                        firstName
                    }
                }
            ';
            $variables = ['email' => $email];
            $response = $this->hasura->query($query, $variables);

            if (isset($response['data']['users'][0]['id'])) {
                session([
                    'hasura_user_id' => $response['data']['users'][0]['id'],
                    'hasura_user_first_name' => $response['data']['users'][0]['firstName'],
                ]);
            }else {
                Log::warning("Usuario con email $email no encontrado en Hasura.");
            }
        }
        return $next($request);
    }
}
