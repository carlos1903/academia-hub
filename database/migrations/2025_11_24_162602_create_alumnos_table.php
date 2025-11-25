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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            
            // Campos obligatorios
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('correo_electronico')->unique();
            
            // ✅ CORREGIDO: ENUM con valores en MAYÚSCULAS para consistencia
            $table->enum('nivel', ['PRIMARIA', 'SECUNDARIA']);
            $table->string('grado', 50);

            // Campos opcionales (nullable)
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono', 20)->nullable();
            
            // Timestamps de Laravel
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};