<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;
use Tabuna\Breadcrumbs\Trail;

use App\Http\Controllers\Frontend\PersonaController;
use App\Http\Controllers\Frontend\AgremiadoController;
use App\Http\Controllers\Frontend\EmpresaController;
use App\Http\Controllers\Frontend\ConceptoController;
use App\Http\Controllers\Frontend\TipoConceptoController;
use App\Http\Controllers\Frontend\MultaController;

use App\Http\Controllers\Frontend\IngresoController;

use App\Http\Controllers\Frontend\MunicipalidadController;
use App\Http\Controllers\Frontend\SeguroController;

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
Route::get('agremiado/editar_agremiado/{id}', [AgremiadoController::class, 'editar_agremiado'])->name('agremiado.editar_agremiado');
Route::get('agremiado/importar_agremiado', [AgremiadoController::class, 'importar_agremiado'])->name('agremiado.importar_agremiado');
Route::get('agremiado/obtener_provincia/{idDepartamento}', [AgremiadoController::class, 'obtener_provincia'])->name('agremiado.obtener_provincia');
Route::get('agremiado/obtener_distrito/{idDepartamento}/{idProvincia}', [AgremiadoController::class, 'obtener_distrito'])->name('agremiado.obtener_distrito');
Route::get('agremiado/consulta_agremiado', [AgremiadoController::class, 'consulta_agremiado'])->name('agremiado.consulta_agremiado');
Route::post('agremiado/listar_agremiado_ajax', [AgremiadoController::class, 'listar_agremiado_ajax'])->name('agremiado.listar_agremiado_ajax');
Route::post('agremiado/send', [AgremiadoController::class, 'send'])->name('agremiado.send');
Route::get('agremiado/modal_agremiado_estudio/{id}', [AgremiadoController::class, 'modal_agremiado_estudio'])->name('agremiado.modal_agremiado_estudio');
Route::post('agremiado/send_agremiado_estudio', [AgremiadoController::class, 'send_agremiado_estudio'])->name('agremiado.send_agremiado_estudio');

Route::get('agremiado/modal_agremiado_idioma/{id}', [AgremiadoController::class, 'modal_agremiado_idioma'])->name('agremiado.modal_agremiado_idioma');
Route::post('agremiado/send_agremiado_idioma', [AgremiadoController::class, 'send_agremiado_idioma'])->name('agremiado.send_agremiado_idioma');

Route::get('agremiado/modal_agremiado_parentesco/{id}', [AgremiadoController::class, 'modal_agremiado_parentesco'])->name('agremiado.modal_agremiado_parentesco');
Route::post('agremiado/send_agremiado_parentesco', [AgremiadoController::class, 'send_agremiado_parentesco'])->name('agremiado.send_agremiado_parentesco');

Route::get('agremiado/modal_agremiado_trabajo/{id}', [AgremiadoController::class, 'modal_agremiado_trabajo'])->name('agremiado.modal_agremiado_trabajo');
Route::post('agremiado/send_agremiado_trabajo', [AgremiadoController::class, 'send_agremiado_trabajo'])->name('agremiado.send_agremiado_trabajo');

Route::get('agremiado/modal_agremiado_traslado/{id}', [AgremiadoController::class, 'modal_agremiado_traslado'])->name('agremiado.modal_agremiado_traslado');
Route::post('agremiado/send_agremiado_traslado', [AgremiadoController::class, 'send_agremiado_traslado'])->name('agremiado.send_agremiado_traslado');

Route::get('agremiado/modal_agremiado_situacion/{id}', [AgremiadoController::class, 'modal_agremiado_situacion'])->name('agremiado.modal_agremiado_situacion');
Route::post('agremiado/send_agremiado_situacion', [AgremiadoController::class, 'send_agremiado_situacion'])->name('agremiado.send_agremiado_situacion');

Route::get('agremiado/eliminar_estudio/{id}', [AgremiadoController::class, 'eliminar_estudio'])->name('agremiado.eliminar_estudio');
Route::get('agremiado/eliminar_idioma/{id}', [AgremiadoController::class, 'eliminar_idioma'])->name('agremiado.eliminar_idioma');
Route::get('agremiado/eliminar_parentesco/{id}', [AgremiadoController::class, 'eliminar_parentesco'])->name('agremiado.eliminar_parentesco');
Route::get('agremiado/eliminar_trabajo/{id}', [AgremiadoController::class, 'eliminar_trabajo'])->name('agremiado.eliminar_trabajo');
Route::get('agremiado/eliminar_traslado/{id}', [AgremiadoController::class, 'eliminar_traslado'])->name('agremiado.eliminar_traslado');
Route::get('agremiado/eliminar_situacion/{id}', [AgremiadoController::class, 'eliminar_situacion'])->name('agremiado.eliminar_situacion');
Route::get('agremiado/obtener_agremiado/{tipo_documento}/{numero_documento}', [AgremiadoController::class, 'obtener_agremiado'])->name('agremiado.obtener_agremiado');

Route::get('empresa/consulta_empresa', [EmpresaController::class, 'consulta_empresa'])->name('empresa.consulta_empresa');

Route::post('empresa/listar_empresa_ajax', [EmpresaController::class, 'listar_empresa_ajax'])->name('empresa.listar_empresa_ajax');

Route::get('empresa/editar_empresa/{id}', [EmpresaController::class, 'editar_empresa'])->name('empresa.editar_empresa');
Route::get('empresa/modal_empresa_nuevoEmpresa/{id}', [EmpresaController::class, 'modal_empresa_nuevoEmpresa'])->name('empresa.modal_empresa_nuevoEmpresa');

Route::get('empresa/modal_empresa_nuevoEmpresa/{id}', [EmpresaController::class, 'modal_empresa_nuevoEmpresa'])->name('empresa.modal_empresa_nuevoEmpresa');
Route::get('municipalidad/consulta_municipalidad', [MunicipalidadController::class, 'consulta_municipalidad'])->name('municipalidad.consulta_municipalidad');
Route::post('municipalidad/listar_municipalidad', [MunicipalidadController::class, 'listar_municipalidad'])->name('municipalidad.listar_municipalidad');
Route::get('municipalidad/modal_municipalidad/{id}', [MunicipalidadController::class, 'modal_municipalidad'])->name('municipalidad.modal_municipalidad');
Route::post('municipalidad/send_municipalidad', [MunicipalidadController::class, 'send_municipalidad'])->name('municipalidad.send_municipalidad');
Route::get('municipalidad/eliminar_municipalidad/{id}/{estado}', [MunicipalidadController::class, 'eliminar_municipalidad'])->name('municipalidad.eliminar_municipalidad');

Route::post('empresa/send_empresa_nuevoEmpresa', [EmpresaController::class, 'send_empresa_nuevoEmpresa'])->name('empresa.send_empresa_nuevoEmpresa');

Route::get('empresa/eliminar_empresa/{id}/{estado}', [EmpresaController::class, 'eliminar_empresa'])->name('empresa.eliminar_empresa');

Route::get('concepto/consulta_concepto', [ConceptoController::class, 'consulta_concepto'])->name('concepto.consulta_concepto');

Route::post('concepto/listar_concepto_ajax', [ConceptoController::class, 'listar_concepto_ajax'])->name('concepto.listar_concepto_ajax');

Route::get('concepto/editar_concepto/{id}', [ConceptoController::class, 'editar_concepto'])->name('concepto.editar_concepto');

Route::get('concepto/modal_concepto_nuevoConcepto/{id}', [ConceptoController::class, 'modal_concepto_nuevoConcepto'])->name('concepto.modal_concepto_nuevoConcepto');

Route::post('concepto/send_concepto_nuevoConcepto', [ConceptoController::class, 'send_concepto_nuevoConcepto'])->name('concepto.send_concepto_nuevoConcepto');

Route::get('concepto/eliminar_concepto/{id}/{estado}', [ConceptoController::class, 'eliminar_concepto'])->name('concepto.eliminar_concepto');

Route::get('TipoConcepto/consulta_tipoConcepto', [TipoConceptoController::class, 'consulta_tipoConcepto'])->name('tipoConcepto.consulta_tipoConcepto');

Route::get('ingreso/create', [IngresoController::class, 'create'])->name('ingreso.create');
Route::get('municipalidad/consulta_municipalidad', [MunicipalidadController::class, 'consulta_municipalidad'])->name('municipalidad.consulta_municipalidad');
Route::post('municipalidad/listar_municipalidad', [MunicipalidadController::class, 'listar_municipalidad'])->name('municipalidad.listar_municipalidad');

Route::get('municipalidad/modal_municipalidad/{id}', [MunicipalidadController::class, 'modal_municipalidad'])->name('municipalidad.modal_municipalidad');
Route::post('TipoConcepto/listar_tipoConcepto_ajax', [TipoConceptoController::class, 'listar_tipoConcepto_ajax'])->name('TipoConcepto.listar_tipoConcepto_ajax');
Route::post('tipoConcepto/listar_tipoConcepto_ajax', [TipoConceptoController::class, 'listar_tipoConcepto_ajax'])->name('tipoConcepto.listar_tipoConcepto_ajax');

Route::get('tipoConcepto/editar_tipoConcepto/{id}', [TipoConceptoController::class, 'editar_tipoConcepto'])->name('tipoConcepto.editar_tipoConcepto');

Route::get('tipoConcepto/modal_tipoConcepto_nuevoTipoConcepto/{id}', [TipoConceptoController::class, 'modal_tipoConcepto_nuevoTipoConcepto'])->name('tipoConcepto.modal_tipoConcepto_nuevoTipoConcepto');

Route::post('tipoConcepto/send_tipoConcepto_nuevoTipoConcepto', [TipoConceptoController::class, 'send_tipoConcepto_nuevoTipoConcepto'])->name('tipoConcepto.send_tipoConcepto_nuevoTipoConcepto');

Route::get('tipoConcepto/eliminar_tipoConcepto/{id}/{estado}', [TipoConceptoController::class, 'eliminar_tipoConcepto'])->name('tipoConcepto.eliminar_tipoConcepto');

Route::get('multa/consulta_multa', [MultaController::class, 'consulta_multa'])->name('multa.consulta_multa');

Route::post('multa/listar_datosAgremiado_ajax', [MultaController::class, 'listar_datosAgremiado_ajax'])->name('multa.listar_datosAgremiado_ajax');

Route::get('multa/editar_multa/{id}', [MultaController::class, 'editar_multa'])->name('multa.editar_multa');

Route::get('multa/modal_multa_nuevoMulta/{id}', [MultaController::class, 'modal_multa_nuevoMulta'])->name('multa.modal_multa_nuevoMulta');

Route::post('multa/send_multa_nuevoMulta', [MultaController::class, 'send_multa_nuevoMulta'])->name('multa.send_multa_nuevoMulta');

Route::get('multa/eliminar_multa/{id}/{estado}', [MultaController::class, 'eliminar_multa'])->name('multa.eliminar_multa');



//Route::get('ingreso/create', [IngresoController::class, 'create'])->name('ingreso.create');
Route::get('ingreso/create', [IngresoController::class, 'create'])->name('ingreso.create');

Route::get('ingreso/obtener_valorizacion/{tipo_documento}/{id_persona}', [IngresoController::class, 'obtener_valorizacion'])->name('ingreso.obtener_valorizacion')->where('tipo_documento', '(.*)');

Route::get('ingreso/obtener_pago/{tipo_documento}/{persona_id}', [IngresoController::class, 'obtener_pago'])->name('ingreso.obtener_pago')->where('tipo_documento', '(.*)');

Route::get('seguro/consulta_seguro', [SeguroController::class, 'consulta_seguro'])->name('seguro.consulta_seguro');
Route::post('seguro/listar_seguro', [SeguroController::class, 'listar_seguro'])->name('seguro.listar_seguro');
Route::post('seguro/listar_plan', [SeguroController::class, 'listar_plan'])->name('seguro.listar_plan');
Route::get('seguro/modal_seguro/{id}', [SeguroController::class, 'modal_seguro'])->name('seguro.modal_seguro');
Route::get('seguro/modal_plan/{id}', [SeguroController::class, 'modal_plan'])->name('seguro.modal_plan');
Route::post('seguro/send_seguro', [SeguroController::class, 'send_seguro'])->name('seguro.send_seguro');
Route::get('seguro/eliminar_seguro/{id}/{estado}', [seguroController::class, 'eliminar_seguro'])->name('seguro.eliminar_seguro');
Route::get('seguro/eliminar_plan/{id}', [seguroController::class, 'eliminar_plan'])->name('seguro.eliminar_plan');
Route::post('seguro/send_plan', [SeguroController::class, 'send_plan'])->name('seguro.send_plan');
Route::get('seguro/obtener_plan/{id}', [SeguroController::class, 'obtener_plan'])->name('seguro.obtener_plan');

