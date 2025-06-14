@extends('layouts.base')

@section('content')
<div class="">
    <div class="container text-center py-4">
        <div class="row align-items-start">
            <div class="col-12 col-md-5 order-1 mt-5 py-5 d-flex justify-content-center">
                <img src="{{ asset('LogoITCA.png') }}" style="height: 131px" alt="Imagen">
            </div>
            <div class="col-12 col-md-7 order-2 order-md-1">
                <h1 class="display-2 fw-bold">¿Estás listo</h1>
                <h4 class="display-6 fw-bold text-orange">para tu</h4>
                <h1 class="display-2 fw-bold">test vocacional?</h1>
                <p class="fs-4 py-4">
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
