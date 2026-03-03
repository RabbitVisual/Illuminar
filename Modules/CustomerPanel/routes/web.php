<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomerPanel\Http\Controllers\CustomerPanelController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('customerpanels', CustomerPanelController::class)->names('customerpanel');
});
