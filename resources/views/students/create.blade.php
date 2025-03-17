@extends('layouts.app')

@section('title', 'Registrar Estudiante')

@section('content')
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-label {
        font-weight: bold;
        color: #003366;
    }
    .btn-primary {
        background-color: #0066CC;
        border: none;
    }
    .btn-primary:hover {
        background-color: #004080;
    }
    .input-group-text {
        background-color: #f8f9fa;
        border: none;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4" style="color: #003366;">Registrar Nuevo Estudiante</h2>
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header" style="background-color: #003366; color: white;">
                <i class="bi bi-person"></i> Datos Personales
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="identificacion" class="form-label">Número de Identificación</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-id-card"></i></span>
                        <input type="text" class="form-control" id="identificacion" name="identificacion" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="course_id" class="form-label">Curso</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-book"></i></span>
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
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header" style="background-color: #003366; color: white;">
                <i class="bi bi-telephone"></i> Datos de Contacto
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="representante" class="form-label">Representante</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="representante" name="representante">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary me-2">Registrar Estudiante</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection