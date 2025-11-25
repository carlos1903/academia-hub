@extends('layouts.app')

@section('title', 'Dashboard - Academia Hub')

{{-- Incluimos Font Awesome (Chart.js ya no es necesario) --}}
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMD/CDQplR1Ff82/3j2Bf6yW/U9G/R1R7vB9Dq9/wD6wzF7l9R2fQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="p-6 md:p-8">
    
    {{-- TÍTULO DE LA PÁGINA --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard</h1>

    {{-- CABECERA Y BOTÓN A REPORTES --}}
    <div class="flex justify-end items-center mb-8">
        {{-- Botón de acceso rápido a Reportes --}}
        <a href="{{ route('reportes.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-lg font-semibold transition flex items-center gap-2 shadow-md">
            <i class="fas fa-chart-line"></i>
            VER REPORTES COMPLETOS
        </a>
    </div>

    {{-- 1. TARJETAS DE MÉTRICAS (KPIs) --}}
    {{-- Se redujo el grid a 3 columnas ya que se eliminó el KPI de Ingresos --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        
        {{-- TARJETA 1: ALUMNOS TOTALES (Datos Dinámicos) --}}
        <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-blue-500 transform hover:scale-[1.02] transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    {{-- VARIABLE DINÁMICA: totalAlumnos --}}
                    <p class="text-4xl font-bold text-gray-900">{{ $totalAlumnos ?? 0 }}</p> 
                    <p class="text-sm font-medium text-blue-500 uppercase">Total de Alumnos</p>
                </div>
                <i class="fas fa-user-graduate text-blue-500 text-3xl opacity-75"></i>
            </div>
        </div>

        {{-- TARJETA 2: DOCENTES ACTIVOS (Datos Dinámicos) --}}
        <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-teal-500 transform hover:scale-[1.02] transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    {{-- VARIABLE DINÁMICA: totalDocentes --}}
                    <p class="text-4xl font-bold text-gray-900">{{ $totalDocentes ?? 0 }}</p>
                    <p class="text-sm font-medium text-teal-500 uppercase">Docentes Activos</p>
                </div>
                <i class="fas fa-chalkboard-teacher text-teal-500 text-3xl opacity-75"></i>
            </div>
        </div>

        {{-- TARJETA 3: CURSOS OFERTADOS (Datos Dinámicos) --}}
        <div class="bg-white p-6 rounded-2xl shadow-xl border-l-4 border-yellow-500 transform hover:scale-[1.02] transition duration-300">
            <div class="flex items-center justify-between">
                <div>
                    {{-- VARIABLE DINÁMICA: totalCursos --}}
                    <p class="text-4xl font-bold text-gray-900">{{ $totalCursos ?? 0 }}</p>
                    <p class="text-sm font-medium text-yellow-500 uppercase">Cursos Vigentes</p>
                </div>
                <i class="fas fa-book-open text-yellow-500 text-3xl opacity-75"></i>
            </div>
        </div>
    </div>

    {{-- 2. BLOQUE DE ACTIVIDAD (ÚLTIMOS REGISTROS) --}}
    {{-- Ahora ocupa todo el ancho de la pantalla (lg:col-span-3) --}}
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-xl lg:col-span-3">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Actividad Reciente</h2>
            <ul class="space-y-4">
                {{-- Loop para actividad reciente (VARIABLE DINÁMICA: actividadReciente) --}}
                @forelse ($actividadReciente as $item)
                    {{-- Lógica para determinar el tipo de elemento y sus propiedades --}}
                    @php
                        // Se asume que \App\Models\Alumno y \App\Models\Docente (o similares) están definidos.
                        $isAlumno = $item instanceof \App\Models\Alumno;
                        $iconClass = $isAlumno ? 'fas fa-plus-circle text-blue-500' : 'fas fa-chalkboard-teacher text-teal-500';
                        $borderColor = $isAlumno ? 'border-blue-400' : 'border-teal-400';
                        $title = $isAlumno ? 'Nuevo Alumno' : 'Nuevo Docente';
                        // Usamos ?? 'Desconocido' como fallback si el campo es nulo
                        $subtitle = $isAlumno ? ($item->nivel ?? 'Nivel Desconocido') : ($item->especialidad ?? 'Especialidad Desconocida');
                        
                        // Generación de links (asegúrate que las rutas existan)
                        $link = '#'; // Fallback
                        try {
                            if ($isAlumno) {
                                $link = route('alumnos.show', $item->id);
                            } else {
                                $link = route('docentes.show', $item->id);
                            }
                        } catch (\Exception $e) {
                            // Ruta no definida, se queda el fallback '#'
                        }
                    @endphp
                    
                    <a href="{{ $link }}" class="block">
                        <li class="flex items-center p-3 bg-gray-50 rounded-lg border-l-4 {{ $borderColor }} hover:bg-gray-100 transition duration-150">
                            <i class="{{ $iconClass }} mr-3 flex-shrink-0"></i>
                            <div>
                                {{-- Usamos el campo 'nombre' o 'name' según el modelo --}}
                                <p class="text-sm font-medium text-gray-800">{{ $title }}: {{ $item->nombre ?? $item->name ?? 'Usuario sin nombre' }}</p>
                                {{-- 'diffForHumans()' necesita que el campo created_at sea un objeto Carbon --}}
                                <p class="text-xs text-gray-500">{{ $subtitle }}, registrado hace {{ $item->created_at->diffForHumans() }}.</p>
                            </div>
                        </li>
                    </a>
                @empty
                    <li class="p-3 text-center text-gray-500">
                        No hay actividad reciente registrada en la base de datos.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

{{-- No hay bloques @php ni @push('scripts') ya que no se usan gráficos. --}}

@endsection