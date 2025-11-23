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
                    class="rounded border shadow-sm"
                    style="width: 60px; height: 60px; cursor: pointer; transition: .2s;"
                    @click="
                        imagen='{{ asset('uploads/motos/' . $variante->imagen) }}';
                        varianteSeleccionada='{{ $variante->id }}';
                        colorTexto='{{ $variante->color_nombre }}';
                    "
                    :class="varianteSeleccionada == '{{ $variante->id }}' ? 'border-primary border-3 scale-110 shadow-lg' : 'border-secondary'"
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

        {{-- 🛒 Formulario del carrito --}}
        <form method="GET" action="{{ route('carrito.agregar') }}" onsubmit="return validarVariante();">

            <input type="hidden" name="moto_id" value="{{ $moto->id }}">
            <input type="hidden" name="variante_id" x-model="varianteSeleccionada" id="variante_id">

            <button class="btn btn-success w-100 mb-3">
                Agregar al carrito 🛒
            </button>
        </form>

        {{-- 🔙 Volver --}}
        <a href="{{ route('motos.index') }}" class="btn btn-secondary w-100">
            Volver
        </a>
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
