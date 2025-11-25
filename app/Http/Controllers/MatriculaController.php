<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Añadido para transacciones y mass insertion

class MatriculaController extends Controller
{
    // Definiciones de ENUM (consistentes con la migración y la validación)
    private $niveles = ['PRIMARIA', 'SECUNDARIA'];
    private $estados = ['ACTIVO', 'INACTIVO'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Se añade la paginación para una mejor gestión de la lista
        $matriculas = Matricula::with(['alumno', 'curso'])
                                ->latest()
                                ->paginate(15);
        
        return view('matriculas.index', compact('matriculas'));
    }

    /**
     * Muestra el formulario para crear una nueva matrícula usando el flujo masivo.
     * Renombrado de 'create' a 'createMasiva'
     */
    public function createMasiva()
    {
        // Cargamos todos los alumnos y cursos para la selección masiva
        $alumnos = Alumno::orderBy('nombre')->get();
        $cursos = Curso::with('docente')->orderBy('nombre')->get(); // Cargar docente para la etiqueta
        
        // Las variables $niveles y $estados ya no son necesarias en la vista de Matrícula Masiva, 
        // ya que la matrícula hereda el nivel del curso/alumno.
        
        return view('matriculas.create_masiva', compact('alumnos', 'cursos'));
    }

    /**
     * Almacena múltiples matrículas para un solo curso.
     * Renombrado de 'store' a 'storeMasiva'
     */
    public function storeMasiva(Request $request)
    {
        // 1. Validar el curso y la lista de alumnos
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'alumnos_ids' => 'required|array|min:1', // Debe seleccionar al menos un alumno
            'alumnos_ids.*' => 'exists:alumnos,id',
        ]);

        $curso = Curso::findOrFail($request->input('curso_id'));
        $alumnosIds = $request->input('alumnos_ids');
        $matriculasACrear = [];
        $alumnosYaMatriculados = 0;
        $fechaActual = now();
        $estadoMatricula = 'ACTIVO'; // Asumimos que las nuevas matrículas están activas
        $nivelMatricula = $curso->nivel; // Tomamos el nivel del curso

        DB::beginTransaction();
        try {
            // 2. Verificar duplicados y preparar datos para inserción masiva
            foreach ($alumnosIds as $alumnoId) {
                // Verificar si la matrícula ya existe para evitar errores de clave única
                $existe = Matricula::where('curso_id', $curso->id)
                                    ->where('alumno_id', $alumnoId)
                                    ->exists();

                if (!$existe) {
                    $matriculasACrear[] = [
                        'curso_id' => $curso->id,
                        'alumno_id' => $alumnoId,
                        'fecha' => $fechaActual, // Usamos 'fecha' según tu base de datos
                        'nivel' => strtoupper($nivelMatricula), // Asegurar mayúsculas
                        'estado' => $estadoMatricula, // Asignar estado activo por defecto
                        'created_at' => $fechaActual,
                        'updated_at' => $fechaActual,
                    ];
                } else {
                    $alumnosYaMatriculados++;
                }
            }

            // 3. Insertar las matrículas válidas
            if (!empty($matriculasACrear)) {
                Matricula::insert($matriculasACrear);
            }
            
            DB::commit();

            $totalCreadas = count($matriculasACrear);
            $mensaje = "Matrículas creadas exitosamente: $totalCreadas para el curso '{$curso->nombre}'.";

            if ($alumnosYaMatriculados > 0) {
                $mensaje .= " ($alumnosYaMatriculados alumnos ya estaban matriculados y fueron omitidos.)";
            }
            
            return redirect()->route('matriculas.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            // Descomenta para ver el error exacto: dd($e); 
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al intentar matricular masivamente. Por favor, revise la conexión y los datos.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Matricula $matricula)
    {
        $matricula->load('alumno', 'curso');
        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matricula $matricula)
    {
        $alumnos = Alumno::orderBy('nombre')->get();
        $cursos = Curso::orderBy('nombre')->get();
        $niveles = $this->niveles;
        $estados = $this->estados;
        
        return view('matriculas.edit', compact('matricula', 'alumnos', 'cursos', 'niveles', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matricula $matricula)
    {
        // 1. Transformar Nivel y Estado a MAYÚSCULAS antes de la validación.
        if ($request->has('nivel')) {
            $request->merge(['nivel' => strtoupper($request->input('nivel'))]);
        }
        if ($request->has('estado')) {
            $request->merge(['estado' => strtoupper($request->input('estado'))]);
        }
        
        // 2. Validar la solicitud
        $validatedData = $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => [
                'required',
                'exists:cursos,id',
                // Validación para evitar duplicados, excluyendo la matrícula actual
                Rule::unique('matriculas')->ignore($matricula->id)->where(function ($query) use ($request) {
                    // La unicidad debe ser por la combinación de alumno y curso
                    return $query->where('alumno_id', $request->alumno_id);
                }),
            ],
            // VALIDACIÓN: Ahora verifica que el valor (ya en mayúsculas) sea ACTIVO o INACTIVO.
            'nivel' => ['required', Rule::in($this->niveles)],
            'estado' => ['required', Rule::in($this->estados)],
            'fecha' => 'required|date',
        ]);

        $matricula->update($validatedData);

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