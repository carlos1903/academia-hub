@extends('layouts.app')

@section('title', 'Reportes Analíticos')

@section('content')
<div class="p-6 md:p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <i class="fas fa-file-invoice mr-2 text-teal-500"></i> REPORTES Y ANÁLISIS
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
                <i class="fas fa-chart-bar mr-1 text-red-500"></i> Matrículas Registradas ({{ date('Y') }})
            </h2>
            <canvas id="matriculasChart" class="w-full h-80"></canvas>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm p-5 border-l-4 border-blue-500">
                <p class="text-sm font-semibold text-gray-500 uppercase">Total Alumnos</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalAlumnos }}</p>
            </div>
             <div class="bg-white rounded-2xl shadow-sm p-5 border-l-4 border-teal-500">
                <p class="text-sm font-semibold text-gray-500 uppercase">Total Matrículas Históricas</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalMatriculas }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 overflow-x-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-list-ol mr-1 text-purple-500"></i> Detalle de Carga de Alumnos por Curso
        </h2>
        
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CURSO</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DOCENTE</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">NIVEL</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">ALUMNOS (#)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reporteCursos as $curso)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $curso->nombre }} ({{ $curso->codigo }})</td>
                    <td class="px-6 py-4 text-gray-600">{{ $curso->docente->nombre ?? 'Sin Asignar' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $curso->nivel }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center text-lg font-bold text-teal-600">
                        {{ $curso->alumnos_count }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">No hay cursos disponibles para reportes.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('matriculasChart').getContext('2d');
        const chartData = JSON.parse('{!! $datosGraficoJSON !!}');
        
        const labels = chartData.map(item => item.mes);
        const dataValues = chartData.map(item => item.total);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nuevas Matrículas',
                    data: dataValues,
                    backgroundColor: 'rgba(52, 211, 153, 0.7)', // Teal
                    borderColor: 'rgba(52, 211, 153, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total de Matrículas'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection