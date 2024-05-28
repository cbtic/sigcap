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

                        <input type="hidden" name="id_agremiado" id="id_agremiado" value="<?php //echo $agremiado->id?>">
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
                                                            Resultado de concurso
                                                        </strong>
														
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
												<div style="clear:both"></div>
												
												<div class="row">
													
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														Tipo de concurso
													</div>
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<input type="text" name="tipo_concurso" id="tipo_concurso" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Fecha Acreditaci&oacute;n Inicio
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="fecha_delegatura_inicio" id="fecha_delegatura_inicio" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Fecha Acreditaci&oacute;n Fin
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="fecha_delegatura_fin" id="fecha_delegatura_fin" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>
														
												<div class="row">
													
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														N&deg; CAP
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="numero_cap" id="numero_cap" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Nombre
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="nombres" id="nombres" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														DNI
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="numero_documento" id="numero_documento" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>
												
												<div class="row">
												
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Regional
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="region" id="region" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
														
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Situaci&oacute;n
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="situacion" id="situacion" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Puesto
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="puesto" id="puesto" value="" class="form-control form-control-sm" readonly="readonly">
													</div>
												</div>
														
												<div class="row">
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Puntaje
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<input type="text" name="puntaje" id="puntaje" value="" class="form-control form-control-sm">
													</div>
														
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Estado
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<select name="id_estado" id="id_estado" class="form-control form-control-sm">
															<option value="">--Selecionar--</option>
															<option value="Ingreso">Ingreso</option>
															<option value="No Ingreso">No Ingreso</option>
														</select>
													</div>
													
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														Asignar Plaza
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
														<select name="asignar_puesto" id="asignar_puesto" class="form-control form-control-sm">
															<option value="">--Selecionar--</option>
														</select>
													</div>
													
													<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12"></div>
													
													<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12" style="padding-top:15px"> 
													
														<div class="row">
															
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
																<input class="btn btn-success float-rigth" value="GUARDAR" name="guardar" type="button" id="btnGuardar" style="padding-left:25px;padding-right:25px;" />
															</div>

														</div>
														
													</div>
													
													<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="padding-top:15px">
													
													<div class="row" style="margin-left:0px">

														<input class="btn btn-sm btn-secondary float-rigth" value="Descargar Plantilla" name="descargar" type="button" id="btnDescargar" style="padding-left:15px;padding-right:15px;margin-right:10px;" /> 
														
														<input class="btn btn-sm btn-danger float-rigth" value="Descargar Documentos" name="descargar" type="button" id="btnDescargarComprimido" style="padding-left:15px;padding-right:15px;margin-right:10px;" /> 
														
														<span class="btn btn-warning btn-file" style="float:left">
															Examinar <input id="image" name="image" type="file" />
														</span>
														
														<i id="fileExcel" class="fa fa-file-excel" style="display:none;color:#00B300;font-size:35px;block;float:left;padding-left:10px"></i>
														
														<input type="button" class="btn btn-primary upload" value="Subir" style="margin-left:10px;float:left">
														
														<input type="hidden" id="img_foto" name="img_foto" value="" />
														
													</div>
													
												</div>
													
												</div>
													
													
													
													
													
												</div>
												
											</div>
											
											<div class="row" style="padding:20px 20px 0px 20px;">
													<!--
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_concurso_bus" id="id_concurso_bus" class="form-control form-control-sm" >
															<option value="">--Concurso--</option>
															<?php
															//foreach ($concurso as $row) {?>
															<option <?php //if($row->id==$concurso_ultimo->id)echo "selected='selected'"?> value="<?php //echo $row->id?>"><?php //echo $row->periodo." - ".$row->tipo_concurso; if($row->sub_tipo_concurso!="")echo " - ".$row->sub_tipo_concurso?></option>
															<?php 
															//}
															?>
														</select>
													</div>
													-->
													
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
													<?php 
													if($periodo_activo){
													?>
													<input type="hidden" name="id_periodo_bus" id="id_periodo_bus" value="<?php echo $periodo_activo->id?>">
													<select name="id_periodo_bus_" id="id_periodo_bus_" class="form-control form-control-sm" onChange="obtenerComision()" disabled="disabled">
														<option value="">--Periodo--</option>
														<?php
														foreach ($periodo as $row) {?>
														<option value="<?php echo $row->id?>" <?php if($row->id==$periodo_activo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
														<?php 
														}
														?>
													</select>
													<?php
													}else{
													?>
													<select name="id_periodo_bus" id="id_periodo_bus" class="form-control form-control-sm" onChange="obtenerComision()">
														<option value="">--Periodo--</option>
														<?php
														foreach ($periodo as $row) {?>
														<option value="<?php echo $row->id?>" <?php if($row->id==$periodo_ultimo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
														<?php 
														}
														?>
													</select>
													<?php } ?>
												</div>
												
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
													<select name="id_tipo_concurso_bus" id="id_tipo_concurso_bus" class="form-control form-control-sm" onChange="obtenerSubTipoConcursoBus()">
														<option value="">--TIPO CONCURSO--</option>
														<?php
														foreach ($tipo_concurso as $row) {?>
														<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$concurso->id_tipo_concurso)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
														<?php 
														}
														?>
													</select>
												</div>
												
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
													<select name="id_sub_tipo_concurso_bus" id="id_sub_tipo_concurso_bus" class="form-control form-control-sm" onchange="obtenerRoEspecifico()">
														<option value="">--SUBTIPO CONCURSO--</option>
													</select>
												</div>
													
													<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="numero_cap_bus" name="numero_cap_bus" placeholder="Numero Cap">
													</div>
													<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
															<input class="form-control form-control-sm" id="numero_documento_bus" name="numero_documento_bus" placeholder="Numero Documento">
													</div>
													<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
														<input class="form-control form-control-sm" id="agremiado_bus" name="agremiado_bus" placeholder="Agremiado">
													</div>
												</div>
												
												<div class="row" style="padding:10px 20px 0px 20px;">
												
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_situacion_bus" id="id_situacion_bus" class="form-control form-control-sm" >
															<option value="">--Situaci&oacute;n--</option>
															<?php
															foreach ($situacion_cliente as $row) {?>
															<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
															<?php 
															}
															?>
														</select>
													</div>
													
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<select name="id_puesto_bus" id="id_puesto_bus" class="form-control form-control-sm">
															<option value="">--Puesto--</option>
															<?php
															foreach ($puesto as $row) {?>
															<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$concurso->id_tipo_concurso)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
															<?php 
															}
															?>
														</select>
													</div>
													
													<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
														<select name="id_estado_bus" id="id_estado_bus" class="form-control form-control-sm">
															<option value="">--Estado--</option>
															<option value="Ingreso">Ingreso</option>
															<option value="No Ingreso">No Ingreso</option>
														</select>
													</div>
													
													<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
														<select name="campo" id="campo" class="form-control form-control-sm">
															<option value="t1.id">--Campo--</option>
															<option value="t2.numero_cap::int">CAP</option>
															<option value="t3.apellido_paterno||'' ''||t3.apellido_materno||'' ''||t3.nombres">Nombre</option>
															<option value="t1.puntaje">Puntaje</option>
														</select>
													</div>
													
													<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
														<select name="orden" id="orden" class="form-control form-control-sm">
															<option value="desc">Descendente</option>
															<option value="asc">Ascendente</option>
														</select>
													</div>
													
													<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
														<input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
														<!--<a href="/agremiado" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
													</div>
												</div>
											
											<div class="card-body">				

												<div class="table-responsive">
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
														<th>N&deg; CAP</th>
														<th>N&deg; DNI</th>
														<th>Nombre</th>
														<th>Situaci&oacute;n</th>
														<th>Puntaje</th>
														<th>Estado</th>
														<th class="text-center">Acciones</th>
													</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
												</div><!--table-responsive-->	

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
    
	
	<script src="{{ asset('js/concurso/create_concurso.js') }}"></script>
	<script>
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