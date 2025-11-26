<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Docente;
use App\Models\Curso;
use App\Models\Matricula; 
use Carbon\Carbon; // Necesario para calcular diferencias de tiempo

class DashboardController extends Controller
{
    public function index()
    {
        // 1. CÁLCULO DE KPIS
        $totalAlumnos = Alumno::count();
        $totalDocentes = Docente::count();
        $totalCursos = Curso::count();
        
        // Asumiendo que Matricula tiene un campo 'monto' o similar para calcular ingresos
        // EJEMPLO: Suma de montos de matrículas del mes actual
        $ingresosMes = 'Pendiente de cálculo real'; // Placeholder
        /*
        $ingresosMes = Matricula::whereMonth('created_at', Carbon::now()->month)
                                 ->whereYear('created_at', Carbon::now()->year)
                                 ->sum('monto');
        */

        // 2. DATOS PARA GRÁFICOS
        
        // A. Alumnos por Nivel
        // CORRECCIÓN: Se añade whereNotNull('nivel') para asegurar que solo se cuenten alumnos con nivel definido.
        $alumnosPorNivel = Alumno::whereNotNull('nivel')
                                ->select('nivel')
                                ->selectRaw('count(*) as total')
                                ->groupBy('nivel')
                                ->pluck('total', 'nivel')
                                ->toArray();
        
        $alumnosNivelLabels = array_keys($alumnosPorNivel);
        $alumnosNivelData = array_values($alumnosPorNivel);

        // B. Docentes por Especialidad
        $docentesPorEspecialidad = Docente::select('especialidad')
                                ->selectRaw('count(*) as total')
                                ->groupBy('especialidad')
                                ->pluck('total', 'especialidad')
                                ->toArray();

        $docentesEspecialidadLabels = array_keys($docentesPorEspecialidad);
        $docentesEspecialidadData = array_values($docentesPorEspecialidad);
        
        // C. Actividad Reciente (Últimos 4 registros de Alumnos o Docentes)
        $ultimosAlumnos = Alumno::latest()->take(2)->get();
        $ultimosDocentes = Docente::latest()->take(2)->get();
        
        // Combinamos y ordenamos para una línea de tiempo simple
        $actividadReciente = $ultimosAlumnos->merge($ultimosDocentes)->sortByDesc('created_at')->take(4);

        // 3. DATOS DE OCUPACIÓN (Ejemplo Ficticio)
        $aulasOcupadas = 75; 
        $aulasDisponibles = 25; 
        
        // LA LÍNEA CRÍTICA CORREGIDA: Apunta a resources/views/dashboard/index.blade.php
        return view('dashboard.index', [
            // KPIs
            'totalAlumnos' => $totalAlumnos,
            'totalDocentes' => $totalDocentes,
            'totalCursos' => $totalCursos,
            'ingresosMes' => $ingresosMes, 
            
            // Gráficos
            'alumnosNivelLabels' => $alumnosNivelLabels,
            'alumnosNivelData' => $alumnosNivelData,
            'docentesEspecialidadLabels' => $docentesEspecialidadLabels,
            'docentesEspecialidadData' => $docentesEspecialidadData,
            'aulasOcupadas' => $aulasOcupadas,
            'aulasDisponibles' => $aulasDisponibles,
            
            // Actividad
            'actividadReciente' => $actividadReciente,
        ]);
    }
}



