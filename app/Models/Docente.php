<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'email',
        'especialidad'
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
