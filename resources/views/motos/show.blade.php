@extends('layout')

@section('content')

<style>
    .main-image {
        width: 100%;
        height: 350px;
        object-fit: contain;
        transition: .3s ease;
        cursor: zoom-in;
    }

    .main-image:hover {
        transform: scale(1.05);
    }

    .thumb {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border: 2px solid #ccc;
        border-radius: 6px;
        cursor: pointer;
        transition: .25s;
    }

    .thumb.active {
        border: 3px solid #007bff;
        transform: scale(1.15);
        box-shadow: 0px 0px 6px rgba(0,0,0,.3);
    }

    .spec-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }
</style>


<div class="row"
x-data="{ 
    imagen: '{{ asset('uploads/motos/' . $moto->variantes->first()->imagen) }}', 
    varianteSeleccionada: '{{ $moto->variantes->first()->id }}',
    colorTexto: '{{ $moto->variantes->first()->color_nombre }}'
}">
    
    {{-- 🖼 Imagen principal --}}
    <div class="col-md-6 text-center">
        <img :src="imagen" class="main-image shadow-sm rounded border p-2">

        {{-- 🔄 Miniaturas --}}
        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
            @foreach($moto->variantes as $variante)
                <img 
                    src="{{ asset('uploads/motos/'.$variante->imagen) }}" 
                    class="thumb"
                    :class="varianteSeleccionada == '{{ $variante->id }}' ? 'active' : ''"
                    @click="
                        imagen='{{ asset('uploads/motos/' . $variante->imagen) }}';
                        varianteSeleccionada='{{ $variante->id }}';
                        colorTexto='{{ $variante->color_nombre }}';
                    "
                >
            @endforeach
        </div>
    </div>

    {{-- 📌 Información --}}
    <div class="col-md-6">

        <h2 class="fw-bold text-primary">{{ $moto->nombre }} ({{ $moto->modelo }})</h2>

        {{-- 📍 Ficha Técnica --}}
        <div class="spec-box mt-3">
            <h5 class="fw-bold mb-2">⚙ Especificaciones Técnicas</h5>
            <ul class="mb-0">

                <li><strong>Capacidad de carga:</strong> 180 KG</li>

                <li><strong>Motor:</strong>
                    @if(in_array($moto->modelo, ['IMPORT-03','IMPORT-04']))
                        1200W con palanca Ruste
                    @else
                        1000W con palanca Ruste
                    @endif
                </li>

                <li><strong>Tiempo de carga:</strong> 6 - 8 horas</li>
                <li><strong>Baterías:</strong> 5 baterías de plomo con grafeno</li>
                <li><strong>Autonomía de batería:</strong> 45 KM</li>
                <li><strong>Velocidades:</strong> 3 velocidades + retroceso</li>
                <li><strong>Velocidad máxima:</strong> 55 KM/H</li>

            </ul>
        </div>

        <hr>

        {{-- 💰 Precio --}}
        <h3 class="text-success fw-bold">S/ {{ number_format($moto->precio_unit,2) }}</h3>
        <small class="d-block text-dark mb-2">Precio al por mayor: 
            <strong>S/ {{ number_format($moto->precio_mayor,2) }}</strong>
        </small>

        {{-- 🎨 Selector de color --}}
        <p><strong>Color seleccionado:</strong> 
            <span x-text="colorTexto" class="text-primary fw-bold"></span>
        </p>

        {{-- ❤️ Favoritos --}}
        <form method="POST" action="{{ route('favorito.toggle', $moto->id) }}">
    @csrf
    <button class="btn btn-outline-danger w-100 mb-2">
        ❤️ {{ auth()->check() && auth()->user()->favorites->contains('moto_id', $moto->id) ? 'Quitar de favoritos' : 'Agregar a favoritos' }}
    </button>
</form>


        {{-- 🛒 Carrito --}}
        <form method="GET" action="{{ route('carrito.agregar') }}">
            <input type="hidden" name="moto_id" value="{{ $moto->id }}">
            <input type="hidden" name="variante_id" x-model="varianteSeleccionada">

            <button class="btn btn-success w-100 mb-3">
                🛒 Agregar al carrito
            </button>
        </form>

        <a href="{{ route('motos.index') }}" class="btn btn-secondary w-100">
            ⬅ Volver al catálogo
        </a>

        <hr>

        {{-- ⭐ Reviews --}}
        <h4>Opiniones de clientes</h4>

        @auth
        <form method="POST" action="{{ route('moto.review', $moto) }}">
            @csrf
            <select name="rating" class="form-select w-50">
                <option value="5">⭐⭐⭐⭐⭐ Excelente</option>
                <option value="4">⭐⭐⭐⭐ Bueno</option>
                <option value="3">⭐⭐⭐ Regular</option>
                <option value="2">⭐⭐ Malo</option>
                <option value="1">⭐ Terrible</option>
            </select>

            <textarea name="comentario" class="form-control mt-2" placeholder="Escribe tu opinión" required></textarea>

            <button class="btn btn-primary mt-2">Enviar</button>
        </form>
        @else
            <p class="text-muted">🔐 Inicia sesión para comentar.</p>
        @endauth

        <div class="mt-4">
            @forelse($moto->reviews as $review)
                <div class="border rounded p-2 mb-2">
                    <strong>{{ str_repeat('⭐', $review->rating) }}</strong>
                    <p class="mb-1">{{ $review->comentario }}</p>
                    <small class="text-muted">📅 {{ $review->created_at->format('d/m/Y') }}</small>
                </div>
            @empty
                <p class="text-muted">Aún no hay reseñas. Sé el primero 😊</p>
            @endforelse
        </div>

    </div>
</div>

@endsection
