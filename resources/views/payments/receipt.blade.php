{{-- resources/views/payments/receipt.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-height: 60px; }
        .details, .payment-info { width: 100%; margin-bottom: 10px; }
        .details td, .payment-info td { padding: 5px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        @if($logoPath)
            <img src="{{ public_path('storage/' . $logoPath) }}" alt="Logo del Colegio">
        @endif
        <h2>{{ $schoolName }}</h2>
        <h3>Recibo de Pago</h3>
    </div>
    <table class="details">
        <tr>
            <td><strong>Recibo Nº:</strong> {{ $payment->receipt_number }}</td>
            <td><strong>Fecha y Hora:</strong> {{ $payment->payment_date }}</td>
        </tr>
        <tr>
            <td><strong>Alumno:</strong> {{ $student->nombre }} {{ $student->apellido }}</td>
            <td><strong>Periodo:</strong> {{ $payment->period }}</td>
        </tr>
    </table>
    <table class="payment-info">
        <tr>
            <td><strong>Monto:</strong> {{ $payment->amount }}</td>
            <td><strong>Descripción:</strong> {{ $payment->description }}</td>
        </tr>
    </table>
</body>
</html>
