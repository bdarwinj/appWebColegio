<form action="{{ route('courses.update', $course->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title" id="editCourseModalLabel">Editar Curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $course->name }}" required>
        </div>
        <div class="mb-3">
            <label for="seccion" class="form-label">Sección</label>
            <input type="text" name="seccion" id="seccion" class="form-control" value="{{ $course->seccion }}">
        </div>
        <div class="mb-3">
            <label for="jornada" class="form-label">Jornada (opcional)</label>
            <select class="form-select" id="jornada" name="jornada">
                <option value="" {{ $course->jornada == '' ? 'selected' : '' }}>-- Seleccionar --</option>
                <option value="Mañana" {{ $course->jornada == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                <option value="Tarde" {{ $course->jornada == 'Tarde' ? 'selected' : '' }}>Tarde</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="active" class="form-label">Estado</label>
            <select name="active" id="active" class="form-select">
                <option value="1" {{ $course->active ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$course->active ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
</form>
