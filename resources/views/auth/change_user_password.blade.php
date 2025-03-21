<div class="modal-header">
    <h5 class="modal-title" id="changeUserPasswordModalLabel">Cambiar Contraseña para {{ $user->username }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body">
    @if($errors->any())
        <div class="alert alert-danger">
           <ul>
             @foreach($errors->all() as $error)
               <li>{{ $error }}</li>
             @endforeach
           </ul>
        </div>
    @endif
    <form action="{{ route('users.change_password', $user->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="new_password" class="form-label">Nueva Contraseña</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
    </form>
</div>
