{{-- resources/views/students/details_modal.blade.php --}}
<div class="container">
    <h4>Información del Estudiante</h4>
    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>ID:</strong> {{ $student->id }}</li>
        <li class="list-group-item"><strong>Identificación:</strong> {{ $student->identificacion }}</li>
        <li class="list-group-item"><strong>Nombre:</strong> {{ $student->nombre }}</li>
        <li class="list-group-item"><strong>Apellido:</strong> {{ $student->apellido }}</li>
        <li class="list-group-item"><strong>Correo:</strong> {{ $student->email }}</li>
        <li class="list-group-item"><strong>Curso:</strong> {{ $student->course_name }}</li>
        <li class="list-group-item"><strong>Representante:</strong> {{ $student->representante }}</li>
        <li class="list-group-item"><strong>Teléfono:</strong> {{ $student->telefono }}</li>
        <li class="list-group-item"><strong>Estado:</strong> {{ $student->active ? 'Activo' : 'Inactivo' }}</li>
    </ul>
    <h5>Historial de Pagos</h5>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nº Recibo</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Descripción</th>
                <th>Periodo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr><td>{{ $payment->receipt_number }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->description }}</td>
                <td>{{ $payment->period }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
