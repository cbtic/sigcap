<!--<link rel="stylesheet" href="<?php //echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<style type="text/css">

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

                        <input type="hidden" name="id_agremiado" id="id_agremiado" value="<?php echo $concursoInscripcion->id?>">
						
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
												
													<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
													
														<div class="row">
															<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
															Tipo de concurso
															</div>
															<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="tipo_concurso" id="tipo_concurso" value="<?php echo $concursoInscripcion->tipo_concurso?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														</div>
														<div class="row">
															<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
															N&deg; CAP
															</div>
															<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_cap" id="numero_cap" value="<?php echo $concursoInscripcion->numero_cap?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
															Nombre
															</div>
															<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="nombres" id="nombres" value="<?php echo $concursoInscripcion->apellido_paterno." ".$concursoInscripcion->apellido_materno." ".$concursoInscripcion->nombres?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														</div>
														<div class="row">
															<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
															DNI
															</div>
															<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_documento" id="numero_documento" value="<?php echo $concursoInscripcion->numero_documento?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
															Regional
															</div>
															<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="region" id="region" value="<?php echo $concursoInscripcion->region?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
															Situaci&oacute;n
															</div>
															<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="situacion" id="situacion" value="<?php echo $concursoInscripcion->situacion?>" class="form-control form-control-sm" readonly="readonly">
															</div>
														</div>
													
													</div>
													
													
													<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
													
														<div class="row">
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px">
															Codigo de Pago
															</div>
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_comprobante" id="numero_comprobante" value="<?php echo $concursoInscripcion->tipo.$concursoInscripcion->serie."-".$concursoInscripcion->numero?>" class="form-control form-control-sm" readonly="readonly">
															</div>
															
														</div>
														
														<div class="row" style="padding:10px 0px 10px 0px">
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																<strong>Documentos</strong>
															</div>
														</div>
														
														<div class="row">	
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												
																	<div class="table-responsive">
																	<table id="tblSolicitud" class="table table-hover table-sm">
																	<thead>
																		<tr style="font-size:13px">
																			<th>N&deg;</th>
																			<th>Tipo de Doc</th>
																			<th>Nombre del documento</th>
																			<th>Fecha</th>
																			<th>Horas Academ</th>
																			<th class="text-center">Archivo</th>
																		</tr>
																	</thead>
																	<tbody style="font-size:13px">
																		<?php //foreach($agremiado_estudio as $row){?>
																		<tr>
																			<th><?php //echo $row->universidad?></th>
																			<th><?php //echo $row->especialidad?></th>
																			<th><?php //echo $row->tesis?></th>
																			<th><?php //echo $row->fecha_egresado?></th>
																			<th><?php //echo $row->fecha_graduado?></th>
																			<th>
								<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
									<button style="font-size:12px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Cargar</button>
								</div>
																			</th>
																		</tr>														
																		<?php //}?>
																	</tbody>							
																	</table>
																	
																</div>
															
															</div>
														</div>
														
														<input class="btn btn-sm btn-success float-rigth" value="GUARDAR" name="guardar" type="button" id="btnGuardar_" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" />
														
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