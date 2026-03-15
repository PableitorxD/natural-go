<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('servicios_nutricionales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->date('fecha_consulta');
            
            // Datos Antropométricos
            $table->decimal('peso', 5, 2); // Ej: 75.50 kg
            $table->decimal('talla', 3, 2); // Ej: 1.75 m
            $table->decimal('imc', 5, 2)->nullable(); // Se puede calcular automáticamente
            $table->decimal('porcentaje_grasa', 5, 2)->nullable();
            $table->decimal('porcentaje_musculo', 5, 2)->nullable();
            
            // Medidas (opcional para seguimiento)
            $table->decimal('cintura', 5, 2)->nullable();
            $table->decimal('cadera', 5, 2)->nullable();

            // Notas y Recomendaciones
            $table->text('objetivo')->nullable(); // Ej: Bajar de peso, ganar masa
            $table->text('plan_sugerido')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_nutricionales');
    }
};
