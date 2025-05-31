@extends('layouts.base')

@section('content')
    <div class="position-fixed top-0 start-0 p-3" style="z-index: 1100; max-width: 400px;">
        @if(session('success'))
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success text-white">
                        <i class="bi bi-check-circle me-2"></i> 
                        <strong class="me-auto">Orientación vocacional</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-danger text-white">
                        <i class="bi bi-x-circle me-2"></i> 
                        <strong class="me-auto">Orientación vocacional</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="py-5">
        <div class="container text-center py-5">
            <div class="row align-items-start">
                <div class="col-12 col-md-6 order-1 mt-5 py-5 d-flex justify-content-center">
                    <img src="{{ asset('LogoITCA.png') }}" style="height: 135px" alt="Imagen">
                </div>
                <div class="col-12 col-md-6 order-2 order-md-1">
                    <h1 class="display-2 fw-bold">¿Estás listo</h1>
                    <h4 class="display-6 fw-bold">para tu</h4>
                    <h1 class="display-2 fw-bold">test vocacional?</h1>
                    <p class="fs-4 py-5">
                        ¿Tienes dudas sobre qué carrera estudiar? ¡No te preocupes!
                        Realiza nuestro test vocacional y te ayudaremos a orientarte
                        para elegir la carrera ideal para ti.
                    </p>
                    <form method="POST" action="{{ route('user-survey.store') }}">
                        @csrf
                        <input type="hidden" name="email_approval" value="true">
                        <button type="submit" class="btn btn-orange btn-lg px-5 py-3 fw-bold">
                            Iniciar
                        </button>
                        <p class="text-secondary small fst-italic mt-1">
                            Al hacer clic en "Iniciar", aceptas que podamos enviarte los resultados de la evaluación a tu correo electrónico.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
