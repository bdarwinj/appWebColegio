{{-- resources/views/students/import.blade.php --}}
@extends('layouts.app')

@section('title', 'Importar Estudiantes desde Excel')

@section('content')
<div class="container">
    <h2>Importar Estudiantes desde Excel</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('import_errors'))
        <div class="alert alert-warning">
            <ul>
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="excel_file" class="form-label">Archivo Excel</label>
            <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xls,.xlsx" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar Estudiantes</button>
    </form>
</div>
@endsection
