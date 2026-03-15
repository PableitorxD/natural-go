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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained(); // A qué cliente le cobramos
            $table->decimal('monto', 10, 2); // En Bolivianos
            $table->string('moneda')->default('BOB');
            $table->string('estado')->default('pendiente'); // pendiente, pagado, expirado
            $table->string('referencia_libelula')->nullable(); // El ID que te dará Libélula
            $table->text('qr_image')->nullable(); // Para guardar el código base64 del QR
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
