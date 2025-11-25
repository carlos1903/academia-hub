@extends('layouts.app')

@section('title', 'Editar Alumno - Academia Hub')

@section('content')

<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <!-- Título que muestra el nombre del alumno -->
        <h1 class="text-3xl font-bold text-gray-800">EDITAR ALUMNO: {{ $alumno->nombre }} {{ $alumno->apellido }}</h1>
        
        <!-- Enlace VOLVER -->
        <a href="{{ route('alumnos.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> VOLVER
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
        
        {{-- SECCIÓN PARA MOSTRAR MENSAJES DE ERROR DE VALIDACIÓN O DE BD --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Por favor, corrija los siguientes errores:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Error al Guardar!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        {{-- FIN DE LA SECCIÓN DE ERRORES --}}

        <!-- Formulario de Edición/Actualización -->
        <form action="{{ route('alumnos.update', $alumno->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') <!-- Necesario para el método de actualización -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- CAMPO 1: NOMBRE --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="nombre" class="block text-sm font-bold text-gray-700 mb-2">NOMBRE</label>
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre', $alumno->nombre) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                           required placeholder="Ej: Juan">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CAMPO 2: APELLIDO --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="apellido" class="block text-sm font-bold text-gray-700 mb-2">APELLIDO</label>
                    <input type="text" name="apellido" id="apellido" 
                           value="{{ old('apellido', $alumno->apellido) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                           required placeholder="Ej: Pérez">
                    @error('apellido')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- CAMPO 3: CORREO ELECTRÓNICO (Autocompletado asegurado) --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="correo_electronico" class="block text-sm font-bold text-gray-700 mb-2">CORREO ELECTRÓNICO</label>
                    <input type="email" name="correo_electronico" id="correo_electronico" 
                           value="{{ old('correo_electronico', $alumno->correo_electronico) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                           required placeholder="juan@ejemplo.com">
                    @error('correo_electronico')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CAMPO 4: TELÉFONO --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="telefono" class="block text-sm font-bold text-gray-700 mb-2">TELÉFONO (Opcional)</label>
                    <input type="text" name="telefono" id="telefono" 
                           value="{{ old('telefono', $alumno->telefono) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                           placeholder="Ej: 987654321">
                    @error('telefono')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- CAMPO 5: FECHA DE NACIMIENTO --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="fecha_nacimiento" class="block text-sm font-bold text-gray-700 mb-2">FECHA DE NACIMIENTO (Opcional)</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                           value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    @error('fecha_nacimiento')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CAMPO 6: NIVEL ACADÉMICO (Solución al error 'invalid') --}}
                <div>
                    <label for="nivel" class="block text-sm font-bold text-gray-700 mb-2">NIVEL ACADÉMICO</label>
                    <select name="nivel" id="nivel" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                            required>
                        
                        @php
                            // Valores exactos que debe aceptar el controlador
                            $niveles = ['Primaria', 'Secundaria'];
                            // Determinar el valor actual (viejo o guardado)
                            $currentNivel = old('nivel', $alumno->nivel);
                        @endphp
                        
                        <!-- Opción por defecto deshabilitada -->
                        <option value="" disabled {{ !$currentNivel ? 'selected' : '' }}>Seleccionar Nivel</option>
                        
                        <!-- Opciones dinámicas preseleccionando el valor correcto -->
                        @foreach($niveles as $nivel)
                            <option value="{{ $nivel }}" {{ $currentNivel === $nivel ? 'selected' : '' }}>
                                {{ $nivel }}
                            </option>
                        @endforeach
                    </select>
                    @error('nivel')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CAMPO 7: GRADO / AÑO --}}
                <div>
                    <label for="grado" class="block text-sm font-bold text-gray-700 mb-2">GRADO / AÑO</label>
                    <input type="text" name="grado" id="grado" 
                           value="{{ old('grado', $alumno->grado) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" 
                           required placeholder="Ej: 5TO">
                    @error('grado')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-gray-100 mt-6">
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-save"></i> GUARDAR CAMBIOS
                </button>
                <a href="{{ route('alumnos.index') }}" class="text-gray-600 hover:text-gray-800 font-medium px-4 py-3 transition">
                    CANCELAR
                </a>
            </div>
        </form>
    </div>


</div>
@endsection