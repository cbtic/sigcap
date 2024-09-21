<!--<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--
<script src="<?php echo URL::to('/') ?>/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/adminlte.min.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/demo.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/js.util.grid.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link media="all" type="text/css" rel="stylesheet" href="https://app-gsf.saludpol.gob.pe:29692/css/datatables/dataTables.bootstrap.min.css">
<script src="https://app-gsf.saludpol.gob.pe:29692/js/datatables/datatables.min.js"></script>

<!--<script src="<?php echo URL::to('/') ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>-->
<!--<script src="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>-->

<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->

<link rel="stylesheet"
    href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" type="text/css"
    href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    var urlApp = "<?php echo URL::to('/') ?>";
    //alert(urlApp);

if (history.forward(1)) {
	location.replace(history.forward(1));
}

$(document).ready(function() {

    $('#addFiltro').on('click', function () {
        var addFiltro = $('#addFiltro').attr("aria-pressed");
        $("#fsFiltro").hide();
        if(addFiltro == "false"){
            $("#fsFiltro").show();
        }
    });
});

function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

<style type="text/css">
body {
    background-color: #bdc3c7;
}

.table-fixed {
    width: 100%;
    background-color: #f3f3f3;
}

.table-fixed tbody {
    height: 200px;
    overflow-y: auto;
    width: 100%;
}

.table-fixed thead,
.table-fixed tbody,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
    display: block;
}

.table-fixed tbody td {
    float: left;
}

.table-fixed thead tr th {
    float: left;
    background-color: #f39c12;
    border-color: #e67e22;
}
.btn-xsm {
    font-size: 11px !important;
}

/* Begin - Overriding styles for this page */
.card-body {
    padding: 0 1.25rem !important;
}

.form-control-sm {
    line-height: 1.1 !important;
    margin: 0 !important;
}

.form-group {
    margin-bottom: 0.5rem !important;
}

.breadcrumb {
    padding: 0.2rem 2rem !important;
    margin-bottom: 0 !important;
}

.card-header {
    padding: 0.2rem 1.25rem !important;
}

.pesajeIngreso {
    line-height: 2.8;
}

.fecha_ingreso_salida {
    color: blue;
    font-size: 14px;
    font-style: italic;
}

br {
    line-height: 30px;
}
.flotante {
    display:inline;
        position:fixed;
        bottom:0px;
        right:0px;
}
.flotanteC {
    display:inline;
        position:fixed;
        bottom:65px;
        right:0px;
}

.loader {
	width: 100%;
	height: 100%;
	/*height: 1500px;*/
	overflow: hidden; 
	top: 0px;
	left: 0px;
	z-index: 10000;
	text-align: center;
	position:absolute; 
	background-color: #000;
	opacity:0.6;
	filter:alpha(opacity=40);
	display:none;
}

.dataTables_processing {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 500px!important;
	font-size: 1.7em;
	border: 0px;
	margin-left: -17%!important;
	text-align: center;
	background: #3c8dbc;
	color: #FFFFFF;
}

</style>


@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app1')

@section('title', app_name() . ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Facturacion</li>
    <li class="breadcrumb-item active">Editar</li>
    </li>
</ol>
@endsection

@section('content')

<div class="loader"></div>

<div class="justify-content-center">
    <!--<div class="container-fluid">-->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        <?php echo $titulo ?>
                        <!--Edita Factura-->
                        <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div>
                <!--col-->
            </div>
            <div class="row justify-content-center">
                <div class="col col-sm-12 align-self-center">
                    <form class="form-horizontal" method="post" action="{{ route('frontend.factura.create')}} "
                        id="frmFacturacion" name="frmFacturacion" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="trans" id="trans" value="<?php echo $trans;?>">
                        <input type="hidden" name="TipoF" value="<?php if ($trans == 'FA'){echo $TipoF;}?>">
                        <input type="hidden" name="vestab" value="1">
                        <input type="hidden" name="totalF" value="<?php if ($trans == 'FA'){echo $total;}?>">
                        <input type="hidden" name="ubicacion" value="<?php if ($trans == 'FA'){echo $ubicacion;}?>">
                        <input type="hidden" name="persona" value="<?php if ($trans == 'FA'){echo $persona;}?>">
                        <input type="hidden" name="id_caja" value="<?php if ($trans == 'FA'){echo $id_caja;}?>">
                        <input type="hidden" name="MonAd" value="<?php if ($trans == 'FA'){echo $MonAd;}?>">
                        <input type="hidden" name="adelanto" value="<?php if ($trans == 'FA'){echo $adelanto;}?>">
                        <input type="hidden" name="id_factura" value="<?php if ($trans == 'FE'){echo $facturas->id;}?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Datos del Cliente
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fsFiltro" class="card-body" >
                                                <div id="" class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Serie</label>
                                                            <select name="serieF" id="serieF" class="form-control form-control-sm">
                                                                <?php if ($trans == 'FA'||$trans == 'FN'){?>
                                                                    <?php foreach($serie as $row):?>
                                                                        <option value="<?php echo $row->denominacion?>"><?php echo $row->denominacion?></option>
                                                                    <?php  endforeach;?>
                                                                <?php } ?>
                                                                <?php if ($trans == 'FE'){?>
                                                                    <option value="<?php echo $facturas->fac_serie?>"><?php echo $facturas->fac_serie?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12"name="divNumeroF" id="divNumeroF">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Número</label>
                                                            <input type="text" name="numerof" readonly
                                                                id="numerof" value="<?php if ($trans == 'FE'){echo $facturas->fac_numero;}?>"
                                                                placeholder="" class="form-control form-control-sm text-center"  >
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Fecha Emisión</label>
                                                            <?php if ($trans == 'FA'||$trans == 'FN'){?>
                                                                <input type="text" name="fechaF" id="fechaF" value="<?php echo date("d/m/Y")?>"
                                                                placeholder="" class="form-control form-control-sm datepicker">
                                                            <?php } ?>
                                                            <?php if ($trans == 'FE'){?>
                                                                <input type="text" name="fechaFE" id="fechaFE" value="<?php echo date("d/m/Y", strtotime($facturas->fac_fecha)) ?>"
                                                                placeholder="" class="form-control form-control-sm text-center" readonly>
                                                            <?php } ?>
                                                            <!--{!!Form::date('name', \Carbon\Carbon::now())!!} -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <label class="form-control-sm">RUC/DNI</label>
                                                            <div class="input-group">
                                                            <input type="text" name="numero_documento"  readonly
                                                                id="numero_documento" value="<?php if ($trans == 'FA'){echo $empresa->ruc;} if ($trans == 'FE'){echo $facturas->fac_cod_tributario;} ?>"
                                                                placeholder="" class="form-control form-control-sm">
                                                            </div>
                                                            <button type="button" data-toggle="modal"
                                                                            data-target="#duenoCargaModal" id=""
                                                                            class="btn btn-link btn-xsm">Buscar Empresa</button>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Razón Social/Nombre</label>
                                                            <input type="text" name="numero_documento" readonly
                                                                id="numero_documento" value="<?php if ($trans == 'FA'){echo $empresa->razon_social;} if ($trans == 'FE'){echo $facturas->fac_destinatario;}?>"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Dirección</label>
                                                            <input type="text" name="direccion" readonly
                                                                id="numero_documento" value="<?php if ($trans == 'FA'){echo $empresa->direccion;} if ($trans == 'FE'){echo $facturas->fac_direccion;}?>"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Email</label>
                                                            <input type="text" name="direccion" readonly
                                                                id="numero_documento" value="<?php if ($trans == 'FA'){echo $empresa->email;} if ($trans == 'FE'){echo $facturas->fac_correo_des;}?>"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row" style="display:none">
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Tipo de Operación</label>
                                                            <select name="tipo_documento" id="serieF"
                                                                class="form-control form-control-sm"
                                                                onchange="validaTipoDocumento()">
                                                                <option
                                                                    value="ft">
                                                                    <?php echo "Venta Interna"?></option>
                                                                <option
                                                                    value="bl">
                                                                    <?php echo "Exportación"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Orden Compra</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Solicitante</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row" style="display:none">
                                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Serie GR</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Número GR</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Tipo Guia</label>
                                                            <select name="tipo_documento" id="serieF"
                                                                class="form-control form-control-sm"
                                                                onchange="validaTipoDocumento()">
                                                                <option
                                                                    value="ft">
                                                                    <?php echo "Venta Interna"?></option>
                                                                <option
                                                                    value="bl">
                                                                    <?php echo "Exportación"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Serie TR</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Número TR</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Tipo Documento</label>
                                                            <select name="tipo_documento" id="serieF"
                                                                class="form-control form-control-sm"
                                                                onchange="validaTipoDocumento()">
                                                                <option
                                                                    value="ft">
                                                                    <?php echo "Venta Interna"?></option>
                                                                <option
                                                                    value="bl">
                                                                    <?php echo "Exportación"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                </div>
                                <br>

                                <div id="" class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>
                                                    <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                    Detalle Resumen
                                                    <?php
                                                    if ($trans == 'FN'){?>
                                                        <button type="button" id="addRow" style="margin-left:10px" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Agregar Item(s)</button>
                                                    <?php } ?>
                                                </strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive overflow-auto" style="max-height: 500px;">
                                                    <table id="tblDetalle" class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-right" width="5%">#</th>
                                                                <th class="text-center" width="10%">Cant.</th>
                                                                <th width="40%">Descripción</th>
                                                                <th width="40%">%Dscto.</th>
                                                                <th class="text-right" width="15%">PU</th>
                                                                <th class="text-right" width="15%">IGV</th>
                                                                <th class="text-right" width="15%">P.Venta</th>
                                                                <th class="text-right" width="15%">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $n = 0;
															$smodulo = "";
                                                            if ($trans == 'FA' || $trans == 'FE'){?>
                                                                <?php foreach($facturad as $key=>$fac){ 
																		$smodulo = $fac['smodulo'];
																?>
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][vestab]" value="<?php echo $fac['vestab']?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][vcodigo]" value="<?php echo $fac['vcodigo']?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][modulo]" value="<?php echo $fac['modulo']?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][denominacion]" value="<?php echo $fac['denominacion']?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][smodulo]" value="<?php echo $fac['smodulo']?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][cantidad]" value="<?php echo $fac['cantidad']?>" />

                                                                    <input type="hidden" name="facturad[<?php echo $key?>][subtotal]" value="<?php if ($trans == 'FA') {if ($adelanto == 'S'){echo ($MonAd-$MonAd*0.18);} else {echo $fac['valor_venta_bruto'];}}?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][igv]" value="<?php if ($trans == 'FA') {if ($adelanto == 'S'){echo ($MonAd*0.18);} else {echo $fac['igv'];}}?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][total]" value="<?php if ($trans == 'FA') {if ($adelanto == 'S'){echo $MonAd;} else {echo $fac['total'];}}?>" />

                                                                    <input type="hidden" name="facturad[<?php echo $key?>][plancontable]" value="<?php echo $fac['plancontable']?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][descuento_item]" value="<?php echo $fac['descuento_item']?>" />
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][descuento]" value="<?php echo $fac['descuento']?>" />
                                                                    <tr>
                                                                        <td class="text-right"><?php $n = $n + 1; echo $n;?></td>
                                                                        <td class="text-center"><?php if ($trans == 'FA'){echo $fac['cantidad'];}if ($trans == 'FE'){echo $fac['facd_cantidad'];}?></td>
                                                                        <td class="text-left">
																		<?php 
																		if ($trans == 'FA'){
																			echo $fac['denominacion'];
																		}if ($trans == 'FE'){
																			echo $fac['facd_descripcion'];
																		}?>
																		</td>
                                                                        <td class="text-left"><?php if ($trans == 'FA'){echo $fac['descuento'];}if ($trans == 'FE'){echo $fac['facd_descuento'];}?></td>

                                                                        <td class="text-right"><?php if ($trans == 'FA') {if ($adelanto == 'S'){echo ($MonAd-$MonAd*0.18);} else {echo $fac['precio_venta'];}} if ($trans == 'FE'){echo number_format($fac['facd_importe'],2);} ?></td>
                                                                        <td class="text-right"><?php if ($trans == 'FA') {if ($adelanto == 'S'){echo ($MonAd*0.18);} else {echo $fac['igv'];}} if ($trans == 'FE'){echo number_format($fac['facd_igv_total'],2);} ?></td>
                                                                        <td class="text-right"><?php if ($trans == 'FA') {if ($adelanto == 'S'){echo ($MonAd-$MonAd*0.18);} else {echo $fac['valor_venta'];}} if ($trans == 'FE'){echo number_format($fac['facd_pu'],2);} ?></td>
                                                                        <td class="text-right" ><?php if ($trans == 'FA') {if ($adelanto == 'S'){echo $MonAd;} else {echo $fac['total'];}} if ($trans == 'FE'){echo number_format($fac['facd_importe'],2);} ?></td>

                                                                        <?php
                                                                        if ($trans == 'FN'){?>
                                                                            <td class="text-center">
                                                                                <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Editar Factura</b>">
                                                                                    <a href="/editar_receta_vale/1" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Anular Factura</b>">
                                                                                    <a href="/ver_receta_atendida/1/" class="btn btn-danger btn-xs"><i class="fa fa-xing"></i></a>
                                                                                </div>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                    <input type="hidden" name="facturad[<?php echo $key?>][item]" value="<?php echo $n?>" />
                                                                <?php } ?>
                                                            <?php } ?>
															
															<input type="hidden" name="smodulo_guia" id="smodulo_guia" value="<?php echo $smodulo?>" />
															
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--table-responsive-->
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                    <!--card-->
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>
                                                <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                Información de Pago
                                            </strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="tblPago" class="table table-hover">
                                                    <tbody>
                                                        <tr style="display:none">
                                                            <th></th>
                                                            <th>Anticipos</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span
                                                                    id="anticipos"></span> 0.00</th>
                                                        </tr>
                                                        <tr style="display:none">
                                                            <th></th>
                                                            <th>Descuentos</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span
                                                                    id="descuentos"></span> 0.00</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>Ope Gravadas</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span
                                                                    id="gravadas"></span> <?php if ($trans == 'FA'){echo number_format($stotal,2);} if ($trans == 'FE'){echo number_format($facturas->fac_subtotal,2);}?></th>
                                                        </tr>
                                                        <tr style="display:none">
                                                            <th></th>
                                                            <th>Ope Inafectas</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span
                                                                    id="inafectas"></span> 0.00</th>
                                                        </tr>
                                                        <tr style="display:none">
                                                            <th></th>
                                                            <th>Ope Exoneradas</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span
                                                                    id="exoneradas"></span> 0.00</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>I.G.V.</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span
                                                                    id="igv"></span> <?php if ($trans == 'FA'){echo number_format($igv,2);} if ($trans == 'FE'){echo number_format($facturas->fac_impuesto,2);}?></th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>Total--</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th class="text-right"><span
                                                                    id="totalP"></span> <?php if ($trans == 'FA'){echo number_format($total,2);} if ($trans == 'FE'){echo number_format($facturas->fac_total,2);}?></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--table-responsive-->
                                        </div>
                                        <!--card-body-->
                                    </div>
                                    <!--card-->
                                    </div>
                                </div>

                                <br>

                                <div id="" class="row" >
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Cobros y Vencimientos
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fsFiltro" class="card-body" >
                                                <div id="" class="row">
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Estado de Pago</label>
                                                            <select name="tipo_documento" id="serieF"
                                                                class="form-control form-control-sm"
                                                                onchange="validaTipoDocumento()">
                                                                <option
                                                                    value="P">
                                                                    <?php echo "Pendiente"?></option>
                                                                <option
                                                                    value="C">
                                                                    <?php echo "Cancelado"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">F. Pago</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Fecha Vence</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">F. Recepción</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Forma de Pago</label>
                                                            <select name="tipo_documento" id="serieF"
                                                                class="form-control form-control-sm"
                                                                onchange="validaTipoDocumento()">
                                                                <option
                                                                    value="P">
                                                                    <?php echo "Transferencia Bancaria"?></option>
                                                                <option
                                                                    value="C">
                                                                    <?php echo "Cancelado"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Condición de Pago</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">F. Programado</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
										
										
										<?php if($smodulo == 32){?>
                                        <div class="card" style="margin-top:15px">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Datos de la Guia
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fsFiltro" class="card-body" >
                                                <div id="" class="row">
                                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Direcci&oacute;n del punto de llegada</label>
															<input type="text" name="guia_llegada_direccion" id="guia_llegada_direccion" value="" placeholder="" class="form-control form-control-sm">
														</div>
													</div>
												</div>
											</div>
										</div>					
										<?php } ?>
															
															
										
										
										
										
                                    </div>
                                    <!--card-->
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Impuestos
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fsFiltro" class="card-body" >
                                                <div id="" class="row">
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Descuento Global</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Tipo de Cambio</label>
                                                            <input type="text" name="direccion"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Monto de Percepción</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm"></label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Monto Total</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Sujeto a Detracción</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm"></label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Afecta a:</label>
                                                            <select name="tipo_documento" id="serieF"
                                                                class="form-control form-control-sm"
                                                                onchange="validaTipoDocumento()">
                                                                <option
                                                                    value="">
                                                                    <?php echo ""?></option>
                                                                <option
                                                                    value="004">
                                                                    <?php echo "Recursos hidrobiológicos"?></option>
                                                                <option
                                                                    value="017">
                                                                    <?php echo "Harina, polvo y (pellets) de pescado, crustáceos,   moluscos y demás invertebrados acuáticos"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                </div>
								
								
								
								
                            </div>
                        </div>
                                <a class='flotante' name="guardar" id="guardar" onclick="guardarFactura()" href='#' ><img src='/img/btn_save.png' border="0"/></a>
                                <!--<a class='flotante' name="guardar" id="guardar" onclick="validaNumeroComprobante()" href='#' ><img src='/img/btn_save.png' border="0"/></a>-->

                                <!-- <a class='flotante' href='#' ><img src='/img/deshacer.png' border="0"/></a>-->
                        <br>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="duenoCargaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['id' => 'modalNuevoDuenoCargaForm','url' => route('frontend.chofer'), 'autocomplete'
                    =>
                    'off'] )
                    !!}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Buscar Datos del Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-body">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <!-- Option: EMPRESA -->
                                            {{ Form::label('empresa', 'EMPRESA', ['class' => 'control-label']) }}

                                            {{ Form::radio('empresa_particular', 'empresa', 1, ['id' => 'empresa', 'onclick' => 'javascript:$("#modalNuevoDuenoCargaSaveBtn").removeClass("btn-success").addClass("btn-primary");$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");$("#numero_ruc_dni").val("");$("#persona_nuevo_dueno_carga").val("");$("#numero_ruc_dni").attr("placeholder", "Escriba el RUC");$("#empresa_nuevo_dueno_carga").attr("style", "display:block");$("#persona_nuevo_dueno_carga").attr("style", "display:none");$("#modalNuevoEmpresaPersonaBtn").attr("style", "display:none")']) }}

                                            <!-- Option: PARTICULAR -->
                                            {{ Form::label('particular', 'PARTICULAR', ['class' => 'control-label']) }}

                                            {{ Form::radio('empresa_particular', 'particular', 0, ['id' => 'particular', 'onclick' => 'javascript:$("#modalNuevoDuenoCargaSaveBtn").removeClass("btn-success").addClass("btn-primary");$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");$("#numero_ruc_dni").val("");$("#empresa_nuevo_dueno_carga").val("");$("#numero_ruc_dni").attr("placeholder", "Escriba el DNI/PTP/PASAPORTE/CEDULA");$("#persona_nuevo_dueno_carga").attr("style", "display:block");$("#empresa_nuevo_dueno_carga").attr("style", "display:none");$("#modalNuevoEmpresaPersonaBtn").attr("style", "display:none")']) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::number('numero_ruc_dni', old('numero_ruc_dni') , ['id' => 'numero_ruc_dni', 'oninput' => 'javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);', 'maxlength' => 11, 'class' => 'form-control form-control-sm', 'placeholder' => 'Escriba el RUC']) }}
                                        </div>
                                        <p>o ingrese</p>
                                        <div class="form-group">
                                            {{ Form::text('empresa_nuevo_dueno_carga', old('empresa_nuevo_dueno_carga'), ['id' => 'empresa_nuevo_dueno_carga', 'class' => 'form-control form-control-sm', 'placeholder' => 'Escriba la Razón Social']) }}
                                            {{ Form::text('persona_nuevo_dueno_carga', old('persona_nuevo_dueno_carga'), ['id' => 'persona_nuevo_dueno_carga', 'class' => 'form-control form-control-sm', 'style' => 'display:none', 'placeholder' => 'Escriba los Apellidos de la persona']) }}
                                        </div>
										<div class="input-group" id="empresa_nuevo_dueno_carga_busqueda"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        {!! Form::button('Cancelar', ['id' => 'modalNuevoDuenoCargaCancelBtn', 'class' => 'btn
                        btn-secondary', 'data-dismiss' => 'modal']) !!}
                        {!! Form::button('Buscar', ['id' => 'modalNuevoDuenoCargaSaveBtn', 'class' => 'btn
                        btn-primary'])
                        !!}
                        {!! Form::button('Nueva ', ['id' => 'modalNuevoEmpresaPersonaBtn', 'class' => 'btn btn-warning',
                        'style' => 'display:none'])
                        !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--ModalEnd-->
    </div>

    <!--row-->
    @endsection

    @push('after-scripts')
    {!! script(asset('js/factura.js')) !!}
    @if(config('access.captcha.contact'))
    @captchaScripts
    @endif
    @endpush
