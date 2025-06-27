@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de preguntas', 'url' => route('questions.list')],
        ['title' => 'Detalle'],
    ];
@endphp

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Detalle de la pregunta</h3>
    </div>
    <table class="table table-borderless mb-0">
        <tbody>
            <tr>
                <th class="text-muted">Estado</th>
                <td class="fw-bold {{ $question['active'] ? 'text-success' : 'text-danger' }}">
                    {{ $question['active'] ? 'Activo' : 'Inactivo' }}
                </td>
            </tr>
            <tr>
                <th class="text-muted">Número de Pregunta</th>
                <td>
                    @if (!empty($question['questionNumber']))
                        <span>{{ $question['questionNumber'] }}</span>
                    @else
                        <span class="text-muted">No disponible</span>
                    @endif    
                </td>
            </tr>
            <tr>
                <th class="text-muted">Pregunta</th>
                <td>{{ $question['description'] ?? 'No definida' }}</td>
            </tr>
            <tr>
                <th class="text-muted">Categoría</th>
                <td>{{ $question['skillCategoryCatalog']['description'] ?? 'No asignada' }}</td>
            </tr>  
        </tbody>
    </table>
    <div class="d-flex gap-2 justify-content-end">
        <a href="{{ route('questions.edit', $question['id']) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('questions.list') }}" class="btn btn-secondary">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
    </div>
</div>
@endsection
