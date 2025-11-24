<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Necesario para la consulta raw

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     * Genera y muestra diversos reportes analíticos.
     */
    public function index(Request $request)
    {
        // 1. Reporte Principal: Carga de Cursos y Conteo de Alumnos Matriculados
        $reporteCursos = Curso::withCount('alumnos')
            ->with('docente') // Para mostrar el docente asignado
            ->orderByDesc('alumnos_count')
            ->get();
            
        // 2. Reporte Analítico: Total de Matrículas por Mes (Solo del año actual)
        // Agrupa las matrículas por mes para una visualización tipo gráfico
        $matriculasPorMes = Matricula::select(DB::raw('MONTH(fecha) as mes'), DB::raw('COUNT(*) as total'))
            ->whereYear('fecha', date('Y')) 
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->keyBy('mes');

        // Preparamos los datos para un gráfico (JSON)
        $datosGrafico = [];
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        for ($i = 1; $i <= 12; $i++) {
            $datosGrafico[] = [
                'mes' => $meses[$i - 1],
                'total' => $matriculasPorMes->has($i) ? $matriculasPorMes[$i]->total : 0,
            ];
        }

        $data = [
            'reporteCursos' => $reporteCursos,
            'datosGraficoJSON' => json_encode($datosGrafico),
            'totalAlumnos' => Alumno::count(),
            'totalMatriculas' => Matricula::count(),
        ];

        return view('reportes.index', $data);
    }
}