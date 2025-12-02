<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PedidoDetalle;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'estado',
        'total',
        'recoger_tienda',   
        'envio_domicilio',
        'metodo_pago',
        'direccion_entrega',
        'telefono_contacto'
    ];

    /** 🧾 Relación con detalles del pedido */
    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }

    /** 👤 Relación correcta con usuario (estándar Laravel) */
    public function user()
{
    return $this->belongsTo(User::class);
}

    /** 🪪 Alias opcional en español (solo si lo necesitas) */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function items()
    {
    return $this->hasMany(\App\Models\PedidoDetalle::class);
    }
}
