<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favoritos'; // 👈 IMPORTANTE

    protected $fillable = ['user_id', 'moto_id'];

    public function moto()
    {
        return $this->belongsTo(Moto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
