<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'nivel',
        'docente_id',
    ];

    /**
     * Un Curso pertenece a un Docente.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
    
    /**
     * Un Curso tiene muchas Matriculas.
     * ✅ CORREGIDO: Ordenar por 'fecha_matricula' en vez de 'fecha'
     */
    public function matriculas()
    {
        return $this->hasMany(Matricula::class)->orderBy('fecha_matricula', 'desc');
    }

    /**
     * Un Curso tiene muchos Alumnos a través de Matriculas (many-to-many).
     * Esta relación permite acceder directamente a los alumnos del curso.
     */
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'matriculas', 'curso_id', 'alumno_id')
                    ->withPivot('fecha_matricula', 'estado')
                    ->withTimestamps();
    }
}