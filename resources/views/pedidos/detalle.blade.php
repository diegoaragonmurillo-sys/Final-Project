@extends('layout')

@section('content')

<div class="container py-4">

    <h2 class="fw-bold mb-3">📦 Detalle del Pedido #{{ $pedido->id }}</h2>

    <div class="card shadow-sm p-3 mb-4">
        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> 
            <span class="badge bg-info">{{ ucfirst($pedido->estado) }}</span>
        </p>
        <p><strong>Total:</strong> 
            <span class="fw-bold text-success">S/ {{ number_format($pedido->total, 2) }}</span>
        </p>
    </div>

    <h4 class="fw-bold">🛍 Productos comprados</h4>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Imagen</th>
                <th>Producto</th>
                <th>Color</th>
                <th>Cantidad</th>
                <th>Precio unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>

        @foreach($pedido->detalles as $item)

            @php
                $img = $item->imagen;

                if (!$img && isset($item->moto->imagen)) {
                    $img = $item->moto->imagen;
                }

                if ($img && str_contains($img, ',')) {
                    $img = explode(',', $img)[0];
                }

                if ($img && !str_contains($img, 'http')) {
                    $img = str_starts_with($img, 'productos/')
                        ? asset('storage/'.$img)
                        : asset($img);
                }

                $img = $img ?: asset('imagenes/no-image.png');
            @endphp

            <tr class="text-center">
                <td>
                    <img src="{{ $img }}" width="70" class="rounded shadow-sm object-fit-cover">
                </td>

                <td>{{ $item->producto ?? $item->moto->nombre }}</td>
                <td>{{ $item->color ?? '—' }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>S/ {{ number_format($item->precio, 2) }}</td>

                <td class="text-success fw-bold">
                    S/ {{ number_format($item->subtotal, 2) }}
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="{{ route('perfil.pedidos') }}" class="btn btn-dark px-4 py-2">
            ← Volver a mis pedidos
        </a>
        <a href="{{ route('home') }}" class="btn btn-success px-4 py-2">
            Seguir comprando 🛒
        </a>
    </div>

</div>

@endsection
