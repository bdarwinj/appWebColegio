<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <h3 class="text-center">Iniciar Sesión</h3>
        <form action="{{ route('doLogin') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="form-group mt-2">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    {{ $errors->first() }}
                </div>
            @endif
            <button type="submit" class="btn btn-primary mt-3 w-100">Iniciar Sesión</button>
        </form>
    </div>
</div>
@endsection
