<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docente extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que son asignables masivamente.
     * Se añaden 'especialidad' y 'telefono'.
     */
    protected $fillable = [
        'nombre',
        'email',
        'especialidad',
        'telefono', // Añadido para consistencia con el Controller/Migration
    ];

    /**
     * Relación uno a muchos: un docente tiene muchos cursos.
     */
    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}