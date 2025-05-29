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

    <form method="GET" action="{{ route('degree') }}" class="mb-4 d-flex justify-content-center py-5">
        <div class="input-group input-group-md" style="max-width: 350px;">
            <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
        </div>
    </form>

    <div class="container-fluid py-1">
        <div class="row">
            @foreach($groupedCareers as $schoolName => $careers)
                <div class="mb-5">
                    <h6 class="fw-bold text-danger-emphasis mb-3">✓ {{ $schoolName }}</h6>
                    <div class="row">
                        @foreach($careers as $career)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6 class="fw-bold">{{ $career['name'] }}</h6>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <p>{{ $career['description'] ?? 'Sin descripción' }}</p>
                                        <figcaption class="blockquote-footer mt-auto">
                                            <cite title="Source Title">{{ $career['itcaSchool']['name'] ?? 'No asignada' }}</cite>
                                        </figcaption>
                                        <a href="#" class="btn btn-orange mt-auto">
                                            <i class="bi bi-eye"></i> Ver carrera
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
