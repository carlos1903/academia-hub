@extends('layouts.app')

@section('title', 'Detalles del Alumno - Academia Hub')

@section('content')
<div class="p-6 md:p-8 max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">PERFIL DEL ESTUDIANTE</h1>
        <div class="flex gap-2">
            <a href="{{ route('alumnos.edit', $alumno) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-edit"></i> EDITAR
            </a>
            <a href="{{ route('alumnos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> VOLVER
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto flex items-center justify-center mb-4 text-4xl text-gray-400">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $alumno->nombre }}</h2>
                <p class="text-gray-500 mb-4">{{ $alumno->email }}</p>
                
                <div class="inline-block bg-teal-100 text-teal-800 text-sm font-semibold px-3 py-1 rounded-full">
                    Estudiante Activo
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Información Académica</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nivel</p>
                        <p class="font-semibold text-gray-800 text-lg">{{ $alumno->nivel }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Grado</p>
                        <p class="font-semibold text-gray-800 text-lg">{{ $alumno->grado }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Fecha de Registro</p>
                        <p class="font-semibold text-gray-800">{{ $alumno->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Última Actualización</p>
                        <p class="font-semibold text-gray-800">{{ $alumno->updated_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- BLOQUE DE CURSOS MATRICULADOS CORREGIDO Y ACTUALIZADO CON ESTADOS -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Cursos Matriculados</h3>
                
                {{-- *** La iteración correcta es sobre la relación 'matriculas' *** --}}
                @if($alumno->matriculas->isNotEmpty())
                    <ul class="space-y-3">
                        {{-- Iteramos sobre las MATRÍCULAS, no directamente sobre los CURSOS --}}
                        @foreach($alumno->matriculas as $matricula)
                            @if($matricula->curso) {{-- Verificamos que el curso esté disponible --}}
                                @php
                                    // Lógica para asignar estilos según el estado de la matrícula
                                    $estado = strtoupper($matricula->estado);
                                    $class = 'bg-gray-100 text-gray-800'; // Default
                                    $displayText = $matricula->estado;

                                    if ($estado === 'APROBADO') {
                                        $class = 'bg-green-100 text-green-800';
                                    } elseif ($estado === 'PENDIENTE') {
                                        $class = 'bg-yellow-100 text-yellow-800';
                                    } elseif ($estado === 'RECHAZADO') {
                                        $class = 'bg-red-100 text-red-800';
                                    }
                                @endphp

                                <li class="flex justify-between items-center p-4 bg-gray-50 rounded-lg hover:shadow-md transition duration-150 ease-in-out">
                                    {{-- Información del Curso --}}
                                    <div>
                                        <span class="font-semibold text-gray-800 block">{{ $matricula->curso->nombre }}</span>
                                        <span class="text-xs text-gray-500 mt-1">Código: {{ $matricula->curso->codigo }} | Nivel: {{ $matricula->curso->nivel ?? 'N/A' }}</span>
                                    </div>
                                    
                                    {{-- Estado de la Matrícula --}}
                                    <div class="text-right">
                                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $class }}">{{ $displayText }}</span>
                                        <p class="text-xs text-gray-400 mt-1">Matrícula: {{ \Carbon\Carbon::parse($matricula->fecha)->format('d/m/Y') ?? 'N/A' }}</p>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic text-center py-4">El alumno no está matriculado en ningún curso.</p>
                    <div class="text-center mt-2">
                        <a href="{{ route('matriculas.create') }}" class="text-teal-500 hover:underline text-sm">Ir a Matrículas</a>
                    </div>
                @endif
            </div>
            <!-- FIN BLOQUE CORREGIDO -->

        </div>
    </div>
</div>
@endsection