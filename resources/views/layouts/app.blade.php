<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema Colegio')</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Sistema Colegio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <!-- Cursos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="coursesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cursos
          </a>
          <ul class="dropdown-menu" aria-labelledby="coursesDropdown">
            <li><a class="dropdown-item" href="{{ route('courses.index') }}">Listado de Cursos</a></li>
            <li><a class="dropdown-item" href="{{ route('courses.create') }}">Agregar Curso</a></li>
          </ul>
        </li>
        <!-- Estudiantes -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="studentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Estudiantes
          </a>
          <ul class="dropdown-menu" aria-labelledby="studentsDropdown">
            <li><a class="dropdown-item" href="{{ route('students.index') }}">Listado de Estudiantes</a></li>
            <li><a class="dropdown-item" href="{{ route('students.create') }}">Registrar Estudiante</a></li>
          </ul>
        </li>
        <!-- Inscripciones -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('enrollments.index') }}">Inscripciones</a>
        </li>
        <!-- Pagos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="paymentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pagos
          </a>
          <ul class="dropdown-menu" aria-labelledby="paymentsDropdown">
            <li><a class="dropdown-item" href="{{ route('payments.create') }}">Registrar Pago</a></li>
            <li><a class="dropdown-item" href="{{ route('payments.history', 1) }}">Historial de Pagos</a></li>
          </ul>
        </li>
        <!-- Usuarios -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Usuarios
          </a>
          <ul class="dropdown-menu" aria-labelledby="usersDropdown">
            <li><a class="dropdown-item" href="{{ route('users.index') }}">Listado de Usuarios</a></li>
            <li><a class="dropdown-item" href="{{ route('users.create') }}">Crear Usuario</a></li>
          </ul>
        </li>
        <!-- Tarifas (Mensualidades) -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('course_fees.config') }}">Tarifas</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="d-flex">
            @csrf
            <button type="submit" class="btn btn-outline-light">Cerrar Sesión</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    @yield('content')
</div>
<!-- Bootstrap Bundle with Popper CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
