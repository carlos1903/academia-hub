@extends('layouts.app')

@section('title', 'Matrículas - Academia Hub')

@section('content')

<div class="p-6 md:p-8">
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
<h1 class="text-3xl font-bold text-gray-800">MATRÍCULAS</h1>
<a href="{{ route('matriculas.create') }}" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
<i class="fas fa-plus"></i>
NUEVA MATRÍCULA
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
            id="searchMatriculas"
            placeholder="BUSCAR POR ALUMNO O CURSO" 
            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
        >
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">FECHA</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ALUMNO</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CURSO</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ESTADO</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($matriculas as $matricula)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-600 font-mono text-sm">
                        {{-- CORRECCIÓN FINAL DE CAMPO Y TIPO (Línea 50 aprox) --}}
                        @if($matricula->fecha_matricula)
                            {{ method_exists($matricula->fecha_matricula, 'format') ? $matricula->fecha_matricula->format('d/m/Y') : $matricula->fecha_matricula }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $matricula->alumno->nombre }}</p>
                        <p class="text-xs text-gray-500">{{ $matricula->alumno->email }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $matricula->curso->nombre }}</p>
                        <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600">{{ $matricula->curso->codigo }}</span>
                    </td>
                    
                    {{-- BLOQUE DE ESTADO --}}
                    <td class="px-6 py-4">
                        @php
                            // Aseguramos que la comparación sea en mayúsculas
                            $estado = strtoupper($matricula->estado);
                        @endphp

                        @if($estado == 'ACTIVO')
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Activo</span>
                        @elseif($estado == 'PENDIENTE')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Pendiente</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Inactivo</span>
                        @endif
                    </td>
                    {{-- FIN BLOQUE DE ESTADO --}}
                    
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('matriculas.show', $matricula) }}" class="bg-blue-400 hover:bg-blue-500 text-white p-2 rounded-lg transition">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('matriculas.edit', $matricula) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-lg transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('matriculas.destroy', $matricula) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar esta matrícula?')">
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
                        No hay matrículas registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
<div class="mt-6">
    {{ $matriculas->links() }}
</div>


</div>

@push('scripts')

<script>
document.getElementById('searchMatriculas').addEventListener('keyup', function(e) {
const searchTerm = e.target.value.toLowerCase();
const rows = document.querySelectorAll('tbody tr');

rows.forEach(row =&gt; {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(searchTerm) ? &#39;&#39; : &#39;none&#39;;
});


});
</script>

@endpush
@endsection