<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/login', 'pages::auth.login')->name('login');
Route::livewire('/register', 'pages::auth.register')->name('register');
Route::livewire('/email/verify/success', 'pages::auth.verify-success')->name('verification.success');

// Custom email verification route (auto-login after verify)
Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\EmailVerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');
    Route::livewire('/account', 'pages::account.index')->name('account');
});

Route::middleware('auth', 'role:administrator')->group(function () {
    Route::livewire('/user', 'pages::user.index')->name('user');
    Route::livewire('/user/create', 'pages::user.create')->name('user.create');
    Route::livewire('/user/{user}/edit', 'pages::user.edit')->name('user.edit');
    Route::livewire('/role-permission', 'pages::user.role_permission')->name('user.role_permission');
});
