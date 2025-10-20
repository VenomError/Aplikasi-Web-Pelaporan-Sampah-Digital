<?php

use App\Http\Controllers\MailVerifyController;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes (Guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Volt::route('/login', 'auth.login')->name('login');
    Volt::route('/register', 'auth.register')->name('register');
});
Route::get('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();

    // Hapus session & regenerate token CSRF
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/
// Halaman yang memberi tahu user untuk memverifikasi email
Volt::route('/email/verify', 'auth.email-verification')
    ->middleware('auth')
    ->name('verification.notice');
// Link verifikasi dari email
Route::get('/email/verify/{id}/{hash}', [MailVerifyController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/', 'landing.index')->name('home');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/dashboard', 'dashboard.index')->name('dashboard.index');
});
