@extends('layout')

@section('content')

<div class="container py-4">

    <h3 class="mb-3">📦 Pedido #{{ $pedido->id }}</h3>

    {{-- ====== INFORMACIÓN DEL PEDIDO ====== --}}
    <div class="card p-3 mb-4">

        @php
            // 🎨 Color dinámico según estado
            $badgeColor = match($pedido->estado) {
                'pendiente' => 'warning',
                'enviado'   => 'primary',
                'entregado' => 'success',
                default     => 'secondary'
            };
        @endphp

        <p><strong>Cliente:</strong> {{ $pedido->usuario->name }}</p>
        <p><strong>Email:</strong> {{ $pedido->usuario->email }}</p>
        <p><strong>Estado:</strong> 
            <span class="badge bg-{{ $badgeColor }}">
                {{ ucfirst($pedido->estado) }}
            </span>
        </p>
        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Total:</strong> 
            <span class="text-success fw-bold">S/ {{ number_format($pedido->total, 2) }}</span>
        </p>
    </div>

    {{-- ====== CAMBIAR ESTADO ====== --}}
    <div class="card p-3 mb-4">
        <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="d-flex gap-2 align-items-center">
            @csrf
            <label class="fw-bold">Cambiar estado:</label>

            <select name="estado" class="form-select w-auto">
                <option value="pendiente"  {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="enviado"    {{ $pedido->estado == 'enviado' ? 'selected' : '' }}>Enviado</option>
                <option value="entregado"  {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
            </select>

            <button class="btn btn-success">💾 Guardar</button>
        </form>
    </div>

    
    {{-- ====== LISTA DE PRODUCTOS ====== --}}
    <h4> Productos del Pedido</h4>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Imagen</th>
                <th>Producto</th>
                <th>Color</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>

        @foreach($pedido->detalles as $detalle)

            {{-- ==== PROCESAR IMAGEN ==== --}}
            @php
                $img = $detalle->imagen ?? ($detalle->moto->imagen ?? null);

                if ($img && str_contains($img, ',')) {
                    $img = explode(',', $img)[0];
                }

                if ($img) {
                    if (str_starts_with($img, 'http')) {
                        $img = $img;
                    } elseif (str_starts_with($img, 'storage/')) {
                        $img = asset($img);
                    } elseif (str_starts_with($img, 'productos/') || str_starts_with($img, 'public/')) {
                        $img = asset('storage/' . str_replace(['public/', 'storage/'], '', $img));
                    } else {
                        $img = asset('storage/' . $img);
                    }
                }

                $img = $img ?: asset('imagenes/no-image.png');
            @endphp

            <tr class="text-center">
                <td>
                    <img src="{{ $img }}" width="70" height="70" class="rounded shadow-sm object-fit-cover">
                </td>

                <td>
                    {{ $detalle->producto ?? $detalle->moto->nombre . ' (' . $detalle->moto->modelo . ')' }}
                </td>

                <td>{{ $detalle->color ?? '—' }}</td>

                <td>{{ $detalle->cantidad }}</td>

                <td>S/ {{ number_format($detalle->precio_unitario, 2) }}</td>

                <td class="fw-bold text-success">
                    S/ {{ number_format($detalle->subtotal, 2) }}
                </td>
            </tr>

        @endforeach
        
        </tbody>
    </table>

    {{-- ====== BOTONES ====== --}}
    <div class="mt-4 d-flex gap-3">
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary">
            ⬅ Volver
        </a>
    </div>

</div>

@endsection
