@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de preguntas', 'url' => route('questions.list')],
        ['title' => 'Editar'],
    ];
@endphp

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Editar pregunta</h3>
    </div>

    <form action="{{ route('questions.update', $question['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="active" class="form-label">Estado</label>
            <select name="active" id="active" class="form-control" required>
                <option value="1" {{ $question['active'] ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$question['active'] ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Pregunta</label>
            <textarea name="description" id="description" class="form-control" required>{{ $question['description'] }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach ($skillCategoryCatalog as $skillCategoryCatalog)
                    <option value="{{ $skillCategoryCatalog['id'] }}" {{ $question['categoryId'] === $skillCategoryCatalog['id'] ? 'selected' : '' }}>
                        {{ $skillCategoryCatalog['description'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="question_number" class="form-label">Número de Pregunta</label>
            <input type="number" id="question_number" name="question_number" class="form-control"
                value="{{ old('question_number', $question['questionNumber']) }}" required>
            @error('question_number') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </button>
            <a href="{{ route('questions.list') }}" class="btn btn-secondary">
                <i class="bi bi-x-lg"></i> Cancelar
            </a>
        </div>

    </form>

</div>
@endsection
