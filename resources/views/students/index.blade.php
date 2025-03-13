{{-- resources/views/students/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Listado de Estudiantes')

@section('content')
<div class="container">
    <h2>Listado de Estudiantes</h2>
    <!-- Botón que dispara el modal para agregar nuevo estudiante -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">
      Agregar Nuevo Estudiante
    </button>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Identificación</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Curso</th>
                <th>Representante</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->identificacion }}</td>
                <td>{{ $student->nombre }}</td>
                <td>{{ $student->apellido }}</td>
                <td>{{ $student->course_name }}</td>
                <td>{{ $student->representante }}</td>
                <td>{{ $student->telefono }}</td>
                <td>{{ $student->active ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">Ver Detalles</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal para Agregar Nuevo Estudiante -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('students.store') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="addStudentModalLabel">Registrar Nuevo Estudiante</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
              <div class="row mb-3">
                  <div class="col-md-6">
                      <label for="identificacion" class="form-label">Número de Identificación</label>
                      <input type="text" class="form-control" id="identificacion" name="identificacion" required>
                  </div>
                  <div class="col-md-6">
                      <label for="nombre" class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" required>
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col-md-6">
                      <label for="apellido" class="form-label">Apellido</label>
                      <input type="text" class="form-control" id="apellido" name="apellido" required>
                  </div>
                  <div class="col-md-6">
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
              </div>
              <div class="row mb-3">
                  <div class="col-md-6">
                      <label for="representante" class="form-label">Representante</label>
                      <input type="text" class="form-control" id="representante" name="representante">
                  </div>
                  <div class="col-md-6">
                      <label for="telefono" class="form-label">Teléfono</label>
                      <input type="text" class="form-control" id="telefono" name="telefono">
                  </div>
              </div>
              <div class="mb-3">
                  <label for="email" class="form-label">Correo Electrónico</label>
                  <input type="email" class="form-control" id="email" name="email">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Registrar Estudiante</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
