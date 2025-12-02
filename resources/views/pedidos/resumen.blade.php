@extends('layout')

@section('content')

<div class="container py-4">

    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">🎉 ¡Gracias por tu compra!</h2>
        <p class="text-muted">Tu pedido ha sido confirmado y registrado correctamente.</p>
    </div>

    {{-- Información del pedido --}}
    <div class="card shadow-sm p-3 mb-4">
        <h5 class="fw-bold">📦 Pedido #{{ $pedido->id }}</h5>
        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> 
            <span class="badge bg-info">{{ ucfirst($pedido->estado) }}</span>
        </p>
    </div>

    <h4>🛍 Detalle del Pedido</h4>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Color</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>

            @foreach($pedido->detalles as $item)

                {{-- 🔧 Manejo inteligente de imágenes --}}
                @php
                    $img = $item->imagen ?? null;

                    // Intentar obtener imagen del producto si viene vacía
                    if (!$img && isset($item->moto->imagen)) {
                        $img = $item->moto->imagen;
                    }

                    // Si hay varias imágenes separadas por coma → usar primera
                    if ($img && str_contains($img, ',')) {
                        $img = explode(',', $img)[0];
                    }

                    // Normalizar rutas
                    if ($img) {
                        if (str_starts_with($img, 'http')) {
                            $img = $img;
                        } elseif (str_starts_with($img, 'storage/')) {
                            $img = asset($img);
                        } elseif (str_starts_with($img, 'public/')) {
                            $img = asset(str_replace('public/', 'storage/', $img));
                        } else {
                            $img = asset('storage/' . $img);
                        }
                    }

                    // Imagen por defecto
                    $img = $img ?: asset('imagenes/no-image.png');
                @endphp

                <tr>
                    <td class="text-center">
                        <img src="{{ $img }}" width="70" height="70" class="rounded shadow object-fit-cover">
                    </td>

                    <td>{{ $item->producto }}</td>

                    <td>{{ $item->color ?? '—' }}</td>

                    <td>{{ $item->cantidad }}</td>

                    <td>S/ {{ number_format($item->precio, 2) }}</td>

                    <td class="fw-bold text-success">
                        S/ {{ number_format($item->subtotal, 2) }}
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

    <div class="text-end mt-3">
        <h3 class="fw-bold text-success">
            Total: S/ {{ number_format($pedido->total, 2) }}
        </h3>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="{{ route('home') }}" class="btn btn-success px-4 py-2">Seguir comprando 🛒</a>
        <a href="{{ route('perfil.pedidos') }}" class="btn btn-dark px-4 py-2">Ver mis pedidos 📦</a>
    </div>

</div>

@endsection
