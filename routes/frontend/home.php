<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use Tabuna\Breadcrumbs\Trail;

use App\Http\Controllers\Frontend\PersonaController;
use App\Http\Controllers\Frontend\AgremiadoController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('frontend.index'));
    });

Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('frontend.index')
            ->push(__('Terms & Conditions'), route('frontend.pages.terms'));
    });

Route::get('persona', [personaController::class, 'index'])->name('persona');
Route::post('persona/listar_persona_ajax', [PersonaController::class, 'listar_persona_ajax'])->name('persona.listar_persona_ajax');
Route::get('persona/modal_persona/{id}', [PersonaController::class, 'modal_persona'])->name('persona.modal_persona');
Route::post('persona/send_persona', [PersonaController::class, 'send_persona'])->name('persona.send_persona');
Route::get('persona/eliminar_persona/{id}/{estado}', [PersonaController::class, 'eliminar_persona'])->name('persona.eliminar_persona');
Route::get('persona/obtener_persona/{tipo_documento}/{numero_documento}', [PersonaController::class, 'obtener_persona'])->name('persona.obtener_persona')->where('tipo_documento', '(.*)');
Route::get('persona/buscar_persona/{tipo_documento}/{numero_documento}', [PersonaController::class, 'buscar_persona'])->name('persona.buscar_persona');
Route::get('persona/create', [personaController::class, 'create'])->name('persona.create');
Route::get('persona/list_persona/{term}', [personaController::class, 'list_persona'])->name('persona.list_persona');

Route::get('agremiado', [AgremiadoController::class, 'index'])->name('agremiado');
Route::get('agremiado/importar_agremiado', [AgremiadoController::class, 'importar_agremiado'])->name('agremiado.importar_agremiado');

