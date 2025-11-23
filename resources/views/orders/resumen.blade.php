@extends('layout')

@section('content')
<h2>Compra Confirmada ✔</h2>

<p>Gracias por tu compra. Tu pedido ha sido registrado.</p>

<a href="{{ route('motos.index') }}" class="btn btn-primary">Seguir comprando</a>
@endsection
