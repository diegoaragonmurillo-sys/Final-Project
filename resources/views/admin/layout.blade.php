<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador - MotoVolt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f9fafb; }
        .sidebar {
            width: 250px;
            background: #13a74b;
            height: 100vh;
            color:white;
            position: fixed;
            padding-top:20px;
        }
        .sidebar a {
            color:white;
            display:block;
            padding:10px 20px;
            text-decoration:none;
            font-weight:500;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.15);
        }
        .main {
            margin-left: 260px;
            padding: 30px;
        }
    </style>
</head>

<body>

@php
    if(!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Acceso solo para administradores.');
    }
@endphp

<div class="sidebar">
    <h4 class="text-center mb-4">⚙ Admin MotoVolt</h4>

    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.motos.index') }}">🛒 Productos</a>
    <a href="{{ route('admin.pedidos.index') }}">📦 Pedidos</a>
    <a href="{{ route('admin.usuarios.index') }}">👥 Usuarios</a>
    <a href="{{ route('admin.cupones.index') }}">🎟 Cupónes</a>

    <hr class="border-light">

    <a href="{{ route('home') }}">🏠 Ver tienda</a>

    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        🚪 Cerrar Sesión
    </a>
</div>

<div class="main">
    @yield('content')
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

</body>
</html>
