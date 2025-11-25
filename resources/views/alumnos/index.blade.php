@extends('layouts.app')

@section('title', 'Alumnos - Academia Hub')

@section('head')
    {{-- Aseguramos la carga de Font Awesome para los íconos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMD/CDQplR1Ff82/3j2Bf6yW/U9G/R1R7vB9Dq9/wD6wzF7l9R2fQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="p-6 md:p-8">
    
    {{-- ENCABEZADO Y BOTÓN NUEVO ALUMNO --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">ALUMNOS</h1>
        <a href="{{ route('alumnos.create') }}" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2 shadow-md">
            <i class="fas fa-user-plus"></i>
            NUEVO ALUMNO
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    {{-- BARRA DE BÚSQUEDA --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <div class="relative">
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input 
                type="text" 
                id="searchAlumnos"
                placeholder="BUSCAR ALUMNOS POR NOMBRE, EMAIL O GRADO" 
                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            >
        </div>
    </div>

    {{-- TABLA DE ALUMNOS --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        {{-- ID (Ancho ajustado) --}}
                        <th class="w-16 px-4 py-4 text-left">ID</th>
                        {{-- NOMBRE COMPLETO (Se le da más espacio) --}}
                        <th class="w-48 px-6 py-4 text-left">NOMBRE COMPLETO</th>
                        {{-- EMAIL (Se le da más espacio) --}}
                        <th class="w-56 px-6 py-4 text-left">EMAIL</th>
                        {{-- NIVEL (Ancho ajustado para el badge) --}}
                        <th class="w-32 px-6 py-4 text-left">NIVEL</th>
                        {{-- GRADO (Ancho ajustado) --}}
                        <th class="w-24 px-6 py-4 text-left">GRADO</th>
                        {{-- ACCIONES (Ancho fijo para los 3 botones) --}}
                        <th class="w-40 px-6 py-4 text-left">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="alumnosTableBody">
                    @forelse($alumnos as $alumno)
                    <tr class="hover:bg-gray-50">
                        {{-- ID --}}
                        <td class="px-4 py-4 text-gray-600">{{ $alumno->id }}</td>
                        
                        {{-- Nombre Completo --}}
                        <td class="px-6 py-4 text-gray-900 font-semibold whitespace-normal leading-snug">{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                        
                        {{-- Correo Electrónico (Truncado si es muy largo) --}}
                        <td class="px-6 py-4 text-gray-600 overflow-hidden text-ellipsis">{{ $alumno->correo_electronico }}</td>
                        
                        {{-- Nivel (Badge de color) --}}
                        <td class="px-6 py-4">
                            @php
                                $nivel = strtoupper($alumno->nivel ?? 'N/A');
                                $badgeClass = match ($nivel) {
                                    'PRIMARIA' => 'bg-blue-100 text-blue-800',
                                    'SECUNDARIA' => 'bg-indigo-100 text-indigo-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase {{ $badgeClass }}">
                                {{ $alumno->nivel ?? 'N/A' }}
                            </span>
                        </td>

                        {{-- Grado --}}
                        <td class="px-6 py-4 text-gray-600">{{ $alumno->grado ?? 'N/A' }}</td>

                        {{-- ACCIONES (Botones cuadrados y separados) --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                {{-- BOTÓN VER DETALLE (Ojo/Check) --}}
                                <a href="{{ route('alumnos.show', $alumno->id) }}" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white w-8 h-8 flex items-center justify-center rounded-lg transition shadow-md" 
                                    title="Ver Detalles"
                                >
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                {{-- BOTÓN EDITAR --}}
                                <a href="{{ route('alumnos.edit', $alumno->id) }}" 
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white w-8 h-8 flex items-center justify-center rounded-lg transition shadow-md" 
                                    title="Editar"
                                >
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                {{-- BOTÓN ELIMINAR --}}
                                <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar a {{ $alumno->nombre }}? Esto es un borrado lógico.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 flex items-center justify-center rounded-lg transition shadow-md" 
                                        title="Eliminar"
                                    >
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No hay alumnos registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Paginación si existe --}}
        @if ($alumnos instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-4 bg-gray-50 border-t border-gray-200">
                {{ $alumnos->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.getElementById('searchAlumnos').addEventListener('keyup', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#alumnosTableBody tr');
    
    rows.forEach(row => {
        // Obtenemos el texto de las celdas relevantes (Nombre, Email, Nivel, Grado).
        // Se asegura que la celda exista antes de intentar acceder a textContent
        const name = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
        const email = row.cells[2] ? row.cells[2].textContent.toLowerCase() : ''; 
        const nivel = row.cells[3] ? row.cells[3].textContent.toLowerCase() : '';
        const grado = row.cells[4] ? row.cells[4].textContent.toLowerCase() : '';
        
        const textToSearch = name + ' ' + email + ' ' + nivel + ' ' + grado;

        row.style.display = textToSearch.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endpush
@endsection