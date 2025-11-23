<?php

namespace App\Http\Controllers;

use App\Services\OrderService;

class OrderController extends Controller
{
    public function confirmar()
    {
        $order = OrderService::crearOrden();
        return view('orders.resumen', compact('order'));
    }
}
