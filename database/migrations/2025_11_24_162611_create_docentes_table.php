<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            // Corregido el ENUM para usar solo 'PRIMARIA' y 'SECUNDARIA'
            $table->enum('especialidad', ['PRIMARIA', 'SECUNDARIA']); 
            // Añadido el campo telefono que se valida en el Controller
            $table->string('telefono', 20)->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};