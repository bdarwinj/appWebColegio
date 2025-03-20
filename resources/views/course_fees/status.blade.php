@extends('layouts.app')

@section('title', 'Estado de Cuenta de Mensualidades')

@section('content')
<div class="container">
    <h2 class="mb-4">Estado de Cuenta de Mensualidades - Año {{ $academicYear }}</h2>
    <table id="courseFeesTable" class="table table-bordered">
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
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
        });
    });
</script>
@endsection
