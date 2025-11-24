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
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->enum('nivel', ['SECUNDARIA', 'INSTITUTO', 'UNIVERSIDAD']);
            $table->date('fecha');
            $table->enum('estado', ['RECHAZADO', 'PENDIENTE', 'APROBADA'])->default('PENDIENTE');
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['alumno_id', 'curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};