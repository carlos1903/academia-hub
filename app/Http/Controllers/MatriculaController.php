<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Usamos 'with' para traer los datos del alumno y curso de una vez (optimización)
        $matriculas = Matricula::with(['alumno', 'curso'])->latest()->get();
        return view('matriculas.index', compact('matriculas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Necesitamos enviar la lista de alumnos y cursos para los <select>
        $alumnos = Alumno::all();
        $cursos = Curso::all();
        return view('matriculas.create', compact('alumnos', 'cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validamos los datos
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'nivel' => 'required|string',
            'fecha' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        // Creamos la matrícula
        Matricula::create($request->all());

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Matricula $matricula)
    {
        // Laravel busca automáticamente la matrícula por el ID
        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matricula $matricula)
    {
        // Para editar, necesitamos la matrícula actual Y las listas para los desplegables
        $alumnos = Alumno::all();
        $cursos = Curso::all();
        return view('matriculas.edit', compact('matricula', 'alumnos', 'cursos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matricula $matricula)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'nivel' => 'required|string',
            'fecha' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $matricula->update($request->all());

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matricula $matricula)
    {
        $matricula->delete();

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula eliminada correctamente.');
    }
}