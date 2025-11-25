@extends('layouts.app')

@section('title', 'Crear Curso - Academia Hub')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">NUEVO CURSO</h1>
        <a href="{{ route('cursos.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> VOLVER
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
        <form action="{{ route('cursos.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CÓDIGO DEL CURSO -->
                <div>
                    <label for="codigo" class="block text-sm font-bold text-gray-700 mb-2">CÓDIGO DEL CURSO</label>
                    <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                           required placeholder="Ej: MAT-101" maxlength="10">
                    @error('codigo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NOMBRE DEL CURSO -->
                <div>
                    <label for="nombre" class="block text-sm font-bold text-gray-700 mb-2">NOMBRE DEL CURSO</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                           required placeholder="Ej: Matemáticas Básicas">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIVEL (SELECT - para ENUM) -->
                <div>
                    <label for="nivel" class="block text-sm font-bold text-gray-700 mb-2">NIVEL</label>
                    <select name="nivel" id="nivel" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                            required>
                        <option value="">Seleccionar Nivel</option>
                        @php $selectedNivel = old('nivel'); @endphp
                        
                        {{-- Iteramos sobre los niveles definidos en el Controller --}}
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

                <!-- DOCENTE RESPONSABLE (LLAVE FORÁNEA) -->
                <div>
                    <label for="docente_id" class="block text-sm font-bold text-gray-700 mb-2">DOCENTE RESPONSABLE</label>
                    <select name="docente_id" id="docente_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                            required>
                        <option value="">Seleccionar Docente</option>
                        @php $selectedDocente = old('docente_id'); @endphp

                        @forelse($docentes as $docente)
                            <option value="{{ $docente->id }}" {{ $selectedDocente == $docente->id ? 'selected' : '' }}>
                                {{ $docente->nombre }} ({{ $docente->especialidad }})
                            </option>
                        @empty
                            <option value="" disabled>No hay docentes registrados</option>
                        @endforelse
                    </select>
                    @error('docente_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 mt-6">
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> GUARDAR CURSO
                </button>
                <a href="{{ route('cursos.index') }}" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-3 transition">
                    CANCELAR
                </a>
            </div>
        </form>
    </div>
</div>
@endsection