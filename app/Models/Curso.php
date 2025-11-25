<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'nivel', // Este campo será un ENUM en la DB
        'docente_id',
        'alumnos_count' // Campo de conteo, manejado por la DB/lógica
    ];

    /**
     * Relación uno a uno (inversa): Un curso pertenece a un docente.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Relación uno a muchos: Un curso tiene muchas matrículas.
     */
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    /**
     * Relación muchos a muchos: Un curso tiene muchos alumnos a través de la tabla 'matriculas'.
     */
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'matriculas');
    }
}