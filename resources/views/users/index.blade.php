@extends('layouts.app')

@section('title', 'Listado de Usuarios')

@section('content')
<style>
    .table thead th {
        background-color: #003366; /* Azul oscuro */
        color: white;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0; /* Gris claro al pasar el cursor */
        cursor: pointer;
    }
    .alert {
        border-radius: 4px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .modal-header {
        background-color: #003366;
        color: white;
    }
    .modal-content {
        border-radius: 8px;
    }
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>

<div class="container py-4">
    <h2 class="text-center mb-4" style="color: #003366;">Listado de Usuarios</h2>
    
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    
    <table id="usersTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody style="cursor: pointer;">
            @foreach($users as $user)
            <tr data-user-id="{{ $user->id }}">
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <!-- Botón para cambiar contraseña (se carga vía doble clic) -->
                    <button type="button" class="btn btn-sm btn-warning btn-edit-user" data-user-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#changeUserPasswordModal">
                        <i class="bi bi-pencil"></i> Cambiar Clave
                    </button>
                    <!-- Botón para eliminar usuario -->
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal: Cambiar Contraseña de Usuario -->
@if(Auth::user()->role === 'admin')
<div class="modal fade" id="changeUserPasswordModal" tabindex="-1" aria-labelledby="changeUserPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="changeUserPasswordContent">
      <!-- El contenido se cargará vía AJAX -->
      <div class="modal-header">
        <h5 class="modal-title" id="changeUserPasswordModalLabel">Cambiar Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    // Inicializar DataTables en la tabla de usuarios
    var table = $('#usersTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
    });

    // Delegar el evento de doble clic sobre el tbody (para cargar formulario de cambio de contraseña)
    $('#usersTable tbody').on('dblclick', 'tr', function(){
        var userId = $(this).data('user-id');
        console.log("Fila doble clickeada. userId:", userId);
        if(!userId) {
            alert("No se encontró el ID del usuario en la fila.");
            return;
        }
        var modalContent = $('#changeUserPasswordContent');
        modalContent.html(
          '<div class="modal-header">' +
            '<h5 class="modal-title" id="changeUserPasswordModalLabel">Cambiar Contraseña</h5>' +
            '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>' +
          '</div>' +
          '<div class="modal-body text-center">' +
            '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>' +
          '</div>'
        );
        
        $.ajax({
            url: '/users/' + userId + '/change-password',
            type: 'GET',
            success: function(response) {
                modalContent.html(response);
                var myModal = new bootstrap.Modal(document.getElementById('changeUserPasswordModal'));
                myModal.show();
            },
            error: function(xhr, status, error) {
                modalContent.html('<p class="text-danger">Error al cargar el formulario. Inténtelo nuevamente.</p>');
                console.error("AJAX error:", status, error);
            }
        });
    });

    // También, si se hace clic en el botón "Cambiar Clave" dentro de cada fila, se puede cargar el formulario (esto es opcional)
    $('.btn-edit-user').on('click', function(e){
        e.stopPropagation(); // Evita que el doble clic se dispare
        var userId = $(this).data('user-id');
        var modalContent = $('#changeUserPasswordContent');
        modalContent.html(
          '<div class="modal-header">' +
            '<h5 class="modal-title" id="changeUserPasswordModalLabel">Cambiar Contraseña</h5>' +
            '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>' +
          '</div>' +
          '<div class="modal-body text-center">' +
            '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>' +
          '</div>'
        );
        
        $.ajax({
            url: '/users/' + userId + '/change-password',
            type: 'GET',
            success: function(response) {
                modalContent.html(response);
                var myModal = new bootstrap.Modal(document.getElementById('changeUserPasswordModal'));
                myModal.show();
            },
            error: function(xhr, status, error) {
                modalContent.html('<p class="text-danger">Error al cargar el formulario. Inténtelo nuevamente.</p>');
                console.error("AJAX error:", status, error);
            }
        });
    });
});
</script>
@endsection
