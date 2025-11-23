<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'moto_id',
        'user_id',
        'rating',
        'comentario'
    ];

    public function moto()
    {
        return $this->belongsTo(Moto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
