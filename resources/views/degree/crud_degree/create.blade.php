@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de carreras', 'url' => route('degree.list')],
        ['title' => 'Crear'],
    ];
@endphp

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-danger-emphasis">Crear carrera</h3>
</div>
<form method="POST" action="{{ route('degree.store') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nombre de la carrera</label>
        <input type="text" id="name" name="name" class="form-control" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" required value="{{ old('name') }}">
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
