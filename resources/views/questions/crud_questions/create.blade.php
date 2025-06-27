@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de preguntas', 'url' => route('questions.list')],
        ['title' => 'Crear'],
    ];
@endphp

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-danger-emphasis">Crear pregunta</h3>
</div>
<form method="POST" action="{{ route('questions.store') }}">
    @csrf
    <div class="mb-3">
        <label for="description" class="form-label">Pregunta</label>
        <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Categorías</label>
        <select id="category_id" name="category_id" class="form-select" required>
            <option value="">Seleccione una categoría</option>
            @foreach($skillCategory as $skillCategory)
                <option value="{{ $skillCategory['id'] }}" @selected(old('category_id') == $skillCategory['id'])>
                    {{ $skillCategory['description'] }}
                </option>
            @endforeach
        </select>
        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="mb-3">
        <label for="question_number" class="form-label">Número de pregunta</label>
        <input type="number" id="question_number" name="question_number" class="form-control" value="{{ old('question_number') }}" placeholder="#" required>
        @error('question_number') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="d-flex gap-2 justify-content-end">
        <button type="submit" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> Crear
        </button>
        <a href="{{ route('questions.list') }}" class="btn btn-secondary">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
    </div>
</form>
@endsection
