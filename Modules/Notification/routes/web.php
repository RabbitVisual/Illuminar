<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\AdminNotificationController;
use Modules\Notification\Http\Controllers\NotificationController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('notifications', NotificationController::class)->names('notification');
});

Route::middleware(['auth', 'role:SuperAdmin|Owner'])->prefix('admin')->name('admin.notification.')->group(function () {
    Route::get('notification/templates', [AdminNotificationController::class, 'index'])->name('templates.index');
    Route::get('notification/templates/{email_template}/edit', [AdminNotificationController::class, 'edit'])->name('templates.edit');
    Route::put('notification/templates/{email_template}', [AdminNotificationController::class, 'update'])->name('templates.update');
});
