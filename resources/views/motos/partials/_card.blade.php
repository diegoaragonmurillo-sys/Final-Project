<div class="card moto-card">

    {{-- Etiquetas --}}
    @if($moto->oferta_activa && $moto->descuento)
        <span class="badge-off">-{{ $moto->descuento }}%</span>
    @endif

    {{-- Imagen --}}
    <img 
        src="{{ asset('storage/' . $moto->imagen) }}" 
        class="catalog-img"
        onerror="this.src='{{ asset('storage/productos/default.png') }}'"
    >

    <div class="card-body text-center">
        <h6 class="fw-bold">{{ $moto->nombre }}</h6>

        {{-- Si existe oferta --}}
        @if($moto->oferta_activa && $moto->precio_oferta)
            <p class="price text-success">
                S/ {{ number_format($moto->precio_oferta,2) }}
                <br>
                <small class="text-muted text-decoration-line-through">
                    S/ {{ number_format($moto->precio_unit,2) }}
                </small>
            </p>
        @else
            <p class="price fw-bold">S/ {{ number_format($moto->precio_unit,2) }}</p>
        @endif

        <a href="{{ route('motos.show', $moto->id) }}" class="btn btn-style w-100">
            Ver detalles
        </a>
    </div>

</div>
