@extends('layouts.app')

@section('title', 'Historial de Pagos')

@section('content')
<style>
    .table thead th {
        background-color: #003366; /* Azul oscuro para encabezado */
        color: white;
        border-radius: 4px 4px 0 0; /* Bordes redondeados en la parte superior */
    }
    .table tbody tr:hover {
        background-color: #f0f0f0; /* Gris claro al pasar el cursor */
        transition: background-color 0.2s ease; /* Transición suave */
    }
    .btn-action {
        margin-right: 5px;
    }
    h2 {
        color: #003366; /* Color coherente para el título */
        font-weight: 600;
    }
    .container {
        padding-top: 20px;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4">Historial de Pagos</h2>
    <a href="{{ route('payments.create') }}" class="btn btn-primary mb-4">
        <i class="bi bi-plus-circle me-1"></i> Registrar Nuevo Pago
    </a>
    <table class="table table-bordered table-striped shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nº Recibo</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Descripción</th>
                <th>Periodo</th>
                <th>Acciones</th>
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
                <td>
                    <a href="{{ route('payments.receipt', $payment->id) }}" class="btn btn-sm btn-primary btn-action">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Descargar PDF
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver al Listado de Estudiantes
    </a>
</div>
@endsection