<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReservasiController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rute beranda
Route::get('/', function () {
    return Inertia::render('HomeBeforeView', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// Rute login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Rute register
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Rute logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute dashboard dengan middleware autentikasi
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute HomeView setelah login
Route::get('/home', function () {
    return Inertia::render('HomeView');
})->middleware(['auth'])->name('home');

// Rute Reservasi (formulir reservasi)
Route::get('/reservasi', function () {
    return Inertia::render('ReservasiView');
})->middleware(['auth'])->name('reservasi');

// Rute ReservasiList (daftar reservasi)
Route::get('/reservasilist', function () {
    return Inertia::render('ReservasiListView');
})->middleware(['auth'])->name('reservasilist');

// Rute Edit Reservasi
Route::get('/editreservasi', function () {
    return Inertia::render('EditReservasiView');
})->middleware(['auth'])->name('editreservasi');

//rute berita
Route::get('/berita', function () {
    return Inertia::render('BeritaView');
})->middleware(['auth'])->name('berita');

// Rute CRUD untuk Reservasi
Route::middleware('auth')->group(function () {
    Route::get('/reservasis', [ReservasiController::class, 'index'])->name('reservasis.index'); // Menampilkan daftar reservasi
    Route::post('/submit-reservasi', [ReservasiController::class, 'store'])->name('reservasis.store'); // Menyimpan data reservasi baru
    Route::get('/reservasi/{id}', [ReservasiController::class, 'show'])->name('reservasis.show'); // Menampilkan detail reservasi
    Route::get('/reservasi/{id}/edit', [ReservasiController::class, 'edit'])->name('reservasis.edit'); // Menampilkan form edit reservasi
    Route::put('/reservasi/{id}', [ReservasiController::class, 'update'])->name('reservasis.update'); // Mengupdate data reservasi
    Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy'])->name('reservasis.destroy'); // Menghapus data reservasi
});
