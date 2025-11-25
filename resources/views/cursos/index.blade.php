@extends('layouts.app')

@section('title', 'Cursos - Academia Hub')

@section('content')
<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">LISTADO DE CURSOS</h1>
        <a href="{{ route('cursos.create') }}" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
            <i class="fas fa-book-reader"></i>
            NUEVO CURSO
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Barra de búsqueda (Añadida para funcionalidad estándar) -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <div class="relative">
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input 
                type="text" 
                id="searchCursos"
                placeholder="BUSCAR CURSOS POR CÓDIGO, NOMBRE O DOCENTE" 
                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            >
        </div>
    </div>

    <!-- Tabla de Cursos -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CÓDIGO / NOMBRE</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIVEL</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DOCENTE</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ALUMNOS</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($cursos as $curso)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $curso->nombre }}</div>
                            <div class="text-sm text-gray-500">({{ $curso->codigo }})</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ ucfirst(strtolower($curso->nivel)) }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $curso->docente->nombre ?? 'Docente no asignado' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="inline-flex items-center justify-center px-3 py-1 text-sm font-semibold leading-none rounded-full bg-blue-100 text-blue-800">
                                {{ $curso->alumnos_count ?? 0 }} {{-- Usamos 0 como fallback si no hay count cargado --}}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                {{-- BOTÓN MOSTRAR DETALLE AÑADIDO --}}
                                <a href="{{ route('cursos.show', $curso) }}" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg transition" 
                                    title="Ver Detalle y Matrículas"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- Botón Editar --}}
                                <a href="{{ route('cursos.edit', $curso) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-lg transition" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- Botón Eliminar --}}
                                <form action="{{ route('cursos.destroy', $curso) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar el curso {{ $curso->nombre }}? Esto es un borrado lógico.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No hay cursos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación (Si estás usando el método paginate() en el controlador) -->
        @if (isset($cursos) && $cursos instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-4 bg-gray-50 border-t border-gray-200">
                {{ $cursos->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.getElementById('searchCursos').addEventListener('keyup', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        // Concatenamos todo el texto de la fila para buscar en código, nombre y docente.
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endpush
@endsection