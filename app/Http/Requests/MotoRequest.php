<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio_unit' => 'required|numeric',
            'precio_mayor' => 'nullable|numeric',
            'cantidad_mayorista' => 'nullable|integer',
            'imagen' => 'nullable'
        ];
    }
}
