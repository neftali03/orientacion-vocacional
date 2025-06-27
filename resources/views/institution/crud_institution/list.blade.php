@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de escuelas'],
    ];
@endphp

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Lista de escuelas</h3>
    </div>
    <div class="mb-3 text-start">
        <a href="{{ route('institution.create') }}" class="btn btn-orange btn-md fw-bold">
            <i class="bi bi-plus-lg"></i> Crear
        </a>
    </div>
    <table class="table table-bordered table-sm table-hover">
        <thead>
            <tr>
                <th class="text-secondary-emphasis bg-primary-subtle">Escuela</th>
                <th class="text-center text-secondary-emphasis bg-primary-subtle">Estado</th>
                <th class="text-center text-secondary-emphasis bg-primary-subtle">Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($itcaSchools as $itcaSchool)
                <tr>
                    <td>{{ $itcaSchool['name'] }}</td>
                    <td class="{{ $itcaSchool['active'] ? 'text-success' : 'text-danger' }} text-center">{{ $itcaSchool['active'] ? 'Activo' : 'Inactivo' }}</td>
                    <td class="text-center">
                        <a href="{{ route('institution.details', $itcaSchool['id']) }}"
                           class="btn btn-info btn-sm d-inline-flex align-items-center gap-1">
                            <i class="bi bi-eye-fill"></i>Ver
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay escuelas disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mb-3 text-secondary small text-end">
        {{ count($itcaSchools) }} registros
    </div>
</div>
@endsection
