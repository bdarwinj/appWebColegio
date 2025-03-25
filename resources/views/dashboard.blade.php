@extends('layouts.app')

@section('title', 'Dashboard - Sistema Colegio')

@section('content')
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        transition: box-shadow 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #003366;
        color: white;
        font-weight: bold;
        padding: 15px;
    }
    .list-group-item {
        border: none;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .badge {
        font-size: 1.1em;
        background-color: #0066CC;
        color: white;
        border-radius: 20px;
        padding: 5px 10px;
    }
    .table thead th {
        background-color: #003366;
        color: white;
        font-weight: bold;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }
    .btn {
        transition: background-color 0.3s ease;
    }
    .btn:hover {
        background-color: #004080;
        color: white;
    }
    .icon {
        margin-right: 10px;
    }
    /* Ajustes para móviles */
    @media (max-width: 768px) {
        .card-header {
            font-size: 1.1em;
        }
        .badge {
            font-size: 1em;
        }
        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
<div class="container py-4">
    <h2 class="text-center mb-4" style="color: #003366;">Dashboard</h2>
    <div class="row">
        <div class="col-12 col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart icon"></i> Estadísticas Generales
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            Número total de cursos
                            <span class="badge">{{ $totalCourses }}</span>
                        </li>
                        <li class="list-group-item">
                            Número de cursos con alumnos
                            <span class="badge">{{ $coursesWithStudents }}</span>
                        </li>
                        <li class="list-group-item">
                            Número total de alumnos
                            <span class="badge">{{ $totalStudents }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-book icon"></i> Alumnos por Curso
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($courses as $course)
                            <div class="col-12 col-md-6 mb-2">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $course->name }}
                                        @if($course->seccion) - {{ $course->seccion }} @endif
                                        @if($course->jornada) - {{ $course->jornada }} @endif
                                        <span class="badge">{{ $course->students_count ?? 0 }}</span>
                                        <a href="{{ route('courses.students', $course->id) }}" class="btn btn-sm btn-info">Ver</a>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-cash icon"></i> Pagos Recogidos
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            Mes ({{ $currentMonth }})
                            <span class="badge">{{ number_format($totalMonth, 2, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item">
                            Año ({{ $currentYear }})
                            <span class="badge">{{ number_format($totalYear, 2, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle icon"></i> Alumnos sin Pago en el Mes Actual
                    <span class="badge bg-danger rounded-pill" data-bs-toggle="tooltip" data-bs-placement="top" title="Estos estudiantes no han realizado pagos en el mes actual">{{ count($studentsWithoutPayment) }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="studentsWithoutPaymentTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Identificación</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentsWithoutPayment as $student)
                                    <tr>
                                        <td>{{ $student->identificacion }}</td>
                                        <td>{{ $student->nombre }}</td>
                                        <td>{{ $student->apellido }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2"><i class="bi bi-arrow-clockwise"></i> Refrescar Dashboard</a>
        <a href="{{ route('payments.history', 1) }}" class="btn btn-info"><i class="bi bi-file-earmark-text"></i> Ver Estado de Cuenta</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Inicializar DataTables
        $('#studentsWithoutPaymentTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json" // Traducción al español
            },
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
        dom: 'Bfrtip', // Habilita los botones de exportación
        buttons: [
            {
                extend: 'pdf',
                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                className: 'btn btn-danger btn-export',
                title: 'Estudiantes Morosos',
                exportOptions: {
                    // Ocultar la primera columna (índice 0)
                    columns: ':not(:first-child)'
                }
            }
        ]
        });
    });
</script>
@endsection