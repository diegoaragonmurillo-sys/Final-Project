@extends('admin.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">📊 Dashboard Administrador</h2>

    <div class="row g-4 text-center">
        <div class="col-md-3">
            <div class="card shadow-sm border-0"><div class="card-body">
                <h4>{{ $totalMotos }}</h4><p>Motos Registradas</p>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0"><div class="card-body">
                <h4>{{ $totalPedidos }}</h4><p>Pedidos</p>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0"><div class="card-body">
                <h4>{{ $totalUsuarios }}</h4><p>Usuarios</p>
            </div></div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0"><div class="card-body">
                <h4>{{ $stockLlegada }}</h4><p>Stock Total</p>
            </div></div>
        </div>
    </div>

</div>
@endsection
