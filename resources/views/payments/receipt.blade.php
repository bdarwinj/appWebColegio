{{-- resources/views/payments/receipt.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; position: relative; }
        .header img { max-height: 60px; position: absolute; left: 0; top: 0; }
        .header h2 { font-size: 18px; color: #003366; margin: 0; padding-top: 10px; }
        .header h3 { font-size: 14px; color: #003366; margin: 5px 0; }
        .header .line { border-bottom: 1px solid #003366; margin-top: 10px; }
        .details, .payment-info { width: 80%; margin: 0 auto 10px; background-color: #F0F0F0; border-radius: 5px; padding: 10px; }
        .details table, .payment-info table { width: 100%; }
        .details td, .payment-info td { padding: 5px; vertical-align: top; }
        .details td strong, .payment-info td strong { color: #003366; }
        .payment-info .amount { color: #0066CC; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        @if($logoPath)
            <img src="{{ public_path('storage/' . $logoPath) }}" alt="Logo del Colegio">
        @endif
        <h2>{{ $schoolName }}</h2>
        <h3>Recibo de Pago</h3>
        <div class="line"></div>
    </div>
    <div class="details">
        <table>
            <tr>
                <td><strong>Recibo Nº:</strong> {{ $payment->receipt_number }}</td>
                <td><strong>Fecha y Hora:</strong> {{ $payment->payment_date }}</td>
            </tr>
            <tr>
                <td><strong>Alumno:</strong> {{ $student->nombre }} {{ $student->apellido }}</td>
                <td><strong>Periodo:</strong> {{ $payment->period }}</td>
            </tr>
        </table>
    </div>
    <div class="payment-info">
        <table>
            <tr>
                <td><strong>Monto:</strong> <span class="amount">{{ $payment->amount }}</span></td>
                <td><strong>Descripción:</strong> {{ $payment->description }}</td>
            </tr>
        </table>
    </div>
</body>
</html>