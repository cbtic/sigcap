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
use App\Http\Controllers\Frontend\ConcursoController;

use App\Http\Controllers\Frontend\ProntoPagoController;
use App\Http\Controllers\Frontend\AfiliacionSeguroController;
use App\Http\Controllers\Frontend\ComprobanteController;
use App\Http\Controllers\Frontend\CertificadoController;
use App\Models\Certificado;

use App\Http\Controllers\Frontend\ComisionController;

use App\Http\Controllers\Frontend\PeriodoComisionController;
use App\Http\Controllers\Frontend\MovilidadController;


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

Route::get('TipoConcepto/consulta_tipoConcepto', [TipoConceptoController::class, 'consulta_tipoConcepto'])->name('TipoConcepto.consulta_tipoConcepto');

Route::get('ingreso/create', [IngresoController::class, 'create'])->name('ingreso.create');
Route::get('municipalidad/consulta_municipalidad', [MunicipalidadController::class, 'consulta_municipalidad'])->name('municipalidad.consulta_municipalidad');
Route::post('municipalidad/listar_municipalidad', [MunicipalidadController::class, 'listar_municipalidad'])->name('municipalidad.listar_municipalidad');

Route::get('municipalidad/modal_municipalidad/{id}', [MunicipalidadController::class, 'modal_municipalidad'])->name('municipalidad.modal_municipalidad');
//Route::post('TipoConcepto/listar_tipoConcepto_ajax', [TipoConceptoController::class, 'listar_tipoConcepto_ajax'])->name('TipoConcepto.listar_tipoConcepto_ajax');
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

Route::get('multa/modal_multa_historialMulta/{id}', [MultaController::class, 'modal_multa_historialMulta'])->name('multa.modal_multa_historialMulta');

Route::post('multa/listar_historialMulta_ajax', [MultaController::class, 'listar_historialMulta_ajax'])->name('multa.listar_historialMulta_ajax');

Route::get('prontoPago/consulta_prontoPago', [ProntoPagoController::class, 'consulta_prontoPago'])->name('prontoPago.consulta_prontoPago');

Route::post('prontoPago/listar_prontoPago_ajax', [ProntoPagoController::class, 'listar_prontoPago_ajax'])->name('prontoPago.listar_prontoPago_ajax');

Route::get('prontoPago/editar_prontoPago/{id}', [ProntoPagoController::class, 'editar_prontoPago'])->name('prontoPago.editar_prontoPago');

Route::get('prontoPago/modal_prontoPago_nuevoProntoPago/{id}', [ProntoPagoController::class, 'modal_prontoPago_nuevoProntoPago'])->name('prontoPago.modal_prontoPago_nuevoProntoPago');

Route::post('prontoPago/send_prontoPago_nuevoProntoPago', [ProntoPagoController::class, 'send_prontoPago_nuevoProntoPago'])->name('prontoPago.send_prontoPago_nuevoProntoPago');

Route::get('prontoPago/eliminar_prontoPago/{id}/{estado}', [ProntoPagoController::class, 'eliminar_prontoPago'])->name('prontoPago.eliminar_prontoPago');


//Route::get('ingreso/create', [IngresoController::class, 'create'])->name('ingreso.create');
Route::get('ingreso/create', [IngresoController::class, 'create'])->name('ingreso.create');
Route::get('ingreso/obtener_valorizacion/{tipo_documento}/{id_persona}', [IngresoController::class, 'obtener_valorizacion'])->name('ingreso.obtener_valorizacion')->where('tipo_documento', '(.*)');
Route::post('ingreso/listar_valorizacion', [IngresoController::class, 'listar_valorizacion'])->name('ingreso.listar_valorizacion');

Route::get('ingreso/obtener_pago/{tipo_documento}/{persona_id}', [IngresoController::class, 'obtener_pago'])->name('ingreso.obtener_pago')->where('tipo_documento', '(.*)');
Route::post('ingreso/sendCaja', [IngresoController::class, 'sendCaja'])->name('ingreso.sendCaja');
Route::get('ingreso/modal_otro_pago/{periodo}/{idpersona}/{idagremiado}', [IngresoController::class, 'modal_otro_pago'])->name('ingreso.modal_otro_pago');
Route::get('ingreso/modal_fraccionar/{idConcepto}/{idpersona}/{idagremiado}/{TotalFraccionar}', [IngresoController::class, 'modal_fraccionar'])->name('ingreso.modal_fraccionar');

Route::get('ingreso/obtener_conceptos/{periodo}', [IngresoController::class, 'obtener_conceptos'])->name('ingreso.obtener_conceptos')->where('periodo', '(.*)');
Route::post('ingreso/send_concepto', [IngresoController::class, 'send_concepto'])->name('ingreso.send_concepto');
Route::post('ingreso/fracciona_deuda', [IngresoController::class, 'fracciona_deuda'])->name('ingreso.fracciona_deuda');

Route::get('ingreso/modal_valorizacion_factura/{id}', [IngresoController::class, 'modal_valorizacion_factura'])->name('ingreso.modal_valorizacion_factura');


Route::post('comprobante/edit', [ComprobanteController::class, 'edit'])->name('comprobante.edit');
Route::get('comprobante', [ComprobanteController::class, 'index'])->name('comprobante.all');
Route::post('comprobante/create', [ComprobanteController::class, 'create'])->name('comprobante.create');
Route::post('comprobante/send', [ComprobanteController::class, 'send'])->name('comprobante.send');
Route::get('comprobante/{id}', [ComprobanteController::class, 'show'])->name('comprobante.show');



Route::get('seguro/consulta_seguro', [SeguroController::class, 'consulta_seguro'])->name('seguro.consulta_seguro');
Route::post('seguro/listar_seguro', [SeguroController::class, 'listar_seguro'])->name('seguro.listar_seguro');
Route::post('seguro/listar_plan', [SeguroController::class, 'listar_plan'])->name('seguro.listar_plan');
Route::get('seguro/modal_seguro/{id}', [SeguroController::class, 'modal_seguro'])->name('seguro.modal_seguro');
Route::get('seguro/modal_plan/{id}', [SeguroController::class, 'modal_plan'])->name('seguro.modal_plan');
Route::post('seguro/send_seguro', [SeguroController::class, 'send_seguro'])->name('seguro.send_seguro');
Route::post('seguro/edit', [SeguroController::class, 'edit'])->name('seguro.create');

Route::get('seguro/eliminar_seguro/{id}/{estado}', [seguroController::class, 'eliminar_seguro'])->name('seguro.eliminar_seguro');
Route::get('seguro/eliminar_plan/{id}', [seguroController::class, 'eliminar_plan'])->name('seguro.eliminar_plan');
Route::post('seguro/send_plan', [SeguroController::class, 'send_plan'])->name('seguro.send_plan');
Route::get('seguro/obtener_plan/{id}', [SeguroController::class, 'obtener_plan'])->name('seguro.obtener_plan');

Route::get('afiliacion_seguro/consulta_afiliacion_seguro', [AfiliacionSeguroController::class, 'consulta_afiliacion_seguro'])->name('afiliacion_seguro.consulta_afiliacion_seguro');
Route::post('afiliacion_seguro/listar_afiliacion_seguro', [AfiliacionSeguroController::class, 'listar_afiliacion_seguro'])->name('afiliacion_seguro.listar_afiliacion_seguro');
Route::get('afiliacion_seguro/modal_afiliado/{id}', [AfiliacionSeguroController::class, 'modal_afiliado'])->name('afiliacion_seguro.modal_afiliado');
Route::get('afiliacion_seguro/obtener_plan/{id}', [AfiliacionSeguroController::class, 'obtener_plan'])->name('afiliacion_seguro.obtener_plan');
Route::post('afiliacion_seguro/send_afiliacion', [AfiliacionSeguroController::class, 'send_afiliacion'])->name('afiliacion_seguro.send_afiliacion');
Route::get('afiliacion_seguro/modal_parentesco/{id}', [AfiliacionSeguroController::class, 'modal_parentesco'])->name('afiliacion_seguro.modal_parentesco');
Route::post('afiliacion_seguro/listar_parentesco', [AfiliacionSeguroController::class, 'listar_parentesco'])->name('afiliacion_seguro.listar_parentesco');
Route::get('afiliacion_seguro/obtener_agremiado/{id}', [AfiliacionSeguroController::class, 'obtener_agremiado'])->name('afiliacion_seguro.obtener_agremiado');
Route::post('afiliacion_seguro/send_parentesco_fila', [AfiliacionSeguroController::class, 'send_parentesco_fila'])->name('afiliacion_seguro.send_parentesco_fila');
//Route::get('afiliacion_seguro/obtener_parentesco/{id_agremiado}', [AfiliacionSeguroController::class, 'obtener_parentesco'])->name('afiliacion_seguro.obtener_parentesco')->where('id_agremiado', '(.*)');
//Route::get('afiliacion_seguro/obtener_parentesco/{id}', [AfiliacionSeguroController::class, 'obtener_parentesco'])->name('afiliacion_seguro.obtener_parentesco');
Route::get('afiliacion_seguro/obtener_parentesco/{id_agremiado}', [AfiliacionSeguroController::class, 'obtener_parentesco'])->name('afiliacion_seguro.obtener_parentesco')->where('id_agremiado', '(.*)');

Route::get('concurso', [ConcursoController::class, 'index'])->name('concurso');
Route::post('concurso/listar_concurso', [ConcursoController::class, 'listar_concurso'])->name('concurso.listar_concurso');
Route::get('concurso/modal_concurso/{id}', [ConcursoController::class, 'modal_concurso'])->name('concurso.modal_concurso');
Route::post('concurso/send_concurso', [ConcursoController::class, 'send_concurso'])->name('concurso.send_concurso');
Route::get('concurso/modal_puesto/{id}', [ConcursoController::class, 'modal_puesto'])->name('concurso.modal_puesto');
Route::post('concurso/listar_puesto', [ConcursoController::class, 'listar_puesto'])->name('concurso.listar_puesto');
Route::get('concurso/eliminar_puesto/{id}', [ConcursoController::class, 'eliminar_puesto'])->name('concurso.eliminar_puesto');
Route::post('concurso/send_puesto', [ConcursoController::class, 'send_puesto'])->name('concurso.send_puesto');
Route::get('concurso/obtener_puesto/{id}', [ConcursoController::class, 'obtener_puesto'])->name('concurso.obtener_puesto');

Route::get('concurso/create', [ConcursoController::class, 'create'])->name('concurso.create');
Route::post('concurso/send_inscripcion', [ConcursoController::class, 'send_inscripcion'])->name('concurso.send_inscripcion');
Route::get('concurso/editar_inscripcion/{id}', [ConcursoController::class, 'editar_inscripcion'])->name('concurso.editar_inscripcion');

Route::post('concurso/listar_concurso_agremiado', [ConcursoController::class, 'listar_concurso_agremiado'])->name('concurso.listar_concurso_agremiado');

Route::get('concurso/obtener_concurso_inscripcion/{id}', [ConcursoController::class, 'obtener_concurso_inscripcion'])->name('concurso.obtener_concurso_inscripcion');

Route::get('concurso/modal_concurso_requisito/{id}', [ConcursoController::class, 'modal_concurso_requisito'])->name('concurso.modal_concurso_requisito');
Route::post('concurso/send_concurso_documento', [ConcursoController::class, 'send_concurso_documento'])->name('concurso.send_concurso_documento');

Route::get('concurso/obtener_concurso_documento/{id}', [ConcursoController::class, 'obtener_concurso_documento'])->name('concurso.obtener_concurso_documento');

Route::get('concurso/obtener_concurso_requisito/{id}', [ConcursoController::class, 'obtener_concurso_requisito'])->name('concurso.obtener_concurso_requisito');

Route::get('concurso/modal_requisito/{id}', [ConcursoController::class, 'modal_requisito'])->name('concurso.modal_requisito');

Route::post('concurso/send_requisito', [ConcursoController::class, 'send_requisito'])->name('concurso.send_requisito');
Route::post('concurso/listar_requisito', [ConcursoController::class, 'listar_requisito'])->name('concurso.listar_requisito');

Route::get('comision/consulta_comision', [ComisionController::class, 'consulta_comision'])->name('comision.consulta_comision');
Route::post('comision/listar_comision_ajax', [ComisionController::class, 'listar_comision_ajax'])->name('comision.listar_comision_ajax');
Route::post('concurso/upload_documento', [ConcursoController::class, 'upload_documento'])->name('concurso.upload_documento');

Route::get('concurso/create_resultado', [ConcursoController::class, 'create_resultado'])->name('concurso.create_resultado');
Route::post('concurso/send_inscripcion_resultado', [ConcursoController::class, 'send_inscripcion_resultado'])->name('concurso.send_inscripcion_resultado');
Route::get('comision/consulta_empresa', [ComisionController::class, 'consulta_empresa'])->name('comision.consulta_empresa');
Route::post('comision/listar_municipalidad_ajax', [ComisionController::class, 'listar_municipalidad_ajax'])->name('comision.listar_municipalidad_ajax');
Route::post('comision/send_comision_fila', [ComisionController::class, 'send_comision_fila'])->name('tipoConcepto.send_comision_fila');

Route::post('comision/send_comision', [ComisionController::class, 'send_comision'])->name('comision.send_comision');
Route::get('comision/obtener_municipalidades', [ComisionController::class, 'obtener_municipalidades'])->name('comision.obtener_municipalidades');
Route::get('comision/obtener_municipalidadesIntegradas', [ComisionController::class, 'obtener_municipalidadesIntegradas'])->name('comision.obtener_municipalidadesIntegradas');
Route::post('comision/listar_municipalidad_integrada_ajax', [ComisionController::class, 'listar_municipalidad_integrada_ajax'])->name('comision.listar_municipalidad_integrada_ajax');
Route::get('comision/consulta_municipalidadIntegrada', [ComisionController::class, 'consulta_municipalidadIntegrada'])->name('comision.consulta_municipalidadIntegrada');

Route::get('concurso/consulta_resultado', [ConcursoController::class, 'consulta_resultado'])->name('concurso.consulta_resultado');
Route::post('concurso/listar_resultado_ajax', [ConcursoController::class, 'listar_resultado_ajax'])->name('concurso.listar_resultado_ajax');


Route::get('certificado/consulta_certificado', [CertificadoController::class, 'consulta_certificado'])->name('certificado.consulta_certificado');


Route::get('periodoComision/consulta_periodoComision', [PeriodoComisionController::class, 'consulta_periodoComision'])->name('periodoComision.consulta_periodoComision');
Route::post('periodoComision/listar_consulta_periodoComision_ajax', [PeriodoComisionController::class, 'listar_consulta_periodoComision_ajax'])->name('periodoComision.listar_consulta_periodoComision_ajax');
Route::get('periodoComision/editar_consulta_periodoComision/{id}', [PeriodoComisionController::class, 'editar_consulta_periodoComision'])->name('periodoComision.editar_consulta_periodoComision');
Route::get('periodoComision/modal_periodoComision_nuevoPeriodoComision/{id}', [PeriodoComisionController::class, 'modal_periodoComision_nuevoPeriodoComision'])->name('periodoComision.modal_periodoComision_nuevoPeriodoComision');
Route::post('periodoComision/send_periodoComision_nuevoPeriodoComision', [PeriodoComisionController::class, 'send_periodoComision_nuevoPeriodoComision'])->name('periodoComision.send_periodoComision_nuevoPeriodoComision');
Route::get('periodoComision/eliminar_periodoComision/{id}/{estado}', [PeriodoComisionController::class, 'eliminar_periodoComision'])->name('periodoComision.eliminar_periodoComision');




Route::get('certificado/consultar_certificado', [CertificadoController::class, 'consultar_certificado'])->name('certificado.consultar_certificado');
Route::post('certificado/listar_certificado', [CertificadoController::class, 'listar_certificado'])->name('certificado.listar_certificado');
Route::get('certificado/modal_certificado/{id}', [CertificadoController::class, 'modal_certificado'])->name('certificado.modal_certificado');
Route::get('certificado/valida_pago/{idagremiado}/{serie}/{numero}/{concepto}', [CertificadoController::class, 'valida_pago'])->name('certificado.valida_pago');
Route::post('certificado/send_certificado', [CertificadoController::class, 'send_certificado'])->name('certificado.send_certificado');
Route::get('certificado/eliminar_certificado/{id}/{estado}', [CertificadoController::class, 'eliminar_certificado'])->name('certificado.eliminar_certificado');
Route::get('certificado/certificado_vista/{id}', [CertificadoController::class, 'certificado_vista'])->name('certificado.certificado_vista');
Route::get('certificado/certificado_pdf/{id}', [CertificadoController::class, 'certificado_pdf'])->name('certificado.certificado_pdf');

Route::get('comprobante/consultar', [ComprobanteController::class, 'consultar'])->name('comprobante.consultar');
Route::post('comprobante/listar_comprobante', [ComprobanteController::class, 'listar_comprobante'])->name('comprobante.listar_comprobante');
Route::get('certificado/certificado_pdf/{id}', [CertificadoController::class, 'certificado_pdf'])->name('certificado.certificado_pdf');
Route::get('movilidad/consulta_movilidad', [MovilidadController::class, 'consulta_movilidad'])->name('movilidad.consulta_movilidad');
Route::post('movilidad/listar_movilidad_ajax', [MovilidadController::class, 'listar_movilidad_ajax'])->name('movilidad.listar_movilidad_ajax');
Route::get('movilidad/editar_movilidad/{id}', [MovilidadController::class, 'editar_movilidad'])->name('movilidad.editar_movilidad');
Route::get('movilidad/modal_movilidad_nuevoMovilidad/{id}', [MovilidadController::class, 'modal_movilidad_nuevoMovilidad'])->name('movilidad.modal_movilidad_nuevoMovilidad');
Route::post('movilidad/send_movilidad_nuevoMovilidad', [MovilidadController::class, 'send_movilidad_nuevoMovilidad'])->name('movilidad.send_movilidad_nuevoMovilidad');
Route::get('comprobante/consultar', [ComprobanteController::class, 'consultar'])->name('comprobante.consultar');
Route::post('comprobante/listar_comprobante', [ComprobanteController::class, 'listar_comprobante'])->name('comprobante.listar_comprobante');
Route::get('certificado/certificado_pdf/{id}', [CertificadoController::class, 'certificado_pdf'])->name('certificado.certificado_pdf');
Route::get('movilidad/eliminar_movilidad/{id}/{estado}', [MovilidadController::class, 'eliminar_movilidad'])->name('movilidad.eliminar_movilidad');

Route::post('comision/send_municipalidad_integrada', [ComisionController::class, 'send_municipalidad_integrada'])->name('comision.send_municipalidad_integrada');
Route::get('comision/obtener_comision/{cad_id}', [ComisionController::class, 'obtener_comision'])->name('comision.obtener_comision');
Route::post('comision/send_comisiones_integradas', [ComisionController::class, 'send_comisiones_integradas'])->name('comision.send_comisiones_integradas');
Route::post('comision/listar_comision_integrada_ajax', [ComisionController::class, 'listar_comision_integrada_ajax'])->name('comision.listar_comision_integrada_ajax');
Route::get('comision/consulta_comision_integrada', [ComisionController::class, 'consulta_comision_integrada'])->name('comision.consulta_comision_integrada');

