<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotoVariante extends Model
{
    protected $fillable = ['moto_id', 'color_nombre', 'color_hex', 'imagen'];

    public function moto()
    {
        return $this->belongsTo(Moto::class);
    }
}
