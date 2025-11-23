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
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @php $total = 0; @endphp

        @foreach($carrito as $key => $item)

            @php 
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            @endphp

            <tr>
                <td width="100">
                    <img src="{{ asset('uploads/motos/'.$item['imagen']) }}" class="img-fluid rounded border" style="max-height: 70px;">
                </td>

                <td>{{ $item['moto'] }}</td>
                <td><span class="badge text-bg-primary">{{ $item['color'] }}</span></td>

                <td>{{ $item['cantidad'] }}</td>

                <td>S/ {{ number_format($item['precio'],2) }}</td>

                <td class="fw-bold text-success">S/ {{ number_format($subtotal,2) }}</td>

                <td>
                    <a href="{{ route('carrito.eliminar', $key) }}" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este producto del carrito?');">
                       ❌ Eliminar
                    </a>
                </td>
            </tr>

        @endforeach
    </tbody>
</table>

<div class="text-end">
    <h3>Total a pagar: <span class="text-success fw-bold">S/ {{ number_format($total,2) }}</span></h3>

    <a href="{{ route('orden.confirmar') }}" class="btn btn-lg btn-success mt-3">
        Confirmar pedido ✅
    </a>
</div>

@endif

@endsection
