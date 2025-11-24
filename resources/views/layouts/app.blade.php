<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Academia Hub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="p-6 border-b border-gray-200">
                <img src="/logo.png" alt="Academia Hub" class="h-12">
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('alumnos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('alumnos.*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>Alumnos</span>
                </a>
                
                <a href="{{ route('docentes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('docentes.*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Docentes</span>
                </a>
                
                <a href="{{ route('cursos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('cursos.*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-book"></i>
                    <span>Cursos</span>
                </a>
                
                <a href="{{ route('matriculas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('matriculas.*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Matrículas</span>
                </a>
                
                <a href="{{ route('reportes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('reportes.*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Reportes</span>
                </a>
            </nav>
            
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>CERRAR SESIÓN</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>