{{-- resources/views/students/_form.blade.php --}}
<form action="{{ isset($student) ? route('students.update', $student->id) : route('students.store') }}" method="POST">
    @csrf
    @if(isset($student))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label for="identificacion" class="form-label">Número de Identificación</label>
        <input type="number" class="form-control" id="identificacion" name="identificacion" value="{{ $student->identificacion ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control uppercase" id="nombre" name="nombre" value="{{ $student->nombre ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control uppercase" id="apellido" name="apellido" value="{{ $student->apellido ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label for="course_id" class="form-label">Curso</label>
        <select class="form-select" id="course_id" name="course_id">
            <option value="">-- Seleccionar Curso --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}"
                    {{ (isset($student) && $student->course_id == $course->id) ? 'selected' : '' }}>
                    {{ $course->name }}
                    @if($course->seccion) - {{ $course->seccion }} @endif 
                    @if($course->jornada) - {{ $course->jornada }} @endif
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="representante" class="form-label">Representante</label>
        <input type="text" class="form-control uppercase" id="representante" name="representante" value="{{ $student->representante ?? '' }}">
    </div>
    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $student->telefono ?? '' }}">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $student->email ?? '' }}">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">
            {{ isset($student) ? 'Actualizar Estudiante' : 'Registrar Estudiante' }}
        </button>
    </div>
</form>
