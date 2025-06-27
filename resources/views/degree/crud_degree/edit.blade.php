@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de carreras', 'url' => route('degree.list')],
        ['title' => 'Editar'],
    ];
@endphp

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Editar carrera</h3>
    </div>

    <form action="{{ route('degree.update', $career['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="active" class="form-label">Estado</label>
            <select name="active" id="active" class="form-control" required>
                <option value="1" {{ $career['active'] ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$career['active'] ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $career['name'] }}" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control">{{ $career['description'] }}</textarea>
        </div>

        <div class="mb-3">
            <label for="school_id" class="form-label">Escuela</label>
            <select name="school_id" id="school_id" class="form-control" required>
                @foreach ($schools as $school)
                    <option value="{{ $school['id'] }}" {{ $career['schoolId'] === $school['id'] ? 'selected' : '' }}>
                        {{ $school['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="portal_url" class="form-label">Portal</label>
            <input type="url" id="portal_url" name="portal_url" class="form-control"
                value="{{ old('portal_url', $career['portalUrl']) }}">
            @error('portal_url') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </button>
            <a href="{{ route('degree.list') }}" class="btn btn-secondary">
                <i class="bi bi-x-lg"></i> Cancelar
            </a>
        </div>

    </form>

</div>
@endsection
