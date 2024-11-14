<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Reservasi;

// Home route
Route::get('/', function () {
    return Inertia::render('HomeBeforeView', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// User authentication routes
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Admin-specific logout route
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// User dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth:web', 'verified'])->name('dashboard');

// Admin dashboard with middleware for admin authentication
Route::get('/admin/dashboard', [AdminController::class, 'showReservations'])
    ->middleware(['auth:admin'])
    ->name('admin.dashboard');

// Registration routes for regular users
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Public route for "Berita" (News) page, accessible without login
Route::get('/berita', function () {
    return Inertia::render('BeritaView');
})->name('berita');

// User-specific routes with web middleware
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
});

// Admin routes for managing reservations
Route::middleware('auth:admin')->group(function () {
    // Route to delete a reservation
    Route::delete('/admin/reservations/{id}', [AdminController::class, 'deleteReservation'])
        ->name('admin.reservations.delete');

    // Route to edit a reservation
    Route::get('/admin/reservations/{id}/edit', [AdminController::class, 'editReservation'])
        ->name('admin.reservations.edit');

    // Route to update a reservation
    Route::put('/admin/reservations/{id}', [AdminController::class, 'updateReservation'])
        ->name('admin.reservations.update');
});


// Route untuk halaman cuaca
Route::get('/cuaca', function () {
    return Inertia::render('WeatherView');
})->name('cuaca');


//mengambil kuota
Route::get('/kuota', function () {
    $pendakiPerTanggal = Reservasi::selectRaw('tanggal_reservasi, COUNT(*) as jumlah_pendaki')
        ->with('anggota')
        ->groupBy('tanggal_reservasi')
        ->get();

    return Inertia::render('KuotaView', [
        'pendakiPerTanggal' => $pendakiPerTanggal
    ]);
})->name('kuota');

// Mengubah route /kuota agar tidak menggunakan middleware
Route::get('/kuota', [AdminController::class, 'getPendakiHariIni'])->name('kuota');


// Route untuk mengambil kuota berdasarkan tanggal
Route::get('/api/kuota/{date}', [AdminController::class, 'getKuotaByDate']);




// Additional routes for reservation controller, if required
require __DIR__.'/reservasicontroller.php';
