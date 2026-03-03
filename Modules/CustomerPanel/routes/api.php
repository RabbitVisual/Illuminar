<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomerPanel\Http\Controllers\CustomerPanelController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('customerpanels', CustomerPanelController::class)->names('customerpanel');
});
