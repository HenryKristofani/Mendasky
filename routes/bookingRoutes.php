<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/booking', [BookingController::class, 'index']);
Route::post('/booking', [BookingController::class, 'store']);
Route::get('/booking/{id}', [BookingController::class, 'show']);
Route::put('/booking/{id}', [BookingController::class, 'update']);
Route::delete('/booking/{id}', [BookingController::class, 'destroy']);

require __DIR__.'/auth.php';