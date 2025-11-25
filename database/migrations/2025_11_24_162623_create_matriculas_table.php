<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            
            // LLAVES FORÁNEAS
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('restrict'); 
            
            // CAMPOS ENUM
            // Nivel (solo PRIMARIA y SECUNDARIA, en mayúsculas, consistente con Cursos/Docentes)
            $table->enum('nivel', ['PRIMARIA', 'SECUNDARIA']); 
            // Estado de la Matrícula (ACTIVO o INACTIVO, en mayúsculas)
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            
            $table->date('fecha');

            // Restricción única: un alumno solo puede estar matriculado una vez en un curso.
            $table->unique(['alumno_id', 'curso_id']); 
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};  