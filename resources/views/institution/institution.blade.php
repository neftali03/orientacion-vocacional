@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'ITCA-FEPADE', 'url' => route('index')],
    ];
    $pageTitle = 'Institución';
@endphp

@section('content')
    <div class="d-flex flex-column gap-1">
        <h3 class="fw-bold text-danger-emphasis mb-0">Institución</h3>
        <p class="mb-0">
           Bienvenido a la sección de la institución, donde encontrarás información importante sobre nosotros.
        </p>
    </div>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 text-center">
                <div class="d-flex flex-column gap-1 py-4">
                    <h3 class="fw-bold text-danger-emphasis mb-0">¿Quiénes Somos?</h3>
                </div>
                <p>
                    La Escuela Especializada en Ingeniería ITCA-FEPADE cuenta con una reconocida trayectoria académica, camino sustentado por el esfuerzo y la visión que dieron paso a la concreción de su objetivo de fundación: impulsar la capacitación del recurso humano de El Salvador. 
                </p>
                <p>
                    Estamos comprometidos con la calidad académica, la empresarialidad y la pertinencia de nuestra oferta educativa, por ello, hemos desarrollado un modelo educativo que se caracteriza por la constante innovación del sistema de enseñanza-aprendizaje, en la actualización de la tecnología y la formación del personal docente, con el fin de que nuestros estudiantes obtengan las mejores oportunidades en el mercado laboral. 
                </p>
                <p>
                    Día a día, seguimos viendo más allá de las adversidades y nos comprometemos a trabajar en pro de la educación, orientada a la empleabilidad y la productividad, porque solo con una educación de calidad podemos garantizar el progreso de nuestro país. 
                </p>
                <div class="py-4">
                    <a href="https://www.youtube.com/embed/tY-G01WADnY?si=ZwgN8df_p5uKBtop" target="_blank" class="btn btn-primary">
                        <i class="bi bi-play-circle"></i> Video institucional
                    </a>
                </div>
            </div>
        </div>
        <div class="row py-4 justify-content-center">
            <div class="col-md-4">
                <div class="card text-center mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-danger-emphasis">Misión</h5>
                        <p class="card-text fs-6">
                            Formar profesionales integrales y competentes en las áreas tecnológicas que tengan demanda y oportunidad en el mercado local, regional y mundial tanto como trabajadores y como empresarios.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-danger-emphasis">Visión</h5>
                        <p class="card-text fs-6">
                            Ser una institución educativa líder en educación tecnológica a nivel nacional y regional, comprometida con la calidad, la empresarialidad y la pertinencia de nuestra oferta educativa.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-danger-emphasis">Valores</h5>
                        <p class="card-text fs-6">
                            ✓ Excelencia. ✓ Integridad. ✓ Espiritualidad. ✓ Cooperación. ✓ Comunicación.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="text-center">
                <div class="d-flex flex-column gap-1 py-4">
                    <h3 class="fw-bold text-danger-emphasis mb-0">Métodos de enseñanza</h3>
                </div>
            </div>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-learning-doing-tab" data-bs-toggle="tab" data-bs-target="#nav-learning-doing" type="button" role="tab" aria-controls="nav-learning-doing" aria-selected="true">Aprender haciendo</button>
                    <button class="nav-link" id="nav-dual-education-tab" data-bs-toggle="tab" data-bs-target="#nav-dual-education" type="button" role="tab" aria-controls="nav-dual-education" aria-selected="false">Enseñanza Dual</button>
                </div>
            </nav>
            <div class="tab-content py-3" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-learning-doing" role="tabpanel" aria-labelledby="nav-learning-doing-tab" tabindex="0">
                    <p>
                        El éxito de los profesionales de ITCA-FEPADE es el modelo “Aprender-Haciendo”, que combina la teoría con la práctica, desarrollando éstas en un primer momento en los talleres y laboratorios de nuestros campus y posteriormente en ambientes reales, gracias a la gestión y vinculación: Universidad – Empresa, lo que asegura la aceptación de nuestros graduados en el ámbito laboral.
                    </p>
                </div>
                <div class="tab-pane fade" id="nav-dual-education" role="tabpanel" aria-labelledby="nav-dual-education-tab" tabindex="0">
                    <p class="text-justify">
                        Aprender en la empresa bajo el Sistema Dual, fue la novedosa formación profesional que se implementó en El Salvador en el año 2006, gracias a la visión de la mejora continua de la Escuela Especializada en Ingeniería ITCA-FEPADE.
                        Este modelo de formación sencillo y de mucho éxito tuvo su origen en Europa y fue trasferido a ITCA por la Cooperación Alemana.
                        <br><br>Actualmente muchas compañías del país que cuentan con maquinaria y procesos modernos, invierten en la Formación Dual, que se basa en el principio de “aprender haciendo”. Los estudiantes del ITCA combinan la teoría y la práctica en dos años, para obtener un título como técnicos.
                        Unos de los grandes beneficios para los jóvenes es que todos reciben beca de estudios, adquieren conocimientos y experiencia laboral, ya que en el período de duración de la carrera, realizan ciclos alternos de dos meses de clases teóricas-prácticas en ITCA y dos meses de práctica en un ambiente real dentro de la empresa apadrinadora.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection