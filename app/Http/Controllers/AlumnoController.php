<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Matricula; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AlumnoController extends Controller
{
    /**
     * Muestra la vista principal de la lista de alumnos.
     */
    public function index()
    {
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
        try {
            // ✅ Convertir nivel a MAYÚSCULAS antes de validar
            $request->merge(['nivel' => strtoupper($request->nivel)]);
            
            // ✅ CORREGIDO: Validación con niveles en MAYÚSCULAS
            $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100', 
                'correo_electronico' => 'required|email|unique:alumnos,correo_electronico', 
                'fecha_nacimiento' => 'nullable|date',
                'nivel' => ['required', Rule::in(['PRIMARIA', 'SECUNDARIA'])],
                'grado' => 'required|string|max:50', 
                'telefono' => 'nullable|string|max:20', 
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Fallo de validación (STORE):', $e->errors());
            return redirect()->back()->withInput()->withErrors($e->errors());
        }
        
        try {
            Alumno::create($request->all());
        
            return redirect()->route('alumnos.index')->with('success', 'Alumno creado con éxito.');

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Error de BD al crear Alumno:', ['error' => $e->getMessage(), 'request' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Error en la base de datos: ' . $e->getMessage());
        }
    }

    /**
     * Muestra la información detallada de un alumno y su historial de matrículas.
     */
    public function show(Alumno $alumno)
    {
        $matriculas = Matricula::where('alumno_id', $alumno->id)
                               ->orderBy('fecha_matricula', 'desc')
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
        // ✅ Convertir nivel a MAYÚSCULAS antes de validar
        $request->merge(['nivel' => strtoupper($request->nivel)]);
        
        // ✅ CORREGIDO: Validación con niveles en MAYÚSCULAS
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo_electronico' => 'required|email|unique:alumnos,correo_electronico,' . $alumno->id,
            'fecha_nacimiento' => 'nullable|date',
            'nivel' => ['required', Rule::in(['PRIMARIA', 'SECUNDARIA'])],
            'grado' => 'required|string|max:50',
            'telefono' => 'nullable|string|max:20',
        ]);
        
        $alumno->update($request->all());
        
        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado con éxito.');
    }

    /**
     * Elimina el alumno especificado del almacenamiento.
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado con éxito.');
    }
}