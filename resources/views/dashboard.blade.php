<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard de Estadísticas</h2>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item">Número total de cursos: {{ $totalCourses }}</li>
                <li class="list-group-item">Número de cursos con alumnos: {{ $coursesWithStudents }}</li>
                <li class="list-group-item">Número total de alumnos: {{ $totalStudents }}</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h5>Alumnos por curso:</h5>
            <ul class="list-group">
                @foreach($courseCount as $course => $count)
                    <li class="list-group-item">{{ $course }}: {{ $count }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <hr>
    <h4>Pagos Recogidos</h4>
    <ul class="list-group">
        <li class="list-group-item">Mes ({{ $currentMonth }}): {{ $totalMonth }}</li>
        <li class="list-group-item">Año ({{ $currentYear }}): {{ $totalYear }}</li>
    </ul>
    <hr>
    <h4>Alumnos sin pago en el mes actual: {{ count($studentsWithoutPayment) }}</h4>
    <ul class="list-group">
        @foreach($studentsWithoutPayment as $student)
            <li class="list-group-item">{{ $student->identificacion }} - {{ $student->nombre }} {{ $student->apellido }}</li>
        @endforeach
    </ul>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Refrescar Dashboard</a>
    <a href="{{ route('payments.history', 1) }}" class="btn btn-info mt-3">Ver Estado de Cuenta</a>
</div>
@endsection
