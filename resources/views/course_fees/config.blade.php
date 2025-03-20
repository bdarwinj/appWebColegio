@extends('layouts.app')

@section('title', 'Configuración de Mensualidades')

@section('content')
<div class="container">
    <h2 class="mb-4">Configuración de Mensualidades</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('course_fees.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="course_id" class="form-label">Curso</label>
            <select name="course_id" id="course_id" class="form-select" required>
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
            <label for="academic_year" class="form-label">Año Académico</label>
            <input type="number" name="academic_year" id="academic_year" class="form-control" value="{{ $currentYear }}" required>
        </div>
        <div class="mb-3">
            <label for="fee" class="form-label">Tarifa Mensual</label>
            <input type="number" step="0.01" name="fee" id="fee" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
    </form>
    <hr>
    <h3>Tarifas Configuradas (Año {{ $currentYear }})</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Tarifa Mensual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courseFees as $fee)
                <tr>
                    <td>
                        {{ $fee->course->name }}
                        @if($fee->course->seccion) - {{ $fee->course->seccion }} @endif
                        @if($fee->course->jornada) - {{ $fee->course->jornada }} @endif
                    </td>
                    <td>${{ number_format($fee->fee, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
