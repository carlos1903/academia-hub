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

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Cursos Matriculados</h3>
                @if($alumno->cursos && $alumno->cursos->count() > 0)
                    <ul class="space-y-3">
                        @foreach($alumno->cursos as $curso)
                            <li class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="font-medium text-gray-700">{{ $curso->nombre }}</span>
                                <span class="text-sm text-gray-500">{{ $curso->codigo }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic text-center py-4">El alumno no está matriculado en ningún curso.</p>
                    <div class="text-center mt-2">
                        <a href="{{ route('matriculas.create') }}" class="text-teal-500 hover:underline text-sm">Ir a Matrículas</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection