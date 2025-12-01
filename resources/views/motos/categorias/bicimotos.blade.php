@extends('layout')

@section('content')

@include('motos.categorias._estilos')

{{-- ---------- BANNER ---------- --}}
<div class="position-relative">
    <img src="{{ asset('imagenes/banner-bicimotos.jpg') }}" class="catalog-banner">
    <h1 class="catalog-title position-absolute top-50 start-50 translate-middle">
        Bicimotos & VMP
    </h1>
</div>

{{-- ---------- TEXTO ---------- --}}
<div class="container text-center mt-4">
    <h4 class="fw-bold">Movilidad eléctrica ligera, compacta y económica ⚡🚲</h4>
    <p class="text-muted">
        Ideal para ciudad, trabajo o estudios. Elige calidad GreenLine y muévete con estilo sin combustible.
    </p>
</div>


<div class="container mt-5">
    <div class="row">

        {{-- ---------- FILTRO SOLO POR PRECIO ---------- --}}
        <div class="col-md-3">
            <div class="filter-box">
                <form method="GET" action="{{ url()->current() }}">

                    <h6 class="fw-bold">Filtrar por Precio</h6>
                    <hr>

                    <label>Precio mínimo</label>
                    <input type="number" name="min" class="form-control mb-2"
                           value="{{ request('min') }}" placeholder="Ej: 1500">

                    <label>Precio máximo</label>
                    <input type="number" name="max" class="form-control mb-3"
                           value="{{ request('max') }}" placeholder="Ej: 3500">

                    <button class="btn btn-success w-100 mb-3">Aplicar filtros</button>

                    @if(request()->anyFilled(['min','max','order']))
                        <a href="{{ url()->current() }}" class="btn btn-outline-danger w-100">
                            ✖ Limpiar filtros
                        </a>
                    @endif

                </form>
            </div>
        </div>

        {{-- ---------- PRODUCTOS ---------- --}}
        <div class="col-md-9">

            {{-- ORDENAR --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small>Portada » Bicimotos</small>

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

                            <a href="{{ route('motos.show', $moto->id) }}" class="btn btn-style w-100">
                                Ver detalles
                            </a>
                        </div>

                    </div>
                </div>
                @empty

                <p class="text-center text-muted">❌ No se encontraron motos con ese precio.</p>

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
