<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta principal - Página de inicio (tu HTML convertido)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación (Laravel Breeze ya las creó automáticamente)
// login, register, logout, etc.

// Rutas protegidas - Solo usuarios autenticados
Route::middleware(['auth'])->group(function () {
    
    // Dashboard del usuario
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('appointments.index');
    })->name('dashboard');
    
    // Rutas de Agendamiento
    Route::get('/agendar-cita', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/citas', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/mis-citas', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/citas/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/citas/{appointment}/cancelar', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    
    // AJAX - Obtener horarios disponibles
    Route::get('/api/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('api.available-slots');
});

// Rutas de administrador - Solo usuarios con rol admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        $pendingAppointments = \App\Models\Appointment::pending()->count();
        $todayAppointments = \App\Models\Appointment::today()->count();
        $totalClients = \App\Models\User::clients()->count();
        
        return view('admin.dashboard', compact('pendingAppointments', 'todayAppointments', 'totalClients'));
    })->name('dashboard');
    
    // Gestión de citas
    Route::get('/citas', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'index'])->name('appointments.all');
    Route::get('/citas/pendientes', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'pending'])->name('appointments.pending');
    Route::get('/citas/hoy', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'today'])->name('appointments.today');
    Route::get('/citas/proximas', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'upcoming'])->name('appointments.upcoming');
    Route::get('/citas/{appointment}', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'show'])->name('appointments.show');
    Route::post('/citas/{appointment}/confirmar', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/citas/{appointment}/iniciar', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'start'])->name('appointments.start');
    Route::post('/citas/{appointment}/completar', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'complete'])->name('appointments.complete');
    Route::post('/citas/{appointment}/cancelar', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/citas/{appointment}/notas', [\App\Http\Controllers\Admin\AppointmentAdminController::class, 'updateNotes'])->name('appointments.notes');
});

    // Consultas de productos
Route::post('/consultas', [App\Http\Controllers\ProductInquiryController::class, 'store'])->name('inquiries.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/mis-consultas', [App\Http\Controllers\ProductInquiryController::class, 'myInquiries'])->name('inquiries.index');
});

// Redirección de la ruta antigua de agendamiento sin autenticación
Route::get('/agendamiento', function () {
    return redirect()->route('appointments.create');
});

require __DIR__.'/auth.php';