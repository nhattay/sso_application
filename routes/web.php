<?php

use App\Http\Controllers\Auth\SsoAuthenticationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('auth/redirect', [SsoAuthenticationController::class, 'redirect'])->name('sso.redirect');
Route::get('auth/callback', [SsoAuthenticationController::class, 'authenticate'])->name('sso.authenticate');

require __DIR__.'/auth.php';
