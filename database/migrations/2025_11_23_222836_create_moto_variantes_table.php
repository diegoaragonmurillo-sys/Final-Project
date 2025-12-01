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
            $table->string('color_nombre');
            $table->string('color_hex')->nullable();
            $table->string('imagen');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moto_variantes');
    }
};
