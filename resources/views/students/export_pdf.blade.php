<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Estudiantes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: center; }
        th { background-color: #003366; color: white; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Listado de Estudiantes</h2>
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
                <th>Estado</th>
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
                    <td>{{ $student->active ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
