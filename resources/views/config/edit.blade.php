{{-- resources/views/config/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Configuración del Colegio')

@section('content')
<div class="container">
    <h2>Editar Configuración del Colegio</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
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
                    <img src="{{ asset('storage/' . $configs['LOGO_PATH']) }}" alt="Logo" style="max-width: 200px;">
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
    </form>
</div>
@endsection
