@extends('admin.layout')

@section('content')

<h2 class="mb-4">📦 Gestión de Pedidos</h2>

{{-- Mensajes --}}
@if(session('success'))
<div class="alert alert-success fw-bold text-center">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger fw-bold text-center">
    {{ session('error') }}
</div>
@endif

<table class="table table-hover align-middle shadow-sm">
    <thead class="table-dark">
        <tr class="text-center">
            <th>#</th>
            <th>Cliente</th>
            <th>Estado</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($pedidos as $pedido)
        <tr class="text-center">
            <td class="fw-bold">#{{ $pedido->id }}</td>

            {{-- Cliente --}}
            <td>
                <strong>{{ $pedido->usuario->name ?? '—' }}</strong><br>
                <small class="text-muted">{{ $pedido->usuario->email }}</small>
            </td>

            {{-- Estado con color dinámico --}}
            <td>
                @php
                    $badgeColor = match($pedido->estado) {
                        'pendiente' => 'warning',
                        'enviado' => 'primary',
                        'entregado' => 'success',
                        default => 'secondary'
                    };
                @endphp

                <span class="badge bg-{{ $badgeColor }} px-3 py-2">
                    {{ ucfirst($pedido->estado) }}
                </span>
            </td>

            {{-- Total --}}
            <td class="fw-bold text-success">
                S/ {{ number_format($pedido->total, 2) }}
            </td>

            {{-- Fecha --}}
            <td>{{ $pedido->created_at->format('d/m/Y') }}</td>

            {{-- Botones --}}
            <td class="d-flex justify-content-center gap-2">

                {{-- Ver Pedido --}}
                <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-sm btn-primary">
                    Ver
                </a>

                {{-- Eliminar Pedido --}}
                <form action="{{ route('admin.pedidos.destroy', $pedido->id) }}" method="POST"
                    onsubmit="return confirm('⚠ ¿Seguro que deseas eliminar este pedido? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>

            </td>
        </tr>

        @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-muted">
                🚫 No hay pedidos registrados aún.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- Paginación --}}
<div class="mt-3">
    {{ $pedidos->links() }}
</div>

@endsection
