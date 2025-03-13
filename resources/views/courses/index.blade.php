{{-- resources/views/courses/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Listado de Cursos')

@section('content')
<div class="container">
    <h2>Listado de Cursos</h2>
    <!-- Botón que dispara el modal para agregar curso -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">
      Agregar Curso
    </button>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
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

<!-- Modal para Agregar Curso -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('courses.store') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="addCourseModalLabel">Agregar Nuevo Curso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
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
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Curso</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
