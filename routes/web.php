<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/admin-login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/do-register', [AuthController::class, 'doRegister'])->name('do.register');
Route::post('/do-login', [AuthController::class, 'doLogin'])->name('do.login');
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forget.password');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password.send');
Route::get('otp-verifcation', [AuthController::class, 'verificationOtp'])->name('verifcation.otp');
Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::get('password-reset', [AuthController::class, 'passwordReset'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

// Email verification
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('email.verify');
Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('email.resend');

// social login
Route::get('auth/google', [AuthController::class, 'googlePage'])->name('auth.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/admin-logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/', [TaskController::class, 'index'])->name('task.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('task.delete');
});
