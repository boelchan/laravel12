<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/login', 'pages::auth.login')->name('login');
Route::livewire('/register', 'pages::auth.register')->name('register');

Route::middleware('auth')->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');
    Route::livewire('/account', 'pages::account.index')->name('account');
});

Route::middleware('active', 'role:administrator')->group(function () {
    Route::livewire('/user', 'pages::user.index')->name('user');
    Route::livewire('/user/create', 'pages::user.create')->name('user.create');
    Route::livewire('/user/{user}/edit', 'pages::user.edit')->name('user.edit');
    Route::livewire('/role-permission', 'pages::user.role_permission')->name('user.role_permission');
});
