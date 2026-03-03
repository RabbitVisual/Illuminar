<?php

use Illuminate\Support\Facades\Route;
use Modules\StorePanel\Http\Controllers\StorePanelController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('storepanels', StorePanelController::class)->names('storepanel');
});
