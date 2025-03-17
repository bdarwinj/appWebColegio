@extends('layouts.app')

@section('title', 'Editar Configuración del Colegio')

@section('content')
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-label {
        font-weight: bold;
        color: #003366;
    }
    .btn-primary {
        background-color: #0066CC;
        border: none;
    }
    .btn-primary:hover {
        background-color: #004080;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: none;
        border-radius: 4px;
    }
    h2 {
        color: #003366;
        font-weight: 600;
    }
</style>

<div class="container py-4">
    <h2 class="text-center mb-4">Editar Configuración del Colegio</h2>
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('config.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="SCHOOL_NAME" class="form-label">Nombre del Colegio</label>
                    <input type="text" class="form-control" id="SCHOOL_NAME" name="SCHOOL_NAME" value="{{ $configs['SCHOOL_NAME'] ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo del Colegio (opcional)</label>
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                    @if(isset($configs['LOGO_PATH']) && $configs['LOGO_PATH'])
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $configs['LOGO_PATH']) }}" alt="Logo" style="max-width: 200px; border-radius: 4px;">
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection