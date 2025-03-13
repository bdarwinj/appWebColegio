{{-- resources/views/course_fees/config.blade.php --}}
@extends('layouts.app')

@section('title', 'Configurar Tarifas de Cursos')

@section('content')
<div class="container">
    <h2>Configurar Tarifas de Cursos</h2>
    <form action="{{ route('course_fees.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="course_id" class="form-label">Curso</label>
            <select class="form-select" id="course_id" name="course_id" required>
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
            <input type="number" class="form-control" id="academic_year" name="academic_year" required>
        </div>
        <div class="mb-3">
            <label for="fee" class="form-label">Tarifa (Mensualidad)</label>
            <input type="number" step="0.01" class="form-control" id="fee" name="fee" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Tarifas</button>
    </form>
    <hr>
    <h4>Tarifas Configuradas</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Año Académico</th>
                <th>Tarifa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courseFees as $fee)
            <tr>
                <td>
                    @php
                        $course = $fee->course;
                    @endphp
                    {{ $course->name }} 
                    @if($course->seccion) - {{ $course->seccion }} @endif 
                    @if($course->jornada) - {{ $course->jornada }} @endif
                </td>
                <td>{{ $fee->academic_year }}</td>
                <td>{{ $fee->fee }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
