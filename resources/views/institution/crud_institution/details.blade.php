@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de escuelas', 'url' => route('institution.list')],
        ['title' => 'Detalle'],
    ];
@endphp

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Detalle de la escuela</h3>
    </div>
    <table class="table table-borderless mb-0">
        <tbody>
            <tr>
                <th class="text-muted">Estado</th>
                <td class="fw-bold {{ $itcaSchools['active'] ? 'text-success' : 'text-danger' }}">
                    {{ $itcaSchools['active'] ? 'Activo' : 'Inactivo' }}
                </td>
            </tr>
            <tr>
                <th class="text-muted w-25">Código</th>
                <td>{{ strtoupper($itcaSchools['id']) }}</td>
            </tr>
            <tr>
                <th class="text-muted">Escuela</th>
                <td>{{ $itcaSchools['name'] }}</td>
            </tr>
            <tr>
                <th class="text-muted">Descripción</th>
                <td>{{ $itcaSchools['description'] ?? 'No definida' }}</td>
            </tr>  
        </tbody>
    </table>
    <div class="d-flex gap-2 justify-content-end">
        <a href="{{ route('institution.edit', $itcaSchools['id']) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('institution.list') }}" class="btn btn-secondary">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
    </div>
</div>
@endsection
