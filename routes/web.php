<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rute beranda
Route::get('/', function () {
    return Inertia::render('HomeBeforeView', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// Rute login (gunakan Login.vue di path yang baru)
Route::get('/login', function () {
    return Inertia::render('Auth/Login'); // Menggunakan path baru untuk Login.vue
})->name('login');

// Proses login untuk admin dan user biasa
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Proses logout untuk admin dan user biasa
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute logout khusus admin
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Rute dashboard pengguna biasa
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard'); // Halaman dashboard untuk pengguna biasa
})->middleware(['auth:web', 'verified'])->name('dashboard');

// Rute dashboard admin (dengan middleware untuk memastikan admin hanya bisa login dengan email tertentu)
Route::get('/admin/dashboard', function () {
    return Inertia::render('DashboardView'); // Halaman dashboard khusus admin
})->middleware(['auth:admin'])->name('admin.dashboard');

// Rute register pengguna biasa
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Rute lainnya
Route::middleware('auth:web')->group(function () {
    Route::get('/home', function () {
        return Inertia::render('HomeView');
    })->name('home');

    Route::get('/reservasi', function () {
        return Inertia::render('ReservasiView');
    })->name('reservasi');

    Route::get('/reservasilist', function () {
        return Inertia::render('ReservasiListView');
    })->name('reservasilist');

    Route::get('/berita', function () {
        return Inertia::render('BeritaView');
    })->name('berita');

});


require __DIR__.'/reservasicontroller.php';