@extends('layouts.app')

@section('title', 'Editar Matrícula - Academia Hub')

@section('content')

<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">EDITAR MATRÍCULA</h1>
        <a href="{{ route('matriculas.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> VOLVER
        </a>
    </div>

    {{-- Mensajes de Estado --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Formulario de Edición --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
        <form action="{{ route('matriculas.update', $matricula) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Campo Alumno --}}
                <div class="col-span-2">
                    <label for="alumno_id" class="block text-sm font-bold text-gray-700 mb-2">ALUMNO</label>
                    <select id="alumno_id" name="alumno_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @foreach($alumnos as $alumno)
                            <option value="{{ $alumno->id }}" {{ $matricula->alumno_id == $alumno->id ? 'selected' : '' }}>
                                {{ $alumno->nombre }} ({{ $alumno->nivel }})
                            </option>
                        @endforeach
                    </select>
                    @error('alumno_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Curso --}}
                <div class="md:col-span-1">
                    <label for="curso_id" class="block text-sm font-bold text-gray-700 mb-2">CURSO</label>
                    <select id="curso_id" name="curso_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ $matricula->curso_id == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }} ({{ $curso->nivel }})
                            </option>
                        @endforeach
                    </select>
                    @error('curso_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Campo Fecha de Matrícula --}}
                <div class="md:col-span-1">
                    <label for="fecha_matricula" class="block text-sm font-bold text-gray-700 mb-2">FECHA DE MATRÍCULA</label>
                    <input 
                        type="date" 
                        id="fecha_matricula" 
                        name="fecha_matricula" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        value="{{ old('fecha_matricula', $matricula->fecha_matricula ? $matricula->fecha_matricula->format('Y-m-d') : '') }}">
                    @error('fecha_matricula')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Estado --}}
                {{-- ✅ CORREGIDO: Usar la variable $estados del controlador en vez de hardcodear --}}
                <div class="md:col-span-1">
                    <label for="estado" class="block text-sm font-bold text-gray-700 mb-2">ESTADO</label>
                    <select id="estado" name="estado" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @foreach($estados as $estado)
                            <option value="{{ $estado }}" {{ $matricula->estado == $estado ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                    @error('estado')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
            
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 mt-6">
                <button type="submit" 
                        class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> ACTUALIZAR MATRÍCULA
                </button>
                <a href="{{ route('matriculas.index') }}" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-3 transition">
                    CANCELAR
                </a>
            </div>
        </form>
    </div>

</div>
@endsection