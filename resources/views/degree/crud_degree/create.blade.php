@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Orientación Vocacional', 'url' => route('index')],
        ['title' => 'Carreras', 'url' => route('degree.list')],
        ['title' => 'Crear'],
    ];
@endphp

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-danger-emphasis">Crear carrera</h3>
    <p>Completa el formulario para registrar una nueva carrera.</p>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm w-100" role="alert">
        <strong><i class="bi bi-exclamation-triangle me-1"></i></strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

<form method="POST" action="{{ route('degree.list') }}">
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

    <div class="d-flex gap-2 justify-content-end">
        <button type="submit" class="btn btn-orange">Crear</button>
        <a href="{{ route('degree.list') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
@endsection
