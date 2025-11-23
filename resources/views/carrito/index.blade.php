@extends('layout')

@section('content')

<h2 class="mb-4">🛒 Carrito de compras</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(empty($carrito))
    <div class="alert alert-warning text-center">
        Tu carrito está vacío 😕 <br>
        <a href="{{ route('motos.index') }}" class="btn btn-primary mt-3">Ver catálogo</a>
    </div>

@else

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Color</th>
            <th width="160">Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th width="90">Acción</th>
        </tr>
    </thead>

    <tbody>
        @php 
            $total = 0; 
        @endphp

        @foreach($carrito as $key => $item)

            @php 
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            @endphp

            <tr>
                <td width="100">
                    <img src="{{ asset('uploads/motos/'.$item['imagen']) }}" 
                         class="img-fluid rounded border"
                         style="max-height: 70px;">
                </td>

                <td>{{ $item['moto'] }}</td>

                <td><span class="badge text-bg-primary">{{ $item['color'] }}</span></td>

                {{-- 🔼🔽 Cantidad control --}}
                <td class="text-center">
                    <a href="{{ route('carrito.actualizar', [$key, 'restar']) }}" 
                       class="btn btn-outline-secondary btn-sm">-</a>

                    <span class="mx-2 fw-bold">{{ $item['cantidad'] }}</span>

                    <a href="{{ route('carrito.actualizar', [$key, 'sumar']) }}" 
                       class="btn btn-outline-secondary btn-sm">+</a>
                </td>

                <td>S/ {{ number_format($item['precio'],2) }}</td>

                <td class="fw-bold text-success">S/ {{ number_format($subtotal,2) }}</td>

                {{-- ❌ Botón eliminar --}}
                <td>
                    <a href="{{ route('carrito.eliminar', $key) }}" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este producto del carrito?');">
                        ❌
                    </a>
                </td>
            </tr>

        @endforeach
    </tbody>
</table>

{{-- 📦 Vaciar carrito --}}
<div class="mb-3">
    <a href="{{ route('carrito.vaciar') }}" 
       class="btn btn-sm btn-danger"
       onclick="return confirm('¿Seguro que deseas vaciar todo el carrito?')">
       🗑 Vaciar carrito
    </a>
</div>

{{-- 🎟 Cupón --}}
<form method="GET" action="{{ route('carrito.index') }}" class="mt-3">
    <div class="d-flex gap-2 w-50">
        <input type="text" name="cupon" value="{{ request('cupon') }}" class="form-control" placeholder="Ingresa cupón">
        <button class="btn btn-primary">Aplicar</button>
    </div>
</form>

{{-- Descuento calculado --}}
@php 
    $descuento = 0;
    if(request('cupon') === 'DESC10') {
        $descuento = $total * 0.10;
    }
@endphp

<hr>

{{-- 🧮 Totales --}}
<div class="text-end">

    @if($descuento > 0)
        <p class="text-success fw-bold">Cupón aplicado: - S/ {{ number_format($descuento,2) }}</p>
    @endif

    <h3>Total final: 
        <span class="text-success fw-bold">S/ {{ number_format($total - $descuento,2) }}</span>
    </h3>

    <a href="{{ route('orden.confirmar') }}" class="btn btn-lg btn-success mt-3">
        Confirmar pedido ✅
    </a>
</div>

@endif

@endsection
