@extends('layout')

@section('content')

<style>
.table thead th {
    background:#1d1d1d !important;
    color:white;
    font-size:.95rem;
}

img.cart-img {
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:8px;
    border:1px solid #ddd;
}

.qty-btn {
    width:30px;
    height:30px;
    border-radius:6px !important;
    padding:0;
    font-weight:bold;
}

.total-highlight {
    font-size:1.6rem;
    font-weight:800;
    color:#13a74b;
}

.btn-confirm {
    background:#13a74b;
    border:none;
    padding:12px 25px;
    font-size:1.1rem;
    border-radius:8px;
    font-weight:600;
    transition:.2s;
}
.btn-confirm:hover{
    background:#0d8a3e;
}

.coupon-box {
    max-width:420px;
}
</style>


<h2 class="fw-bold mb-4">
    <i class="bi bi-cart-check"></i> Carrito de compras
</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif


@if(empty($carrito))

<div class="alert alert-warning text-center p-4">
    🛒 Tu carrito está vacío <br>
    <a href="{{ route('motos.index') }}" class="btn btn-success mt-3">Explorar productos</a>
</div>

@else

@php $total = 0; @endphp

<table class="table table-bordered align-middle shadow-sm">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Color</th>
            <th width="130">Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th width="90">Acción</th>
        </tr>
    </thead>

    <tbody>
        @foreach($carrito as $key => $item)

        @php 
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        @endphp

        <tr>
            <td class="text-center">
                <img src="{{ asset('uploads/motos/'.$item['imagen']) }}" class="cart-img">
            </td>

            <td class="fw-semibold">{{ $item['moto'] }}</td>

            <td><span class="badge bg-primary">{{ $item['color'] }}</span></td>

            {{-- cantidad --}}
            <td class="text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <a href="{{ route('carrito.actualizar', [$key, 'restar']) }}" 
                       class="btn btn-outline-secondary qty-btn">-</a>

                    <span class="fw-semibold">{{ $item['cantidad'] }}</span>

                    <a href="{{ route('carrito.actualizar', [$key, 'sumar']) }}" 
                       class="btn btn-outline-secondary qty-btn">+</a>
                </div>
            </td>

            <td>S/ {{ number_format($item['precio'],2) }}</td>

            <td class="fw-bold text-success">S/ {{ number_format($subtotal,2) }}</td>

            <td class="text-center">
                <a href="{{ route('carrito.eliminar', $key) }}" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('¿Eliminar este producto?')">
                   ✖
                </a>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>


{{-- Vaciar --}}
<a href="{{ route('carrito.vaciar') }}" 
   class="btn btn-outline-danger btn-sm mb-3"
   onclick="return confirm('¿Vaciar carrito completo?')">
   🗑 Vaciar carrito
</a>


{{-- Cupón --}}
<form method="GET" action="{{ route('carrito.index') }}" class="coupon-box mb-4">
    <div class="input-group">
        <input type="text" name="cupon" value="{{ $cupon }}" class="form-control" placeholder="Ingresa cupón">
        <button class="btn btn-dark">Aplicar</button>
    </div>
</form>

@php
$descuento = 0;

if (!empty($cuponData)) {

    if ($cuponData['tipo'] === 'porcentaje') {
        $descuento = $total * ($cuponData['valor'] / 100);
    } else {
        $descuento = $cuponData['valor'];
    }

    if ($descuento > $total) {
        $descuento = $total;
    }
}
@endphp

<hr>

{{-- Total --}}
<div class="text-end">
    @if($descuento > 0)
        <p class="text-success fw-bold">
            Cupón aplicado <strong>({{ $cupon }})</strong>: - S/ {{ number_format($descuento,2) }}
        </p>
    @endif

    <p class="total-highlight">
        Total final: S/ {{ number_format($total - $descuento,2) }}
    </p>

    <a href="{{ route('orden.confirmar') }}" class="btn btn-confirm">
        Confirmar pedido ✔
    </a>
</div>

@endif

@endsection
