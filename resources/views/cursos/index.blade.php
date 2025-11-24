@extends('layouts.app')

@section('title', 'Cursos - Academia Hub')

@section('content')
<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">CURSOS</h1>
        <a href="{{ route('cursos.create') }}" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
            <i class="fas fa-plus"></i>
            NUEVO CURSO
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <div class="relative">
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input 
                type="text" 
                id="searchCursos"
                placeholder="BUSCAR CURSO POR NOMBRE O CÓDIGO" 
                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            >
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CÓDIGO</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NOMBRE DEL CURSO</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIVEL</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DOCENTE ASIGNADO</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($cursos as $curso)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-sm text-gray-600">{{ $curso->codigo }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $curso->nombre }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $curso->nivel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $curso->docente ? $curso->docente->nombre : 'Sin Asignar' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('cursos.show', $curso) }}" class="bg-blue-400 hover:bg-blue-500 text-white p-2 rounded-lg transition">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cursos.edit', $curso) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-lg transition">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cursos.destroy', $curso) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este curso?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No hay cursos registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('searchCursos').addEventListener('keyup', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endpush
@endsection