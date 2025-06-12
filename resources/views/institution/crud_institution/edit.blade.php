@extends('layouts.base')

@php
    $breadcrumbs = [
        ['title' => 'Administrador', 'url' => route('index')],
        ['title' => 'Lista de escuelas', 'url' => route('institution.list')],
        ['title' => 'Editar'],
    ];
@endphp

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold text-danger-emphasis">Editar escuela</h3>
    </div>

    <form action="{{ route('institution.update', $itcaSchools['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="active" class="form-label">Estado</label>
            <select name="active" id="active" class="form-control" required>
                <option value="1" {{ $itcaSchools['active'] ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$itcaSchools['active'] ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Escuela</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $itcaSchools['name'] }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control">{{ $itcaSchools['description'] }}</textarea>
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </button>
            <a href="{{ route('institution.list') }}" class="btn btn-secondary">
                <i class="bi bi-x-lg"></i> Cancelar
            </a>
        </div>

    </form>

</div>
@endsection
