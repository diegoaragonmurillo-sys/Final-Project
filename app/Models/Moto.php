<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'modelo', 'descripcion',
        'precio_unit', 'precio_mayor',
        'cantidad_mayorista', 'imagen'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function variantes()
    {
    return $this->hasMany(MotoVariante::class);
    }
}
