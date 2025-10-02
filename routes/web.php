<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

 Route::get('/dashboard', fn() => view('dashboard'));
  Route::get('/button', fn() => view('button'));
    Route::get('/typography', fn() => view('typography'));
    Route::get('/element', fn() => view('element'));
    Route::get('/widget', fn() => view('widget'));
    Route::get('/form', fn() => view('form'));
    Route::get('/table', fn() => view('table'));
    Route::get('/chart', fn() => view('chart'));
    Route::get('/404', fn() => view('404'));
    Route::get('/blank', fn() => view('blank'));

Route::get('/', function () {
    return view('signin');
});


 Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register.get');
 Route::post('register', [UserController::class, 'register'])->name('register.post');

  Route::get('signin', [UserController::class, 'showSignInForm'])->name('signin.get');
 Route::post('signin', [UserController::class, 'signIn'])->name('signin.post');

// routes for forgetpassword
 Route::get('forgetpassword', [PasswordController::class, 'showForgetPasswordPage'])->name('forgetpassword.email');
 Route::post('forgetpassword', [PasswordController::class, 'sendResetEmailLink'])->name('forgetpassword.reset');

// require __DIR__.'/auth.php';
