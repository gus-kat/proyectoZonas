<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ZonaRiesgoController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('zonasRiesgo.index');
    }
    return redirect()->route('login');
});

// Esta ruta es opcional, si quieres mantener '/dashboard' como ruta, redirige a zonasRiesgo
Route::get('/dashboard', function () {
    return redirect()->route('zonasRiesgo.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('zonasRiesgo', ZonaRiesgoController::class);

require __DIR__.'/auth.php';
