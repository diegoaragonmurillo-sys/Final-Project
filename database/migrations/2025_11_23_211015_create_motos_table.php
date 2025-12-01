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
            
            // Información base
            $table->string('nombre');
            $table->string('modelo');
            $table->text('descripcion')->nullable();

            // Categorías (Catálogo base)
            $table->string('categoria'); // bicimotos, motos-electricas, trimotos, accesorios, repuestos
            $table->string('subcategoria')->nullable(); // llantas, baterías, luces, etc

            // Precios
            $table->decimal('precio_unit', 10, 2);
            $table->decimal('precio_mayor', 10, 2)->nullable();
            $table->integer('cantidad_mayorista')->default(5);

            // Inventario
            $table->integer('stock')->default(0);

            // Imagen principal
            $table->string('imagen')->nullable();

            // Relación con sede
            $table->unsignedBigInteger('sede_id')->nullable();
            $table->foreign('sede_id')->references('id')->on('sedes')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motos');
    }
};
