@extends('admin.layout')

@section('content')
<h2 class="mb-4">📦 Pedidos</h2>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th># Pedido</th>
            <th>Cliente</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->user->name ?? '—' }}</td>
            <td>{{ ucfirst($pedido->estado) }}</td>
            <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.pedidos.show', $pedido->id) }}" class="btn btn-primary btn-sm">
                    Ver
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center text-muted">No hay pedidos aún.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
