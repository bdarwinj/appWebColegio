{{-- resources/views/payments/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Pago')

@section('content')
<div class="container">
    <h2>Registrar Pago</h2>
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
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
