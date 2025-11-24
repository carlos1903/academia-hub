<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'nombre',
        'nivel',
        'docente_id',
        'alumnos_count'
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'matriculas');
    }
}