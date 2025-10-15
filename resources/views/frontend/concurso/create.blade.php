<!--<link rel="stylesheet" href="<?php //echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<style type="text/css">

#tblConcurso tbody tr{
		font-size:13px
}
#tblAfiliado tbody tr{
	font-size:13px
}
.table-sortable tbody tr {
	cursor: move;
}

.row_selected{
	background:#CAE983 !important
}

.table td.verde{
	background:#CAE983 !important
}

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
	float:left
}

br {
    line-height: 30px;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}

ul.ui-autocomplete {
    z-index: 1100;
}

.btn-xsm {
    font-size: 11px !important;
}

/* End - Overriding styles for this page */
/*********************************************************/
.switch {
  position: relative;
  display: inline-block;
  width: 42px;
  height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 0px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.no {padding-right:3px;padding-left:0px;display:block;width:20px;float:left;font-size:11px;text-align:right;padding-top:5px}
.si {padding-right:0px;padding-left:3px;display:block;width:20px;float:left;font-size:11px;text-align:left;padding-top:5px}

.flotante {
    display:inline;
        position:fixed;
        bottom:0px;
        right:0px;
		z-index:1000
}
.flotanteC {
    display:inline;
        position:fixed;
        bottom:65px;
        right:0px;
}

label.form-control-sm{
	padding-left:0px!important;
	padding-right:0px;
	padding-top:5px!important;
	height:25px!important;
	/*line-height:10px!important*/
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

.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
}

.wrapper { 
	/*background:#EFEFEF; */
	/*box-shadow: 1px 1px 10px #999; */
	margin: auto; 
	text-align: center; 
	position: relative;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	margin-bottom: 20px !important;
	width: 800px;
	padding-top: 5px;
}
.scrolls { 
	overflow-x: scroll;
	overflow-y: hidden;
	height: 200px;
	white-space:nowrap
} 
.imageDiv img { 
	box-shadow: 1px 1px 10px #999; 
	margin: 2px;
	max-height: 50px;
	cursor: pointer;
	display:inline-block;
	*display:inline;
	*zoom:1;
	vertical-align:top;
}


.img_ruta{
	position:relative;
	float:left
}

.delete_ruta{
	background-image:url(img/delete.png);
	top:0px;
	left:110px;
	background-size: 100%;
	position:absolute;
	display:block;
	width:30px;
	height:30px;
	cursor:pointer
}

</style>

<script>

function obtenerSubTipoConcurso(callback){
	
	var id_tipo_concurso = $('#id_tipo_concurso').val();
	
	$.ajax({
		url: '/concurso/listar_maestro_by_tipo_subtipo/93/'+id_tipo_concurso,
		dataType: "json",
		success: function(result){
			var option = "<option value='0'>Seleccionar</option>";
			$("#id_sub_tipo").html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.codigo+"'>"+oo.denominacion+"</option>";
			});
			$("#id_sub_tipo").html(option);

			callback();
		}
		
	});
	
	
}

</script>

@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Registro de Solicitud</li>
    </li>
</ol>

@endsection

<div class="loader"></div>

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
	
	<a href="javascript:void(0)" onclick="ocultar_solicitud()"><i class="fa fa-bars fa-lg" style="position:absolute;right:50%;top:-24px;color:#FFFFFF"></i></a>
	
    <div class="card">

        <div class="card-body">
					
			
            <form class="form-horizontal" method="post" action="" id="frmExpediente" autocomplete="off">
				<!--
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="margin-top:15px">
                        <h4 class="card-title mb-0 text-primary" style="font-size:22px">
                            Registro Solicitudes
                        </h4>
                    </div>
                </div>
				-->
                <div class="row justify-content-center" style="margin-top:15px">
					
                    <input type="hidden" name="flag_ocultar" id="flag_ocultar" value="0">
					
					<div class="col col-sm-12 align-self-center">


                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="id_agremiado" id="id_agremiado" value="<?php echo $agremiado->id?>">
						<input type="hidden" name="id_concurso_inscripcion" id="id_concurso_inscripcion" value="0">
						
                        <div class="row" id="divSolicitud">
							
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Registrar al concurso
                                                        </strong>
														
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
												<div style="clear:both"></div>
												
													
														<div class="row">
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															Tipo concurso
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<select name="id_concurso" id="id_concurso" class="form-control form-control-sm" onchange="obtener_datos_concurso();obtenerTipoSubTipo();">
																<option value="">--Selecionar--</option>
																<?php
																foreach ($concurso as $row) {?>
																<option 
																fecha_acreditacion_inicio="<?php echo $row->fecha_acreditacion_inicio?>"
																fecha_acreditacion_fin="<?php echo $row->fecha_acreditacion_fin?>"
																data_tipo_concurso="<?php echo $row->tipo_concurso?>"
																data_sub_tipo_concurso="<?php echo $row->sub_tipo_concurso?>"
																value="<?php echo $row->id?>"><?php echo $row->periodo." - ".$row->tipo_concurso; if($row->sub_tipo_concurso!="")echo " - ".$row->sub_tipo_concurso?></option>
																<?php 
																}
																?>
															</select>
															</div>
														
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															Puesto
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<select name="id_concurso_puesto" id="id_concurso_puesto" class="form-control form-control-sm">
																<option value="">--Selecionar--</option>
															</select>
															</div>
															
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															F. Acreditaci&oacute;n. Inicio
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="fecha_acreditacion_inicio" id="fecha_acreditacion_inicio" value="" class="form-control form-control-sm" readonly="readonly">
															</div>
															
														</div>
														
														<div class="row">
															
														
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															F. Acreditaci&oacute;n. Fin
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="fecha_acreditacion_fin" id="fecha_acreditacion_fin" value="" class="form-control form-control-sm" readonly="readonly">
															</div>
															
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															N&deg; CAP
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_cap" id="numero_cap" value="<?php echo $agremiado->numero_cap?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															Nombre
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="nombres" id="nombres" value="<?php echo $agremiado->apellido_paterno." ".$agremiado->apellido_materno." ".$agremiado->nombres?>" class="form-control form-control-sm" readonly="readonly">
															</div>
															
														</div>
														
														
														<div class="row">
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															DNI
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_documento" id="numero_documento" value="<?php echo $agremiado->numero_documento?>" class="form-control form-control-sm" readonly="readonly">
															</div>
															
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															Regional
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="region" id="region" value="<?php echo $agremiado->region?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															Situaci&oacute;n
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="situacion" id="situacion" value="<?php echo $agremiado->situacion?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														</div>
														
														
														<div class="row">
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px">
															Codigo de Pago
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_comprobante" id="numero_comprobante" value="<?php //echo $agremiado->numero_cap?>" class="form-control form-control-sm" disabled="disabled">
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input class="btn btn-sm btn-success float-rigth" value="GUARDAR" name="guardar" type="button" id="btnGuardar" style="padding-left:25px;padding-right:25px;margin-left:0px;" />
															</div>
														</div>
														
														
													</div>
													
													
													
													
													
													
													
												
											
														
											<div class="card-body">
											
												<div class="row" style="padding:15px 0px 10px 0px">
													<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="padding-top:6px">
														<strong></strong>
													</div>
													
												</div>
												<!--
												<div class="row" style="padding:20px 20px 0px 20px;">
				
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_regional_bus" id="id_regional_bus" class="form-control form-control-sm" >
															<option value="">--Regional--</option>
															<?php
															//foreach ($region as $row) {?>
															<option value="<?php //echo $row->id?>"><?php //echo $row->denominacion?></option>
															<?php 
															//}
															?>
														</select>
													</div>
													<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="numero_cap_bus" name="numero_cap_bus" placeholder="Numero Cap">
													</div>
													<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="numero_documento_bus" name="numero_documento_bus" placeholder="Numero Documento">
													</div>
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="agremiado_bus" name="agremiado_bus" placeholder="Agremiado">
													</div>
													<div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="fecha_inicio_bus" name="fecha_inicio_bus" placeholder="Fecha Desde">
													</div>
													<div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="fecha_fin_bus" name="fecha_fin_bus" placeholder="Fecha Hasta">
													</div>
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_situacion_bus" id="id_situacion_bus" class="form-control form-control-sm" >
															<option value="">--Situaci&oacute;n--</option>
															<?php
															//foreach ($situacion_cliente as $row) {?>
															<option value="<?php //echo $row->codigo?>"><?php //echo $row->denominacion?></option>
															<?php 
															//}
															?>
														</select>
													</div>
													
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
														<input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
												
													</div>
												</div>
												-->
												
												
												<div class="row" style="padding:20px 20px 0px 20px;">
													<!--<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_concurso_bus" id="id_concurso_bus" class="form-control form-control-sm" >
															<option value="">--Concurso--</option>
															<?php
															//foreach ($concursoTotal as $row) {?>
															<option <?php //if($row->id==$concurso_ultimo->id)echo "selected='selected'"?> value="<?php //echo $row->id?>"><?php //echo $row->periodo." - ".$row->tipo_concurso; if($row->sub_tipo_concurso!="")echo " - ".$row->sub_tipo_concurso?></option>
															<?php 
															//}
															?>
														</select>
													</div>-->
													
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select disabled="disabled" name="flag_concurso" id="flag_concurso" class="form-control form-control-sm" >
															<option value="">--Todos los Concursos--</option>
															<option value="1" selected="selected">Concursos Vigentes</option>
															<option value="2">Concursos Pasados</option>
														</select>
													</div>

													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_tipo_concurso" id="id_tipo_concurso" class="form-control form-control-sm" onchange="" >
															<option value="" selected="selected">--Seleccionar Tipo--</option>
															<?php
															foreach ($tipo_concurso as $row) {?>
															<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
															<?php 
															}?>
														</select>
													</div>

													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_sub_tipo" id="id_sub_tipo" class="form-control form-control-sm" onChange="">
															<option value="">--Selecionar Sub Tipo--</option>
														</select>
													</div>
													
													<!--
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_regional_bus" id="id_regional_bus" class="form-control form-control-sm" >
															<option value="">--Regional--</option>
															<?php
															//foreach ($region as $row) {?>
															<option value="<?php //echo $row->id?>"><?php //echo $row->denominacion?></option>
															<?php 
															//}
															?>
														</select>
													</div>
													-->
													
													<!--
													<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="numero_cap_bus" name="numero_cap_bus" placeholder="Numero Cap">
													</div>
													<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
															<input class="form-control form-control-sm" id="numero_documento_bus" name="numero_documento_bus" placeholder="Numero Documento">
													</div>
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="agremiado_bus" name="agremiado_bus" placeholder="Agremiado">
													</div>
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_situacion_bus" id="id_situacion_bus" class="form-control form-control-sm" >
															<option value="">--Situaci&oacute;n--</option>
															<?php
															//foreach ($situacion_cliente as $row) {?>
															<option value="<?php //echo $row->codigo?>"><?php //echo $row->denominacion?></option>
															<?php 
															//}
															?>
														</select>
													</div>
													-->
													
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
														<input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
														<!--<a href="/agremiado" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
													</div>
												</div>

												<div class="table-responsive" style="padding-top:10px">
												<table id="tblConcurso" class="table table-hover table-sm">
													<thead>
													<tr style="font-size:13px">
														<th>Id</th>
														<th>Periodo</th>
														<th>Tipo Concurso</th>
														<th>SubTipo Concurso</th>
														<th>Puesto</th>
														<th>Fecha Inscripci&oacute;n</th>
														<th>Codigo Pago</th>
														<th>Puntaje</th>
														<th>Estado</th>
														<th>Acciones</th>
													</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
												</div><!--table-responsive-->	

												<div class="row">
												
												
												
												
												
												<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
														
														<div class="row" style="padding:15px 0px 10px 0px">
															<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="padding-top:6px">
																<strong>Requisitos</strong>
															</div>
														</div>
														
														<div class="row">	
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												
																	<div class="table-responsive">
																	<table id="tblRequisito" class="table table-hover table-sm">
																	<thead>
																		<tr style="font-size:13px">
																			<!--<th>N&deg;</th>-->
																			<th>Requisito</th>
																			<th>Tipo de Doc</th>
																			<th>Archivo</th>
																		</tr>
																	</thead>
																	<tbody style="font-size:13px">
																	</tbody>							
																	</table>
																	
																</div>
															
															</div>
														</div>
														<!--
														<input class="btn btn-sm btn-success float-rigth" value="GUARDAR" name="guardar" type="button" id="btnGuardar_" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" /> 
														-->
														
														<?php //if(count($documento_pendiente)>0){?>
														<!--
														<div id="divAlertaDocumento" class="alert alert-warning" role="alert" style="font-size:20px">
															
													  		El concurso <?php //echo $row->periodo." ".$row->tipo_concurso;//if($row->sub_tipo_concurso!="")echo " - ".$row->sub_tipo_concurso?> esta pendiente de presentar documentos, haga click en el boton azul Registrar Doc para adjuntar
															
															
															
															<?php 
															//echo "<br>";
															//}
															?>
														</div>
														-->
														<script type="text/javascript">
														var nombre_concurso = "";
														</script>
														<?php 
														if(count($documento_pendiente)>0){
														foreach($documento_pendiente as $row){
														?>
														<script type="text/javascript">
														var c_periodo="<?php echo $row->periodo?>";
														var c_tipo_concurso="<?php echo $row->tipo_concurso?>";
														var c_sub_tipo_concurso="<?php echo $row->sub_tipo_concurso?>";
														nombre_concurso += c_periodo+' '+c_tipo_concurso;
														if(c_sub_tipo_concurso!="")nombre_concurso += " - "+c_sub_tipo_concurso;
														nombre_concurso +=", ";
														
														</script>
														<?php 
														}
														}
														?>	
													</div>
													
													
													<div id="divDocumentos" style="display:none" class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
														
														<div class="row" style="padding:15px 0px 10px 0px">
															<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="padding-top:6px">
																<strong>Registrar Documentos</strong>
															</div>
															<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
																<input class="btn btn-warning pull-rigth" value="Nuevo" type="button" id="btnNuevo" style="margin-left:0px" />
																
																<input class="btn btn-success pull-rigth" value="Traer Req. Guardados" type="button" id="btnDuplicar" style="margin-left:8px" />
																
															</div>
														</div>
														
														<div class="row">	
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												
																	<div class="table-responsive">
																	<table id="tblSolicitud" class="table table-hover table-sm">
																	<thead>
																		<tr style="font-size:13px">
																			<!--<th>N&deg;</th>-->
																			<th>Orden</th>
																			<th>Nombre del documento</th>
																			<th>Tipo de Doc</th>
																			<th>Fecha</th>
																			<th class="text-left">Archivo</th>
																			<th class="text-left">Opc</th>
																		</tr>
																	</thead>
																	<tbody style="font-size:13px">
																	</tbody>							
																	</table>
																	
																</div>
															
															</div>
														</div>
														<!--
														<input class="btn btn-sm btn-success float-rigth" value="GUARDAR" name="guardar" type="button" id="btnGuardar_" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" /> 
														-->
														
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

						

        </div>
        <!--col-->

        </form>

        

    </div>
    <!--row-->
    @endsection

	<div id="openOverlayOpc" class="modal fade" role="dialog">
	  <div class="modal-dialog" >
	
		<div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
		
		  <div class="modal-body" style="padding: 0px;margin: 0px">
	
				<div id="diveditpregOpc"></div>
	
		  </div>
		
		</div>
	
	  </div>
		
	</div>

    @push('after-scripts')
    
	
	<script src="{{ asset('js/concurso/create.js') }}"></script>
	<script>
	
	var c_cantidad_concurso ="<?php echo count($documento_pendiente)?>";
	//var c_periodo="<?php //echo $row->periodo?>";
	//var c_tipo_concurso="<?php //echo $row->tipo_concurso?>";
	//var c_sub_tipo_concurso="<?php //echo $row->sub_tipo_concurso?>";
	/*
	var id_ubigeo_nacimiento = $("#id_ubigeo_nacimiento").val();
	var idProvincia = id_ubigeo_nacimiento.substring(2,4);
	var idDistrito = id_ubigeo_nacimiento.substring(4,6);
	obtenerProvinciaEdit(idProvincia);
	obtenerDistritoEdit(idProvincia,idDistrito);
	
	var id_ubigeo_domicilio = $("#id_ubigeo_domicilio").val();
	var idProvinciaDomiciliario = id_ubigeo_domicilio.substring(2,4);
	var idDistritoDomiciliario = id_ubigeo_domicilio.substring(4,6);
	obtenerProvinciaDomiciliarioEdit(idProvinciaDomiciliario);
	obtenerDistritoDomiciliarioEdit(idProvinciaDomiciliario,idDistritoDomiciliario);
	*/
	</script>
	@endpush