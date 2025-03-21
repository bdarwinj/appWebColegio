@extends('layouts.app')

@section('title', 'Cambiar Contraseña')

@section('content')
<style>
    .form-label {
        font-weight: bold;
        color: #003366; /* Azul oscuro */
    }
    .form-control {
        border-radius: 4px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s ease;
    }
    .form-control:focus {
        border-color: #0066CC; /* Azul personalizado */
        box-shadow: 0 0 5px rgba(0, 102, 204, 0.5);
    }
    .btn-primary {
        background-color: #0066CC; /* Azul personalizado */
        border: none;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #004080; /* Azul más oscuro */
    }
    .alert {
        border-radius: 4px;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .container {
        padding-top: 20px;
    }
</style>

<div class="container">
    <h2 class="text-center mb-4" style="color: #003366;">Cambiar Contraseña</h2>
    
    @if($errors->any())
        <div class="alert alert-danger d-flex align-items-center mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('password.change') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="current_password" class="form-label">Contraseña Actual</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Nueva Contraseña</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
        </div>
    </form>
</div>
@endsection