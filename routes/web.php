<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth::routes();

Route::middleware('auth')->group(function () {
  Route::get('/',  [DashboardController::class, 'index']);
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
  Route::delete('job_types/{id}', [JobTypeController::class, 'destroy'])->name('job_types.destroy');

  //  Jobs Routes
  Route::controller(JobController::class)->group(function () {
    Route::get('jobs', 'index')->name('jobs.index');
    Route::get('/jobs/create', 'create')->name('jobs.create');
    Route::post('/jobs/store', 'store')->name('jobs.store');
    Route::get('/jobs/edit/{id}', 'edit')->name('jobs.edit');
    Route::put('/jobs/{id}', 'update')->name('jobs.update');
    Route::delete('/jobs/{id}', 'destroy')->name('jobs.destroy');
  });
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('auth/register', [RegisterController::class, 'showRegisterForm'])->name('register.get');
Route::post('auth/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('forgot_password', [ForgetPasswordController::class, 'showForgotPasswordPage'])->name('forgot_password.get');
Route::post('forgot_password', [ForgetPasswordController::class, 'sendResetEmailLink'])->name('forgot_password.reset');

// Route::get('/reset_password', fn() => view('reset_password'));
// Route::get('reset_password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset_password', [ResetPasswordController::class, 'store'])->name('password.store');
