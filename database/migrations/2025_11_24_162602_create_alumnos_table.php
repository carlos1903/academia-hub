<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            
            // CORREGIDO: Solo se permiten 'PRIMARIA' y 'SECUNDARIA'
            $table->enum('nivel', ['PRIMARIA', 'SECUNDARIA']); 
            
            // Grados se mantienen igual, pero asegúrate de que sean consistentes
            $table->enum('grado', ['1RO', '2DO', '3RO', '4TO', '5TO', '6TO']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};