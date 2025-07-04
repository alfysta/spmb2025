<?php

use App\Http\Controllers\Pendaftaran\SiswaController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\UserImageController;
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
    Route::post('/persyaratan/rapor', [SiswaController::class, 'updateRapor'])->name('pendaftaran.updateRapor');

    Route::get('/wilayah/provinsi', [SiswaController::class, 'getProvinces']);
    Route::get('/wilayah/kabupaten/{code}', [SiswaController::class, 'getRegencies']);
    Route::get('/wilayah/kecamatan/{code}', [SiswaController::class, 'getDistricts']);
    Route::get('/wilayah/desa/{code}', [SiswaController::class, 'getVillages']);

    // Route::get('/media/create', [MediaController::class, 'index'])->name('media.index');
    // Route::post('/media', [MediaController::class, 'store'])->name('media.store');

    // Route::middleware(['auth'])->get('/user/profile-image', [UserImageController::class, 'index']);
    // Route::middleware(['auth'])->post('/user/profile-image', [UserImageController::class, 'update']);
});
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/upload-thumbnail', [PostController::class, 'uploadThumbnail']);
});



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
