<?php

use App\Http\Controllers\Pendaftaran\SiswaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/pendaftaran', [SiswaController::class, 'index'])->name('pendaftaran.index');
    Route::patch('/pendaftaran', [SiswaController::class, 'update'])->name('pendaftaran.update');
    Route::get('/persyaratan', [SiswaController::class, 'show'])->name('pendaftaran.show');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
