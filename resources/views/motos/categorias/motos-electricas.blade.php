@extends('layout')

@section('content')

@include('motos.categorias._estilos')

{{-- ---------- BANNER ---------- --}}
<div class="position-relative">
    <img src="{{ asset('imagenes/banner-motos-electricas.jpg') }}" class="catalog-banner">
    <h1 class="catalog-title position-absolute top-50 start-50 translate-middle">
        Motos Eléctricas
    </h1>
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

                    {{-- PRECIO --}}
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


            <div class="row g-4">
                @forelse ($motos as $moto)
                <div class="col-md-4">
                    @include('motos.partials._card', ['moto'=>$moto])
                </div>
                @empty

                <p class="text-center text-muted">❌ No se encontraron motos con los filtros seleccionados.</p>

                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $motos->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
