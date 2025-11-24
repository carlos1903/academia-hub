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
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->enum('nivel', ['SECUNDARIA', 'INSTITUTO', 'UNIVERSIDAD']);
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
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