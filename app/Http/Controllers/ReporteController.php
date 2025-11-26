<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        /* ============================================================
           1. DISTRIBUCIÓN DE ALUMNOS POR CURSO
        ============================================================ */
        $alumnosPorCurso = Curso::withCount('alumnos')
            ->orderBy('alumnos_count', 'desc')
            ->get();

        $datosAlumnosPorCurso = [
            'labels' => $alumnosPorCurso->pluck('nombre'),
            'data'   => $alumnosPorCurso->pluck('alumnos_count'),
        ];

        /* ============================================================
           2. ALUMNOS POR GRADO
        ============================================================ */
        $alumnosPorGrado = Alumno::select('grado', DB::raw('COUNT(*) as total'))
            ->groupBy('grado')
            ->orderByRaw("CAST(SUBSTRING(grado, 1, LENGTH(grado)-2) AS UNSIGNED) ASC")
            ->get();

        $datosAlumnosPorGrado = [
            'labels' => $alumnosPorGrado->pluck('grado'),
            'data'   => $alumnosPorGrado->pluck('total'),
        ];

        /* ============================================================
           3. TOP 5 DOCENTES CON MÁS CURSOS
        ============================================================ */
        $topDocentes = Curso::select('docente_id', DB::raw('COUNT(*) as total'))
            ->with('docente')
            ->groupBy('docente_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $datosDocentes = [
            'labels' => $topDocentes->pluck('docente.nombre'),
            'data'   => $topDocentes->pluck('total'),
        ];

        return view('reportes.index', compact(
            'datosAlumnosPorCurso',
            'datosAlumnosPorGrado',
            'datosDocentes'
        ));
    }
}
