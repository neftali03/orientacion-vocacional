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
<div class="container-fluid py-5">
    <div class="row">
        @foreach ($careers as $career)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="fw-bold">{{ $career['name'] }}</h6>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="text-justify">{{ $career['description'] ?? 'Sin descripción' }}</p>
                        <figcaption class="blockquote-footer mt-auto">
                            <cite title="Source Title">{{ $career['itcaSchool']['name'] ?? 'No asignada' }}</cite>
                        </figcaption>
                        @if (!empty($career['portalUrl']))
                            <a href="{{ $career['portalUrl'] }}" class="btn btn-orange btn-sm text-decoration-none" target="_blank">
                                <i class="bi bi-eye me-2"></i>Ver carrera
                            </a>
                        @else    
                            <div class="btn btn-orange btn-sm text-decoration-none">
                                <i class="bi bi-eye me-2"></i>Sin enlace
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>    
</div>
@endsection