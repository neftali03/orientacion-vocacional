@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
    ];
    $pageTitle = 'Carreras';
@endphp

@section('content')
    <div class="d-flex flex-column gap-1">
        <h3 class="fw-bold text-danger-emphasis mb-0">Carreras</h3>
        <p class="mb-0">
           Bienvenido a la sección de carreras, donde podrás explorar las distintas opciones que ofrece ITCA-FEPADE.
        </p>
    </div>
@endsection
