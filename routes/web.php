<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Frontend\ComprobanteController;
use App\Http\Controllers\Frontend\AsientoPlanillaController;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');

/*
 * Frontend Routes
 */
Route::group(['as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    includeRouteFiles(__DIR__.'/backend/');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/comprobante', [ComprobanteController::class, 'index']);
    Route::post('/comprobante', [ComprobanteController::class, 'create']);
});
             
Route::post('enviar_planilla', 
    [AsientoPlanillaController::class, 'enviar_planilla_siscont']);
    

Route::post('test-ruta', function () {
    return response()->json(['message' => 'Ruta de prueba funciona']);
});