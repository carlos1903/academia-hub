<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->string('nombre');
            // CORREGIDO: Usamos solo PRIMARIA y SECUNDARIA para consistencia con Docentes
            $table->enum('nivel', ['PRIMARIA', 'SECUNDARIA']); 
            
            // LLAVE FORÁNEA a la tabla de Docentes. Usar constrained() es la forma moderna.
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('restrict'); 
            
            // Campo para almacenar el conteo de alumnos (opcional pero útil)
            $table->integer('alumnos_count')->default(0); 
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};