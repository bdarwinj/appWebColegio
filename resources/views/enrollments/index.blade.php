@extends('layouts.app')

@section('title', 'Listado de Inscripciones')

@section('content')
<style>
    .table thead th {
        background-color: #003366;
        color: white;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4" style="color: #003366;">Listado de Inscripciones</h2>
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    <table id="enrollmentsTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Año Académico</th>
                <th>Estado</th>
                <th>Fecha de Inscripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
            <tr>
                <td>{{ $enrollment->id }}</td>
                <td>{{ $enrollment->student->nombre }} {{ $enrollment->student->apellido }}</td>
                <td>
                    @if($enrollment->course)
                        {{ $enrollment->course->name }}
                        @if($enrollment->course->seccion) - {{ $enrollment->course->seccion }} @endif
                        @if($enrollment->course->jornada) - {{ $enrollment->course->jornada }} @endif
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $enrollment->academic_year }}</td>
                <td>{{ $enrollment->status }}</td>
                <td>{{ $enrollment->date_enrolled }}</td>
                <td>
                    @if(strtolower($enrollment->status) == 'inscrito')
                        <form action="{{ route('enrollments.promote', $enrollment->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de promover al estudiante?');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Promover</button>
                        </form>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        // Inicializar DataTables en la tabla de inscripciones
        $('#enrollmentsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            },
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
        });
    });
</script>
@endsection
