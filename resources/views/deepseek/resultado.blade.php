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
    <div class="text-end my-4">
        <form method="POST" action="{{ route('deepseek.enviarResultados') }}">
            @csrf
            <button id="btnEnviarResultado" type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-envelope me-1"></i> Enviar resultado
            </button>
        </form>
    </div>
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
<div id="custom-loading-toast" class="toast-container position-fixed bottom-0 end-0 p-3 d-none" style="z-index: 1100;">
    <div id="toast-inner" class="toast text-white" style="background-color: #8B5CF6;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header text-white" style="background-color: #7C3AED;">
            <div class="bg-white rounded p-1 me-2 d-flex align-items-center" style="width: 32px; height: 32px;">
                <svg viewBox="0 0 64 64" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="10" y="20" width="44" height="32" rx="8" fill="#EDE9FE"/>
                    <circle cx="22" cy="36" r="4" fill="#8B5CF6"/>
                    <circle cx="42" cy="36" r="4" fill="#8B5CF6"/>
                    <path d="M28 44h8" stroke="#6D28D9" stroke-width="2" stroke-linecap="round"/>
                    <path d="M32 10v10" stroke="#4B5563" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <strong class="me-auto">Cargando</strong>
        </div>
        <div class="toast-body">
            <div class="spinner-border spinner-border-sm text-light me-2" role="status"></div>
            <span>Espere por favor...</span>
        </div>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toastContainer = document.getElementById('custom-loading-toast');
            const btnEnviar = document.getElementById('btnEnviarResultado');

            btnEnviar.addEventListener('click', () => {
                toastContainer.classList.remove('d-none');

                // Ocultar después de 10 segundos
                setTimeout(() => {
                    toastContainer.classList.add('d-none');
                }, 10000);
            });
        });
    </script> 
@endsection