<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('motos', function (Blueprint $table) {

            // Hacer columnas opcionales si existen
            if (Schema::hasColumn('motos', 'categoria')) {
                $table->string('categoria')->nullable()->change();
            }

            if (Schema::hasColumn('motos', 'modelo')) {
                $table->string('modelo')->nullable()->change();
            }

            // Agregar si no existen
            if (!Schema::hasColumn('motos', 'stock_disponible')) {
                $table->integer('stock_disponible')->default(0);
            }

            if (!Schema::hasColumn('motos', 'stock_llegada')) {
                $table->integer('stock_llegada')->default(0);
            }

            if (!Schema::hasColumn('motos', 'recojo_tienda')) {
                $table->boolean('recojo_tienda')->default(false);
            }

            if (!Schema::hasColumn('motos', 'entrega_domicilio')) {
                $table->boolean('entrega_domicilio')->default(false);
            }

            if (!Schema::hasColumn('motos', 'pago_contra_entrega')) {
                $table->boolean('pago_contra_entrega')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('motos', function (Blueprint $table) {
            // No borramos para no romper datos
        });
    }
};
