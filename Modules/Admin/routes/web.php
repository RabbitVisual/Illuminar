<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\SecurityRequestController;
use Modules\Admin\Http\Controllers\SecuritySettingsController;

Route::middleware(['auth'])->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    Route::middleware(['role:SuperAdmin|Owner'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('security-requests', [SecurityRequestController::class, 'index'])->name('security-requests.index');
        Route::get('settings/security', [SecuritySettingsController::class, 'index'])->name('settings.security');
        Route::put('settings/security', [SecuritySettingsController::class, 'update'])->name('settings.security.update');
    });
});
