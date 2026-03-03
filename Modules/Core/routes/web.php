<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\CoreController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/core', [CoreController::class, 'index'])->name('core.index');
    Route::resource('cores', CoreController::class)->names('core');
});
