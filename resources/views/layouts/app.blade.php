<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema Colegio')</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"/>
    <!-- CSS para DataTables Buttons -->
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <!-- Favicon -->
    @if($logoPath)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $logoPath) }}">
    @endif
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .navbar-brand img {
            max-height: 40px;
            margin-right: 10px;
            border-radius: 50%; /* Bordes redondeados para el logo */
        }
        .navbar-dark .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #ddd;
        }
        .dropdown-menu {
            background-color: #f8f9fa;
        }
        .dropdown-item:hover {
            background-color: #e9ecef;
        }
        .navbar-nav .nav-item .nav-link i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        @if($logoPath)
            <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo del Colegio">
        @endif
        {{ $schoolName }}
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Menú de navegación con iconos -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
        </li>
        <!-- Cursos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="coursesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-book"></i> Cursos
          </a>
          <ul class="dropdown-menu" aria-labelledby="coursesDropdown">
            <li><a class="dropdown-item" href="{{ route('courses.index') }}">Listado de Cursos</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addCourseModal">Agregar Curso</a></li>
          </ul>
        </li>
        <!-- Estudiantes -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="studentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person"></i> Estudiantes
          </a>
          <ul class="dropdown-menu" aria-labelledby="studentsDropdown">
            <li><a class="dropdown-item" href="{{ route('students.index') }}">Listado de Estudiantes</a></li>
            @if(Auth::user()->role === 'admin')
            <li><a class="dropdown-item" href="{{ route('students.create') }}">Registrar Estudiante</a></li>
            @endif
          </ul>
        </li>
        <!-- Inscripciones -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('enrollments.index') }}"><i class="bi bi-pencil-square"></i> Inscripciones</a>
        </li>
         <!-- Pagos -->
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="paymentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pagos
          </a>
          <ul class="dropdown-menu" aria-labelledby="paymentsDropdown">
            <li><a class="dropdown-item" href="{{ route('payments.create') }}">Registrar Pago</a></li>
            <li><a class="dropdown-item" href="{{ route('payments.history.all') }}">Historial de Pagos</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <!-- Submenú para Mensualidades -->
            @if(Auth::user()->role === 'admin')
              <li><a class="dropdown-item" href="{{ route('course_fees.config') }}">Configurar Tarifas</a></li>
              <li><a class="dropdown-item" href="{{ route('course_fees.status') }}">Estado de Cuenta</a></li>
            @endif
          </ul>
        </li>
        <!-- Usuarios -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-people"></i> Usuarios
          </a>
          <ul class="dropdown-menu" aria-labelledby="usersDropdown">
            <li><a class="dropdown-item" href="{{ route('users.index') }}">Listado de Usuarios</a></li>
            <li><a class="dropdown-item" href="{{ route('users.create') }}">Crear Usuario</a></li>
          </ul>
        </li>
        <!-- Configuración Colegio -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('config.edit') }}"><i class="bi bi-gear"></i> Configuración Colegio</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="d-flex">
            @csrf
            <button type="submit" class="btn btn-outline-light"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    @yield('content')
</div>
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle with Popper CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS CDN -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<!-- JS de DataTables Buttons y dependencias -->
<script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
@yield('scripts')
</body>
</html>