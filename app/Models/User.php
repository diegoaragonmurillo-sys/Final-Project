<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que se pueden llenar masivamente
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // si usas roles
    ];

    /**
     * Campos ocultos para serialización
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * ❤️ Relación Many-to-Many con motos favoritas
     */
    public function favoritos()
    {
        return $this->belongsToMany(
            Moto::class,
            'favoritos',   // tabla pivote
            'user_id',     // llave del usuario
            'moto_id'      // llave de la moto
        )->withTimestamps(); // guarda fechas en la tabla pivote
    }

    /**
     * Alias opcional para compatibilidad si usaste favorites() en Blade
     */
    public function favorites()
    {
        return $this->favoritos();
    }
    public function pedidos()
{
    return $this->hasMany(\App\Models\Pedido::class, 'user_id');
}

}
