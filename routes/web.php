<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

// Redirige la ruta raíz (/) a la página de login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    
    // RUTA DEL DASHBOARD:
    // Esta ruta llama al método 'index' del DashboardController, 
    // donde se debe retornar la vista 'dashboard.index'.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de Recursos (CRUD completo)
    Route::resource('alumnos', AlumnoController::class);
    Route::resource('docentes', DocenteController::class);
    Route::resource('cursos', CursoController::class);
    Route::resource('matriculas', MatriculaController::class);
    
    
    // RUTA DE REPORTES:
    // Solo se necesita la vista principal (index) para Reportes.
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

// Incluye las rutas de autenticación (login, register, logout, etc.)
require __DIR__.'/auth.php';