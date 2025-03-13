{{-- resources/views/courses/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Listado de Cursos')

@section('content')
<div class="container">
    <h2>Listado de Cursos</h2>
    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Agregar Nuevo Curso</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Sección</th>
                <th>Jornada</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->seccion }}</td>
                <td>{{ $course->jornada }}</td>
                <td>{{ $course->active ? 'Activo' : 'Inactivo' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
