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
        Schema::table('matriculas', function (Blueprint $table) {
            // *** IMPORTANTE: CAMBIA 'old_column_name' por el nombre REAL de la columna de fecha en tu tabla 'matriculas' ***
            if (Schema::hasColumn('matriculas', 'fecha')) {
                 $table->renameColumn('fecha', 'fecha_matricula');
            } 
            // Si no existía ninguna columna de fecha, descomenta esta línea:
            /*
            else {
                $table->date('fecha_matricula')->nullable()->after('curso_id');
            }
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            // Revertir el nombre si el rollback es necesario
            if (Schema::hasColumn('matriculas', 'fecha_matricula')) {
                $table->renameColumn('fecha_matricula', 'fecha');
            }
        });
    }
};