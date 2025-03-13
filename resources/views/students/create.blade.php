{{-- resources/views/students/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Estudiante')

@section('content')
<div class="container">
    <h2>Registrar Nuevo Estudiante</h2>
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="identificacion" class="form-label">Número de Identificación</label>
            <input type="text" class="form-control" id="identificacion" name="identificacion" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="mb-3">
            <label for="course_id" class="form-label">Curso</label>
            <select class="form-select" id="course_id" name="course_id">
                <option value="">-- Seleccionar Curso --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">
                        {{ $course->name }} 
                        @if($course->seccion) - {{ $course->seccion }} @endif 
                        @if($course->jornada) - {{ $course->jornada }} @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="representante" class="form-label">Representante</label>
            <input type="text" class="form-control" id="representante" name="representante">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <button type="submit" class="btn btn-primary">Registrar Estudiante</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
