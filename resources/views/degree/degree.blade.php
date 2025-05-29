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

    
    <div class="container-fluid py-5">
        <div class="row">
            @foreach($careers as $career)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $career['name'] }}</h5>
                            <p class="card-text flex-grow-1">{{ $career['description'] ?? 'Sin descripción' }}</p>
                            <figcaption class="blockquote-footer mt-auto">
                                <cite title="Source Title">{{ $career['itcaSchool']['name'] ?? 'No asignada' }}</cite>
                            </figcaption>
                            <a href="#" class="btn btn-orange mt-2">
                                <i class="bi bi-eye"></i> Ver carrera
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    

@endsection
