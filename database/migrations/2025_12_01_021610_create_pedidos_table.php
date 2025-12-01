<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            // Relación con usuario
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Información del pedido
            $table->enum('estado', ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'])
                ->default('pendiente');

            $table->decimal('total', 10, 2)->default(0);

            // Métodos de entrega
            $table->boolean('recoger_tienda')->default(false);
            $table->boolean('envio_domicilio')->default(false);

            // Métodos de pago
            $table->string('metodo_pago')->nullable();

            // Información opcional
            $table->string('direccion_entrega')->nullable();
            $table->string('telefono_contacto')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
