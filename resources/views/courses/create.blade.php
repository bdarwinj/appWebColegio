{{-- resources/views/courses/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Agregar Curso')

@section('content')
<div class="container">
    <h2>Agregar Nuevo Curso</h2>
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Curso</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="seccion" class="form-label">Sección (opcional)</label>
            <input type="text" class="form-control" id="seccion" name="seccion">
        </div>
        <div class="mb-3">
            <label for="jornada" class="form-label">Jornada (opcional)</label>
            <select class="form-select" id="jornada" name="jornada">
                <option value="" selected>-- Seleccionar --</option>
                <option value="Mañana">Mañana</option>
                <option value="Tarde">Tarde</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Curso</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
