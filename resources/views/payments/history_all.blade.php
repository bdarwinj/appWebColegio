{{-- resources/views/payments/history_all.blade.php --}}
@extends('layouts.app')

@section('title', 'Historial de Pagos')

@section('content')
<div class="container">
    <h2>Historial de Pagos</h2>
    <!-- Formulario de búsqueda -->
    <form action="{{ route('payments.history.all') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-8">
            <input type="text" name="search" class="form-control" placeholder="Buscar por identificación, nombre o apellido" value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </form>
    <table class="table table-bordered table-striped">
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
                    <a href="{{ route('payments.receipt', $payment->id) }}" class="btn btn-sm btn-primary">Descargar PDF</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $payments->withQueryString()->links() }}
    </div>
</div>
@endsection
