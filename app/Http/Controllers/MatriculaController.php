<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::with(['alumno', 'curso'])->orderBy('fecha_matricula', 'desc')->paginate(10);
        return view('matriculas.index', compact('matriculas'));
    }

    public function create()
    {
        $alumnos = Alumno::orderBy('nombre')->get();
        $cursos = Curso::orderBy('nombre')->get();

        // ✅ CORREGIDO: Estados en MAYÚSCULAS como en la BD
        $estados = [
            'ACTIVO',
            'INACTIVO',
        ];

        return view('matriculas.create', compact('alumnos', 'cursos', 'estados'));
    }

    public function store(Request $request)
    {
        // ✅ CORREGIDO: Validación con estados en MAYÚSCULAS
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id|unique:matriculas,alumno_id,NULL,id,curso_id,' . $request->input('curso_id'),
            'curso_id' => 'required|exists:cursos,id',
            'fecha_matricula' => 'required|date',
            'estado' => ['required', 'string', 'in:ACTIVO,INACTIVO'],
        ]);

        Matricula::create($request->all());

        return redirect()->route('matriculas.index')
                             ->with('success', 'Matrícula creada exitosamente.');
    }

    public function show(Matricula $matricula)
    {
        $matricula->load(['alumno', 'curso']);
        return view('matriculas.show', compact('matricula'));
    }

    public function edit(Matricula $matricula)
    {
        $alumnos = Alumno::orderBy('nombre')->get();
        $cursos = Curso::orderBy('nombre')->get();
        
        // ✅ CORREGIDO: Estados en MAYÚSCULAS
        $estados = [
            'ACTIVO',
            'INACTIVO',
        ];

        return view('matriculas.edit', compact('matricula', 'alumnos', 'cursos', 'estados'));
    }

    public function update(Request $request, Matricula $matricula)
    {
        // ✅ CORREGIDO: Validación con estados en MAYÚSCULAS
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id|unique:matriculas,alumno_id,' . $matricula->id . ',id,curso_id,' . $request->input('curso_id'), 
            'curso_id' => 'required|exists:cursos,id',
            'fecha_matricula' => 'required|date',
            'estado' => ['required', 'string', 'in:ACTIVO,INACTIVO'],
        ]);

        $matricula->update($request->all());

        return redirect()->route('matriculas.index')
                             ->with('success', 'Matrícula actualizada correctamente.');
    }

    public function destroy(Matricula $matricula)
    {
        $matricula->delete();

        return redirect()->route('matriculas.index')
                             ->with('success', 'Matrícula eliminada correctamente.');
    }
}