<?php

use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;



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




Route::get('/wedding/create', [WeddingController::class, 'create'])->name('weddings.create');
Route::post('/wedding', [WeddingController::class, 'store'])->name('weddings.store');
Route::get('/wedding', [WeddingController::class, 'index'])->name('weddings.index');
