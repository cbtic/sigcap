<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->
<style type="text/css">
    .dataTables_length {
        float: left !important;
    }

    .tooltip>.tooltip-inner {
        background-color: #5cb85c !important;
        color: #FFFFFF;
        border: 1px solid #5cb85c !important;
        padding: 4px;
        font-size: 11px;
    }

    .tooltip.top>.tooltip-arrow {
        border-top: 2px solid #5cb85c !important;
    }

    .tooltip.bottom>.tooltip-arrow {
        border-bottom: 2px solid #5cb85c !important;
    }

    .tooltip.left>.tooltip-arrow {
        border-left: 2px solid #5cb85c !important;
    }

    .tooltip.right>.tooltip-arrow {
        border-right: 2px solid #5cb85c !important;
    }


    .selected {
        background-color: brown;
        color: #FFF;
    }
</style>
@stack('before-scripts')
@stack('after-scripts')


@extends('frontend.layouts.app')

@section('title', __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <!--<li class="breadcrumb-item active">Nuevo Ingreso</li>-->
    <li class="breadcrumb-item active" style="color:#FFFFFF;font-weight:bold">Estado de Cuenta</li>
    </li>
</ol>
@endsection

@section('content')
<!--
    <ol class="breadcrumb" style="padding-left:120px;margin-top:0px;background-color:#355C9D">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Nueva Asistencia</li>
        </li>
    </ol>
    -->

<div class="justify-content-center">
    <!--<div class="container-fluid">-->

    <div class="card">

        <div class="card-body">

            <form class="form-horizontal" method="post" action="{{ route('frontend.comprobante.edit')}}" id="frmValorizacion" name="frmValorizacion" autocomplete="off">

                <div class="row">
                    <div class="col-sm-12">

                        <div class="row">

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top:0px!important;text-align:center">
                                <!--
								<h4 class="card-title mb-0 text-primary">
									Estado de cuenta
								</h4>
								-->
                                <div style="position:relative">
                                    <!--<img src="{{ $logged_in_user->picture }}" class="user-profile-image_" id="foto" width="80px" height="110px" style="position:absolute;top:-30px;left:35%" />-->
                                    <img src="../img/profile-icon.png" id="foto" width="90px" height="110px" style="position:absolute;top:-30px;left:35%" />
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <br>

                                    <?php
                                    $readonly = '';
                                    $saldo_inicial = "";
                                    $total_recaudado = "";
                                    $saldo_total = "";
                                    $disabled = "disabled='disabled'";
                                    if (isset($caja_usuario) && $caja_usuario->estado == 1) :
                                        $readonly = "readonly='readonly'";
                                        $disabled = "";
                                        $saldo_inicial = number_format($caja_usuario->saldo_inicial, 2);
                                        $total_recaudado = number_format($caja_usuario->total_recaudado, 2);
                                        $saldo_total = number_format($caja_usuario->saldo_total, 2);
                                    ?>
                                        <input class="btn btn-warning btn-sm pull-right" value="CERRAR DE CAJA" name="cerrar" type="button" form="prestacionescrea" id="btnGuardar" onclick="aperturar('u')" />
                                    <?php else : ?>
                                        <input class="btn btn-warning btn-sm pull-right" value="APERTURA DE CAJA" name="aperturar" type="button" form="prestacionescrea" id="btnGuardar" onclick="aperturar('i')" />
                                    <?php endif; ?>


                                </div>
                            </div>


                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="form-control-sm">Caja</label>

                                    <?php
                                    //$readonly='';
                                    if (isset($caja_usuario) && $caja_usuario->estado == 1) :
                                        //$readonly="readonly='readonly'";
                                    ?>
                                        <input type="text" name="caja" id="caja" readonly="" value="<?php echo $caja_usuario->caja ?>" placeholder="" class="form-control form-control-sm">
                                        <input type="hidden" name="id_caja" id="id_caja" value="<?php echo $caja_usuario->id_caja ?>" />
                                        <input type="hidden" name="id_caja_ingreso" id="id_caja_ingreso" value="<?php echo $caja_usuario->id ?>" />
                                    <?php else : ?>
                                        <select name="id_caja" id="id_caja" class="form-control form-control-sm">
                                            <option value="0">Seleccionar</option>
                                            <?php foreach ($caja as $row) : ?>
                                                <option value="<?php echo $row->codigo ?>"><?php echo $row->denominacion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="form-control-sm">Saldo Caja</label>
                                    <input type="text" name="saldo_inicial" id="saldo_inicial" <?php echo $readonly ?> value="<?php echo $saldo_inicial ?>" placeholder="" class="form-control form-control-sm text-right">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="form-control-sm">Total Recaudado</label>
                                    <input type="text" name="total_recaudado" id="total_recaudado" value="<?php echo $total_recaudado ?>" readonly="" placeholder="" class="form-control form-control-sm text-right">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="form-control-sm">Saldo Total</label>
                                    <input type="text" name="saldo_total" id="saldo_total" value="<?php echo $saldo_total ?>" readonly="" placeholder="" class="form-control form-control-sm text-right">
                                </div>
                            </div>

                        </div>

                    </div><!--col-->
                </div>

                <div class="row justify-content-center">

                    <div class="col col-sm-12 align-self-center">

                        <!--<form class="form-horizontal" method="post" action="{{ route('frontend.ingreso.create')}}" id="frmValorizacion" name="frmValorizacion" autocomplete="off" >-->
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                        <div class="row">

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

                                <div class="card">
                                    <div class="card-header">
                                        <strong>
                                            Datos de la Persona
                                        </strong>
                                    </div>

                                    <div class="card-body">
                                        <input type='hidden' name='txt_IdEmpresa' id="txt_IdEmpresa" value='{{Auth::user()->IdEmpresa}}'>https://dev-qry-cia.saludpol.gob.pe:8017/solicitud_reembolso/0#

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <?php ?>
                                                    <label class="form-control-sm">Tipo Documento</label>

                                                    <select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onblur="validaTipoDocumento();">
                                                        <?php
                                                        foreach ($tipo_documento as $row) { ?>
                                                            <option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == "85") echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>

                                                    <input type="hidden" readonly name="empresa_id" id="empresa_id" value="" class="form-control form-control-sm">
                                                    <input type="hidden" readonly name="id_ubicacion" id="id_ubicacion" value="" class="form-control form-control-sm">
                                                    <input type="hidden" readonly name="id_ubicacion_p" id="id_ubicacion_p" value="" class="form-control form-control-sm">
                                                    <input type="hidden" readonly name="id_persona" id="id_persona" value="" class="form-control form-control-sm">
                                                    <input type="hidden" readonly name="id_agremiado" id="id_agremiado" value="" class="form-control form-control-sm">
                                                    <input type="hidden" readonly name="numero_documento_" id="numero_documento_" value="" class="form-control form-control-sm">
                                                    <input type="hidden" readonly name="id_tipo_documento_" id="id_tipo_documento_" value="" class="form-control form-control-sm">
                                                    <input type="hidden" readonly name="id_concepto" id="id_concepto" value="" class="form-control form-control-sm">


                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <!--
                            <div class="form-group">
                                <label class="form-control-sm">N° Documento</label>
                                <input type="text" name="numero_documento" id="numero_documento" onblur="obtenerBeneficiario()" value="{{old('clinum')}}"  placeholder="" class="form-control form-control-sm" />

                                <input class="form-control input-sm text-uppercase" type="text" name="txtBusNroDocF" id="txtBusNroDocF" autocomplete="OFF" maxlength="12" required="" tabindex="0" disabled="">
                            </div>
                                        -->
                                                <label><small>Nro. de Documento</small></label>
                                                <div class="input-group input-group-sm">
                                                    <!--
                                <input type="text" name="numero_documento" id="numero_documento" onblur="obtenerBeneficiario()" value="{{old('clinum')}}"  placeholder="" class="form-control form-control-sm" />
                                        -->
                                                    <input class="form-control input-sm text-uppercase" type="text" name="numero_documento" id="numero_documento" autocomplete="OFF" maxlength="12" required="" tabindex="0">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success btn-sm" type="button" id="btnCon" onClick="obtenerBeneficiario()" tabindex="0"><i class="glyphicon glyphicon-search"></i> Buscar </button>
                                                    </span>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row" id="divNombreApellido">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Nombres y Apellidos</label>
                                                    <input type="text" readonly name="nombre_" id="nombre_" value="{{old('clinom')}}" class="form-control form-control-sm" />
                                                </div>
                                            </div>
                                        </div>

                                        <div id="divTarjeta" class="alert alert-danger" style="padding:6px 5px;display:none">
                                            Tarjeta: <span id="numero_tarjeta" class="alert-link"></span>
                                        </div>

                                        <div class="row" id="divCodigoAfliado">
                                            <div class="col">
                                                <div class="form-group">
                                                <label class="form-control-sm">Situación</label>
                                                    <input type="text" readonly name="situacion_" id="situacion_" value="{{old('clinom')}}" class="form-control form-control-sm" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="divEmpresaRazonSocial" style="display:none">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Razón Social</label>
                                                    <input type="text" readonly name="empresa_razon_social" id="empresa_razon_social" value="{{old('clinom')}}" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row" id="divDireccionEmpresa" style="display:none">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Direcci&oacute;n</label>
                                                    <input type="text" readonly name="empresa_direccion" id="empresa_direccion" value="{{old('clinom')}}" class="form-control form-control-sm">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="divRepresentanteEmpresa" style="display:none">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Representante</label>
                                                    <input type="text" readonly name="empresa_representante" id="empresa_representante" value="{{old('clinom')}}" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="divFechaAfliado">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Actividad</label>
                                                    <input type="text" readonly name="fecha_colegiatura" id="fecha_colegiatura" value="{{old('clinom')}}" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="divRucP">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-control-sm">RUC Personal</label>
                                                    <input type="text" readonly name="ruc_p" id="ruc_p" value="{{old('clinom')}}" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="row">
                                            <div class="col">
                                                <button class="btn btn-success btn-sm" type="button" name="btnOtroConcepto" id="btnOtroConcepto" onClick="modal_otro_pago()" tabindex="0" disabled><i class="glyphicon glyphicon-search"></i> Pago Otros Conceptos </button>
                                            </div>
                                        </div>


                                        <!--</div>-->



                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="padding:0px">

                                <div class="card">
                                    <div class="card-header">
                                        <strong>
                                            <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                            Registro de Estado de Cuenta
                                            @hasanyrole('administrator')
                                            <input class="btn btn-warning btn-sm pull-right" value="DUDOSO" type="button" id="btnEstado" onclick="guardarEstado('D')" style="margin-left:20px" /> @endhasanyrole
                                        </strong>
                                    </div>

                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                                <div class="form-group form-group-sm">
                                                    <select name="cboPeriodo_b" id="cboPeriodo_b" class="form-control form-control-sm" onchange="cargarValorizacion()">
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                        <option value="2024" selected>2024</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
                                                <div class="form-group form-group-sm">
                                                    <select name="cboTipoCuota_b" id="cboTipoCuota_b" class="form-control form-control-sm" onchange="cargarValorizacion()">
                                                        <option value="" selected>Todas cuotas</option>
                                                        <option value="1">Cuotas vencidas</option>
                                                        <option value="0">Cuotas pendientes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12">
                                                <div class="form-group form-group-sm">
                                                    <select id="cboTipoConcepto_b" name="cboTipoConcepto_b" class="form-control form-control-sm" onchange="cargarValorizacion()">
                                                    </select>
                                                </div>
                                            </div>


                                        </div>

                                        <?php $seleccionar_todos = "style='display:none'"; ?>
                                        @hasanyrole('administrator')
                                        <?php $seleccionar_todos = "style='display:block'"; ?>
                                        @else
                                        @endhasanyrole

                                        <div class="table-responsive">
                                            <table id="tblValorizacion" class="table table-hover table-sm">
                                                <thead>
                                                    <tr style="font-size:13px">
                                                        <!--<th class="text-right" width="5%">-->
                                                        <th style="text-align: center; padding-bottom:0px;padding-right:5px;margin-bottom: 0px; vertical-align: middle">
                                                            <input type="checkbox" name="select_all" value="1" id="example-select-all" <?php echo $seleccionar_todos ?> readonly />
                                                        </th>
                                                        <th>F. Proceso</th>
                                                        <th>Concepto</th>
                                                        <th>F. Vencimiento</th>
                                                        <th>Moneda</th>
                                                        <th class="text-right">Monto</th>
                                                        <!--<th>Estado</th>-->
                                                        <!--<th>Opc</th>-->
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <!--<tr>
                                            <td colspan="11" class="text-center">
                                                <span class="badge badge-default">{{ __('log-viewer::general.empty-logs') }}</span>
                                            </td>
                                        </tr>
                                        -->
                                                </tbody>
                                                <tfoot>
                                                    <!--
										<tr>
											<th colspan="3" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Pago a Cuenta</th>
											<td style="padding-bottom:0px;margin-bottom:0px">

												<input type="text" readonly name="MonAd" id="MonAd" value="0" class="form-control form-control-sm text-right" onkeyup="validarMonAd()"/>
											</td>
										</tr>
                                        -->

                                                    <tr>
                                                        <th colspan="5" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px">Total a Pagar</th>
                                                        <td style="padding-bottom:0px;margin-bottom:0px">
                                                            <input type="text" readonly name="total" id="total" value="0" class="form-control form-control-sm text-right">
                                                            <input type="hidden" readonly name="idConcepto" id="idConcepto" value="" class="form-control form-control-sm">
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div><!--table-responsive-->

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group mb-0 clearfix">
                                                    <!--<input class="btn btn-primary pull-right" value="NUEVA" <?php echo $disabled ?> name="crea" type="button" form="prestacionescrea" id="btnGuardar" data-toggle='dropdown' onclick="guardarValorizacion()" />-->
                                                    <!--<input class="btn btn-primary pull-right" value="NUEVA" <?php echo $disabled ?> name="crea" type="button" form="prestacionescrea" id="btnGuardar" data-toggle='dropdown' />-->
                                                    <!--
									<input type="button" class="btn btn-primary pull-right" data-toggle='dropdown' <?php echo $disabled ?> value="NUEVA"/>
									<ul class="dropdown-menu" role="menu" style="padding-left:10px">
										<input type="hidden" name="TipoF" id="TipoF" value="" />
										<input type="hidden" name="Trans" id="Trans" value="FA" />
										<li><input class="btn btn-default pull-right" value="FACTURA" type="button" id="tipoFactura" onclick="enviarTipo(1)" /></li>
                                        <li><input class="btn btn-default pull-right" value="BOLETA" type="button" id="tipoBoleta" onclick="enviarTipo(2)" /></li>
                                        <li><input class="btn btn-default pull-right" value="TICKET" type="button" id="tipoBoleta" onclick="enviarTipo(3)" /></li>
									</ul>
									-->
                                                    <input type="hidden" name="TipoF" id="TipoF" value="" />
                                                    <input type="hidden" name="Trans" id="Trans" value="FA" />
                                                    <input class="btn btn-success pull-rigth" value="FACTURA" type="button" id="btnFactura" disabled="disabled" onclick="enviarTipo(1)" />
                                                    <input class="btn btn-info pull-rigth" value="BOLETA" type="button" id="btnBoleta" disabled="disabled" onclick="enviarTipo(2)" />
                                                    
                                                    <input class="btn btn-info pull-rigth" value="BOLETA" type="button" id="btnTicket" disabled="disabled" onclick="enviarTipo(3)" style="display:none" />

                                                    <input class="btn btn-primary pull-rigth" value="FRACCIONAR" type="button" id="btnFracciona" disabled="disabled" onclick="modal_fraccionamiento()" />


                                                    <!--<input class="btn btn-primary pull-right" value="BOLETA" name="crea" type="button" form="prestacionescrea" id="btnGuardar" onclick="guardarValorizacion()" />-->
                                                </div><!--form-group-->
                                            </div><!--col-->
                                        </div><!--row-->
                                    </div><!--card-body-->
                                </div><!--card-->
                                <br />
                            </div>


                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                                <div class="card">
                                    <div class="card-header">
                                        <strong>
                                            Registro de Pagos
                                        </strong>
                                    </div>


                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblPago" class="table table-hover table-sm">
                                                <thead>
                                                    <tr style="font-size:13px">
                                                        <th>Fecha</th>
                                                        <!--<th>Tipo</th>-->
                                                        <th>Serie</th>
                                                        <th>Numero</th>
                                                        <th>Concepto</th>
                                                        <th class="sum">Monto</th>
                                                        <th>Pago</th>
                                                        <th>Deuda</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>





                        </div>

                    </div><!--col-->


                    <div id="openOverlayOpc" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">

                                <div class="modal-body" style="padding: 0px;margin: 0px">

                                    <div id="diveditpregOpc"></div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
			
			
			<!--
            <form class="form-horizontal" method="post" action="{{route('frontend.comprobante.nc_edita')}}" id="frmPagos" name="frmPagos" autocomplete="off">
                <input type="hidden" name="id_comprobante_" id="id_comprobante_" value="" />
                <input type="hidden" name="id_caja_" id="id_caja_" value="<?php //echo $caja_usuario->id_caja ?>" />
            </form>
			-->


@push('after-scripts')
<script type="text/javascript">
    var id_caja_usuario = "<?php echo ($caja_usuario) ? $caja_usuario->id_caja : 0 ?>";
    //alert(id_caja_usuario);
</script>

@endpush


@push('after-scripts')

<script src="{{ asset('js/ingreso.js') }}"></script>
@endpush