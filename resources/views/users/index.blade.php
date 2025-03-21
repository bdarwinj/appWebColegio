@extends('layouts.app')

@section('title', 'Listado de Usuarios')

@section('content')
<div class="container">
    <h2 class="mb-4">Listado de Usuarios</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table id="usersTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody style="cursor: pointer;">
            @foreach($users as $user)
            <tr data-user-id="{{ $user->id }}">
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role }}</td>
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
      <div class="modal-body">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@section('scripts')
<!-- Inicializar DataTables (si lo deseas) -->
<script>
$(document).ready(function(){
    var table = $('#usersTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
    });

    // Delegar el evento de doble click sobre el tbody
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
});
</script>
@endsection
