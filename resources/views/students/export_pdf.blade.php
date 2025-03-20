<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Estudiantes</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 100px 40px 60px 40px; /* Espacio para encabezado y pie */
            color: #333; 
        }
        .header {
            position: fixed; /* Fijo en todas las páginas */
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            display: block;
            align-items: center;
            padding: 5px;
            background-color: white;
            border-bottom: 2px solid #003366;
        }
        .header img, h1 {
            display: inline-block;
            vertical-align: middle;
        }
        .header img {
            max-width: 100px;
            margin-right: 20px; /* Espacio entre logo y nombre */
        }
        .header h1 {
            font-size: 22px;
            color: #003366;
            margin: 0;
            font-weight: bold;
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 20px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #e0e0e0; 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background-color: #003366; 
            color: white; 
            font-weight: bold; 
        }
        .footer {
            position: fixed; /* Fijo en todas las páginas */
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            text-align: right;
            padding: 10px 40px;
            font-size: 10px;
            color: #666;
            background-color: white;
        }
    </style>
</head>
<body>
    <!-- Encabezado fijo con logo y nombre -->
    <div class="header">
        @if($logoPath)
            <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo del Colegio">
        @endif
        <h1>{{ $schoolName ?? 'Nombre del Colegio' }}</h1>
    </div>
    <!-- Título y tabla de estudiantes -->
    <h2>Listado de Estudiantes</h2>
    <table>
        <thead>
            <tr>
                <th>Identificación</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Curso</th>
                <th>Representante</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                @php
                    $courseName = $student->course ? $student->course->name : '';
                    if($student->course && $student->course->seccion) {
                        $courseName .= ' - ' . $student->course->seccion;
                    }
                    if($student->course && $student->course->jornada) {
                        $courseName .= ' - ' . $student->course->jornada;
                    }
                @endphp
                <tr>
                    <td>{{ $student->identificacion }}</td>
                    <td>{{ $student->nombre }}</td>
                    <td>{{ $student->apellido }}</td>
                    <td>{{ $courseName }}</td>
                    <td>{{ $student->representante }}</td>
                    <td>{{ $student->telefono }}</td>
                    <td>{{ $student->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pie de página fijo -->
    <div class="footer">
        Generado el {{ date('d/m/Y') }} | Sistema de Gestión Escolar
    </div>
</body>
</html>