<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno; // Asegúrate de que este modelo exista

class AlumnoController extends Controller
{
    /**
     * Muestra la lista de alumnos (Index de la maqueta Desktop - 2.png).
     */
    public function index()
    {
        // Obtiene todos los alumnos para la tabla
        $alumnos = Alumno::all();

        // Retorna la vista: resources/views/alumnos/index.blade.php
        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Muestra el formulario para crear un nuevo alumno.
     */
    public function create()
    {
        // Retorna la vista: resources/views/alumnos/create.blade.php
        return view('alumnos.create');
    }

    /**
     * Guarda un nuevo alumno en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validación de datos (Ajusta estas reglas a tus necesidades)
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:alumnos,email',
            'nivel' => 'required|string|max:255',
            'grado' => 'required|string|max:20', // Usa 'max:20' que coincide con la migración
        ]);
        
        // 2. Creación del registro
        Alumno::create($validatedData);

        // 3. Redirección y mensaje
        return redirect()->route('alumnos.index')->with('success', '¡Alumno creado exitosamente!');
    }

    // Faltan los métodos show, edit, update y destroy.
    // ...
}