@extends('layout')

@section('content')

@include('motos.categorias._estilos')

{{-- ---------- BANNER ---------- --}}
<div class="position-relative">
    <img src="{{ asset('imagenes/banner-repuestos.jpg') }}" class="catalog-banner">
    <h1 class="catalog-title position-absolute top-50 start-50 translate-middle">
        Repuestos Originales
    </h1>
</div>

{{-- ---------- TEXTO ---------- --}}
<div class="container text-center mt-4">
    <h4 class="fw-bold">Mantén tu vehículo en óptimo funcionamiento 🔧⚡</h4>
    <p class="text-muted">Baterías, cargadores, llantas, controladores, luces LED y más — compatibles con modelos GreenLine.</p>
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
                           value="{{ request('min') }}" placeholder="Ej: 100">

                    <label>Precio máximo</label>
                    <input type="number" name="max" class="form-control mb-3"
                           value="{{ request('max') }}" placeholder="Ej: 400">

                    <button class="btn btn-success w-100 mb-3">Aplicar filtros</button>

                    @if(request()->anyFilled(['min','max','order','subcategoria']))
                        <a href="{{ url()->current() }}" class="btn btn-outline-danger w-100">
                            ✖ Limpiar filtros
                        </a>
                    @endif

                </form>
            </div>
        </div>

        {{-- ---------- PRODUCTOS ---------- --}}
        <div class="col-md-9">

            {{-- 🧭 BREADCRUMB --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                
                {{-- Breadcrumb dinámico --}}
                <small>
                    Portada » Repuestos
                    @if(request('subcategoria'))
                        » <strong>{{ ucfirst(request('subcategoria')) }}</strong>
                    @endif
                </small>

                {{-- Selector de orden --}}
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

            {{-- LISTADO --}}
            <div class="row g-4">
                @forelse ($motos as $moto)
                <div class="col-md-4">
                    @include('motos.partials._card', ['moto'=>$moto])
                </div>
                @empty
                <p class="text-center text-muted">❌ No hay repuestos en esta categoría o filtro.</p>
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
