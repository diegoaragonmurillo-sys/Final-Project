<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'telefono'
    ];

    public function motos()
    {
        return $this->hasMany(Moto::class);
    }
}
