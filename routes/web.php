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
    Route::view('/', 'welcome')->name('home');
});
