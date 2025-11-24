@extends('layouts.app')

@section('title', 'Detalles del Curso - Academia Hub')

@section('content')
<div class="p-6 md:p-8 max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">DETALLES DEL CURSO</h1>
        <div class="flex gap-2">
            <a href="{{ route('cursos.edit', $curso) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-edit"></i> EDITAR
            </a>
            <a href="{{ route('cursos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> VOLVER
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex justify-between items-start mb-6 border-b pb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $curso->nombre }}</h2>
                        <span class="text-gray-500 font-mono text-sm">Código: {{ $curso->codigo }}</span>
                    </div>
                    <span class="bg-purple-100 text-purple-800 font-semibold px-3 py-1 rounded-full text-sm">
                        {{ $curso->nivel }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Docente Asignado</p>
                        @if($curso->docente)
                            <p class="font-bold text-gray-800 text-lg">{{ $curso->docente->nombre }}</p>
                            <p class="text-xs text-gray-500">{{ $curso->docente->email }}</p>
                        @else
                            <p class="text-red-500 font-medium">Sin asignar</p>
                        @endif
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Alumnos Inscritos</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $curso->alumnos->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Estudiantes Matriculados</h3>
                @if($curso->alumnos->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($curso->alumnos as $alumno)
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-800">{{ $alumno->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ $alumno->email }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $alumno->grado }}</span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic text-center py-4">Aún no hay alumnos matriculados en este curso.</p>
                @endif
            </div>
        </div>

        <div class="md:col-span-1">
            <div class="bg-teal-500 rounded-2xl shadow-sm p-6 text-white mb-6">
                <h3 class="font-bold text-lg mb-2">Acciones Rápidas</h3>
                <p class="text-teal-100 text-sm mb-4">Gestione este curso rápidamente desde aquí.</p>
                
                <a href="{{ route('matriculas.create') }}" class="block w-full bg-white text-teal-600 text-center font-bold py-2 rounded-lg hover:bg-gray-50 transition mb-2">
                    Matricular Alumno
                </a>
            </div>
        </div>
    </div>
</div>
@endsection