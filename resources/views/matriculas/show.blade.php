@extends('layouts.app')

@section('title', 'Detalle de Matrícula - Academia Hub')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">DETALLE DE MATRÍCULA</h1>
        <div class="flex gap-2">
            <a href="{{ route('matriculas.edit', $matricula) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-edit"></i> EDITAR
            </a>
            <a href="{{ route('matriculas.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> VOLVER
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <div>
                <span class="text-gray-500 text-sm uppercase font-bold tracking-wider">ID Matrícula</span>
                <p class="font-mono text-xl text-gray-800">#{{ str_pad($matricula->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div>
                @if($matricula->estado == 'Activo')
                    <span class="bg-green-100 text-green-800 font-bold px-4 py-2 rounded-lg">ACTIVA</span>
                @else
                    <span class="bg-red-100 text-red-800 font-bold px-4 py-2 rounded-lg">INACTIVA</span>
                @endif
            </div>
        </div>

        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
            <div>
                <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider mb-4 border-b pb-2">Datos del Estudiante</h3>
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-blue-100 p-3 rounded-full text-blue-500">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-800">{{ $matricula->alumno->nombre }}</p>
                        <p class="text-gray-500">{{ $matricula->alumno->email }}</p>
                    </div>
                </div>
                <div class="ml-14">
                    <p class="text-sm text-gray-500">Grado Actual: <span class="text-gray-800 font-medium">{{ $matricula->alumno->grado }}</span></p>
                </div>
            </div>

            <div>
                <h3 class="text-gray-400 text-sm font-bold uppercase tracking-wider mb-4 border-b pb-2">Datos del Curso</h3>
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-purple-100 p-3 rounded-full text-purple-500">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-800">{{ $matricula->curso->nombre }}</p>
                        <p class="text-gray-500 font-mono text-sm">{{ $matricula->curso->codigo }}</p>
                    </div>
                </div>
                <div class="ml-14 space-y-1">
                    <p class="text-sm text-gray-500">Nivel: <span class="text-gray-800 font-medium">{{ $matricula->nivel }}</span></p>
                    <p class="text-sm text-gray-500">Fecha Inscripción: <span class="text-gray-800 font-medium">{{ optional($matricula->fecha)->format('d/m/Y') }}</span></p>
                    @if($matricula->curso->docente)
                        <p class="text-sm text-gray-500">Docente: <span class="text-gray-800 font-medium">{{ $matricula->curso->docente->nombre }}</span></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-6 text-center text-sm text-gray-500 border-t border-gray-100">
            Registrado el {{ $matricula->created_at->format('d/m/Y H:i') }}
        </div>
    </div>
</div>
@endsection