<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $table = 'pedido_detalles';

    protected $fillable = [
        'pedido_id',
        'moto_id',
        'producto',
        'color',
        'cantidad',
        'precio',
        'subtotal',
        'imagen',
    ];

    public function moto()
{
    return $this->belongsTo(\App\Models\Moto::class, 'moto_id');
}


    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
