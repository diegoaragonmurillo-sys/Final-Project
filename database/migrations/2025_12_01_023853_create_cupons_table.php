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
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // Código del cupón (Ej: DESCUENTO10)
            $table->enum('tipo', ['porcentaje', 'fijo']); // Tipo de descuento (10% o monto fijo)
            $table->decimal('valor', 10, 2); // Valor del descuento
            $table->integer('uso_maximo')->default(1); // Límite de usos
            $table->integer('usos_realizados')->default(0); // Contador de usos
            $table->date('fecha_expira')->nullable(); // Fecha límite
            $table->boolean('activo')->default(true); // Estado activo/inactivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupons');
    }
};
