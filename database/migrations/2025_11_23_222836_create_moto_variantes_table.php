<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moto_variantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moto_id')->constrained()->cascadeOnDelete();
            $table->string('color_nombre');   // Rojo, Negro, Blanco, Azul, etc.
            $table->string('color_hex')->nullable(); // #ff0000 (para botón visual)
            $table->string('imagen'); // imagen principal de la variante
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moto_variantes');
    }
};
