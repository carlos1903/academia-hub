<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Matricula;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Muestra la página de reportes con métricas centradas en alumnos y cursos.
     */
    public function index()
    {
        // 1. Métrica Globales (Tarjetas Superiores)
        $totalAlumnos = Alumno::count();
        $totalDocentes = Docente::count();
        $totalCursos = Curso::count();
        $totalMatriculas = Matricula::count();
        
        // 2. Conteo de Alumnos por Nivel (Primaria vs. Secundaria)
        // Usamos whereIn para filtrar por niveles conocidos y DB::raw para el conteo
        $alumnosPorNivel = Alumno::select('nivel', DB::raw('count(*) as total'))
                                 ->whereIn('nivel', ['Primaria', 'Secundaria'])
                                 ->groupBy('nivel')
                                 ->pluck('total', 'nivel')
                                 ->all();

        // Inicializamos las variables en 0 y luego asignamos el valor del conteo
        $alumnosPrimaria = $alumnosPorNivel['Primaria'] ?? 0;
        $alumnosSecundaria = $alumnosPorNivel['Secundaria'] ?? 0;

        // 3. Conteo de Alumnos por Curso (para el gráfico principal)
        $cursosConConteo = Curso::select('cursos.nombre', DB::raw('count(matriculas.id) as total_alumnos'))
                                ->leftJoin('matriculas', 'cursos.id', '=', 'matriculas.curso_id')
                                ->groupBy('cursos.id', 'cursos.nombre')
                                ->orderBy('cursos.nombre', 'asc')
                                ->get();
        
        $labelsCursos = $cursosConConteo->pluck('nombre')->toArray();
        $dataCursos = $cursosConConteo->pluck('total_alumnos')->toArray();

        // 4. Conteo de Docentes por Cantidad de Cursos que Imparten (Top 5)
        $docentesConCursos = Docente::select('docentes.nombre', DB::raw('count(cursos.id) as total_cursos'))
                                    ->leftJoin('cursos', 'docentes.id', '=', 'cursos.docente_id')
                                    ->groupBy('docentes.id', 'docentes.nombre')
                                    ->orderByDesc('total_cursos')
                                    ->limit(5)
                                    ->get();

        $labelsDocentes = $docentesConCursos->pluck('nombre')->toArray();
        $dataDocentes = $docentesConCursos->pluck('total_cursos')->toArray();


        // === El arreglo $data es crucial para pasar las variables a la vista ===
        $data = [
            'globales' => [
                'total_alumnos' => $totalAlumnos,
                'total_docentes' => $totalDocentes,
                'total_cursos' => $totalCursos,
                'total_matriculas' => $totalMatriculas,
            ],
            // La variable 'niveles' que faltaba se define aquí
            'niveles' => [
                'alumnos_primaria' => $alumnosPrimaria,
                'alumnos_secundaria' => $alumnosSecundaria,
            ],
            'alumnos_por_curso' => [
                'labels' => $labelsCursos,
                'data' => $dataCursos,
            ],
            'cursos_por_docente' => [
                'labels' => $labelsDocentes,
                'data' => $dataDocentes,
            ]
        ];

        return view('reportes.index', $data);
    }
}