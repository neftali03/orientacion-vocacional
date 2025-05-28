@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
    ];
    $pageTitle = 'Preguntas';
@endphp

@section('content')
<div class="d-flex flex-column gap-1">
    <h3 class="fw-bold text-danger-emphasis mb-0">Preguntas Frecuentes</h3>
    <p class="mb-0">
      Bienvenido a la sección de preguntas frecuentes. Si no encuentras lo que buscas,
      puedes escribirnos al correo <strong>correoAdmin@itca.edu.sv</strong> y con gusto te atenderemos.
    </p>
</div>
<div class="accordion accordion-flush py-5" id="accordionFlushExample">
    @foreach ($questions_answer as $index => $questions_answer)
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading{{ $index }}">
                <button class="accordion-button collapsed fw-bold" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse{{ $index }}"
                        aria-expanded="false"
                        aria-controls="flush-collapse{{ $index }}">
                    {{ $questions_answer['question'] }}
                </button>
            </h2>
            <div id="flush-collapse{{ $index }}"
                 class="accordion-collapse collapse"
                 aria-labelledby="flush-heading{{ $index }}"
                 data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    {{ $questions_answer['answer'] }}
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
