@extends('layouts.app')

@section('title', 'Dashboard - Sistema Colegio')

@section('content')
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .card-header {
        background-color: #003366;
        color: white;
        font-weight: bold;
    }
    .list-group-item {
        border: none;
        padding: 10px 15px;
    }
    .badge {
        font-size: 1.1em;
        background-color: #0066CC;
        color: white;
    }
    .btn {
        transition: background-color 0.3s;
    }
    .btn:hover {
        background-color: #004080;
        color: white;
    }
    .icon {
        margin-right: 10px;
    }
</style>
<div class="container">
    <h2 class="text-center mb-4" style="color: #003366;">Dashboard</h2>
    <div class="row">
        <!-- Estadísticas Generales -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-bar-chart icon"></i> Estadísticas Generales
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Número total de cursos
                            <span class="badge rounded-pill">{{ $totalCourses }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Número de cursos con alumnos
                            <span class="badge rounded-pill">{{ $coursesWithStudents }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Número total de alumnos
                            <span class="badge rounded-pill">{{ $totalStudents }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Alumnos por Curso -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-book icon"></i> Alumnos por Curso
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($courseCount as $course => $count)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $course }}
                                <span class="badge rounded-pill">{{ $count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Pagos Recogidos -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-cash icon"></i> Pagos Recogidos
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Mes ({{ $currentMonth }})
                            <span class="badge rounded-pill">{{ number_format($totalMonth, 2, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Año ({{ $currentYear }})
                            <span class="badge rounded-pill">{{ number_format($totalYear, 2, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Alumnos sin Pago en el Mes Actual -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
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
        <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">Refrescar Dashboard</a>
        <a href="{{ route('payments.history', 1) }}" class="btn btn-info">Ver Estado de Cuenta</a>
    </div>
</div>

<!-- Inicializar tooltips -->
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
<script>
    $(document).ready(function(){
        $('#studentsWithoutPaymentTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            },
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
        });
    });
</script>
@endsection