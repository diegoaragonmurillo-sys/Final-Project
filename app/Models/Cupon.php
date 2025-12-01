<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cupon extends Model
{
    protected $fillable = [
        'codigo',
        'tipo', // porcentaje, fijo
        'valor',
        'uso_maximo',
        'fecha_expira',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_expira' => 'date'
    ];

    // Función para validar el estado del cupón
    public function valido()
    {
        return $this->activo 
            && ($this->fecha_expira === null || $this->fecha_expira->isFuture()) 
            && ($this->uso_maximo === null || $this->uso_maximo > 0);
    }
}
