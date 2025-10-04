<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/button', fn() => view('button'));
    Route::get('/widget', fn() => view('widget'));
    Route::get('/typography', fn() => view('typography'));
    Route::get('/element', fn() => view('element'));
    Route::get('/form', fn() => view('form'));
    Route::get('/table', fn() => view('table'));
    Route::get('/chart', fn() => view('chart'));
    Route::get('/404', fn() => view('404'));
    Route::get('/blank', fn() => view('blank'));
});


Route::get('/', fn() => view('auth.login'));
Route::get('auth.login', [LoginController::class, 'showLoginForm'])->name('login.get');
Route::post('auth.login', [LoginController::class, 'login'])->name('login.post');    
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('auth.register', [RegisterController::class, 'showRegisterForm'])->name('register.get');
Route::post('auth.register', [RegisterController::class, 'register'])->name('register.post');

Route::get('forgot_password', [ForgetPasswordController::class, 'showForgotPasswordPage'])->name('forgot_password.get');
Route::post('forgot_password', [ForgetPasswordController::class, 'sendResetEmailLink'])->name('forgot_password.reset');

Route::get('/reset_password', fn() => view('reset_password'));
Route::get('reset_password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
Route::post('reset_password', [ResetPasswordController::class, 'store'])
        ->name('password.store');