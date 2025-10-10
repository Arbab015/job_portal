<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\DesignationController;
use App\Http\Controllers\Auth\JobTypeController;
use App\Http\Controllers\Auth\JobController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

// Designation Routes 
  Route::get('designations', [DesignationController::class, 'index'])->name('designations.index');
Route::post('designations', [DesignationController::class, 'store'])->name('designations.store');
Route::put('designations/{id}', [DesignationController::class, 'update'])->name('designations.update');
Route::delete('designations/{id}', [DesignationController::class, 'destroy'])->name('designations.destroy');

//  Job Types Routes
 Route::get('job_types', [JobTypeController::class, 'index'])->name('job_types.index');
 Route::post('job_types', [JobTypeController::class, 'store'])->name('job_types.store');
  Route::put('job_types/{id}', [JobTypeController::class, 'update'])->name('job_types.update');
  Route::delete('job_types/{id}', [JobTypeController::class, 'distroy'])->name('job_types.distroy');


  //  Jobs Routes
  Route::controller(JobController::class)->group(function () {
    Route::get('Jobs', 'index')->name('jobs.index');
    Route::get('/jobs.add', 'add')->name('jobs.add');
    // Route::post('/users', 'store');
    // Route::put('/users/{id}', 'update');
    // Route::delete('/users/{id}', 'destroy');
});


    Route::get('/typography', fn() => view('typography'));
    Route::get('/element', fn() => view('element'));
    Route::get('/form', fn() => view('form'));
    Route::get('/table', fn() => view('table'));
    Route::get('/chart', fn() => view('chart'));
    Route::get('/404', fn() => view('404'));
    Route::get('/blank', fn() => view('blank'));
});


Route::get('/', fn() => view('auth.login'));
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('auth.register', [RegisterController::class, 'showRegisterForm'])->name('register.get');
Route::post('auth.register', [RegisterController::class, 'register'])->name('register.post');

Route::get('forgot_password', [ForgetPasswordController::class, 'showForgotPasswordPage'])->name('forgot_password.get');
Route::post('forgot_password', [ForgetPasswordController::class, 'sendResetEmailLink'])->name('forgot_password.reset');

Route::get('/reset_password', fn() => view('reset_password'));
Route::get('reset_password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset_password', [ResetPasswordController::class, 'store'])->name('password.store');