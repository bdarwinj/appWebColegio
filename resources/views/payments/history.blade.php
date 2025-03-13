{{-- resources/views/payments/history.blade.php --}}
@extends('layouts.app')

@section('title', 'Historial de Pagos')

@section('content')
<div class="container">
    <h2>Historial de Pagos</h2>
    <a href="{{ route('payments.create') }}" class="btn btn-primary mb-3">Registrar Nuevo Pago</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nº Recibo</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Descripción</th>
                <th>Periodo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->receipt_number }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->description }}</td>
                <td>{{ $payment->period }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Volver al Listado de Estudiantes</a>
</div>
@endsection
