@extends('layouts.app')

@section('title', 'Crear Alumno - Academia Hub')

@section('content')

<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">NUEVO ALUMNO</h1>
        <a href="{{ route('alumnos.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> VOLVER
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
        {{-- Mensajes de Error --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg" role="alert">
                <p class="font-bold">Por favor, corrija los siguientes errores:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg" role="alert">
                <strong class="font-bold">¡Error al Guardar!</strong>
                <span class="block">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('alumnos.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- NOMBRE --}}
                <div>
                    <label for="nombre" class="block text-sm font-bold text-gray-700 mb-2">NOMBRE *</label>
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                           required placeholder="Ej: Juan">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- APELLIDO --}}
                <div>
                    <label for="apellido" class="block text-sm font-bold text-gray-700 mb-2">APELLIDO *</label>
                    <input type="text" name="apellido" id="apellido" 
                           value="{{ old('apellido') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                           required placeholder="Ej: Pérez">
                    @error('apellido')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- CORREO ELECTRÓNICO - CAMPO CRÍTICO --}}
                <div class="col-span-2">
                    <label for="correo_electronico" class="block text-sm font-bold text-gray-700 mb-2">CORREO ELECTRÓNICO *</label>
                    <input type="email" 
                           name="correo_electronico" 
                           id="correo_electronico" 
                           value="{{ old('correo_electronico') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                           required 
                           placeholder="ejemplo@correo.com">
                    @error('correo_electronico')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TELÉFONO --}}
                <div>
                    <label for="telefono" class="block text-sm font-bold text-gray-700 mb-2">TELÉFONO</label>
                    <input type="text" name="telefono" id="telefono" 
                           value="{{ old('telefono') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                           placeholder="Ej: 987654321">
                    @error('telefono')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- FECHA DE NACIMIENTO --}}
                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-bold text-gray-700 mb-2">FECHA DE NACIMIENTO</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                           value="{{ old('fecha_nacimiento') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    @error('fecha_nacimiento')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIVEL ACADÉMICO --}}
                <div>
                    <label for="nivel" class="block text-sm font-bold text-gray-700 mb-2">NIVEL ACADÉMICO *</label>
                    <select name="nivel" id="nivel" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                            required>
                        <option value="">Seleccionar Nivel</option>
                        <option value="Primaria" {{ old('nivel') == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                        <option value="Secundaria" {{ old('nivel') == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                    </select>
                    @error('nivel')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- GRADO --}}
                <div>
                    <label for="grado" class="block text-sm font-bold text-gray-700 mb-2">GRADO / AÑO *</label>
                    <input type="text" name="grado" id="grado" 
                           value="{{ old('grado') }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                           required placeholder="Ej: 5to">
                    @error('grado')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 mt-6">
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> GUARDAR ALUMNO
                </button>
                <a href="{{ route('alumnos.index') }}" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-3 transition">
                    CANCELAR
                </a>
            </div>
        </form>
    </div>
</div>
@endsection