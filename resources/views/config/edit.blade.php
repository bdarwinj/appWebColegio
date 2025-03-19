@extends('layouts.app')

@section('title', 'Editar Configuración del Colegio')

@section('content')
<style>
    .form-label {
        font-weight: bold;
        color: #003366; /* Azul oscuro */
    }
    .btn-primary {
        background-color: #0066CC; /* Azul personalizado */
        border: none;
    }
    .btn-primary:hover {
        background-color: #004080; /* Azul más oscuro al pasar el ratón */
    }
    .alert {
        border-radius: 4px;
    }
    .img-thumbnail {
        max-width: 200px;
        border-radius: 8px;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #003366;
        color: white;
    }
</style>

<div class="container py-4">
    <h2 class="text-center mb-4" style="color: #003366;">Editar Configuración del Colegio</h2>

    <!-- Mensajes de éxito -->
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Mensajes de error -->
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

    <!-- Formulario de Configuración -->
    <form action="{{ route('config.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-gear"></i> Configuración General
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="SCHOOL_NAME" class="form-label">Nombre del Colegio</label>
                    <input type="text" class="form-control" id="SCHOOL_NAME" name="SCHOOL_NAME" value="{{ $configs['SCHOOL_NAME'] ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo del Colegio (opcional)</label>
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                    @if(isset($configs['LOGO_PATH']) && $configs['LOGO_PATH'])
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $configs['LOGO_PATH']) }}" alt="Logo" class="img-thumbnail">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Guardar Configuración</button>
        </div>
    </form>

    <!-- Separador -->
    <hr class="my-4">

    <!-- Sección Backup/Restaurar -->
    <h3 class="text-center mb-4" style="color: #003366;">Backup / Restaurar Base de Datos</h3>
    <div class="row">
        <!-- Backup -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-database"></i> Backup
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('database.backup') }}" class="btn btn-warning">Hacer Backup</a>
                </div>
            </div>
        </div>
        <!-- Restaurar -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-database-up"></i> Restaurar
                </div>
                <div class="card-body">
                    <form action="{{ route('database.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="backup_file" class="form-label">Seleccionar Archivo de Backup (.sql)</label>
                            <input type="file" class="form-control" id="backup_file" name="backup_file" accept=".sql" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Restaurar Base de Datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection