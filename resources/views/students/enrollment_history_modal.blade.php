{{-- resources/views/students/enrollment_history_modal.blade.php --}}
<div class="container">
    <h4 class="mb-3">Historial de Inscripciones de {{ $student->nombre }} {{ $student->apellido }}</h4>
    @if($student->enrollments->isEmpty())
        <p>No se encontraron inscripciones para este estudiante.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Año Académico</th>
                    <th>Estado</th>
                    <th>Fecha de Inscripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->id }}</td>
                    <td>
                        @if($enrollment->course)
                            {{ $enrollment->course->name }}
                            @if($enrollment->course->seccion) - {{ $enrollment->course->seccion }} @endif
                            @if($enrollment->course->jornada) - {{ $enrollment->course->jornada }} @endif
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $enrollment->academic_year }}</td>
                    <td>{{ $enrollment->status }}</td>
                    <td>{{ $enrollment->date_enrolled }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
