<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $blueprint) {
            // Añadimos el campo después de 'total'
            $blueprint->string('metodo_pago')->default('efectivo')->after('total');
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $blueprint) {
            $blueprint->dropColumn('metodo_pago');
        });
    }
};