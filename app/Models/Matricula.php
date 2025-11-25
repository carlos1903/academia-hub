<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'curso_id',
        'fecha_matricula',
        'estado',
        // Asegúrate de incluir todos los demás campos relevantes
    ];

    /**
     * Definimos los 'casts' para asegurarnos de que el campo de fecha se maneje como un objeto Carbon.
     * Esto soluciona el error "Call to a member function format() on string" en todas las vistas.
     */
    protected $casts = [
        'fecha_matricula' => 'datetime', // Usamos 'datetime' para mayor compatibilidad, aunque 'date' también funciona.
    ];
    
    //---------------------------------------------------------
    // RELACIONES
    //---------------------------------------------------------

    /**
     * Una Matrícula pertenece a un Alumno.
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    /**
     * Una Matrícula pertenece a un Curso.
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}