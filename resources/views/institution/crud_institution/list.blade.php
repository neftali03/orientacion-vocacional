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
                <th class="text-secondary-emphasis bg-primary-subtle">Código</th>
                <th class="text-secondary-emphasis bg-primary-subtle">Escuela</th>
                <th class="text-secondary-emphasis bg-primary-subtle">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($itcaSchools as $itcaSchool)
                <tr>
                    <td>
                        <a href="{{ route('institution.details', $itcaSchool['id']) }}">
                            {{ strtoupper($itcaSchool['id']) }}
                        </a>
                    </td>
                    <td>{{ $itcaSchool['name'] }}</td>
                    <td class="{{ $itcaSchool['active'] ? 'text-success' : 'text-danger' }}">{{ $itcaSchool['active'] ? 'Activo' : 'Inactivo' }}</td>
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
