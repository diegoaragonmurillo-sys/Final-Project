<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class OrderService
{
    public static function crearOrden()
    {
        $carrito = session()->get('carrito', []);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => array_sum(array_column($carrito, 'precio')),
            'estado' => 'Pendiente'
        ]);

        foreach ($carrito as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'moto_id' => $id,
                'cantidad' => $item['cantidad'],
                'precio' => $item['precio']
            ]);
        }

        session()->forget('carrito');

        return $order;
    }
}
