<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\Pendaftaran\SiswaController;
use App\Http\Controllers\UserImageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/biodata', [SiswaController::class, 'index'])->name('biodata.index');
    Route::post('/biodata', [SiswaController::class, 'update'])->name('biodata.update');
    Route::post('/persyaratan', [SiswaController::class, 'updateImage'])->name('pendaftaran.updateImage');
    Route::get('/persyaratan', [SiswaController::class, 'show'])->name('pendaftaran.show');
    Route::post('/persyaratan/umum', [SiswaController::class, 'updateBerkas'])->name('pendaftaran.updateBerkas');

    Route::get('/wilayah/provinsi', [SiswaController::class, 'getProvinces']);
    Route::get('/wilayah/kabupaten/{code}', [SiswaController::class, 'getRegencies']);
    Route::get('/wilayah/kecamatan/{code}', [SiswaController::class, 'getDistricts']);
    Route::get('/wilayah/desa/{code}', [SiswaController::class, 'getVillages']);

    Route::get('/media/create', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');

    Route::middleware(['auth'])->get('/user/profile-image', [UserImageController::class, 'index']);
    Route::middleware(['auth'])->post('/user/profile-image', [UserImageController::class, 'update']);
});



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
