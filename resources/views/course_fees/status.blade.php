@extends('layouts.app')

@section('title', 'Estado de Cuenta de Mensualidades')

@section('content')
<style>
    .table thead th {
        background-color: #003366; /* Azul oscuro */
        color: white;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0; /* Gris claro al pasar el cursor */
    }
    .alert {
        border-radius: 4px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
    }
    .container {
        padding-top: 20px;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        color: #003366; /* Azul oscuro para textos de DataTables */
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #0066CC; /* Azul personalizado */
        color: white;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #004080; /* Azul más oscuro al pasar el ratón */
        color: white;
    }
    .dataTables_filter{
        margin-bottom: 5px;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4" style="color: #003366;">Estado de Cuenta de Mensualidades - Año {{ $academicYear }}</h2>
    
    @if($globalBalance == 0)
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle me-2"></i> Todos los estudiantes están al día.
        </div>
    @else
        <div class="alert alert-warning d-flex align-items-center mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Total Adeudado Global:</strong> ${{ number_format($globalBalance, 2) }} <br>
            <strong> - Total de Meses Pendientes:</strong> {{ $globalPendingMonths }}
        </div>
    @endif

    <table id="courseFeesTable" class="table table-bordered table-striped">
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
            <!-- Se llenará de forma asíncrona -->
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#courseFeesTable').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "{{ route('course_fees.status.ajax') }}",
                "data": {
                    "academic_year": "{{ $academicYear }}"
                }
            },
            "columns": [
                { "data": "id" },
                { "data": "identificacion" },
                { "data": "nombre" },
                { "data": "course" },
                { "data": "monthly_fee" },
                { "data": "expected_total" },
                { "data": "total_paid" },
                { "data": "balance" },
                { "data": "pending_months" }
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
            },
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
            "dom": 'Bfrtip', // Habilitar botones
            "buttons": [
                'copy', 'excel', 'pdf', 'print' // Botones para exportar
            ]
        });
    });
</script>
@endsection