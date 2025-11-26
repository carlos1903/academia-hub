@extends('layouts.app')

@section('title', 'Reportes Académicos')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="p-8 max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-8">Panel de Reportes Académicos</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- ============================
             1. ALUMNOS POR CURSO
        ============================= -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-xl font-semibold mb-4">DISTRIBUCIÓN DE ALUMNOS POR CURSO</h2>
            <div class="h-80">
                <canvas id="chartAlumnosPorCurso"></canvas>
            </div>
        </div>

        <!-- ============================
             2. ALUMNOS POR GRADO
        ============================= -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-xl font-semibold mb-4">ALUMNOS POR GRADO</h2>
            <div class="h-80">
                <canvas id="chartAlumnosPorGrado"></canvas>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 mt-10">

        <!-- ============================
             3. CURSOS POR DOCENTE (TOP 5)
        ============================= -->
        <div class="bg-white p-6 rounded-xl shadow border">
            <h2 class="text-xl font-semibold mb-4">CARGA DE CURSOS POR DOCENTE (TOP 5)</h2>
            <div class="h-80">
                <canvas id="chartCursosPorDocente"></canvas>
            </div>
        </div>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* 1) ALUMNOS POR CURSO */
    new Chart(document.getElementById('chartAlumnosPorCurso'), {
        type: 'bar',
        data: {
            labels: @json($datosAlumnosPorCurso['labels']),
            datasets: [{
                label: "Alumnos",
                data: @json($datosAlumnosPorCurso['data']),
                backgroundColor: "rgba(59, 130, 246, 0.7)"
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    /* 2) ALUMNOS POR GRADO */
    new Chart(document.getElementById('chartAlumnosPorGrado'), {
        type: 'bar',
        data: {
            labels: @json($datosAlumnosPorGrado['labels']),
            datasets: [{
                label: "Cantidad",
                data: @json($datosAlumnosPorGrado['data']),
                backgroundColor: "rgba(234, 88, 12, 0.7)"
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    /* 3) CURSOS POR DOCENTE */
    new Chart(document.getElementById('chartCursosPorDocente'), {
        type: 'bar',
        data: {
            labels: @json($datosDocentes['labels']),
            datasets: [{
                label: "Cursos",
                data: @json($datosDocentes['data']),
                backgroundColor: "rgba(16, 185, 129, 0.7)"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y'
        }
    });
});
</script>

@endsection
