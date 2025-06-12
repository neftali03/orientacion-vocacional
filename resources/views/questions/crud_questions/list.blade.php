@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de preguntas'],
    ];
@endphp

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Lista de preguntas</h3>
    </div>
    <div class="mb-3 text-start">
        <a href="{{ route('questions.create') }}" class="btn btn-orange btn-md fw-bold">
            <i class="bi bi-plus-lg"></i> Crear
        </a>
    </div>
    <table class="table table-bordered table-sm table-hover">
        <thead>
            <tr>
                <th class="text-secondary-emphasis bg-primary-subtle">Código</th>
                <th class="text-secondary-emphasis bg-primary-subtle">Pregunta</th>
                <th class="text-secondary-emphasis bg-primary-subtle">Categoría</th>
                <th class="text-secondary-emphasis bg-primary-subtle">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($questions as $question)
                <tr>
                    <td>
                        <a href="{{ route('questions.details', $question['id']) }}">
                            {{ strtoupper($question['id']) }}
                        </a>
                    </td>
                    <td>{{ $question['description'] }}</td>
                    <td>{{ $question['skillCategoryCatalog']['description'] ?? 'No asignada' }}</td>
                    <td class="{{ $question['active'] ? 'text-success' : 'text-danger' }}">{{ $question['active'] ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay preguntas disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mb-3 text-secondary small text-end">
        {{ count($questions) }} registros
    </div>
</div>
@endsection
