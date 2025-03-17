@extends('layouts.auth')
@section('title', 'Iniciar Sesión - Sistema Colegio')

@section('content')
<style>
    body {
        background-color: #F0F0F0; /* Gris claro para el fondo */
        font-family: 'Arial', sans-serif;
    }
    .card {
        background-color: #FFFFFF; /* Fondo blanco */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        border-radius: 8px; /* Bordes redondeados */
        padding: 20px;
        margin-top: 50px; /* Espacio superior */
    }
    .card-title {
        font-size: 24px;
        color: #003366; /* Azul oscuro */
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: bold;
        color: #003366; /* Azul oscuro */
    }
    .btn-primary {
        background-color: #0066CC; /* Azul claro */
        border: none;
        transition: background-color 0.3s; /* Transición suave */
    }
    .btn-primary:hover {
        background-color: #004080; /* Azul más oscuro al pasar el mouse */
    }
    .alert-danger {
        margin-bottom: 20px; /* Espacio debajo de los errores */
    }
    .logo {
        display: block;
        margin: 0 auto 10px; /* Centrado con espacio inferior */
        max-height: 80px; /* Tamaño máximo del logo */
    }
    .school-name {
        font-size: 28px;
        color: #003366; /* Azul oscuro */
        text-align: center;
        margin-bottom: 20px; /* Espacio debajo del nombre */
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <!-- Logo del colegio -->
                @if(isset($logoPath))
                    <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo del Colegio" class="logo">
                @endif
                <!-- Nombre del colegio -->
                <h2 class="school-name">{{ $schoolName ?? 'Nombre del Colegio' }}</h2>
                <h3 class="card-title text-center">Iniciar Sesión</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="{{ route('doLogin') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection