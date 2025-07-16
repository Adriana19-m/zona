<!-- Bootstrap 5.3 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
        background: linear-gradient(135deg, #a5dee5, #f9fafb);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card {
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border: none;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.4);
        border-color: #22c55e;
    }
    .btn-custom {
        background-color: #3B82F6;
        font-weight: bold;
        color: white;
        transition: 0.3s;
    }
    .btn-custom:hover {
        background-color: #2563EB;
    }
</style>

<div class="container">
    <div class="card p-5 mx-auto" style="max-width: 450px;">
        <div class="text-center mb-4">
            <h1 class="fw-bold text-dark mb-2">Bienvenido 👋</h1>
            <p class="text-secondary mb-0">Inicia sesión para continuar</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger text-center" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" name="email" required class="form-control" placeholder="ejemplo@correo.com">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" name="password" required class="form-control" placeholder="••••••••">
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-custom py-3">Iniciar Sesión</button>
            </div>
        </form>

        <!-- Puedes descomentar esta sección si quieres incluir registro -->
        <!--
        <p class="text-center text-muted mt-4">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-decoration-none text-success fw-bold">Regístrate</a>
        </p>
        -->
    </div>
</div>
