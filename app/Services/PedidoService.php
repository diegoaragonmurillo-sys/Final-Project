<?php

namespace App\Services;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Cupon;
use Illuminate\Support\Facades\Auth;

class PedidoService
{
    public static function crearPedido()
    {
        $usuario = Auth::user();
        $carrito = session()->get('carrito', []);

        // --- Validar carrito vacío ---
        if (empty($carrito)) {
            return false;
        }

        // --- Calcular subtotal ---
        $subtotal = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);

        // --- Leer cupón desde sesión ----
        $codigoCupon = session()->get('cupon');
        $cuponData   = session()->get('cupon_data');
        $descuento   = 0;

        if ($codigoCupon && $cuponData) {

            // Si el cupón es porcentaje
            if ($cuponData['tipo'] === 'porcentaje') {
                $descuento = $subtotal * ($cuponData['valor'] / 100);
            }

            // Si es un monto fijo
            if ($cuponData['tipo'] === 'fijo') {
                $descuento = $cuponData['valor'];
            }

            // Evitar descuento mayor al total
            $descuento = min($subtotal, $descuento);

            // Descontar uso del CUPON en BD si aplica
            $cupon = Cupon::where('codigo', $codigoCupon)->first();
            if ($cupon && $cupon->uso_maximo !== null) {
                $cupon->uso_maximo = max(0, $cupon->uso_maximo - 1);
                $cupon->save();
            }
        }

        // --- Total final aplicando cupón ---
        $totalFinal = $subtotal - $descuento;

        // Crear pedido
        $pedido = Pedido::create([
            'user_id'     => $usuario->id,
            'estado'      => 'pendiente',
            'subtotal'    => $subtotal,
            'descuento'   => $descuento,
            'total'       => $totalFinal,
            'cupon_usado' => $codigoCupon,
        ]);

        // Registrar los items del pedido
        foreach ($carrito as $item) {
            PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'moto_id'   => $item['id'],
                'producto'  => $item['moto'],
                'color'     => $item['color'],
                'cantidad'  => $item['cantidad'],
                'precio'    => $item['precio'],
                'subtotal'  => $item['precio'] * $item['cantidad'],
                'imagen'    => $item['imagen'] ?? null,
            ]);
        }

        // Vaciar carrito y cupón después del pedido
        session()->forget(['carrito', 'cupon', 'cupon_data']);

        return $pedido;
    }
}
