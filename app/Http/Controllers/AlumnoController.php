<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Matricula; 
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Muestra la vista principal de la lista de alumnos.
     */
    public function index()
    {
        // Ordenamos por nombre (o apellido, según preferencia) para una mejor visualización.
        $alumnos = Alumno::orderBy('nombre')->paginate(10);
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Muestra el formulario para crear un nuevo alumno.
     */
    public function create()
    {
        return view('alumnos.create');
    }

    /**
     * Almacena un alumno recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // 1. Lógica de validación
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:alumnos,email', // Debe ser único en la tabla 'alumnos'
            'fecha_nacimiento' => 'nullable|date',
            // Asegúrate de que los valores de 'nivel' coincidan con tu base de datos (e.g., Primaria, Secundaria)
            'nivel' => 'required|in:Primaria,Secundaria', 
        ]);
        
        // 2. Almacenamiento
        Alumno::create($request->all());
        
        return redirect()->route('alumnos.index')->with('success', 'Alumno creado con éxito.');
    }

    /**
     * Muestra la información detallada de un alumno y su historial de matrículas.
     */
    public function show(Alumno $alumno)
    {
        // Cargamos las matrículas relacionadas con este alumno, ordenadas por fecha descendente
        $matriculas = Matricula::where('alumno_id', $alumno->id)
                               ->orderBy('fecha', 'desc')
                               ->with('curso') 
                               ->get();

        return view('alumnos.show', compact('alumno', 'matriculas'));
    }

    /**
     * Muestra el formulario para editar el alumno especificado.
     */
    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    /**
     * Actualiza el alumno especificado en el almacenamiento.
     */
    public function update(Request $request, Alumno $alumno)
    {
        // 1. Lógica de validación
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            // El email debe ser único, excluyendo el ID del alumno actual
            'email' => 'required|email|unique:alumnos,email,' . $alumno->id,
            'fecha_nacimiento' => 'nullable|date',
            'nivel' => 'required|in:Primaria,Secundaria',
        ]);
        
        // 2. Actualización
        $alumno->update($request->all());
        
        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado con éxito.');
    }

    /**
     * Elimina el alumno especificado del almacenamiento.
     */
    public function destroy(Alumno $alumno)
    {
        // Lógica de eliminación. 
        // Si usas llaves foráneas en la base de datos con ON DELETE CASCADE, 
        // las matrículas relacionadas se eliminarán automáticamente.
        $alumno->delete();
        
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado con éxito.');
    }
}