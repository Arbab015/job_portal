<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Auth::routes();
Route::middleware('auth')->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->middleware('permission:dashboard');
  Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('permission:dashboard');

  // Designation Routes 
  Route::get('designations', [DesignationController::class, 'index'])->name('designations.index')->middleware('permission:designations_listing');
  Route::post('designations', [DesignationController::class, 'store'])->name('designations.store');
  Route::put('designations/{id}', [DesignationController::class, 'update'])->name('designations.update');
  Route::delete('designations/{id}', [DesignationController::class, 'destroy'])->name('designations.destroy')->middleware('permission:delete_designation');;

  //  Job Types Routes
  Route::get('job_types', [JobTypeController::class, 'index'])->name('job_types.index')->middleware('permission:jobtypes_listing');
  Route::post('job_types', [JobTypeController::class, 'store'])->name('job_types.store');
  Route::put('job_types/{id}', [JobTypeController::class, 'update'])->name('job_types.update');
  Route::delete('job_types/{id}', [JobTypeController::class, 'destroy'])->name('job_types.destroy')->middleware('permission:delete_jobtype');

  //  Jobs Routes
  Route::controller(JobController::class)->group(function () {
    Route::get('jobs', 'index')->name('jobs.index')->middleware('permission:jobs_listing');
    Route::get('/jobs/create', 'create')->name('jobs.create')->middleware('permission:add_job');
    Route::post('/jobs/store', 'store')->name('jobs.store');
    Route::get('/jobs/edit/{slug}', 'edit')->name('jobs.edit')->middleware('permission:edit_job');
    Route::put('/jobs/{slug}', 'update')->name('jobs.update');
    Route::delete('/jobs/{slug}', 'destroy')->name('jobs.destroy')->middleware('permission:delete_job');
  });


  // user profile
   Route::controller(ProfileController::class)->group(function () {

       Route::get('user/profile', 'edit')->name('user.profile');
       Route::put('user/{id}/update', 'update')->name('profile.update');



   });  


  // route work only if role is super admin 
  Route::middleware('role:Super Admin')->group(function () {
    // Role routes
    Route::controller(RoleController::class)->group(function () {
      Route::get('roles', 'index')->name('roles.index');
      Route::get('role/create', 'create')->name('role.create');
      Route::post('role/store', 'store')->name('role.store');
      Route::get('role/{id}/edit', 'edit')->name('roles.edit');
      Route::put('role/{id}', 'update')->name('roles.update');
      Route::delete('role/{id}', 'destroy')->name('roles.destroy');
    });
    // users routes
    Route::controller(UserController::class)->group(function () {
      Route::get('users', 'index')->name('users.index');
      Route::get('user/create', 'create')->name('users.create');
      Route::post('users/import', 'import')->name('users.import');
       Route::get('get_progress', 'getPercentage');
      Route::post('user/store', 'store')->name('users.store');
      Route::get('user/{id}/edit', 'edit')->name('users.edit');
      Route::put('user/{id}', 'update')->name('users.update');
      Route::delete('user/{id}', 'destroy')->name('users.destroy');
    });;
  });
});

Route::get('auth/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('auth/register', [RegisterController::class, 'showForm'])->name('register.get');
Route::post('auth/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('forgot_password', [ForgetPasswordController::class, 'showForgotPasswordPage'])->name('forgot_password.get');
Route::post('forgot_password', [ForgetPasswordController::class, 'sendResetEmailLink'])->name('forgot_password.reset');

// Route::get('/reset_password', fn() => view('reset_password'));
// Route::get('reset_password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset_password', [ResetPasswordController::class, 'store'])->name('password.store');
