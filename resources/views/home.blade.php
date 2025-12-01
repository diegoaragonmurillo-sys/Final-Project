@extends('layout')

@section('content')

{{-- =========================
    HERO SLIDER
========================= --}}
<div id="heroSlider" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="/imagenes/banner1.jpg" class="d-block w-100" style="object-fit:cover; height:430px;">
        </div>

        <div class="carousel-item">
            <img src="/imagenes/banner2.jpg" class="d-block w-100" style="object-fit:cover; height:430px;">
        </div>

        <div class="carousel-item">
            <img src="/imagenes/banner3.jpg" class="d-block w-100" style="object-fit:cover; height:430px;">
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>



{{-- =========================
    SECCIÓN PROMOCIONES
========================= --}}
<div class="text-center py-3">
    <h2 class="fw-bold text-uppercase">Modelos en Promoción</h2>
</div>

<div class="container">
    <div class="row row-cols-1 row-cols-md-4 g-4">

        @foreach($motos as $moto)
        <div class="col">
            <div class="card border-0 shadow-sm moto-card">

                <div class="position-relative">
                    <span class="badge bg-success position-absolute top-0 start-0 m-2">
                        -{{ rand(5,15) }}%
                    </span>

                    <a href="{{ route('motos.show', $moto) }}">
                        <img src="{{ asset($moto->imagen_url ?? 'imagenes/default.png') }}"
                        class="card-img-top" style="height:200px; object-fit:contain;">
                    </a>
                </div>

                <div class="card-body text-center">
                    <h6 class="fw-bold">{{ $moto->nombre }}</h6>

                    <p class="text-muted text-decoration-line-through mb-0">
                        S/ {{ number_format($moto->precio + 1200,2) }}
                    </p>

                    <p class="text-success fw-bold fs-5">
                        S/ {{ number_format($moto->precio,2) }}
                    </p>

                    <a href="{{ route('motos.show', $moto) }}" class="btn btn-dark w-100">
                        Ver detalles
                    </a>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- PAGINACIÓN --}}
<div class="d-flex justify-content-center mt-4">
    {{ $motos->onEachSide(1)->links() }}
</div>

<p class="text-center text-muted small mt-2">
    Mostrando {{ $motos->firstItem() }} a {{ $motos->lastItem() }} de {{ $motos->total() }} resultados
</p>




{{-- =========================
    SECCIÓN CARGUEROS / DESTACADOS
========================= --}}
<section class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <h3 class="text-center fw-bold">Los Mejores Cargueros Eléctricos</h3>

        <div class="row row-cols-1 row-cols-md-4 g-4 mt-4">
            @foreach($destacados as $item)
            <div class="col">
                <div class="card border-0 shadow-sm">
                    <img src="{{ asset($item->imagen_url ?? 'imagenes/default.png') }}"
                         class="card-img-top p-3"
                         style="height:200px; object-fit:contain;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">{{ $item->nombre }}</h6>
                        <p class="text-success fw-bold">S/ {{ number_format($item->precio, 2) }}</p>
                        <a href="{{ route('motos.show', $item) }}" class="btn btn-outline-light w-100">
                            Ver modelo
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>



{{-- =========================
    NUEVOS INGRESOS
========================= --}}
<section class="py-5 bg-light">
    <div class="container text-center">
        <h3 class="fw-bold">Nuevos Ingresos</h3>

        <div class="row row-cols-1 row-cols-md-4 g-4 mt-4">
            @foreach($nuevos as $n)
            <div class="col">
                <img src="{{ asset($n->imagen_url ?? 'imagenes/default.png') }}"
                     class="img-fluid rounded">
            </div>
            @endforeach
        </div>

        <a href="{{ route('motos.index') }}" class="btn btn-success mt-4">
            Ver catálogo completo
        </a>
    </div>
</section>



{{-- =========================
    MARCAS
========================= --}}
<section class="py-5">
    <div class="container text-center">
        <h4 class="fw-bold mb-4">Marcas Aliadas</h4>

        <div class="d-flex justify-content-center gap-5 flex-wrap">
            <img src="/imagenes/marca1.png" height="50">
            <img src="/imagenes/marca2.png" height="50">
            <img src="/imagenes/marca3.png" height="50">
            <img src="/imagenes/marca4.png" height="50">
        </div>
    </div>
</section>



{{-- =========================
    FOOTER GREENLINE STYLE
========================= --}}
<footer class="bg-white py-5 border-top mt-5">
    <div class="container">

        <div class="row justify-content-between">

            {{-- INFO --}}
            <div class="col-12 col-md-3 mb-4">
                <img src="/imagenes/logo.png" alt="Logo" class="mb-3" style="height:50px;">
                <p class="text-muted" style="font-size: 14px;">
                    Empresa líder de vehículos eléctricos en Perú.
                </p>

                <p class="text-muted mb-0">📍 Av. Jose Leal 507, Lima</p>
                <p class="text-muted mb-0">📞 +51 999 999 999</p>
                <p class="text-muted">🕒 Lun–Vie 9:30–7:00 / Sáb 9:30–5:00</p>
            </div>

            {{-- EMPRESA --}}
            <div class="col-6 col-md-2 mb-4">
                <h6 class="fw-bold mb-3">NUESTRA EMPRESA</h6>
                <ul class="list-unstyled" style="font-size: 14px;">
                    <li><a href="#" class="text-muted text-decoration-none">Nosotros</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Trabaja con nosotros</a></li>
                </ul>
            </div>

            {{-- SOPORTE --}}
            <div class="col-6 col-md-2 mb-4">
                <h6 class="fw-bold mb-3">SOPORTE</h6>
                <ul class="list-unstyled" style="font-size: 14px;">
                    <li><a href="#" class="text-muted text-decoration-none">Contáctanos</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Preguntas frecuentes</a></li>
                </ul>
            </div>

            {{-- SEDES --}}
            <div class="col-12 col-md-3 mb-4">
                <h6 class="fw-bold mb-3">SEDES PRINCIPALES</h6>
                <ul class="list-unstyled" style="font-size: 14px;">
                    <li>Lince</li>
                    <li>Surco</li>
                    <li>San Miguel</li>
                    <li>La Molina</li>
                    <li>Miraflores</li>
                </ul>
            </div>

        </div>

        {{-- REDES --}}
        <div class="text-center mt-4">
            <a href="#" class="mx-2 text-dark fs-5"><i class="bi bi-facebook"></i></a>
            <a href="#" class="mx-2 text-dark fs-5"><i class="bi bi-instagram"></i></a>
            <a href="#" class="mx-2 text-dark fs-5"><i class="bi bi-tiktok"></i></a>
            <a href="#" class="mx-2 text-dark fs-5"><i class="bi bi-youtube"></i></a>
        </div>

        <hr class="mt-4">

        <p class="text-center text-muted" style="font-size: 13px;">
            © {{ date('Y') }} Motovolt Perú — Todos los derechos reservados.
        </p>

    </div>
</footer>


{{-- =========================
    ESTILO EXTRA
========================= --}}
<style>
.moto-card:hover {
    transform: scale(1.03);
    transition: .2s;
}
</style>

@endsection
