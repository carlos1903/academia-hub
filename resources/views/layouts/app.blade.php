<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Academia Hub')</title>

    <!-- Tailwind CSS (asumo que está configurado, o uso el CDN para ejemplo) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Sección para scripts/estilos adicionales como Chart.js -->
    @yield('head')
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- ---------------------------------------------------- -->
    <!--             BARRA LATERAL FIJA (SIDEBAR)             -->
    <!-- ---------------------------------------------------- -->
    <div class="sidebar bg-white shadow-xl w-64 h-full fixed top-0 left-0 z-30 flex flex-col justify-between">
        
        <!-- Contenido Superior del Sidebar (Logo y Navegación) -->
        <div>
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-extrabold text-blue-600">ACADEMIA HUB</h1>
            </div>

            <!-- Navegación -->
            <nav class="mt-6 px-4 space-y-2">
                
                {{-- Función para verificar si la ruta es activa (depende de tu helper) --}}
                @php
                    $isRouteActive = function($route) {
                        return request()->routeIs($route) ? 'bg-blue-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
                    };
                @endphp

                <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-xl transition duration-150 ease-in-out {{ $isRouteActive('dashboard') }}">
                    <i class="fas fa-chart-line mr-3"></i> Dashboard
                </a>
                <a href="{{ route('alumnos.index') }}" class="flex items-center p-3 rounded-xl transition duration-150 ease-in-out {{ $isRouteActive('alumnos.*') }}">
                    <i class="fas fa-user-graduate mr-3"></i> Alumnos
                </a>
                <a href="{{ route('docentes.index') }}" class="flex items-center p-3 rounded-xl transition duration-150 ease-in-out {{ $isRouteActive('docentes.*') }}">
                    <i class="fas fa-chalkboard-teacher mr-3"></i> Docentes
                </a>
                <a href="{{ route('cursos.index') }}" class="flex items-center p-3 rounded-xl transition duration-150 ease-in-out {{ $isRouteActive('cursos.*') }}">
                    <i class="fas fa-book-open mr-3"></i> Cursos
                </a>
                <a href="{{ route('matriculas.index') }}" class="flex items-center p-3 rounded-xl transition duration-150 ease-in-out {{ $isRouteActive('matriculas.*') }}">
                    <i class="fas fa-id-card mr-3"></i> Matrículas
                </a>
                <a href="{{ route('reportes.index') }}" class="flex items-center p-3 rounded-xl transition duration-150 ease-in-out {{ $isRouteActive('reportes.*') }}">
                    <i class="fas fa-file-alt mr-3"></i> Reportes
                </a>
            </nav>
        </div>

        <!-- CERRAR SESIÓN (Parte Inferior del Sidebar) -->
        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="/logout"> {{-- Reemplaza /logout con tu ruta de cierre de sesión --}}
                @csrf
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-4 rounded-xl transition duration-150 ease-in-out shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> CERRAR SESIÓN
                </button>
            </form>
        </div>
    </div>

    <!-- ---------------------------------------------------- -->
    <!--               CONTENIDO PRINCIPAL                    -->
    <!-- ---------------------------------------------------- -->
    {{-- Agregamos 'ml-64' para dar espacio a la barra lateral fija --}}
    <main class="content ml-64 min-h-screen">
        @yield('content')
    </main>

</body>
</html>