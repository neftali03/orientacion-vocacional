<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Orientación vocacional</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body hx-ext="loading-states">
    @include('common._navbar')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-auto px-0 border-end">
                @include('common._sidebar')
            </div>
            <main class="col px-3 py-3 py-md-2">
                <h5 class="fw-bold mt-2 mb-4 text-primary-emphasis"></h5>
                @yield('content')
            </main>
        </div>
    </div>
    <script src="{{ asset('js/base.js') }}" defer></script>
    @yield('scripts')
</body>
</html>