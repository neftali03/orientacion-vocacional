@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de escuelas', 'url' => route('institution.list')],
        ['title' => 'Crear'],
    ];
@endphp

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-danger-emphasis">Crear escuela</h3>
</div>
<form method="POST" action="{{ route('institution.store') }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nombre de la escuela</label>
        <input type="text" id="name" name="name" class="form-control" required  pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" value="{{ old('name') }}">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="d-flex gap-2 justify-content-end">
        <button type="submit" class="btn btn-orange">
            <i class="bi bi-plus-lg"></i> Crear
        </button>
        <a href="{{ route('institution.list') }}" class="btn btn-secondary">
            <i class="bi bi-x-lg"></i> Cancelar
        </a>
    </div>
</form>
@endsection
