<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotoVolt Perú</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animaciones suaves (opcional pero mejora UX) -->
    <style>
        .scale-110 { transform: scale(1.10); }
        .transition { transition: .25s ease-in-out; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="{{ route('home') }}">⚡ MotoVolt</a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            <li><a class="nav-link" href="{{ route('motos.index') }}">Catálogo</a></li>
            <li><a class="nav-link" href="{{ route('carrito.index') }}">Carrito 🛒</a></li>

            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a class="nav-link" href="{{ route('admin') }}">Admin Panel</a></li>
                @endif
            @endauth
        </ul>

        <ul class="navbar-nav">
            @guest
                <li><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                <li><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
            @else
                <li class="nav-link">Hola, {{ auth()->user()->name }}</li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-light">Salir</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<div class="container py-4">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AlpineJS (NECESARIO PARA CAMBIAR COLOR E IMAGEN) -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html>
