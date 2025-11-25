<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Docente; 
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Muestra la vista principal de la lista de cursos.
     */
    public function index()
    {
        // Se asegura de recuperar todos los cursos (incluyendo los 'no eliminados')
        $cursos = Curso::with('docente')
                       ->withCount('matriculas as alumnos_count') 
                       ->orderBy('nombre', 'asc')
                       ->paginate(10);
        
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Muestra el formulario para crear un nuevo curso.
     */
    public function create()
    {
        $docentes = Docente::orderBy('nombre', 'asc')->get();
        
        $niveles = [
            'Primaria' => 'Primaria',
            'Secundaria' => 'Secundaria',
        ];

        return view('cursos.create', compact('docentes', 'niveles'));
    }

    /**
     * Almacena un curso recién creado.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos de entrada
        $request->validate([
            'codigo' => 'required|string|max:50|unique:cursos,codigo', 
            'nombre' => 'required|string|max:255',
            'nivel' => 'required|string|in:Primaria,Secundaria',
            'docente_id' => 'required|exists:docentes,id',
            'descripcion' => 'nullable|string', // Se asume que 'descripcion' debe guardarse
        ]);
        
        // 2. Crear y guardar el curso
        Curso::create($request->all());

        // 3. Redirigir con mensaje de éxito
        return redirect()->route('cursos.index')->with('success', 'Curso creado con éxito.');
    }

    /**
     * Muestra la información detallada de un curso y su lista de alumnos (Matrículas).
     */
    public function show(Curso $curso)
    {
        $curso->load('docente');

        $matriculas = $curso->matriculas()
                           ->with('alumno') 
                           ->orderBy('fecha', 'desc') 
                           ->get();

        return view('cursos.show', compact('curso', 'matriculas'));
    }

    /**
     * Muestra el formulario para editar el curso especificado.
     */
    public function edit(Curso $curso)
    {
        $docentes = Docente::orderBy('nombre', 'asc')->get();
        
        $niveles = [
            'Primaria' => 'Primaria',
            'Secundaria' => 'Secundaria',
        ];
        
        return view('cursos.edit', compact('curso', 'docentes', 'niveles'));
    }

    /**
     * Actualiza el curso especificado.
     */
    public function update(Request $request, Curso $curso)
    {
        // 1. Validar los datos de entrada
        $request->validate([
            'codigo' => 'required|string|max:50|unique:cursos,codigo,' . $curso->id, 
            'nombre' => 'required|string|max:255',
            'nivel' => 'required|string|in:Primaria,Secundaria',
            'docente_id' => 'required|exists:docentes,id',
            'descripcion' => 'nullable|string',
        ]);

        $curso->update($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado con éxito.');
    }

    /**
     * Elimina el curso especificado (Borrado suave/Soft Delete).
     */
    public function destroy(Curso $curso)
    {
        // Usa el método delete() de Eloquent, que activa SoftDeletes.
        $curso->delete();

        return redirect()->route('cursos.index')->with('success', 'Curso eliminado con éxito.');
    }
}