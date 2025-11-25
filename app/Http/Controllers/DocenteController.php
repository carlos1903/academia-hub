<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    /**
     * Muestra la lista de todos los docentes.
     */
    public function index()
    {
        // Recupera todos los docentes, ordenados alfabéticamente por nombre y con paginación
        $docentes = Docente::orderBy('nombre', 'asc')->paginate(10);
        
        // Retorna la vista index de docentes, pasando la colección
        return view('docentes.index', compact('docentes'));
    }

    /**
     * Muestra el formulario para crear un nuevo docente.
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Almacena un docente recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:docentes,email|max:255',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'required|string|max:100',
        ]);

        // 2. Crear el nuevo docente
        Docente::create($request->all());

        // 3. Redirigir con mensaje de éxito
        return redirect()->route('docentes.index')
                         ->with('success', 'Docente creado con éxito.');
    }

    /**
     * Muestra la información detallada del docente especificado.
     */
    public function show(Docente $docente)
    {
        return view('docentes.show', compact('docente'));
    }

    /**
     * Muestra el formulario para editar el docente especificado.
     */
    public function edit(Docente $docente)
    {
        return view('docentes.edit', compact('docente'));
    }

    /**
     * Actualiza el docente especificado en la base de datos.
     */
    public function update(Request $request, Docente $docente)
    {
        // 1. Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            // El email debe ser único, excluyendo el email actual del docente
            'email' => 'required|email|max:255|unique:docentes,email,' . $docente->id,
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'required|string|max:100',
        ]);

        // 2. Actualizar el docente
        $docente->update($request->all());

        // 3. Redirigir con mensaje de éxito
        return redirect()->route('docentes.index')
                         ->with('success', 'Docente actualizado con éxito.');
    }

    /**
     * Elimina el docente especificado.
     */
    public function destroy(Docente $docente)
    {
        $docente->delete();

        return redirect()->route('docentes.index')
                         ->with('success', 'Docente eliminado con éxito.');
    }
}