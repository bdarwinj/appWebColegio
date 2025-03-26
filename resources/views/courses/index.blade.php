@extends('layouts.app')

@section('title', 'Listado de Cursos')

@section('content')
<style>
    /* Estilos personalizados para mejorar el diseño */
    .table thead th {
        background-color: #003366; /* Azul oscuro para el encabezado */
        color: white;
        border-radius: 4px 4px 0 0;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0; /* Gris claro al pasar el ratón */
        transition: background-color 0.2s ease; /* Transición suave */
    }
    .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* Sombra sutil */
    }
    .btn-action {
        margin-right: 5px;
    }
    .alert-success {
        background-color: #d4edda; /* Verde claro para éxito */
        color: #155724;
        border: none;
        border-radius: 4px;
    }
    h2 {
        color: #003366; /* Color coherente con el tema */
        font-weight: 600;
    }
</style>
<div class="container py-4">
    <h2 class="text-center mb-4" style="color: #003366;">Listado de Cursos</h2>
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif
    <!-- Botón para agregar curso con ícono -->
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addCourseModal">
        <i class="bi bi-plus-circle me-1"></i> Agregar Curso
    </button>
    <table id="coursesTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Sección</th>
                <th>Jornada</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr data-course-id="{{ $course->id }}">
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->seccion }}</td>
                <td>{{ $course->jornada }}</td>
                <td>{{ $course->active ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning btn-edit-course" data-course-id="{{ $course->id }}" data-bs-toggle="modal" data-bs-target="#editCourseModal">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Modal para agregar curso -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
<!-- Modal: Editar Curso -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="editCourseModalContent">
      <!-- El contenido se cargará vía AJAX -->
      <div class="modal-header">
        <h5 class="modal-title" id="editCourseModalLabel">Editar Curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- DataTables JS CDN -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#coursesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
    });

    // Manejar clic en el botón "Editar"
    $('.btn-edit-course').on('click', function(){
        var courseId = $(this).data('course-id');
        var modalContent = $('#editCourseModalContent');
        modalContent.html(
          '<div class="modal-header">' +
            '<h5 class="modal-title" id="editCourseModalLabel">Editar Curso</h5>' +
            '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>' +
          '</div>' +
          '<div class="modal-body text-center">' +
            '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>' +
          '</div>'
        );
        $.ajax({
            url: '/courses/' + courseId + '/edit',
            type: 'GET',
            success: function(response) {
                modalContent.html(response);
            },
            error: function(xhr, status, error) {
                modalContent.html('<p class="text-danger">Error al cargar el formulario. Inténtelo nuevamente.</p>');
                console.error("AJAX error:", status, error);
            }
        });
    });
});
</script>
@endsection