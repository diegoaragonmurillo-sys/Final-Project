@extends('layout')

@section('content')

{{-- ===== ESTILOS ESPECÍFICOS ===== --}}
<style>
/* 🔹 Banner */
.hero-banner {
    width: 100%;
    height: 230px;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    margin-bottom: 20px;
}

.hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.65);
    transition: .3s ease;
}

.hero-banner:hover .hero-img {
    transform: scale(1.02);
}

.hero-title {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 2.2rem;
    font-weight: 800;
    color: white;
    text-shadow: 0px 4px 12px rgba(0,0,0,0.8);
}

@media(max-width: 768px) {
    .hero-banner { height: 160px; }
    .hero-title { font-size: 1.5rem; }
}

/* 🔹 Filtro */
.filter-box{
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,.08);
    position: sticky;
    top: 20px;
}

/* 🔹 Productos */
.pagination .page-link { color: #0c9e4e; font-weight: 600; }
.pagination .active .page-link { background: #0c9e4e; border-color: #0c9e4e; }

.text-muted { font-size: .95rem; }
</style>


{{-- ===== BANNER ===== --}}
@php
$labels = [
    'baterias' => 'Baterías',
    'llantas' => 'Llantas',
    'luces' => 'Luces LED',
    'cargadores' => 'Cargadores',
    'controladores' => 'Controladores',
    'frenos' => 'Frenos',
];

$titulo = request('subcategoria') 
    ? ($labels[request('subcategoria')] ?? ucfirst(request('subcategoria')))
    : 'Repuestos Originales';
@endphp

<div class="hero-banner">
    <img src="{{ asset('imagenes/ui/repuestos.jpg') }}" class="hero-img">
    <h1 class="hero-title">{{ $titulo }}</h1>
</div>


{{-- ===== DESCRIPCIÓN ===== --}}
<div class="container text-center mt-4">
    <h4 class="fw-bold">Mantén tu vehículo en óptimo funcionamiento 🔧⚡</h4>
    <p class="text-muted">Baterías, cargadores, llantas, controladores, luces LED y más — compatibles con modelos MotoVolt.</p>
</div>


<div class="container mt-5">
    <div class="row">

        {{-- ===== FILTRO PRECIO ===== --}}
        <div class="col-md-3">
            <div class="filter-box">
                <form method="GET" action="{{ url()->current() }}">

                    <h6 class="fw-bold">Filtrar por Precio</h6>
                    <hr>

                    <label>Precio mínimo</label>
                    <input type="number" name="min" class="form-control mb-2"
                           value="{{ request('min') }}" placeholder="Ej: 50">

                    <label>Precio máximo</label>
                    <input type="number" name="max" class="form-control mb-3"
                           value="{{ request('max') }}" placeholder="Ej: 400">

                    <button class="btn btn-success w-100 mb-3">Aplicar filtros</button>

                    @if(request()->anyFilled(['min','max','order','subcategoria']))
                        <a href="{{ route('motos.categoria','repuestos') }}" class="btn btn-outline-danger w-100">
                            ✖ Limpiar filtros
                        </a>
                    @endif

                </form>
            </div>
        </div>


        {{-- ===== PRODUCTOS ===== --}}
        <div class="col-md-9">

            {{-- Selector ORDER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small>Portada » Repuestos @if(request('subcategoria')) » <strong>{{ $titulo }}</strong> @endif</small>

                <form method="GET" action="{{ url()->current() }}">
                    <select name="order" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">Ordenar por recientes</option>
                        <option value="price_asc" {{ request('order')=='price_asc' ? 'selected':'' }}>
                            Precio menor a mayor
                        </option>
                        <option value="price_desc" {{ request('order')=='price_desc' ? 'selected':'' }}>
                            Precio mayor a menor
                        </option>
                    </select>

                    {{-- Mantener filtros --}}
                    @foreach(request()->except('order') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>
            </div>


            {{-- LISTADO --}}
            <div class="row g-4">
                @forelse ($motos as $moto)
                <div class="col-md-4">
                    @include('motos.partials._card', ['moto'=>$moto])
                </div>
                @empty
                    <p class="text-center text-muted">❌ No hay repuestos disponibles en esta categoría.</p>
                @endforelse
            </div>


            {{-- PAGINACIÓN --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $motos->links() }}
            </div>

        </div>
    </div>
</div>

@endsection
