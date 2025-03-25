@extends('layouts.app')

@section('title', 'Estudiantes de ' . $course->name)

@section('content')
<div class="container">
    <h2 class="mb-4">Estudiantes de {{ $course->name }} 
        @if($course->seccion)
            - {{ $course->seccion }}
        @endif
        @if($course->jornada)
            - {{ $course->jornada }}
        @endif
    </h2>
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
            <tr>
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
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $('#courseStudentsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
    });
});
</script>
@endsection
