@extends('layouts.app')

@section('title', 'Reportes Centralizados - Academia Hub')

{{-- Incluye la librería de Chart.js --}}
@section('head')
    {{-- Asumiendo Font Awesome para los íconos de las tarjetas --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMD/CDQplR1Ff82/3j2Bf6yW/U9G/R1R7vB9Dq9/wD6wzF7l9R2fQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
@endsection

@section('content')
<div class="p-6 md:p-8 max-w-7xl mx-auto">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-2">PANEL DE INTELIGENCIA ACADÉMICA</h1>
    <p class="text-gray-600 mb-10">Métricas clave sobre la distribución de alumnos, cursos, docentes y matrículas.</p>

    <!-- ---------------------------------------------------------------------- -->
    <!--                           TARJETAS GLOBALES                                 -->
    <!-- ---------------------------------------------------------------------- -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        
        {{-- Total Alumnos --}}
        <div class="relative bg-white rounded-xl shadow-lg p-5 border-b-4 border-blue-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-semibold text-gray-500 uppercase">Total Alumnos</p>
            {{-- Usamos ?? para prevenir error si globales no existe --}}
            <p class="text-3xl font-bold text-blue-600">{{ $globales['total_alumnos'] ?? 0 }}</p>
            <div class="absolute top-5 right-5 text-4xl text-blue-100"><i class="fas fa-users"></i></div>
        </div>
        
        {{-- Total Docentes --}}
        <div class="relative bg-white rounded-xl shadow-lg p-5 border-b-4 border-teal-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-semibold text-gray-500 uppercase">Total Docentes</p>
            <p class="text-3xl font-bold text-teal-600">{{ $globales['total_docentes'] ?? 0 }}</p>
            <div class="absolute top-5 right-5 text-4xl text-teal-100"><i class="fas fa-chalkboard-teacher"></i></div>
        </div>
        
        {{-- Total Cursos --}}
        <div class="relative bg-white rounded-xl shadow-lg p-5 border-b-4 border-purple-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-semibold text-gray-500 uppercase">Cursos Disponibles</p>
            <p class="text-3xl font-bold text-purple-600">{{ $globales['total_cursos'] ?? 0 }}</p>
            <div class="absolute top-5 right-5 text-4xl text-purple-100"><i class="fas fa-book-open"></i></div>
        </div>

        {{-- Total Matrículas --}}
        <div class="relative bg-white rounded-xl shadow-lg p-5 border-b-4 border-orange-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-semibold text-gray-500 uppercase">Matrículas Activas</p>
            <p class="text-3xl font-bold text-orange-600">{{ $globales['total_matriculas'] ?? 0 }}</p>
            <div class="absolute top-5 right-5 text-4xl text-orange-100"><i class="fas fa-receipt"></i></div>
        </div>
    </div>

    <!-- ---------------------------------------------------------------------- -->
    <!--                           GRÁFICOS CENTRALES                              -->
    <!-- ---------------------------------------------------------------------- -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        
        {{-- Columna 1 & 2: Alumnos por Curso (Vertical Bar Chart) --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-700 mb-4">DISTRIBUCIÓN DE ALUMNOS POR CURSO</h2>
            <p class="text-sm text-gray-500 mb-6">Muestra la carga de alumnos en cada curso matriculado.</p>
            <div class="h-96">
                <canvas id="chartAlumnosPorCurso"></canvas>
            </div>
        </div>

        {{-- Columna 3: Alumnos por Nivel (Donut Chart) --}}
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-lg p-6 border border-gray-100 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-700 mb-4">ALUMNOS POR NIVEL</h2>
                <p class="text-sm text-gray-500 mb-6">Conteo de alumnos segmentado por nivel académico (Primaria y Secundaria).</p>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="chartAlumnosPorNivel"></canvas>
                </div>
            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-100 space-y-2">
                {{-- FIX: Usamos el operador ?? 0 para garantizar que se muestre 0 si la clave no existe --}}
                <p class="flex justify-between font-semibold text-sm text-blue-600">Primaria: <span class="text-lg">{{ $niveles['alumnos_primaria'] ?? 0 }}</span></p>
                <p class="flex justify-between font-semibold text-sm text-indigo-600">Secundaria: <span class="text-lg">{{ $niveles['alumnos_secundaria'] ?? 0 }}</span></p>
            </div>
        </div>
    </div>

    <!-- ---------------------------------------------------------------------- -->
    <!--                           GRÁFICO DE DOCENTES (Horizontal Bar Chart)    -->
    <!-- ---------------------------------------------------------------------- -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-700 mb-4">CARGA DE CURSOS POR DOCENTE (TOP 5)</h2>
        <p class="text-sm text-gray-500 mb-6">Identifica a los docentes con mayor cantidad de cursos asignados.</p>
        <div class="h-96">
            <canvas id="chartCursosPorDocente"></canvas>
        </div>
    </div>

</div>

{{-- FIX: Bloque PHP defensivo para garantizar la estructura de las variables antes de la inyección en JS --}}
@php
    // Aseguramos que la variable $niveles exista y tenga las claves necesarias con valores por defecto de 0
    // Esto evita que @json($niveles) reciba una variable no definida o que el JS falle al intentar acceder a la clave.
    $niveles = [
        'alumnos_primaria' => $niveles['alumnos_primaria'] ?? 0,
        'alumnos_secundaria' => $niveles['alumnos_secundaria'] ?? 0,
    ];

    // También aseguramos el resto de variables para robustez general, aunque el foco era $niveles
    $globales = $globales ?? ['total_alumnos' => 0, 'total_docentes' => 0, 'total_cursos' => 0, 'total_matriculas' => 0];
    $alumnos_por_curso = $alumnos_por_curso ?? ['labels' => [], 'data' => []];
    $cursos_por_docente = $cursos_por_docente ?? ['labels' => [], 'data' => []];
@endphp

<script>
    // Datos de rendimiento enviados desde el controlador
    // Dado que se ha garantizado la estructura en el bloque @php, la inyección es segura
    const globales = @json($globales);
    const niveles = @json($niveles);
    const alumnosPorCurso = @json($alumnos_por_curso);
    const cursosPorDocente = @json($cursos_por_docente);
    
    // Función genérica para renderizar gráficos de barras (vertical u horizontal)
    function renderBarChart(canvasId, title, labels, data, backgroundColor, borderColor, isHorizontal = false) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        
        let scalesConfig = {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Cantidad de Registros', font: { weight: 'bold' } },
                ticks: { precision: 0 }
            },
            x: {
                grid: { display: false }
            }
        };

        let indexAxis = 'x'; // Default: Vertical Bar Chart
        if (isHorizontal) {
            indexAxis = 'y'; // Horizontal Bar Chart
            scalesConfig = {
                y: { // Y-axis now shows the labels (Docente names)
                    grid: { display: false }
                },
                x: { // X-axis now shows the data (Curso count)
                    beginAtZero: true,
                    title: { display: true, text: 'Cursos Asignados', font: { weight: 'bold' } },
                    ticks: { precision: 0 }
                }
            };
        }

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    data: data,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: indexAxis,
                scales: scalesConfig,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: title,
                        font: { size: 16 }
                    }
                }
            }
        });
    }

    // Función para renderizar gráficos de pastel o dona
    function renderDoughnutChart(canvasId, title, labels, data, colors) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    hoverOffset: 15,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 20
                        }
                    },
                    title: {
                        display: false,
                        text: title
                    }
                }
            }
        });
    }

    // Inicializar gráficos al cargar la página
    window.onload = function() {
        // --- 1. Gráfico de Alumnos por Curso (Barra Vertical) ---
        renderBarChart(
            'chartAlumnosPorCurso', 
            'Alumnos Matriculados por Curso', 
            alumnosPorCurso.labels, 
            alumnosPorCurso.data, 
            '#3b82f6CC', // Color Blue
            '#3b82f6',
            false // isHorizontal: false
        );

        // --- 2. Gráfico de Alumnos por Nivel (Dona) ---
        // Se accede a la variable 'niveles' que ahora está garantizada por el bloque @php
        renderDoughnutChart(
            'chartAlumnosPorNivel', 
            'Alumnos por Nivel', 
            ['Primaria', 'Secundaria'], 
            [niveles.alumnos_primaria, niveles.alumnos_secundaria], // Acceso seguro
            ['#3b82f6', '#6366f1'] // Blue y Indigo
        );

        // --- 3. Gráfico de Cursos por Docente (Barra Horizontal) ---
        renderBarChart(
            'chartCursosPorDocente', 
            'Cursos Asignados por Docente', 
            cursosPorDocente.labels, 
            cursosPorDocente.data, 
            '#10b981CC', // Color Teal
            '#10b981',
            true // isHorizontal: true (Para mejor lectura de nombres de docentes)
        );
    };
</script>
@endsection