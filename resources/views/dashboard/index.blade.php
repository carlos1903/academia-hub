{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard | Reporte General')

@section('content')
<div class="p-6 md:p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <i class="fas fa-chart-line text-teal-500 mr-2"></i> RESUMEN ACADÉMICO
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-2xl shadow-sm p-5 border-l-4 border-blue-500">
            <p class="text-sm font-semibold text-gray-500 uppercase">Total Alumnos</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalAlumnos }}</p>
            <i class="fas fa-user-graduate absolute top-5 right-5 text-gray-200 text-4xl opacity-50"></i>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5 border-l-4 border-yellow-500">
            <p class="text-sm font-semibold text-gray-500 uppercase">Total Docentes</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalDocentes }}</p>
            <i class="fas fa-chalkboard-teacher absolute top-5 right-5 text-gray-200 text-4xl opacity-50"></i>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5 border-l-4 border-purple-500">
            <p class="text-sm font-semibold text-gray-500 uppercase">Cursos Ofertados</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalCursos }}</p>
            <i class="fas fa-book-open absolute top-5 right-5 text-gray-200 text-4xl opacity-50"></i>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5 border-l-4 border-teal-500">
            <p class="text-sm font-semibold text-gray-500 uppercase">Matrículas Activas</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalMatriculasActivas }}</p>
            <i class="fas fa-check-circle absolute top-5 right-5 text-gray-200 text-4xl opacity-50"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-star mr-1 text-yellow-500"></i> TOP 5 Cursos con más Alumnos
            </h2>
            <ul class="divide-y divide-gray-100">
                @forelse($cursosPopulares as $curso)
                <li class="py-3 flex justify-between items-center hover:bg-gray-50 px-2 rounded-lg">
                    <div class="flex items-center">
                        <span class="font-bold text-teal-600 mr-3">{{ $loop->iteration }}.</span>
                        <div>
                            <p class="font-medium text-gray-800">{{ $curso->nombre }}</p>
                            <p class="text-xs text-gray-500">{{ $curso->docente->nombre ?? 'Docente no asignado' }}</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-2.5 py-0.5 rounded-full">
                        {{ $curso->alumnos_count }} Alumnos
                    </span>
                </li>
                @empty
                <li class="py-4 text-center text-gray-500 italic">No hay suficientes datos de cursos.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-layer-group mr-1 text-purple-500"></i> Alumnos por Nivel
            </h2>
            <ul class="space-y-3">
                @foreach($distribucionNiveles as $nivel)
                <li class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">{{ $nivel->grado }}</span>
                    <span class="font-bold text-gray-900">{{ $nivel->total }}</span>
                </li>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    @php
                        $porcentaje = ($nivel->total / $totalAlumnos) * 100;
                    @endphp
                    <div class="bg-teal-400 h-2.5 rounded-full" style="width: {{ $porcentaje }}%"></div>
                </div>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-history mr-1 text-gray-500"></i> Últimos Alumnos Registrados
        </h2>
        <ul class="divide-y divide-gray-100">
            @forelse($ultimosAlumnos as $alumno)
            <li class="py-3 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fas fa-id-card text-blue-400"></i>
                    <div>
                        <p class="font-medium text-gray-800">{{ $alumno->nombre }}</p>
                        <p class="text-sm text-gray-500">{{ $alumno->email }}</p>
                    </div>
                </div>
                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                    {{ $alumno->grado }}
                </span>
            </li>
            @empty
            <li class="py-4 text-center text-gray-500 italic">No hay alumnos registrados recientemente.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
