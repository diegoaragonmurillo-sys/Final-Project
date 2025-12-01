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

/* 🔹 Tarjetas */
.catalog-img {
    width: 100%;
    height: 230px;
    object-fit: contain;
    background: #fff;
    padding: 15px;
    transition: .3s ease;
    border-radius: 10px 10px 0 0;
}

.catalog-img:hover {
    transform: scale(1.06);
    filter: drop-shadow(0 4px 12px rgba(0,0,0,.15));
}

.moto-card {
    border-radius: 18px;
    transition: .3s ease;
    overflow: hidden;
    border: none;
    position: relative;
    background: #fff;
}

.moto-card:hover {
    transform: translateY(-6px);
    box-shadow: 0px 8px 20px rgba(0,0,0,.15);
}

.badge-new {
    background: #00b84a;
    color: #fff;
    padding: 5px 14px;
    font-weight: bold;
    border-radius: 20px;
    position: absolute;
    top: 10px;
    left: 10px;
}

.price {
    font-size: 1.3rem;
    font-weight: 700;
    color: #00b84a;
}

/* Botón */
.btn-style {
    background: #00b84a;
    border: none;
    transition: .2s;
    font-weight: bold;
    color: white;
}

.btn-style:hover {
    background: #009c3f;
    transform: scale(1.02);
}

/* 🔹 Paginación */
.pagination .page-link {
    color: #0c9e4e;
    font-weight: 600;
}
.pagination .active .page-link {
    background: #0c9e4e;
    border-color: #0c9e4e;
}
</style>


{{-- ---------- BANNER ---------- --}}
<div class="hero-banner">
    <img src="{{ asset('imagenes/ui/motos-electricas.jpg') }}" class="hero-img">
    <h1 class="hero-title">Motos Eléctricas</h1>
</div>


{{-- ---------- TEXTO ---------- --}}
<div class="container text-center mt-4">
    <h4 class="fw-bold">Potencia silenciosa, moderna y ecológica ⚡🔥</h4>
    <p class="text-muted">Motos eléctricas con 40–120 km de autonomía, perfectas para uso urbano o reparto profesional.</p>
</div>


<div class="container mt-5">
    <div class="row">

        {{-- ---------- FILTROS LATERALES ---------- --}}
        <div class="col-md-3">
            <div class="filter-box">

                <form method="GET" action="{{ url()->current() }}">

                    <h6 class="fw-bold">FILTRAR POR PRECIO</h6>
                    <hr>

                    <label>Precio mínimo</label>
                    <input type="number" name="min" class="form-control mb-2"
                           value="{{ request('min') }}" placeholder="Ej: 3000">

                    <label>Precio máximo</label>
                    <input type="number" name="max" class="form-control mb-3"
                           value="{{ request('max') }}" placeholder="Ej: 12000">

                    <button class="btn btn-success w-100 mb-3">Aplicar filtros</button>

                    {{-- LIMPIAR --}}
                    @if(request()->anyFilled(['min','max','order']))
                        <a href="{{ url()->current() }}" class="btn btn-outline-danger w-100">
                            ✖ Limpiar filtros
                        </a>
                    @endif

                </form>
            </div>
        </div>

        {{-- ---------- LISTADO ---------- --}}
        <div class="col-md-9">

            {{-- ORDENAR --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small>Portada » Motos eléctricas</small>

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

                    {{-- Mantener filtros activos --}}
                    @foreach(request()->except('order') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>
            </div>


            {{-- ---------- PRODUCTOS ---------- --}}
            <div class="row g-4">
                @forelse ($motos as $moto)
                <div class="col-md-4">
                    @include('motos.partials._card', ['moto'=>$moto])
                </div>
                @empty
                    <p class="text-center text-muted">❌ No se encontraron motos con los filtros seleccionados.</p>
                @endforelse
            </div>

            {{-- ---------- PAGINACIÓN ---------- --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $motos->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
