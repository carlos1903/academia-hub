@extends('layouts.app')

@section('title', 'Crear Docente - Academia Hub')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">NUEVO DOCENTE</h1>
        <a href="{{ route('docentes.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> VOLVER
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
        <form action="{{ route('docentes.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NOMBRE COMPLETO -->
                <div class="md:col-span-2">
                    <label for="nombre" class="block text-sm font-bold text-gray-700 mb-2">NOMBRE COMPLETO</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" required placeholder="Ej: María González">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- CORREO ELECTRÓNICO -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">CORREO ELECTRÓNICO</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" required placeholder="maria@academia.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TELÉFONO -->
                <div>
                    <label for="telefono" class="block text-sm font-bold text-gray-700 mb-2">TELÉFONO (Opcional)</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Ej: +51 987 654 321">
                    @error('telefono')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ESPECIALIDAD (SELECT - para ENUM) -->
                <div class="md:col-span-2">
                    <label for="especialidad" class="block text-sm font-bold text-gray-700 mb-2">ESPECIALIDAD / Nivel</label>
                    <select name="especialidad" id="especialidad" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" required>
                        <option value="">Seleccionar Nivel de Especialidad</option>
                        @php $selectedEspecialidad = old('especialidad'); @endphp

                        <option value="PRIMARIA" {{ $selectedEspecialidad == 'PRIMARIA' ? 'selected' : '' }}>Primaria</option>
                        <option value="SECUNDARIA" {{ $selectedEspecialidad == 'SECUNDARIA' ? 'selected' : '' }}>Secundaria</option>
                    </select>
                    @error('especialidad')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 mt-6">
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> GUARDAR DOCENTE
                </button>
                <a href="{{ route('docentes.index') }}" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-3 transition">
                    CANCELAR
                </a>
            </div>
        </form>
    </div>
</div>
@endsection