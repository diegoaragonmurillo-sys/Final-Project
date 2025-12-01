@extends('layout')

@section('content')

<style>
.main-image {
    width: 100%;
    height: 380px;
    object-fit: contain;
    border-radius: 12px;
    background: #fff;
    padding: 10px;
    box-shadow: 0px 4px 10px rgba(0,0,0,.08);
    transition: .3s;
}
.main-image:hover { transform: scale(1.05); }

.badge-green {
    background: #00B84A;
    color: white;
    padding: 6px 12px;
    border-radius: 30px;
    font-weight: bold;
    font-size: .9rem;
}
.badge-off {
    background: #ff3131;
    color: white;
    padding: 6px 12px;
    border-radius: 30px;
    font-weight: bold;
    font-size: .9rem;
}

.price-box {
    background: #e8f8ec;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #00B84A;
}

.btn-shop {
    background: #00B84A;
    border: none;
    color: white;
    padding: 12px;
    font-weight: bold;
    border-radius: 8px;
    transition: .2s;
}
.btn-shop:hover { background:#009c3f; transform:scale(1.03); }

.color-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #ccc;
    transition: .25s ease-in-out;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    color: white;
    font-weight: bold;
}
.color-circle:hover {
    transform: scale(1.2);
    border-color: #00b84a;
}
.color-circle.active {
    border: 4px solid #00B84A;
    transform: scale(1.4);
    box-shadow: 0px 0px 15px rgba(0, 184, 74, .7);
}
</style>

@php
$hasVariantes = $moto->variantes->count() > 0;
$defaultVar   = $hasVariantes ? $moto->variantes->first() : null;
@endphp

<div class="container py-5"
    x-data="{
        qty: 1,
        stock: {{ $hasVariantes ? $defaultVar->stock : $moto->stock }},
        imagen: '{{ $hasVariantes ? asset('uploads/motos/' . $defaultVar->imagen) : asset('storage/' . $moto->imagen) }}',
        variante: {{ $hasVariantes ? $defaultVar->id : 'null' }},
        color: '{{ $hasVariantes ? $defaultVar->color_nombre : 'Único' }}',

        increase(){
            if(this.qty < this.stock) this.qty++;
            else alert('⚠️ Stock máximo disponible: ' + this.stock);
        },
        decrease(){
            if(this.qty > 1) this.qty--;
        },
        max(){
            this.qty = this.stock;
        }
    }"
>

    <div class="row align-items-center">

        {{-- 🖼 Imagen --}}
        <div class="col-md-6 text-center">

            <div class="mb-2 d-flex gap-2 justify-content-center">
                @if($moto->oferta_activa)
                    <span class="badge-off">-{{ $moto->descuento }}%</span>
                @endif
                <span class="badge-green">Nuevo</span>
            </div>

            <img :src="imagen" class="main-image">

            {{-- Selector de colores si aplica --}}
            @if($hasVariantes)
            <div class="d-flex justify-content-center gap-3 mt-3">
                @foreach($moto->variantes as $var)
                    <div class="color-circle"
                        style="background: {{ $var->color_hex ?? '#ccc' }};"
                        :class="variante == '{{ $var->id }}' ? 'active' : ''"
                        @click="
                            imagen='{{ asset('uploads/motos/' . $var->imagen) }}';
                            variante={{ $var->id }};
                            color='{{ $var->color_nombre }}';
                            stock={{ $var->stock }};
                            qty=1;
                        ">
                        <span x-show="variante == '{{ $var->id }}'">✔</span>
                    </div>
                @endforeach
            </div>

            <p class="mt-2 text-center">
                <strong>Color seleccionado:</strong> 
                <span x-text="color" class="text-primary fw-bold"></span>
            </p>
            @endif

        </div>

        {{-- 📌 Información --}}
        <div class="col-md-6">

            <h2 class="fw-bold">{{ $moto->nombre }} ({{ $moto->modelo ?? '' }})</h2>

            <div class="price-box mt-3">
                @if($moto->oferta_activa)
                    <h3 class="fw-bold text-success mb-0">S/ {{ number_format($moto->precio_oferta,2) }}</h3>
                    <small class="text-danger">
                        <del>S/ {{ number_format($moto->precio_unit,2) }}</del> Oferta disponible
                    </small>
                @else
                    <h3 class="fw-bold text-success mb-0">S/ {{ number_format($moto->precio_unit,2) }}</h3>
                @endif
            </div>

            {{-- Stock --}}
            <p class="mt-2">
                <strong>Disponibilidad:</strong>
                <span x-text="stock > 0 ? 'Disponible ('+stock+')' : 'Agotado'"
                        :class="stock>0 ? 'text-success' : 'text-danger'"></span>
            </p>

            {{-- ⭐ Cantidad + Carrito --}}
            <form method="GET" action="{{ route('carrito.agregar') }}">
                <input type="hidden" name="moto_id" value="{{ $moto->id }}">
                <input type="hidden" name="variante_id" x-model="variante">
                <input type="hidden" name="cantidad" x-model="qty">

                <div class="d-flex align-items-center gap-3 mt-3">

                    <div class="d-flex border rounded overflow-hidden" style="width:170px;">
                        <button type="button" @click="decrease()" class="btn btn-light w-25">-</button>
                        <input class="form-control text-center" readonly x-model="qty" style="background:#f8f8f8;">
                        <button type="button" @click="increase()" class="btn btn-light w-25">+</button>
                    </div>

                    <button type="button" @click="max()" class="btn btn-outline-primary">MAX</button>

                    <button class="btn btn-shop w-100">🛒 Añadir</button>
                </div>
            </form>

            {{-- 📄 Descripción --}}
            <div class="mt-4 p-3 bg-light rounded">
                <h5 class="fw-bold mb-2">📄 Descripción del producto</h5>
                <p>{{ $moto->descripcion ?: 'No hay descripción disponible.' }}</p>
            </div>

        </div>
    </div>

    
    {{-- ⭐ Opiniones --}}
    <hr class="mt-5">

    <h3 class="fw-bold mb-3">⭐ Opiniones</h3>

    <form method="POST" action="{{ route('moto.review', $moto) }}" class="p-3 rounded shadow-sm bg-white">
        @csrf

        <label class="fw-semibold mb-2">Calificación:</label>
        <select name="rating" class="form-select w-50 mb-3">
            <option value="5">⭐⭐⭐⭐⭐ Excelente</option>
            <option value="4">⭐⭐⭐⭐ Muy bueno</option>
            <option value="3">⭐⭐⭐ Aceptable</option>
            <option value="2">⭐⭐ Regular</option>
            <option value="1">⭐ Malo</option>
        </select>

        <textarea name="comentario" class="form-control" rows="3" placeholder="Escribe tu opinión..."></textarea>

        @auth
            <button class="btn btn-success mt-3 px-4 py-2 fw-bold w-100">✍️ Enviar comentario</button>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary mt-3 w-100 fw-bold">
                🔐 Inicia sesión para enviar tu comentario
            </a>
        @endauth
    </form>


    {{-- Lista Comentarios --}}
    <div class="mt-4">
        @forelse($moto->reviews as $review)
        <div class="border rounded p-3 mb-3 bg-light">
            <strong>{{ str_repeat('⭐', $review->rating) }}</strong>
            <p class="mt-2">{{ $review->comentario }}</p>
            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
        </div>
        @empty
            <p class="text-center text-muted mt-3">⚠️ Aún no hay comentarios.</p>
        @endforelse
    </div>

</div>

@endsection
