<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificación de Deuda</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        .content { max-width: 600px; margin: auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-width: 100px; margin-bottom: 10px; }
        .details { background-color: #f8f9fa; padding: 15px; border-radius: 5px; }
        .details ul { list-style: none; padding: 0; }
        .details li { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <!-- Reemplaza URL_DEL_LOGO por la URL real del logo -->
            <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo del Colegio">
            <h1>{{ $schoolName }}</h1>
        </div>
        <p>Estimado(a) {{ $student->nombre }} {{ $student->apellido }},</p>
        <p>Le notificamos que para el año académico {{ $academicYear }}, se ha detectado un saldo pendiente en sus mensualidades.</p>
        <div class="details">
            <p><strong>Detalle de la deuda:</strong></p>
            <ul>
                <li>Tarifa Mensual: ${{ number_format($balanceData['monthly_fee'], 2) }}</li>
                <li>Total Esperado (hasta el mes actual): ${{ number_format($balanceData['expected_total'], 2) }}</li>
                <li>Total Pagado: ${{ number_format($balanceData['total_paid'], 2) }}</li>
                <li>Balance Pendiente: ${{ number_format($balanceData['balance'], 2) }}</li>
                <li>Meses Pendientes: {{ $balanceData['pending_months'] }}</li>
            </ul>
        </div>
        <p>Por favor, realice el pago correspondiente a la brevedad posible.</p>
        <p>Atentamente,</p>
        <p>Administración del Colegio <strong>Instituto Nuevo Amanecer</strong> </p>
    </div>
</body>
</html>
