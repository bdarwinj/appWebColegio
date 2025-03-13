<!-- resources/views/account_status.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Estado de Cuenta del Estudiante</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Total Esperado:</strong> {{ $status['expected_total'] }}</p>
            <p><strong>Total Pagado:</strong> {{ $status['total_paid'] }}</p>
            <p><strong>Balance Pendiente:</strong> {{ $status['balance'] }}</p>
            <p><strong>Periodos Pagados:</strong> {{ implode(', ', $status['paid_periods']) }}</p>
            <p><strong>Periodos Pendientes:</strong> {{ implode(', ', $status['pending_periods']) }}</p>
        </div>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
