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
    Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('apellido');
        $table->string('ci')->unique(); // Cédula de Identidad
        $table->string('telefono')->nullable();
        $table->string('email')->unique()->nullable();
        $table->text('direccion')->nullable();
        $table->date('fecha_nacimiento')->nullable();
        $table->timestamps(); // Crea 'created_at' y 'updated_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
