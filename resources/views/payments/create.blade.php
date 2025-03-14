{{-- resources/views/payments/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Pago')

@section('content')
<div class="container">
    <h2>Registrar Pago</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">Estudiante</label>
            <select class="form-select" id="student_id" name="student_id" required>
                <option value="">-- Seleccionar Estudiante --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->identificacion }} - {{ $student->nombre }} {{ $student->apellido }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Monto</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="mb-3">
            <label for="period" class="form-label">Periodo (Mes)</label>
            <select class="form-select" id="period" name="period" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Pago</button>
    </form>
</div>

<!-- Modal para mostrar el recibo de pago -->
@if(session('receipt'))
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="receiptModalLabel">Recibo de Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
          <div class="container">
              <h4>Detalles del Recibo</h4>
              <ul class="list-group mb-3">
                  <li class="list-group-item"><strong>Recibo Nº:</strong> {{ session('receipt.receipt_number') }}</li>
                  <li class="list-group-item"><strong>Monto:</strong> {{ session('receipt.amount') }}</li>
                  <li class="list-group-item"><strong>Fecha y Hora:</strong> {{ session('receipt.payment_date') }}</li>
                  <li class="list-group-item"><strong>Descripción:</strong> {{ session('receipt.description') }}</li>
                  <li class="list-group-item"><strong>Periodo:</strong> {{ session('receipt.period') }}</li>
              </ul>
          </div>
      </div>
      <div class="modal-footer">
        <a href="{{ route('payments.receipt', session('receipt.id')) }}" class="btn btn-primary">Descargar PDF</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endif

@if(session('receipt'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        receiptModal.show();
    });
</script>
@endif
@endsection
