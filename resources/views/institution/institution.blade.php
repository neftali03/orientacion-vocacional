@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
    ];
    $pageTitle = 'Instituciones';
@endphp

@section('content')
    <div class="d-flex flex-column gap-1">
        <h3 class="fw-bold text-danger-emphasis mb-0">¿Quiénes somos?</h3>
        <p class="mb-0">
        Description.
        </p>
    </div>

    <div class="d-flex flex-column gap-1">
        <h3 class="fw-bold text-danger-emphasis mb-0">Contacto</h3>
        <p class="mb-0">
        Description.
        </p>
    </div>
@endsection