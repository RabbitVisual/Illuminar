<?php

use Illuminate\Support\Facades\Route;
use Modules\StorePanel\Http\Controllers\StorePanelController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('storepanels', StorePanelController::class)->names('storepanel');
});
