<?php

namespace App\Http\Controllers;

use App\Models\Curso; // Importar el modelo Curso
use App\Models\Docente; // Necesario para el desplegable en create y edit
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Optimizamos cargando la relación 'docente' para evitar N+1 queries en la tabla
        $cursos = Curso::with('docente')->latest()->get();
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Necesitamos la lista de docentes para el <select>
        $docentes = Docente::orderBy('nombre')->get();
        return view('cursos.create', compact('docentes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:10|unique:cursos,codigo',
            'nombre' => 'required|string|max:255',
            'nivel' => 'required|string|max:50',
            'docente_id' => 'required|exists:docentes,id',
        ]);

        Curso::create($request->all());

        return redirect()->route('cursos.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        // Usamos with(['docente', 'alumnos']) para cargar la información relacionada
        $curso->load('docente', 'alumnos');
        return view('cursos.show', compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        // Necesitamos la lista de docentes para el <select> en el formulario de edición
        $docentes = Docente::orderBy('nombre')->get();
        return view('cursos.edit', compact('curso', 'docentes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            // Excluimos el código del curso actual de la regla unique
            'codigo' => 'required|string|max:10|unique:cursos,codigo,' . $curso->id,
            'nombre' => 'required|string|max:255',
            'nivel' => 'required|string|max:50',
            'docente_id' => 'required|exists:docentes,id',
        ]);

        $curso->update($request->all());

        return redirect()->route('cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()->route('cursos.index')
            ->with('success', 'Curso eliminado correctamente.');
    }
}