@extends('layouts.app')

@section('title', 'Perfil Docente - Academia Hub')

@section('content')
<div class="p-6 md:p-8 max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">PERFIL DEL DOCENTE</h1>
        <div class="flex gap-2">
            <a href="{{ route('docentes.edit', $docente) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-edit"></i> EDITAR
            </a>
            <a href="{{ route('docentes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> VOLVER
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
                <div class="w-32 h-32 bg-teal-100 rounded-full mx-auto flex items-center justify-center mb-4 text-4xl text-teal-500">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $docente->nombre }}</h2>
                <p class="text-gray-500 mb-4">{{ $docente->email }}</p>
                
                <div class="inline-block bg-purple-100 text-purple-800 text-sm font-semibold px-3 py-1 rounded-full">
                    {{ $docente->especialidad }}
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Cursos Impartidos</h3>
                
                @if($docente->cursos && $docente->cursos->count() > 0)
                    <div class="grid gap-4">
                        @foreach($docente->cursos as $curso)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $curso->nombre }}</h4>
                                <span class="text-sm text-gray-500">Código: {{ $curso->codigo }}</span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                {{ $curso->nivel }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-book-open text-4xl mb-3 text-gray-300 block"></i>
                        <p>Este docente no tiene cursos asignados todavía.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection