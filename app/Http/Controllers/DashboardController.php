<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Docente;
use App\Models\Curso;
use App\Models\Matricula;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra el resumen estadístico del sistema.
     */
    public function index()
    {
        // 1. Obtener conteos totales
        $totalAlumnos = Alumno::count();
        $totalDocentes = Docente::count();
        $totalCursos = Curso::count();
        $totalMatriculasActivas = Matricula::where('estado', 'Activo')->count();

        // 2. Obtener datos detallados (ej: Top Cursos o Alumnos recientes)
        $cursosPopulares = Curso::withCount('alumnos')
            ->orderByDesc('alumnos_count')
            ->take(5)
            ->get();
            
        $ultimosAlumnos = Alumno::latest()->take(5)->get();

        // 3. Obtener la distribución de niveles (ejemplo de gráfico)
        $distribucionNiveles = Alumno::select('grado', \DB::raw('count(*) as total'))
            ->groupBy('grado')
            ->orderByDesc('total')
            ->get();

        // 4. Preparar datos para la vista
        $data = [
            'totalAlumnos' => $totalAlumnos,
            'totalDocentes' => $totalDocentes,
            'totalCursos' => $totalCursos,
            'totalMatriculasActivas' => $totalMatriculasActivas,
            'cursosPopulares' => $cursosPopulares,
            'ultimosAlumnos' => $ultimosAlumnos,
            'distribucionNiveles' => $distribucionNiveles,
        ];

        return view('dashboard.index', $data);
    }
}