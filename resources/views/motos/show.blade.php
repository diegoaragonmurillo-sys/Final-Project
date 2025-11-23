@extends('layout')

@section('content')

<div class="row"
x-data="{ 
    imagen: '{{ asset('uploads/motos/' . $moto->variantes->first()->imagen) }}', 
    varianteSeleccionada: '{{ $moto->variantes->first()->id }}',
    colorTexto: '{{ $moto->variantes->first()->color_nombre }}'
}">
    
    {{-- 🖼 Imagen principal --}}
    <div class="col-md-6 text-center">
        <img :src="imagen" class="img-fluid rounded border shadow-sm p-2" style="max-height: 350px; transition: .3s;">

        {{-- 🔄 Miniaturas --}}
        <div class="d-flex justify-content-center gap-2 mt-3">
            @foreach($moto->variantes as $variante)
                <img 
                    src="{{ asset('uploads/motos/'.$variante->imagen) }}" 
                    class="rounded border shadow-sm transition"
                    style="width: 60px; height: 60px; cursor: pointer;"
                    @click="
                        imagen='{{ asset('uploads/motos/' . $variante->imagen) }}';
                        varianteSeleccionada='{{ $variante->id }}';
                        colorTexto='{{ $variante->color_nombre }}';
                    "
                    :class="varianteSeleccionada == '{{ $variante->id }}' 
                        ? 'border-primary border-3 scale-110 shadow-lg' 
                        : 'border-secondary'"
                >
            @endforeach
        </div>
    </div>

    {{-- 📌 Información --}}
    <div class="col-md-6">

        <h2 class="fw-bold">{{ $moto->nombre }} ({{ $moto->modelo }})</h2>
        <p class="text-muted">{!! nl2br(e($moto->descripcion)) !!}</p>

        <h3 class="text-success fw-bold">S/ {{ number_format($moto->precio_unit,2) }}</h3>
        <small class="d-block text-dark">Precio por mayor: 
            <strong>S/ {{ number_format($moto->precio_mayor,2) }}</strong>
        </small>

        <hr>

        {{-- 🎨 Selector de color --}}
        <strong>Selecciona un color:</strong>

        <div class="d-flex gap-2 mt-2">
            @foreach($moto->variantes as $variante)
                <button 
                    type="button"
                    class="rounded-circle border shadow-sm"
                    style="width: 45px; height: 45px; background: {{ $variante->color_hex ?? '#ccc' }}; transition: .2s;"
                    title="{{ $variante->color_nombre }}"
                    
                    :class="varianteSeleccionada == '{{ $variante->id }}' 
                        ? 'border-4 border-primary shadow-lg scale-110' 
                        : 'border-2 border-secondary'"
                    
                    @click="
                        imagen='{{ asset('uploads/motos/' . $variante->imagen) }}';
                        varianteSeleccionada='{{ $variante->id }}';
                        colorTexto='{{ $variante->color_nombre }}';
                    "
                ></button>
            @endforeach
        </div>

        {{-- 🏷 Color seleccionado --}}
        <p class="mt-2"><strong>Color elegido:</strong> <span x-text="colorTexto" class="text-primary"></span></p>

        <hr>

        {{-- ❤️ Favoritos --}}
        <a href="{{ route('moto.favorito', $moto->id) }}" class="btn btn-outline-danger w-100 mb-2">
            ❤️ Agregar a favoritos
        </a>

        {{-- 🛒 Formulario del carrito --}}
        <form method="GET" action="{{ route('carrito.agregar') }}" onsubmit="return validarVariante();">

            <input type="hidden" name="moto_id" value="{{ $moto->id }}">
            <input type="hidden" name="variante_id" x-model="varianteSeleccionada" id="variante_id">

            <button class="btn btn-success w-100 mb-3">
                Agregar al carrito 🛒
            </button>
        </form>

        {{-- 🔙 Volver --}}
        <a href="{{ route('motos.index') }}" class="btn btn-secondary w-100 mb-3">
            Volver
        </a>

        <hr>

        {{-- ⭐ Sistema de reviews --}}
        <h4>Opiniones del producto</h4>

        {{-- ⭐ Formulario solo si está logueado --}}
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
        <p class="text-muted">🔐 Inicia sesión para dejar una opinión.</p>
        @endauth

        {{-- 📄 Lista de reviews --}}
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

{{-- 🚨 Validación JS --}}
<script>
function validarVariante() {
    let variante = document.getElementById('variante_id').value;
    if (!variante) {
        alert("⚠️ Debes seleccionar un color antes de agregar al carrito.");
        return false;
    }
    return true;
}
</script>

@endsection
