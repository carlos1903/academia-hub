@extends('layouts.app')

@section('title', 'Docentes - Academia Hub')

@section('content')
<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">DOCENTES</h1>
        <a href="{{ route('docentes.create') }}" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
            <i class="fas fa-plus"></i>
            NUEVO DOCENTE
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
                id="searchDocentes"
                placeholder="BUSCAR DOCENTE POR NOMBRE O ESPECIALIDAD" 
                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            >
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DOCENTE</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">EMAIL</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ESPECIALIDAD</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ACCIONES</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($docentes as $docente)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $docente->nombre }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $docente->email }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $docente->especialidad }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('docentes.show', $docente) }}" class="bg-blue-400 hover:bg-blue-500 text-white p-2 rounded-lg transition" title="Ver perfil">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('docentes.edit', $docente) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-lg transition" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('docentes.destroy', $docente) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este docente?')">
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
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No hay docentes registrados
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
document.getElementById('searchDocentes').addEventListener('keyup', function(e) {
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