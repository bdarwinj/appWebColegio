@extends('layouts.app')

@section('title', 'Historial de Pagos')

@section('content')
<style>
    /* Estilos personalizados para mejorar el diseño */
    .table thead th {
        background-color: #003366; /* Azul oscuro para encabezado */
        color: white;
        border-radius: 4px 4px 0 0; /* Bordes redondeados en la parte superior */
    }
    .table tbody tr:hover {
        background-color: #f0f0f0; /* Gris claro al pasar el cursor */
        transition: background-color 0.2s ease; /* Transición suave */
    }
    .form-control {
        border-radius: 4px; /* Bordes redondeados para inputs */
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
    .pagination {
        margin-top: 20px;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4">Historial de Pagos</h2>
    <!-- Formulario de búsqueda mejorado -->
    <form action="{{ route('payments.history.all') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-8">
            <input type="text" name="search" class="form-control" placeholder="Buscar por identificación, nombre o apellido" value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i> Buscar
            </button>
        </div>
    </form>
    <table class="table table-bordered table-striped shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nº Recibo</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Descripción</th>
                <th>Periodo</th>
                <th>Estudiante</th>
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
                    @if($payment->student)
                        {{ $payment->student->identificacion }} - {{ $payment->student->nombre }} {{ $payment->student->apellido }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <a href="{{ route('payments.receipt', $payment->id) }}" class="btn btn-sm btn-primary btn-action">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Descargar PDF
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Paginación centrada -->
    <div class="d-flex justify-content-center pagination">
        {{ $payments->withQueryString()->links() }}
    </div>
</div>
@endsection