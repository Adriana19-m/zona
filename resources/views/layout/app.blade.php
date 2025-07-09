<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Geo Riesgos</title>

  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f4f8f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar {
      background-color: #007d8f;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .navbar-brand, .navbar-nav .nav-link {
      color: white !important;
    }

    .navbar-nav .nav-link:hover {
      color: #cfeef1 !important;
    }

    .main-title {
      font-weight: bold;
      color: #007d8f;
    }

    .card-custom {
      background-color: white;
      border: none;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      padding: 2rem;
    }

    footer {
      background-color: #004d4d;
      color: white;
    }

    footer a {
      color: #e0f7fa;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    .social-icons i {
      font-size: 1.5rem;
      margin-right: 15px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="{{ route('riesgos.index') }}">
      <i class="bi bi-exclamation-diamond-fill me-2"></i> Sistema de Riesgos
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('riesgos.index') }}"><i class="bi bi-house-door-fill"></i> Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('riesgos.create') }}"><i class="bi bi-plus-circle-fill"></i> Nuevo Riesgo</a></li>

        <li  class="nav-item"><a class="nav-link" href="{{ route('seguras.create') }}"><i class="bi bi-map-fill"></i> Nuevas Zonas Seguras</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('seguras.index') }}"><i class="bi bi-house-door-fill"></i> zonas S</a></li>
        <li  class="nav-item"><a class="nav-link" href="{{ route('encuentros.create') }}"><i class="bi bi-map-fill"></i> Nuevos Puntos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('encuentros.index') }}"><i class="bi bi-house-door-fill"></i> vista de puntos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('encuentros/mapa') }}"><i class="bi bi-map-fill"></i> Ver Puntos Mapa</a></li>

      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i> Cuenta
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Iniciar Sesión</a></li>
            <li><a class="dropdown-item" href="#">Registrarse</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Contenido Principal -->
<div class="container my-5">
  <div class="card card-custom">
    <h2 class="main-title mb-4"><i class="bi bi-tools me-2"></i> MENÚ DE RIESGOS</h2>
    <hr>
    @yield('contenido')
    <hr>
  </div>
</div>

<!-- Footer -->
<footer class="pt-4 pb-3 mt-5">
  <div class="container">
    <div class="row">
      <!-- Col 1 -->
      <div class="col-md-4 mb-3">
        <h5>Contacto</h5>
        <p><i class="bi bi-geo-alt-fill"></i> Ecuador</p>
        <p><i class="bi bi-envelope-fill"></i> contacto@empresa.com</p>
        <p><i class="bi bi-telephone-fill"></i> +593 999 999 999</p>
      </div>
      <!-- Col 2 -->
      <div class="col-md-4 mb-3 text-center">
        <h5>Síguenos</h5>
        <div class="social-icons">
          <a href="https://wa.me/593999999999" target="_blank" class="text-success"><i class="bi bi-whatsapp"></i></a>
          <a href="https://facebook.com/tuempresa" target="_blank" class="text-primary"><i class="bi bi-facebook"></i></a>
          <a href="https://instagram.com/tuempresa" target="_blank" class="text-danger"><i class="bi bi-instagram"></i></a>
          <a href="mailto:contacto@empresa.com" class="text-white"><i class="bi bi-envelope-fill"></i></a>
        </div>
      </div>
      <!-- Col 3 -->
      <div class="col-md-4 mb-3 text-md-end text-center">
        <h5>Cuenta</h5>
        <a href="#" class="d-block">Iniciar sesión</a>
        <a href="#" class="d-block">Registrarse</a>
        <a href="#" class="d-block">Recuperar contraseña</a>
      </div>
    </div>
    <hr class="border-light">
    <div class="text-center">
      <p class="mb-0">&copy; {{ date('Y') }} Sistema de Riesgos. Todos los derechos reservados.</p>
    </div>
  </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
