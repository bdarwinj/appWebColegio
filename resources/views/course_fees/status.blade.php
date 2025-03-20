@extends('layouts.app')

@section('title', 'Estado de Cuenta de Mensualidades')

@section('content')
<div class="container">
    <h2 class="mb-4">Estado de Cuenta de Mensualidades - Año {{ $academicYear }}</h2>
    
    @if(count($studentsInMora) == 0)
        <div class="alert alert-success">
            Todos los estudiantes están al día.
        </div>
    @else
        <div class="alert alert-warning">
            <strong>Total Adeudado Global:</strong> ${{ number_format($globalBalance, 2) }} <br>
            <strong>Total de Meses Pendientes:</strong> {{ $globalPendingMonths }}
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Curso</th>
                    <th>Tarifa Mensual</th>
                    <th>Total Esperado</th>
                    <th>Total Pagado</th>
                    <th>Balance</th>
                    <th>Meses Pendientes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentsInMora as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->identificacion }}</td>
                        <td>{{ $student->nombre }} {{ $student->apellido }}</td>
                        <td>
                            @if($student->course)
                                {{ $student->course->name }}
                                @if($student->course->seccion) - {{ $student->course->seccion }} @endif
                                @if($student->course->jornada) - {{ $student->course->jornada }} @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td>${{ number_format($student->balanceData['monthly_fee'], 2) }}</td>
                        <td>${{ number_format($student->balanceData['expected_total'], 2) }}</td>
                        <td>${{ number_format($student->balanceData['total_paid'], 2) }}</td>
                        <td>${{ number_format($student->balanceData['balance'], 2) }}</td>
                        <td>{{ $student->balanceData['pending_months'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
