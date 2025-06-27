@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de carreras', 'url' => route('degree.list')],
        ['title' => 'Detalle'],
    ];
@endphp

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Detalle de la carrera</h3>
    </div>
    <table class="table table-borderless mb-0">
        <tbody>
            <tr>
                <th class="text-muted">Estado</th>
                <td class="fw-bold {{ $career['active'] ? 'text-success' : 'text-danger' }}">
                    {{ $career['active'] ? 'Activo' : 'Inactivo' }}
                </td>
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
                <th class="text-muted">Portal</th>
                <td>
                    @if (!empty($career['portalUrl']))
                        <a href="{{ $career['portalUrl'] }}" target="_blank" class="text-decoration-none">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Ver carrera
                        </a>
                    @else
                        <span class="text-muted">No disponible</span>
                    @endif    
                </td>
            </tr>    
        </tbody>
    </table>
    <div class="d-flex gap-2 justify-content-end">
        <a href="{{ route('degree.edit', $career['id']) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('degree.list') }}" class="btn btn-secondary">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
    </div>
</div>
@endsection
