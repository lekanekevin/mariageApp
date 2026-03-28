<?php

use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Rediriger automatiquement la racine vers la page de connexion
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes Protégées (Il faut être connecté pour voir ses mariages)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/wedding/create', [WeddingController::class, 'create'])->name('weddings.create');
    Route::post('/wedding', [WeddingController::class, 'store'])->name('weddings.store');
    Route::get('/wedding', [WeddingController::class, 'index'])->name('weddings.index');
    Route::get('/wedding/{wedding}/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::post('/wedding/{wedding}/guests', [GuestController::class, 'store'])->name('guests.store');


    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

    Route::get('/wedding/{wedding}/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/wedding/{wedding}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');


    // Route pour supprimer un invité
    Route::delete('/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    // Afficher le formulaire de modification
    Route::get('/guests/{guest}/edit', [GuestController::class, 'edit'])->name('guests.edit');
    // Mettre à jour l'invité
    Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
    // Modifier un mariage
    Route::get('/weddings/{wedding}/edit', [WeddingController::class, 'edit'])->name('weddings.edit');
    Route::put('/weddings/{wedding}', [WeddingController::class, 'update'])->name('weddings.update');

    // Supprimer un mariage
    Route::delete('/weddings/{wedding}', [WeddingController::class, 'destroy'])->name('weddings.destroy');
    Route::get('/wedding/{wedding}/vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::post('/wedding/{wedding}/vendors', [VendorController::class, 'store'])->name('vendors.store');
    Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendors.destroy');
    Route::get('/vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
    Route::put('/vendors/{vendor}', [VendorController::class, 'update'])->name('vendors.update');
    Route::get('/wedding/{wedding}/dashboard', [DashboardController::class, 'index'])->name('wedding.dashboard');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::get('/wedding/{wedding}/guests/pdf', [GuestController::class, 'exportPdf'])->name('guests.pdf');


});
