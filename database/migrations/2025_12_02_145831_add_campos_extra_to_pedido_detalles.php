<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedido_detalles', function (Blueprint $table) {
            $table->string('producto')->nullable()->after('moto_id');
            $table->string('color')->nullable()->after('producto');
            $table->string('imagen')->nullable()->after('color');
            $table->decimal('precio', 10, 2)->nullable()->after('cantidad'); // Fix porque en tu código usas "precio"
        });
    }

    public function down(): void
    {
        Schema::table('pedido_detalles', function (Blueprint $table) {
            $table->dropColumn(['producto', 'color', 'imagen', 'precio']);
        });
    }
};
