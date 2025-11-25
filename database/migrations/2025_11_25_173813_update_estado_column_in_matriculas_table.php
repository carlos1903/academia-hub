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
        // Se asume que has ejecutado 'composer require doctrine/dbal'
        Schema::table('matriculas', function (Blueprint $table) {
            // Aumenta el tamaño del campo a 20 para que quepa 'PENDIENTE' (9 caracteres)
            $table->string('estado', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            // Revertir al tamaño original o a un tamaño menor si es necesario
            $table->string('estado', 5)->change(); 
        });
    }
};