<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;
    
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'alumno_id', 
        'curso_id',
        'fecha', // Asumo que este es el campo de fecha que estás usando
        'nivel',
        'estado',
    ];

    /**
     * Definir los tipos de datos para la conversión (Casting).
     * Esto convierte la cadena 'fecha' en un objeto Carbon/DateTime automáticamente.
     */
    protected $casts = [
        'fecha' => 'datetime', // ¡ESTA ES LA CORRECCIÓN CRÍTICA!
    ];

    // Relación con Alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    // Relación con Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}