<?php

use App\Http\Controllers\Auth\GitHubController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/auth/github', [GitHubController::class, 'redirect'])->name('auth.github');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class);
    Route::post('/logout', [GitHubController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::get('/auth/github/callback', [GitHubController::class, 'callback'])->name('auth.github.callback');
