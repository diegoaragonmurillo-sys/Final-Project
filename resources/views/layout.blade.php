<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotoVolt Perú</title>

    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background:#f5f5f5; font-family: 'Segoe UI', sans-serif; }
/* Alinear repuestos al mismo nivel */
.dropdown-hover > a {
    padding:6px 14px;
    border-radius:20px;
    font-size:.95rem;
    display:flex;
    align-items:center;
    height:100%;
}

/* Aplicar mismo hover */
.dropdown-hover > a:hover {
    background:white;
    color:#13a74b !important;
}

/* Asegurar alineación con flex */
.categories-menu {
    display:flex;
    align-items:center;
}

        /* Buscar estilo glass */
        .search-bar {
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 8px;
            width: 100%;
            transition: all .25s ease-in-out;
        }
        .search-bar:hover { background:rgba(255,255,255,.9); transform:scale(1.01); }

        .search-btn {
            background:#13a74b;
            color:white;
            width:42px;height:42px;
            border-radius:50%;
            transition:.2s;
        }
        .search-btn:hover { background:#0f8e3f; transform:scale(1.12); }

        .categories-menu a {
            padding:6px 14px;
            border-radius:20px;
            font-size:.95rem;
            transition:.25s;
        }
        .categories-menu a:hover {
            background:white;
            color:#13a74b !important;
        }

        /* Botón login */
        .btn-login {
            padding:8px 18px;
            background:#13a74b;
            border-radius:10px;
            font-weight:600;
            color:white !important;
            transition:.25s;
        }
        .btn-login:hover { background:#0f8e3f; transform:scale(1.05); }

        /* Navbar responsiveness */
        @media(max-width:992px){
            .desktop-menu{ display:none !important; }
            nav{ padding:10px; }
        }
        @media(min-width:992px){
            .mobile-menu{ display:none !important; }
        }

        /* =============================== */
        /* 🔧 DROPDOWN HOVER - REPUESTOS */
        /* =============================== */
        .dropdown-hover {
            position: relative;
        }

        .dropdown-hover .dropdown-menu {
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: all .25s ease;
        }

        .dropdown-hover:hover .dropdown-menu {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-hover .dropdown-menu a:hover {
            background:#13a74b;
            color:white;
        }
    </style>
</head>

<body>

<nav class="shadow-sm bg-white py-2">
    <div class="container d-flex justify-content-between align-items-center gap-3">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <img src="/imagenes/logo.png" style="height:40px;">
            <span class="fw-bold" style="color:#13a74b;font-size:22px;">MotoVolt</span>
        </a>

        {{-- BUSCADOR DESKTOP --}}
        <div class="desktop-menu flex-grow-1 mx-4">
            <form action="{{ route('motos.index') }}" method="GET" class="search-bar d-flex align-items-center">
                <i class="bi bi-search ms-3 text-muted"></i>
                <input type="text" name="buscar" placeholder="Buscar en MotoVolt..." 
                       value="{{ request('buscar') }}" 
                       class="form-control border-0 bg-transparent shadow-none">

                <select name="categoria" class="form-select border-0 bg-transparent text-muted" style="max-width:160px;">
                    <option value="">Todo</option>
                    <option value="bicimotos">Bicimotos</option>
                    <option value="motos-electricas">Motos eléctricas</option>
                    <option value="trimotos">Trimotos</option>
                    <option value="accesorios">Accesorios</option>
                    <option value="repuestos">Repuestos</option>
                </select>

                <button class="btn search-btn ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        {{-- ICONOS Y USUARIO --}}
        <div class="d-flex align-items-center gap-3">

            @guest
                <a href="{{ route('login') }}" class="btn-login text-nowrap">
                    <i class="bi bi-person"></i> Ingresar
                </a>
            @else
                <div class="dropdown">
                    <a class="text-dark fw-semibold dropdown-toggle text-decoration-none" href="#" data-bs-toggle="dropdown">
                        👋 {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        @if(auth()->user()->role === 'admin')
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">🛠 Panel admin</a></li>
                        @endif

                        <li><a class="dropdown-item" href="{{ route('favoritos.index') }}">❤️ Favoritos</a></li>
                        <li><a class="dropdown-item" href="{{ route('carrito.index') }}">🛒 Carrito</a></li>
                        <li><hr></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">🚪 Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest

            {{-- FAVORITOS --}}
            <a href="{{ route('favoritos.index') }}" class="text-dark position-relative">
                <i class="bi bi-heart fs-5"></i>
                <span class="badge bg-success position-absolute top-0 start-100 translate-middle">
                    {{ auth()->user()?->favoritos()->count() ?? 0 }}
                </span>
            </a>

            {{-- CARRITO --}}
            <a href="{{ route('carrito.index') }}" class="text-dark position-relative">
                <i class="bi bi-cart fs-5"></i>
                <span class="badge bg-success position-absolute top-0 start-100 translate-middle">
                    {{ session('carrito') ? count(session('carrito')) : 0 }}
                </span>
            </a>

            <button class="mobile-menu btn btn-outline-success" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>
    </div>
</nav>


{{-- CATEGORÍAS --}}
<div style="background:#13a74b;">
    <div class="container d-flex flex-wrap categories-menu gap-2 py-2">

        <a href="{{ route('motos.categoria','bicimotos') }}" class="text-white text-decoration-none">Bicimotos</a>
        <a href="{{ route('motos.categoria','motos-electricas') }}" class="text-white text-decoration-none">Motos eléctricas</a>
        <a href="{{ route('motos.categoria','trimotos') }}" class="text-white text-decoration-none">Trimotos</a>
        <a href="{{ route('motos.categoria','accesorios') }}" class="text-white text-decoration-none">Accesorios</a>

        {{-- 🔧 REPUESTOS CON SUBMENÚ HOVER --}}
        <div class="dropdown-hover">
            <a href="{{ route('motos.categoria','repuestos') }}" class="text-white text-decoration-none">
                Repuestos ▾
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('motos.categoria','baterias') }}">Baterías</a></li>
                <li><a class="dropdown-item" href="{{ route('motos.categoria','llantas') }}">Llantas</a></li>
                <li><a class="dropdown-item" href="{{ route('motos.categoria','luces') }}">Luces</a></li>
                <li><a class="dropdown-item" href="{{ route('motos.categoria','cargadores') }}">Cargadores</a></li>
            </ul>
        </div>

    </div>
</div>


{{-- CONTENIDO --}}
<div class="container py-4">
    @yield('content')
</div>


<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html>
