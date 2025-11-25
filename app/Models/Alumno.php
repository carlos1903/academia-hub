<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'nombre',
        'correo_electronico', // Debe coincidir exactamente con el nombre de la columna en la migración
        'nivel',    // Ej: Primaria, Secundaria
        'grado',    // Ej: 1, 2, 3...
        'telefono',
        // Si tienes más campos en la migración de alumnos, añádelos aquí.
    ];

    /**
     * Relación uno a muchos: un alumno puede tener varias matrículas.
     */
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}