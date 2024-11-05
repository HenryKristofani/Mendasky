<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

// Rute Reservasi
Route::get('/reservasi', function () {
    return Inertia::render('ReservasiView');
})->middleware(['auth'])->name('reservasi');
