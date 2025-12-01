@extends('layout')

@section('content')
<div class="container py-4">

    <h3>📄 Detalle del Pedido #{{ $pedido->id }}</h3>

    <div class="card shadow-sm p-3 mb-4">
        <h5>Cliente:</h5>
        <p>{{ $pedido->usuario->name }} — {{ $pedido->usuario->email }}</p>

        <h5>Estado:</h5>
        <span class="badge bg-info">{{ $pedido->estado }}</span>

        <h5 class="mt-3">Fecha:</h5>
        <p>{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <h4>🛵 Productos</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->items as $item)
            <tr>
                <td>{{ $item->moto->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>S/. {{ number_format($item->precio,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="text-end mt-4">
        Total: <strong>S/. {{ number_format($pedido->total,2) }}</strong>
    </h3>
</div>
@endsection
