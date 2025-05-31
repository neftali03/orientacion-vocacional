<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class LogoutController extends Controller
{
    public function __invoke()
    {
        Auth::logout();

        $returnTo = urlencode(route('index'));
        $domain = config('services.auth0.domain');
        $clientId = config('services.auth0.client_id');

        $logoutUrl = "https://{$domain}/v2/logout?client_id={$clientId}&returnTo={$returnTo}";

        return Redirect::away($logoutUrl);
    }
}
