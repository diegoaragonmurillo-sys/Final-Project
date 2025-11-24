<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotoVolt Perú</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Global Styles -->
    <style>
.product-thumb {
    width: 100%;
    height: 230px;
    object-fit: contain;
    background: #fff;
    border-radius: 10px;
}

.product-main {
    width: 100%;
    height: 380px;
    object-fit: contain;
    background: #fff;
    border-radius: 12px;
}

.product-variant {
    width: 70px;
    height: 70px;
    object-fit: contain;
    cursor: pointer;
    border-radius: 6px;
    transition: .2s;
}
.product-variant:hover {
    transform: scale(1.15);
    border: 2px solid #007bff;
}
</style>

</head>
<body class="bg-light">

<!-- 🧭 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm px-4">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
        ⚡ <strong>MotoVolt</strong>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="menu" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            <li><a class="nav-link" href="{{ route('motos.index') }}">Catálogo</a></li>
            <li><a class="nav-link" href="{{ route('carrito.index') }}">Carrito 🛒</a></li>

            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a class="nav-link text-warning fw-bold" href="{{ route('admin') }}">🛠 Admin</a></li>
                @endif
            @endauth
        </ul>

        <ul class="navbar-nav align-items-center">

            {{-- 🔑 Usuarios --}}
            @guest
                <li><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                <li><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
            @else
                <li class="nav-link text-light">👋 {{ auth()->user()->name }}</li>
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

<!-- 🏷️ CONTENIDO -->
<div class="container py-4">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<!-- AlpineJS (para cambios dinámicos como variantes de color) -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html>
