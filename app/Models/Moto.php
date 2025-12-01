<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'modelo',
        'descripcion',

        // Categorías
        'categoria',
        'subcategoria',

        // Precios
        'precio_unit',
        'precio_mayor',
        'cantidad_mayorista',

        // Stock
        'stock',
        'stock_llegada',

        // Imagen
        'imagen',

        // Flags opciones
        'recojo_tienda',
        'entrega_domicilio',
        'pago_contra_entrega',

        // Ubicación
        'sede_id',
    ];

    protected $casts = [
        'precio_unit' => 'decimal:2',
        'precio_mayor' => 'decimal:2',
        'cantidad_mayorista' => 'integer',

        'stock' => 'integer',
        'stock_llegada' => 'integer',

        'recojo_tienda' => 'boolean',
        'entrega_domicilio' => 'boolean',
        'pago_contra_entrega' => 'boolean',
    ];

    /** 🔽 Relaciones */
    
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function variantes()
    {
        return $this->hasMany(MotoVariante::class);
    }

    public function favoritos()
    {
        return $this->belongsToMany(User::class, 'favoritos', 'moto_id', 'user_id');
    }

    public function esFavorito($userId)
    {
        return $this->favoritos()->where('user_id', $userId)->exists();
    }

    /** Accesorio para cargar imagen correctamente */
    public function getImagenUrlAttribute()
    {
        return asset("storage/{$this->imagen}");
    }
}
