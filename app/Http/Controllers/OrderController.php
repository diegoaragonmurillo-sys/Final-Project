<?php

namespace App\Http\Controllers;

use App\Services\PedidoService;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirmar()
    {
        $pedido = PedidoService::crearPedido();

        if (!$pedido) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        return view('pedidos.resumen', compact('pedido'));
    }
}
