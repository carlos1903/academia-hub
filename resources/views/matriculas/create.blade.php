@extends('layouts.app')

@section('title', 'Nueva Matrícula - Academia Hub')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">REGISTRAR MATRÍCULA</h1>
        <a href="{{ route('matriculas.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> VOLVER
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
        <form action="{{ route('matriculas.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- SELECCIONAR ALUMNO -->
                <div class="col-span-2">
                    <label for="alumno_id" class="block text-sm font-bold text-gray-700 mb-2">SELECCIONAR ALUMNO</label>
                    <select name="alumno_id" id="alumno_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" required>
                        <option value="">Buscar Alumno...</option>
                        @php $selectedAlumno = old('alumno_id'); @endphp
                        @foreach($alumnos as $alumno)
                            <option value="{{ $alumno->id }}" {{ $selectedAlumno == $alumno->id ? 'selected' : '' }}>
                                {{ $alumno->nombre }} - {{ $alumno->grado }}
                            </option>
                        @endforeach
                    </select>
                    @error('alumno_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SELECCIONAR CURSO -->
                <div class="col-span-2 md:col-span-1">
                    <label for="curso_id" class="block text-sm font-bold text-gray-700 mb-2">SELECCIONAR CURSO</label>
                    <select name="curso_id" id="curso_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" required>
                        <option value="">Buscar Curso...</option>
                        @php $selectedCurso = old('curso_id'); @endphp
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ $selectedCurso == $curso->id ? 'selected' : '' }}>
                                {{ $curso->nombre }} ({{ $curso->nivel }})
                            </option>
                        @endforeach
                    </select>
                    @error('curso_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIVEL (Ajustado para usar solo PRIMARIA y SECUNDARIA, pasados desde el controlador) -->
                <div class="col-span-2 md:col-span-1">
                    <label for="nivel" class="block text-sm font-bold text-gray-700 mb-2">NIVEL</label>
                    <select name="nivel" id="nivel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" required>
                        <option value="">Seleccionar Nivel</option>
                        @php $selectedNivel = old('nivel'); @endphp
                        
                        {{-- Itera solo sobre el array de $niveles (['PRIMARIA', 'SECUNDARIA']) enviado desde el Controller --}}
                        @foreach($niveles as $nivel)
                            <option value="{{ $nivel }}" {{ $selectedNivel == $nivel ? 'selected' : '' }}>
                                {{ ucfirst(strtolower($nivel)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('nivel')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- FECHA DE MATRÍCULA -->
                <div>
                    <label for="fecha" class="block text-sm font-bold text-gray-700 mb-2">FECHA DE MATRÍCULA</label>
                    <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" required>
                    @error('fecha')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ESTADO -->
                <div>
                    <label for="estado" class="block text-sm font-bold text-gray-700 mb-2">ESTADO</label>
                    <select name="estado" id="estado" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" required>
                        @php $selectedEstado = old('estado', 'ACTIVO'); @endphp
                        {{-- Itera solo sobre el array de $estados (['ACTIVO', 'INACTIVO']) enviado desde el Controller --}}
                        @foreach($estados as $estado)
                             <option value="{{ $estado }}" {{ $selectedEstado == $estado ? 'selected' : '' }}>
                                {{ ucfirst(strtolower($estado)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('estado')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 mt-6">
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> REGISTRAR MATRÍCULA
                </button>
                <a href="{{ route('matriculas.index') }}" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-3 transition">
                    CANCELAR
                </a>
            </div>
        </form>
    </div>
</div>
@endsection