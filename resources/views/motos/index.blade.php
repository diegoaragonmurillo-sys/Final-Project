@extends('layout')

@section('content')

<style>
/* ---------- ESTILO GENERAL ---------- */

.catalog-banner{
    width: 100%;
    height: 350px;
    object-fit: cover;
}

.catalog-title{
    font-size: 3rem;
    font-weight: 900;
    color: white;
    text-shadow: 0px 3px 10px rgba(0,0,0,.5);
}

.filter-box{
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,.08);
    position: sticky;
    top: 20px;
}

/* ---------- TARJETAS DE PRODUCTO ---------- */

.catalog-img {
    width: 100%;
    height: 260px;
    object-fit: contain;
    background: #fff;
    padding: 15px;
    transition: .3s ease;
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
    font-size: 1.4rem;
    font-weight: 700;
    color: #00b84a;
}

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
</style>


{{-- ---------- BANNER ---------- --}}
<div class="position-relative">
    <img src="{{ asset('imagenes/banner-bicimotos.jpg') }}" class="catalog-banner">
    <h1 class="catalog-title position-absolute top-50 start-50 translate-middle">
        Bicimotos, VMP
    </h1>
</div>


{{-- ---------- TEXTO CENTRADO ---------- --}}
<div class="container text-center mt-4">
    <h4 class="fw-bold">
        Bicimotos Eléctricas, VMP, Bicis para moverte rápidamente con estilo 🚲⚡
    </h4>
    <p class="text-muted">
        Elige calidad, elige GreenLine. Más de 20 modelos disponibles y precios accesibles.
    </p>
</div>

<div class="container mt-5">
    <div class="row">

        {{-- ---------- FILTROS ---------- --}}
        <div class="col-md-3">
            <div class="filter-box">

                <form method="GET" action="{{ url()->current() }}">

                    {{-- PRECIO --}}
                    <h6 class="fw-bold">FILTRO POR PRECIO</h6>
                    <hr>

                    <label>Precio mínimo</label>
                    <input type="number" name="min" class="form-control mb-2"
                           value="{{ request('min') }}" placeholder="Ej: 1500">

                    <label>Precio máximo</label>
                    <input type="number" name="max" class="form-control mb-3"
                           value="{{ request('max') }}" placeholder="Ej: 3500">

                    <button class="btn btn-success w-100">Aplicar filtros</button>

                    @if(request()->has('min') || request()->has('max') || request()->has('order'))
                        <a href="{{ url()->current() }}" class="btn btn-outline-danger w-100 mt-2">
                            Limpiar filtros
                        </a>
                    @endif

                </form>
            </div>
        </div>



        {{-- ---------- LISTA DE PRODUCTOS ---------- --}}
        <div class="col-md-9">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small>Portada » Bicimotos</small>

                {{-- SELECT DE ORDENAR --}}
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


            <div class="row g-4">

                @forelse ($motos as $moto)
                <div class="col-md-4">
                    <div class="card moto-card">

                        <span class="badge-new">Nuevo</span>

                        <img src="{{ asset('storage/'.$moto->imagen) }}" class="catalog-img">

                        <div class="card-body text-center">
                            <h6 class="fw-bold">{{ $moto->nombre }}</h6>
                            <p class="price">S/ {{ number_format($moto->precio_unit,2) }}</p>

                            <a href="{{ route('motos.show', $moto->id) }}" 
                               class="btn btn-style w-100">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
                @empty

                <p class="text-center text-muted">❌ No se encontraron productos con los filtros aplicados.</p>

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
