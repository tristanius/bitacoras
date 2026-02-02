<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\AircraftController;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\AircraftCategoryController;
use App\Http\Controllers\AircraftModelController;
use App\Http\Controllers\LogEntryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;


Route::get('/', [DashboardController::class, 'index'])->name('/')->middleware(['auth']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);

//Middleware de profile x auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    #Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// vista de pruebas
Route::get('/test-design', function () {
    return view('layouts.admin');
})->middleware(['auth', 'verified'])->name('test-design');


// Gestión de Aeropuertos
Route::middleware(['auth', 'role:Admin|Oficial de Operaciones'])->group(function () {
    Route::resource('airports', AirportController::class);
    // Ruta rápida para activar/desactivar
    Route::patch('airports/{airport}/toggle', [AirportController::class, 'toggleStatus'])->name('airports.toggle');
});

Route::middleware(['auth', 'role:Admin|Oficial de Operaciones'])->group(function () {
    Route::delete('airports/{airport}', [AirportController::class, 'destroy'])->name('airports.destroy');
});

// Gestión de Aeronaves
Route::middleware(['auth', 'role:Admin|Oficial de Operaciones'])->group(function () {
    Route::resource('aircraft', AircraftController::class);
    // Ruta rápida para activar/desactivar
    #Route::put('aircraft/{aircraft}', [AircraftController::class, 'update'])->name('aircraft.update');
    Route::patch('aircraft/{aircraft}/toggle', [AircraftController::class, 'toggleStatus'])->name('aircraft.toggle');
});

Route::middleware(['auth', 'role:Admin|Oficial de Operaciones|Piloto'])->group(function () {
    Route::delete('aircraft/{aircraft}', [AircraftController::class, 'destroy'])->name('aircraft.destroy');
});

// Getión de categorias de aeronaves.
Route::middleware(['auth', 'role:Admin|Oficial de Operaciones'])->group(function () {
    Route::resource('aircraft_categories', AircraftCategoryController::class);
});
// Getión de modelos.
Route::middleware(['auth', 'role:Admin|Oficial de Operaciones'])->group(function () {
    Route::resource('aircraft_models', AircraftModelController::class);
});

//Gestión de pilotos
Route::middleware(['auth', 'role:Admin|Oficial de Operaciones'])->group(function () {
    Route::get('pilots', [PilotController::class, 'index'])->name('pilots.index');
    Route::post('pilots', [PilotController::class, 'store'])->name('pilots.store'); 
    Route::put('pilots/{pilot}', [PilotController::class, 'update'])->name('pilots.update');
    Route::patch('pilots/{pilot}/toggle', [PilotController::class, 'toggleStatus'])->name('pilot.toggle');
    Route::delete('pilots/{pilot}', [PilotController::class, 'destroy'])->name('pilots.destroy');
});

// Rutas para LogEntries (Vuelos)
Route::middleware(['auth'])->group(function () {
    
    // 1. CRUD Estándar de la Bitácora (Index, Create, Store, Edit, Update, Delete)
    // Usamos ->parameters para que en todo el sistema el ID se llame {log_entry}
    Route::resource('log-entries', LogEntryController::class)
        ->names('log_entries')
        ->parameters(['log-entries' => 'log_entry']);

    // 2. Acciones Especiales (Validación del Instructor)
    // Esta ruta permite que el instructor dé el "OK" desde la tabla principal
    Route::post('/log-entries/{log_entry}/validate', [LogEntryController::class, 'validateEntry'])
        ->name('log_entries.validate');

    // 3. Generación de Informes (PDF)
    // Ruta para que el Oficial descargue el reporte de un vuelo específico o mensual
    Route::get('/log-entries/{log_entry}/pdf', [LogEntryController::class, 'generatePDF'])
        ->name('log_entries.pdf');
        
    Route::get('/log-entries/report/general', [LogEntryController::class, 'generalReport'])
        ->name('log_entries.report');
});

// Reportes y consultas
Route::middleware(['auth'])->group(function () {
    Route::get('/reports/log-entries', [LogEntryController::class, 'reports'])->name('log_entries.reports');
    Route::get('/reports/log-entries/export', [LogEntryController::class, 'exportCsv'])->name('log_entries.export');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pilot-pdf', [ReportController::class, 'downloadPilotLogbook'])->name('reports.pilot_pdf');
    Route::get('/reports/aircraft-pdf', [ReportController::class, 'downloadAircraftLogbook'])->name('reports.aircraft_pdf');
});

// USUARIOS
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('usuarios', UserController::class)
        ->names('users')
        ->parameters(['usuarios' => 'user']); // <--- Esto obliga a usar {user} en lugar de {usuario}
    Route::post('/usuarios/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::post('/usuarios/{user}/reset', [UserController::class, 'resetPassword'])->name('users.reset');
});

Route::middleware(['auth'])->group(function () {
    
    // Vista del Perfil
    Route::get('/user-profile', [ProfileController::class, 'show'])->name('profile.show');
    
    // Actualización de Datos (Nombre, Email, Foto)
    Route::post('/user-profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Actualización de Contraseña
    Route::post('/user-profile/password', [ProfileController::class, 'passwordUpdate'])->name('user.password.update');

});

//-----------------------------------
// Logout
use App\Http\Controllers\Auth\AuthenticatedSessionController;
Route::any('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Users
Route::view('edit-profile', 'users.edit_profile')->name('edit-profile');
Route::view('user-cards', 'users.user_cards')->name('user-cards');
//Route::view('user-profile', 'users.user_profile')->name('user-profile');


// Others -> Authentication
Route::view('login', 'others.authentication.login')->name('login');
Route::view('sign-up', 'others.authentication.sign_up')->name('sign-up');
Route::view('unlock', 'others.authentication.unlock')->name('unlock');
Route::view('forget-password', 'others.authentication.forget_password')->name('forget-password');
Route::view('reset-password', 'others.authentication.reset_password')->name('reset-password');
Route::view('maintenance', 'others.authentication.maintenance')->name('maintenance');


require __DIR__.'/auth.php';
