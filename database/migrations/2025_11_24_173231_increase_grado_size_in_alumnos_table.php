<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::table('alumnos', function (Blueprint $table) {
                // Modifica el tipo de columna existente a VARCHAR(20)
                $table->string('grado', 20)->change();
            });
        }

        public function down(): void
        {
            Schema::table('alumnos', function (Blueprint $table) {
                // Vuelve al tamaño anterior si es necesario (ej: 10)
                $table->string('grado', 10)->change(); 
            });
        }
    };