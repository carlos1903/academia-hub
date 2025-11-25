<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * ✅ CRÍTICO: Asegúrate de incluir TODOS los campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'correo_electronico', // ✅ ESTE CAMPO ES CRÍTICO
        'telefono',
        'fecha_nacimiento',
        'nivel',
        'grado',
    ];

    /**
     * Cast de tipos para manejar fechas correctamente
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Un Alumno puede tener muchas Matrículas (relación con Curso a través de Matricula)
     */
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    /**
     * Un Alumno puede estar en muchos Cursos a través de Matriculas (many-to-many)
     */
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'matriculas', 'alumno_id', 'curso_id')
                    ->withPivot('fecha_matricula', 'estado')
                    ->withTimestamps();
    }
}