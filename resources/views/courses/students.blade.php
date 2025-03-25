@extends('layouts.app')

@section('title', 'Estudiantes de ' . $course->name)

@section('content')
<style>
    .table {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .table thead th {
        background-color: #003366;
        color: white;
        font-weight: bold;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0;
        cursor: pointer; /* Cambia el cursor a mano */
    }
    .btn-export {
        margin-right: 10px;
    }
    .alert-info {
        background-color: #d9edf7;
        color: #31708f;
        border-color: #bce8f1;
    }
    .btn-secondary {
        background-color: #0066CC;
        border: none;
        transition: background-color 0.3s;
    }
    .btn-secondary:hover {
        background-color: #004080;
    }
</style>
<div class="container py-4">
    <h2 class="text-center mb-4" style="color: #003366;">Estudiantes del Curso: {{ $course->name }}
        @if($course->seccion)
            - {{ $course->seccion }}
        @endif
        @if($course->jornada)
            - {{ $course->jornada }}
        @endif
    </h2>
    
    @if($course->students->isEmpty())
        <div class="alert alert-info">
            No hay estudiantes registrados para este curso.
        </div>
    @else
        <div class="table-responsive">
            <table id="courseStudentsTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Representante</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($course->students as $student)
                    <tr data-student-id="{{ $student->id }}">
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->identificacion }}</td>
                        <td>{{ $student->nombre }}</td>
                        <td>{{ $student->apellido }}</td>
                        <td>{{ $student->representante }}</td>
                        <td>{{ $student->telefono }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->active ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="mt-3 d-flex justify-content-between">
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Volver al Listado de Estudiantes</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    var table = $('#courseStudentsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
        dom: 'Bfrtip', // Habilita los botones de exportación
        buttons: [
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success btn-export',
                title: 'Estudiantes del Curso {{ $course->name }}'
            },
            {
                extend: 'pdf',
                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                className: 'btn btn-danger btn-export',
                title: 'Estudiantes del Curso {{ $course->name }}'
            }
        ]
    });

    // Capturar doble clic en la fila para abrir la vista completa de detalles del estudiante
    $('#courseStudentsTable tbody').on('dblclick', 'tr', function(){
        var studentId = $(this).data('student-id');
        if(studentId) {
            window.location.href = '/students/' + studentId + '/details_page';
        }
    });
});
</script>
@endsection