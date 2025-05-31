@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
        ['title' => 'Lista de carreras', 'url' => route('degree.list')],
        ['title' => 'Crear'],
    ];
@endphp

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-danger-emphasis">Crear carrera</h3>
</div>

<div class="position-fixed top-0 start-0 p-3" style="z-index: 1100; max-width: 400px;">
    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <i class="bi bi-check-circle me-2"></i> 
                    <strong class="me-auto">Orientación vocacional</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast show bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <i class="bi bi-x-circle me-2"></i> 
                    <strong class="me-auto">Orientación vocacional</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif
</div>

<form method="POST" action="{{ route('degree.store') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nombre de la carrera</label>
        <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label for="school_id" class="form-label">Escuela</label>
        <select id="school_id" name="school_id" class="form-select" required>
            <option value="">Seleccione una escuela</option>
            @foreach($schools as $school)
                <option value="{{ $school['id'] }}" @selected(old('school_id') == $school['id'])>
                    {{ $school['name'] }}
                </option>
            @endforeach
        </select>
        @error('school_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label for="portal_url" class="form-label">Portal</label>
        <input type="url" id="portal_url" name="portal_url" class="form-control" value="{{ old('portal_url') }}" placeholder="https://ejemplo.com">
        @error('portal_url') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <button type="submit" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> Crear
        </button>
        <a href="{{ route('degree.list') }}" class="btn btn-secondary">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
    </div>

</form>
@endsection
