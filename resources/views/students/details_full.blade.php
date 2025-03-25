@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('content')
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .card-header {
        background-color: #003366;
        color: white;
        font-weight: bold;
    }
    .card-body p {
        margin-bottom: 10px;
        line-height: 1.6;
    }
    .card-body strong {
        color: #003366;
    }
    .table thead th {
        background-color: #003366;
        color: white;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0;
    }
    .btn-secondary {
        background-color: #0066CC;
        border: none;
        transition: background-color 0.3s;
    }
    .btn-secondary:hover {
        background-color: #004080;
    }
</style>
<div class="container py-4">
    <h2 class="text-center mb-4" style="color: #003366;">Detalles del Estudiante</h2>
    
    <div class="card mb-4">
        <div class="card-header">
            Información del Estudiante
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $student->id }}</p>
            <p><strong>Identificación:</strong> {{ $student->identificacion }}</p>
            <p><strong>Nombre:</strong> {{ $student->nombre }} {{ $student->apellido }}</p>
            <p><strong>Curso:</strong> 
                @if($student->course)
                    {{ $student->course->name }}
                    @if($student->course->seccion)
                        - {{ $student->course->seccion }}
                    @endif
                    @if($student->course->jornada)
                        - {{ $student->course->jornada }}
                    @endif
                @else
                    N/A
                @endif
            </p>
            <p><strong>Representante:</strong> {{ $student->representante }}</p>
            <p><strong>Teléfono:</strong> {{ $student->telefono }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Estado:</strong> {{ $student->active ? 'Activo' : 'Inactivo' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Historial de Pagos
        </div>
        <div class="card-body">
            @if($payments->isEmpty())
                <p>No se encontraron registros de pago para este estudiante.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="paymentsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Recibo Nº</th>
                                <th>Monto</th>
                                <th>Fecha de Pago</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->receipt_number }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->payment_date }}</td>
                                <td>{{ $payment->description }} <a href="{{ route('payments.receipt', $payment->id) }}" class="btn btn-sm btn-primary btn-action">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Descargar PDF
                    </a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Volver al Listado de Estudiantes</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $('#paymentsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
    });
});
</script>
@endsection