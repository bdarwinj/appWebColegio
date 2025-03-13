{{-- resources/views/students/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Listado de Estudiantes')

@section('content')
<div class="container">
    <h2>Listado de Estudiantes</h2>
    <!-- Botón para abrir modal de agregar estudiante -->
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
                    <!-- Botón para ver detalles -->
                    <button type="button" class="btn btn-sm btn-info btn-view-details" data-student-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#viewStudentModal">
                        Ver Detalles
                    </button>
                    <!-- Botón para editar -->
                    <button type="button" class="btn btn-sm btn-warning btn-edit-student" data-student-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#editStudentModal">
                        Editar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal: Agregar Nuevo Estudiante -->
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
            <!-- Incluye todos los campos necesarios -->
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Registrar Estudiante</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Ver Detalles del Estudiante -->
<div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewStudentModalLabel">Detalles del Estudiante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="viewStudentContent">
        <!-- Contenido se cargará dinámicamente con AJAX -->
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Editar Estudiante -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Contenido se cargará dinámicamente con AJAX -->
      <div class="modal-header">
        <h5 class="modal-title" id="editStudentModalLabel">Editar Estudiante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="editStudentContent">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar detalles del estudiante al hacer clic en "Ver Detalles"
        document.querySelectorAll('.btn-view-details').forEach(function(button) {
            button.addEventListener('click', function(){
                var studentId = this.getAttribute('data-student-id');
                var modalBody = document.getElementById('viewStudentContent');
                modalBody.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
                fetch('/students/' + studentId + '/details')
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                    })
                    .catch(error => {
                        modalBody.innerHTML = '<p class="text-danger">Error al cargar los detalles.</p>';
                    });
            });
        });

        // Cargar formulario de edición al hacer clic en "Editar"
        document.querySelectorAll('.btn-edit-student').forEach(function(button) {
            button.addEventListener('click', function(){
                var studentId = this.getAttribute('data-student-id');
                var modalBody = document.getElementById('editStudentContent');
                modalBody.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
                fetch('/students/' + studentId + '/edit')
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                    })
                    .catch(error => {
                        modalBody.innerHTML = '<p class="text-danger">Error al cargar el formulario.</p>';
                    });
            });
        });
    });
</script>
@endsection