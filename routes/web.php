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


//welcome
Route::get('/', function () {
    return view('welcome');
});
//raiz
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('cuenta');

//Middleware de profile x auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
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
    Route::put('aircraft/{aircraft}', [AircraftController::class, 'update'])->name('aircraft.update');
    Route::patch('aircraft/{aircraft}/toggle', [AircraftController::class, 'toggleStatus'])->name('aircraft.toggle');
});

Route::middleware(['auth', 'role:Admin|Oficial de Operaciones'])->group(function () {
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
Route::resource('log_entries', LogEntryController::class);
Route::post('log-entries', [LogEntryController::class, 'store'])->name('log_entries.store');

// USUARIOS

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('usuarios', UserController::class)
        ->names('users')
        ->parameters(['usuarios' => 'user']); // <--- Esto obliga a usar {user} en lugar de {usuario}
    Route::post('/usuarios/{user}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::post('/usuarios/{user}/reset', [UserController::class, 'resetPassword'])->name('users.reset');
});

//-----------------------------------
// Logout
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// -------------------------------------------------------------------------------------------------------
// Dashboards
Route::view('dashboard', 'dashboards.default_dashboard')->middleware(['auth', 'verified'])->name('dashboard');;

// Widgets
Route::view('general-widget', 'widgets.general_widget')->name('general-widget');
Route::view('chart-widget', 'widgets.chart_widget')->name('chart-widget');

// Page layout
Route::view('box-layout', 'page_layout.box_layout')->name('box-layout');
Route::view('layout-rtl', 'page_layout.layout_rtl')->name('layout-rtl');
Route::view('layout-dark', 'page_layout.layout_dark')->name('layout-dark');
Route::view('hide-on-scroll', 'page_layout.hide_on_scroll')->name('hide-on-scroll');
Route::view('footer-light', 'page_layout.footer_light')->name('footer-light');
Route::view('footer-dark', 'page_layout.footer_dark')->name('footer-dark');
Route::view('footer-fixed', 'page_layout.footer_fixed')->name('footer-fixed');


// Email
Route::view('email-compose', 'email.email_compose')->name('email_compose');
Route::view('email-inbox', 'email.email_inbox')->name('email_inbox');
Route::view('email-read', 'email.email_read')->name('email_read');


// Users
Route::view('edit-profile', 'users.edit_profile')->name('edit-profile');
Route::view('user-cards', 'users.user_cards')->name('user-cards');
Route::view('user-profile', 'users.user_profile')->name('user-profile');

// Task
Route::view('tasks', 'tasks')->name('task');


// Pages
Route::view('sample_page', 'pages.sample_page')->name('sample_page');
Route::view('internationalization', 'pages.internationalization')->name('internationalization');

// Others -> Error pages
Route::view('error-page1', 'others.error_page.error_page1')->name('error-page1');

// Others -> Authentication
Route::view('login', 'others.authentication.login')->name('login');
Route::view('sign-up', 'others.authentication.sign_up')->name('sign-up');
Route::view('unlock', 'others.authentication.unlock')->name('unlock');
Route::view('forget-password', 'others.authentication.forget_password')->name('forget-password');
Route::view('reset-password', 'others.authentication.reset_password')->name('reset-password');
Route::view('maintenance', 'others.authentication.maintenance')->name('maintenance');


// Learning
Route::view('learning-list-view', 'learning.learning_list_view')->name('learning-list-view');
Route::view('learning-detailed', 'learning.learning_detailed')->name('learning-detailed');


// Knowledgebase
Route::view('knowledgebase', 'knowledgebase.knowledgebase')->name('knowledgebase');
// Support Ticket
Route::view('support-ticket', 'support-ticket')->name('support-ticket');

require __DIR__.'/auth.php';
