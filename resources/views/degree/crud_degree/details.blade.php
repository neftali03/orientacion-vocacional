@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
        ['title' => 'Lista de carreras', 'url' => route('degree.list')],
        ['title' => 'Detalle'],
    ];
@endphp

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-danger-emphasis">Detalle de la carrera</h3>
</div>

<div class="container">
    <div class="position-fixed top-0 start-0 p-3" style="z-index: 1100; max-width: 400px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm w-100" role="alert">
                <strong><i class="bi bi-check-circle me-1"></i></strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm w-100" role="alert">
                <strong><i class="bi bi-exclamation-triangle me-1"></i></strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <th class="text-muted w-25">Código</th>
                        <td>{{ $career['id'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Nombre</th>
                        <td>{{ $career['name'] }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Descripción</th>
                        <td>{{ $career['description'] ?? 'No definida' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Escuela</th>
                        <td>{{ $career['itcaSchool']['name'] ?? 'No asignada' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Estado</th>
                        <td>{{ $career['active'] ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="d-flex gap-2 justify-content-end">
        <a href="{{ route('degree.edit', $career['id']) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('degree.list') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>
@endsection
