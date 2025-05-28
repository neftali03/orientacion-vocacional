@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
    ];
    $pageTitle = 'Resultados';
@endphp

@section('content')
<div class="d-flex flex-column gap-1">
    <h3 class="fw-bold text-danger-emphasis mb-0">Resultados</h3>
    <p class="mb-0">
        Muy bien, aspirante. Las carreras que más se aplican a tus aptitudes e intereses son las siguientes:
    </p>
</div>
<div>
    <ul class="list-group mt-4">
        @foreach ($puntajes as $categoria => $puntaje)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $categoria }}
                <p class="mb-0">{{ $puntaje }}</p>
            </li>
        @endforeach
    </ul>
</div>
@endsection