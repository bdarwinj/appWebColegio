@extends('layouts.app')

@section('title', 'Registrar Pago')

@section('content')
<style>
    .form-label {
        font-weight: bold;
        color: #003366; /* Azul oscuro para etiquetas */
    }
    .input-group-text {
        background-color: #f8f9fa; /* Fondo claro para íconos */
        border: none;
    }
    .btn-primary {
        background-color: #0066CC; /* Azul personalizado */
        border: none;
    }
    .btn-primary:hover {
        background-color: #004080; /* Tono más oscuro al pasar el cursor */
    }
    .select2-container--default .select2-selection--single {
        border-radius: 4px; /* Bordes redondeados para Select2 */
    }
    .select2-selection__arrow {
        height: 100%; /* Ajustar la flecha de Select2 */
    }
</style>

<div class="container py-4">
    <h2 class="text-center mb-4" style="color: #003366;">Registrar Pago</h2>
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">Estudiante</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <select class="form-select select2-ajax" id="student_id" name="student_id" required>
                    <option value="">-- Seleccionar Estudiante --</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Monto</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="period" class="form-label">Periodo (Mes) <small>(opcional)</small></label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                <select class="form-select" id="period" name="period">
                    <option value="">-- No especificado --</option>
                    @php
                        $meses = [
                            1  => 'Enero',
                            2  => 'Febrero',
                            3  => 'Marzo',
                            4  => 'Abril',
                            5  => 'Mayo',
                            6  => 'Junio',
                            7  => 'Julio',
                            8  => 'Agosto',
                            9  => 'Septiembre',
                            10 => 'Octubre',
                            11 => 'Noviembre',
                            12 => 'Diciembre'
                        ];
                    @endphp
                    @foreach ($meses as $numero => $mes)
                        <option value="{{ $numero }}">{{ $mes }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Registrar Pago</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-ajax').select2({
                placeholder: '-- Seleccionar Estudiante --',
                ajax: {
                    url: '/api/students',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // Término de búsqueda
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
            });
        });
    </script>
@endsection
