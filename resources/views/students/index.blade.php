@extends('layouts.app')

@section('title', 'Listado de Estudiantes')

@section('content')
<style>
    /* Estilos para botones consolidados */
    .btn-primary, .btn-secondary, .btn-danger, .btn-success {
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover { background-color: #004080; }
    .btn-secondary:hover { background-color: #5a6268; }
    .btn-danger:hover { background-color: #c82333; }
    .btn-success:hover { background-color: #218838; }

    /* Estilos generales */
    .table thead th {
        background-color: #003366;
        color: white;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0;
    }
    .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .modal-header {
        background-color: #003366;
        color: white;
    }
    .form-label {
        font-weight: bold;
        color: #003366;
    }
    .form-control {
        border-radius: 4px;
        border: 1px solid #ced4da;
    }
    .form-control:focus {
        border-color: #0066CC;
        box-shadow: 0 0 5px rgba(0, 102, 204, 0.5);
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
</style>

<div class="container py-4">
    <h2 class="text-center mb-4" style="color: #003366;">Listado de Estudiantes</h2>
    
    @if(Auth::user()->role === 'admin')
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="bi bi-person-plus"></i> Agregar Nuevo Estudiante
                </button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importStudentModal">
                    <i class="bi bi-upload"></i> Importar Estudiantes
                </button>
            </div>
            <div>
                <a href="{{ route('students.export.pdf') }}" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Exportar a PDF
                </a>
                <a href="{{ route('students.export.excel') }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
                </a>
            </div>
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    
    <table id="studentsTable" class="table table-bordered table-striped">
        <thead>
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
            <tr data-student-id="{{ $student->id }}">
                <td>{{ $student->id }}</td>
                <td>{{ $student->identificacion }}</td>
                <td>{{ $student->nombre }}</td>
                <td>{{ $student->apellido }}</td>
                <td>{{ $student->course_name }}</td>
                <td>{{ $student->representante }}</td>
                <td>{{ $student->telefono }}</td>
                <td>{{ $student->active ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-info btn-view-details" data-student-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#viewStudentModal">
                        <i class="bi bi-eye"></i> Ver
                    </button>
                    @if(Auth::user()->role === 'admin')
                        <button type="button" class="btn btn-sm btn-warning btn-edit-student" data-student-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#editStudentModal">
                            <i class="bi bi-pencil"></i> Editar
                        </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal: Agregar Nuevo Estudiante -->
@if(Auth::user()->role === 'admin')
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
@endif

<!-- Modal: Importar Estudiantes -->
@if(Auth::user()->role === 'admin')
<div class="modal fade" id="importStudentModal" tabindex="-1" aria-labelledby="importStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importStudentModalLabel">Importar Estudiantes desde Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Seleccionar Archivo Excel</label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xls,.xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Importar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal: Ver Detalles del Estudiante -->
<div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewStudentModalLabel">Detalles del Estudiante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="viewStudentContent">
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

<!-- Modal: Historial de Inscripciones -->
<div class="modal fade" id="enrollmentHistoryModal" tabindex="-1" aria-labelledby="enrollmentHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollmentHistoryModalLabel">Historial de Inscripciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="enrollmentHistoryContent">
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
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    var table = $('#studentsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
            "dom": 'Bfrtip', // Habilitar botones
            "buttons": [
                'copy', 'excel', 'pdf', 'print' // Botones para exportar
            ]
    });

    // Evento de doble click para historial de inscripciones
    $('#studentsTable tbody').on('dblclick', 'tr', function() {
        var studentId = $(this).data('student-id');
        if (studentId) {
            fetch('/students/' + studentId + '/enrollments')
                .then(response => response.text())
                .then(html => {
                    $('#enrollmentHistoryContent').html(html);
                    $('#enrollmentHistoryModal').modal('show');
                })
                .catch(error => {
                    console.error('Error al cargar el historial:', error);
                    $('#enrollmentHistoryContent').html('<p class="text-danger">Error al cargar el historial.</p>');
                });
        }
    });

    // Evento para ver detalles
    $(document).on('click', '.btn-view-details', function() {
        var studentId = $(this).data('student-id');
        if (studentId) {
            fetch('/students/' + studentId + '/details')
                .then(response => response.text())
                .then(html => {
                    $('#viewStudentContent').html(html);
                    $('#viewStudentModal').modal('show');
                })
                .catch(error => {
                    console.error('Error al cargar detalles:', error);
                    $('#viewStudentContent').html('<p class="text-danger">Error al cargar los detalles.</p>');
                });
        }
    });

    // Evento para editar estudiante
    $(document).on('click', '.btn-edit-student', function() {
        var studentId = $(this).data('student-id');
        if (studentId) {
            fetch('/students/' + studentId + '/edit')
                .then(response => response.text())
                .then(html => {
                    $('#editStudentContent').html(html);
                    $('#editStudentModal').modal('show');
                })
                .catch(error => {
                    console.error('Error al cargar formulario de edición:', error);
                    $('#editStudentContent').html('<p class="text-danger">Error al cargar el formulario.</p>');
                });
        }
    });
});
</script>
@endsection