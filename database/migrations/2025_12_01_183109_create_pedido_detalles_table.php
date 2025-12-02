<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido_detalles', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('moto_id');

            // Información del producto
            $table->string('producto')->nullable();  // Nombre como fue comprado
            $table->string('color')->nullable();     // Color seleccionado
            $table->string('imagen')->nullable();    // Imagen mostrada en pedido

            // Cantidad y precios
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);

            // Metadata de control (opcional útil para reportes)
            $table->enum('estado_stock', ['pendiente', 'reservado', 'entregado'])->default('pendiente');

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('moto_id')->references('id')->on('motos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_detalles');
    }
};
