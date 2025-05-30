@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
        ['title' => 'Lista de carreras'],
    ];
@endphp

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Lista de carreras</h3>
    </div>

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

    <div class="mb-3 text-start">
        <a href="{{ route('degree.create') }}" class="btn btn-orange btn-md fw-bold">Crear</a>
    </div>
    
    <table class="table table-bordered table-sm table-hover">
        <thead>
            <tr>
                <th class="text-secondary-emphasis bg-primary-subtle">Código</th>
                <th class="text-secondary-emphasis bg-primary-subtle">Carrera</th>
                <th class="text-secondary-emphasis bg-primary-subtle">Escuela</th>
                <th class="text-secondary-emphasis bg-primary-subtle">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($careers as $career)
                <tr>
                    <td>
                        <a href="{{ route('degree.details', $career['id']) }}">
                            {{ strtoupper($career['id']) }}
                        </a>
                    </td>
                    <td>{{ $career['name'] }}</td>
                    <td>{{ $career['itcaSchool']['name'] ?? 'No asignada' }}</td>
                    <td class="fw-bold {{ $career['active'] ? 'text-success' : 'text-danger' }}">{{ $career['active'] ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay carreras disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mb-3 text-end">
        {{ count($careers) }} registros
    </div>

</div>
@endsection
