@extends('layouts.base')

@section('content')
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
                    <a href="{{ route('test') }}" class="btn btn-orange btn-lg px-5 py-3 fw-bold">Iniciar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
