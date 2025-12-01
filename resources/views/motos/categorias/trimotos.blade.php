@extends('layout')

@section('content')

@include('motos.categorias._estilos')

{{-- BANNER --}}
<div class="position-relative">
    <img src="{{ asset('imagenes/banner-trimotos.jpg') }}" class="catalog-banner">
    <h1 class="catalog-title position-absolute top-50 start-50 translate-middle">
        Trimotos Eléctricas
    </h1>
</div>

{{-- TEXTO --}}
<div class="container text-center mt-4">
    <h4 class="fw-bold">Capacidad, estabilidad y transporte inteligente 🚚⚡</h4>
    <p class="text-muted">Ideales para reparto, familia o negocio — carga máxima 150 a 300kg.</p>
</div>


<div class="container mt-5">
    <div class="row">

        {{-- FILTROS --}}
        <div class="col-md-3">
            <div class="filter-box">

                <form method="GET" action="{{ url()->current() }}">

                    {{-- PRECIO --}}
                    <h6 class="fw-bold">FILTRO POR PRECIO</h6>
                    <hr>

                    <label>Precio mínimo</label>
                    <input type="number" name="min" class="form-control mb-2"
                           value="{{ request('min') }}" placeholder="Ej: 4500">

                    <label>Precio máximo</label>
                    <input type="number" name="max" class="form-control mb-3"
                           value="{{ request('max') }}" placeholder="Ej: 9600">

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

        {{-- LISTADO --}}
        <div class="col-md-9">

            {{-- ORDENAR --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small>Portada » Trimotos</small>

                <form method="GET" action="{{ url()->current() }}">
                    <select name="order" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">Ordenar por recientes</option>
                        <option value="precio_asc" {{ request('order')=='precio_asc' ? 'selected':'' }}>
                            Precio menor a mayor
                        </option>
                        <option value="precio_desc" {{ request('order')=='precio_desc' ? 'selected':'' }}>
                            Precio mayor a menor
                        </option>
                    </select>

                    {{-- Mantener filtros activos --}}
                    @foreach(request()->except('order') as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                </form>
            </div>


            <div class="row g-4">
                @forelse ($motos as $moto)
                    <div class="col-md-4">
                        @include('motos.partials._card', ['moto'=>$moto])
                    </div>
                @empty
                    <p class="text-center text-muted">
                        ❌ No se encontraron motos con los filtros seleccionados
                    </p>
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
