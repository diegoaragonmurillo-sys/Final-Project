<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('modelo');
            $table->text('descripcion');
            $table->decimal('precio_unit', 10, 2);
            $table->decimal('precio_mayor', 10, 2)->nullable();
            $table->integer('cantidad_mayorista')->default(5);
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motos');
    }
};
