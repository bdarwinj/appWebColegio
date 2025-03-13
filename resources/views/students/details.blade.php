{{-- resources/views/students/details.blade.php --}}
@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('content')
<div class="container">
    <h2>Detalles del Estudiante</h2>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $student->id }}</p>
            <p><strong>Identificación:</strong> {{ $student->identificacion }}</p>
            <p><strong>Nombre:</strong> {{ $student->nombre }}</p>
            <p><strong>Apellido:</strong> {{ $student->apellido }}</p>
            <p><strong>Correo:</strong> {{ $student->email }}</p>
            <p><strong>Curso:</strong> {{ $student->course_name }}</p>
            <p><strong>Representante:</strong> {{ $student->representante }}</p>
            <p><strong>Teléfono:</strong> {{ $student->telefono }}</p>
            <p><strong>Estado:</strong> {{ $student->active ? 'Activo' : 'Inactivo' }}</p>
        </div>
    </div>
    <a href="{{ route('payments.history', $student->id) }}" class="btn btn-info mb-3">Ver Historial de Pagos</a>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Volver al Listado</a>
</div>
@endsection
