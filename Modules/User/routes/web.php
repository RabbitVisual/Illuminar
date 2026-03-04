<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Http\Controllers\ForgotPasswordController;
use Modules\User\Http\Controllers\RegisterController;
use Modules\User\Http\Controllers\RoleController;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\DevLoginController;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('cadastro', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('cadastro', [RegisterController::class, 'register']);

Route::get('esqueci-senha', [ForgotPasswordController::class, 'showRequestForm'])->name('password.request');
Route::post('esqueci-senha', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('esqueci-senha/cpf', [ForgotPasswordController::class, 'showRequestFormCpf'])->name('password.request.cpf');
Route::post('esqueci-senha/cpf', [ForgotPasswordController::class, 'sendResetLinkCpf'])->name('password.email.cpf');
Route::get('redefinir-senha/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('redefinir-senha', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Auto login para ambiente de desenvolvimento
if (app()->environment('local')) {
    Route::get('dev-login/{type}', [DevLoginController::class, 'loginAs'])
        ->whereIn('type', ['admin', 'pdv', 'customer'])
        ->name('dev-login');
}

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class)->names('user');
    Route::resource('roles', RoleController::class)->except(['create', 'store', 'show', 'destroy'])->names('role');
});
