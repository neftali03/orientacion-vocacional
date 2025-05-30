@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Editar Carrera</h2>
    <form action="{{ route('degree.update', $career['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $career['name'] }}" required>
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

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('degree.list') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
