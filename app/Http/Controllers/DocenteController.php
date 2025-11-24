<?php

namespace App\Http\Controllers;

use App\Models\Docente; // Necesario para gestionar los docentes
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra la lista de todos los docentes.
     */
    public function index()
    {
        // Optimizamos cargando la relación 'cursos' (cursos que imparte)
        $docentes = Docente::with('cursos')->latest()->get();
        return view('docentes.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear un nuevo docente.
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Store a newly created resource in storage.
     * Almacena el nuevo docente en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:docentes,email',
            'especialidad' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
        ]);

        Docente::create($request->all());

        return redirect()->route('docentes.index')
            ->with('success', 'Docente registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     * Muestra los detalles de un docente específico, incluyendo sus cursos.
     */
    public function show(Docente $docente)
    {
        // Carga la relación de cursos que imparte para la vista de detalle
        $docente->load('cursos');
        return view('docentes.show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar un docente existente.
     */
    public function edit(Docente $docente)
    {
        return view('docentes.edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza el docente en la base de datos.
     */
    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            // Excluimos el email del docente actual de la regla unique
            'email' => 'required|email|unique:docentes,email,' . $docente->id,
            'especialidad' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
        ]);

        $docente->update($request->all());

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Elimina un docente de la base de datos.
     */
    public function destroy(Docente $docente)
    {
        // Nota: Asegúrate de manejar la restricción de llave foránea si el docente tiene cursos asignados.
        // Podrías necesitar desasignar los cursos antes de eliminar al docente.
        $docente->delete();

        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado correctamente.');
    }
}