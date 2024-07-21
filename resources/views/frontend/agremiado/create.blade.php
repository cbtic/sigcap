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
	display:inline;
	zoom:1;
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

                        <input type="hidden" name="id_agremiado" id="id_agremiado" value="<?php echo $id?>">
						<input type="hidden" name="id_persona" id="id_persona" value="<?php echo $id_persona?>">
						
                        <div class="row" id="divSolicitud">
							
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Datos Generales
                                                        </strong>
														
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
												<div style="clear:both"></div>
												
												<div class="row">
												
													<div class="col-lg-11 col-md-12 col-sm-12 col-xs-12">
													<div class="row">
													
													<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															N&deg; CAP
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_cap" id="numero_cap" value="<?php echo $agremiado->numero_cap?>" class="form-control form-control-sm" <?php if($id!=0)echo "readonly='readonly'"?> >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Libro
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="libro_nacional" id="libro_nacional" value="<?php echo $agremiado->libro_nacional?>" class="form-control form-control-sm" <?php if($id!=0)?>>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															N&deg; Regional
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_regional" id="numero_regional" value="<?php echo $agremiado->numero_regional?>" class="form-control form-control-sm" <?php if($id!=0)?>>
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Libro
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="libro" id="libro" value="<?php echo $agremiado->libro?>" class="form-control form-control-sm" >
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Regional
															</div>
															<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
															<select name="id_regional" id="id_regional" class="form-control form-control-sm" onchange="obtenerLocal()">
																<option value="">--Selecionar--</option>
																<?php
																foreach ($region as $row) {?>
																<option value="<?php echo $row->id?>" <?php if($row->id==$agremiado->id_regional)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
																<?php 
																}
																?>
															</select>
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Tipo de Documento
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" onchange="">
																<option value="">--Selecionar--</option>
																<?php
																foreach ($tipo_documento as $row) {?>
																<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$persona->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
																<?php 
																}
																?>
															</select>
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															N&deg; Doc
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_documento" id="numero_documento" value="<?php echo $persona->numero_documento?>" class="form-control form-control-sm" <?php if($id!=0)echo "readonly='readonly'"?>>
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Ap. Paterno
															</div>
															<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="apellido_paterno" id="apellido_paterno" value="<?php echo $persona->apellido_paterno?>" class="form-control form-control-sm" >
															</div>
														</div>
														
													</div>
													
													<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Folio
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="folio_nacional" id="folio_nacional" value="<?php echo $agremiado->folio_nacional?>" class="form-control form-control-sm" <?php if($id!=0)echo "readonly='readonly'"?>>
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Fecha Colegiado
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="fecha_colegiado" id="fecha_colegiado" value="<?php echo ($agremiado->fecha_colegiado!="")?date("d-m-Y",strtotime($agremiado->fecha_colegiado)):""?>" class="form-control form-control-sm" <?php if($id!=0)echo "disabled='disabled'"?> >
															
															
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Folio
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="folio" id="folio" value="<?php echo $agremiado->folio?>" class="form-control form-control-sm" >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Fecha Actualiza
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="fecha_actualiza" id="fecha_actualiza" value="<?php echo ($agremiado->fecha_actualiza!="")?date("d-m-Y",strtotime($agremiado->fecha_actualiza)):""?>" class="form-control form-control-sm" <?php echo "disabled='disabled'"?>>
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Zonal
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<select name="id_local" id="id_local" class="form-control form-control-sm">
																<option value="">--Selecionar--</option>
															</select>
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Grupo Sang
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<select name="grupo_sanguineo" id="grupo_sanguineo" class="form-control form-control-sm" onchange="">
																<option value="">--Selecionar--</option>
																<?php
																foreach ($grupo_sanguineo as $row) {?>
																<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$persona->grupo_sanguineo)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
																<?php 
																}
																?>
															</select>
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															N&deg; RUC
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="numero_ruc" id="numero_ruc" value="<?php echo $persona->numero_ruc?>" class="form-control form-control-sm" >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Estado Civil
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<select name="id_estado_civil" id="id_estado_civil" class="form-control form-control-sm" onchange="">
																<option value="">--Selecionar--</option>
																<?php
																foreach ($estado_civil as $row) {?>
																<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$agremiado->id_estado_civil)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
																<?php 
																}
																?>
															</select>
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Ap. Materno
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="apellido_materno" id="apellido_materno" value="<?php echo $persona->apellido_materno?>" class="form-control form-control-sm" >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Nombres
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="nombres" id="nombres" value="<?php echo $persona->nombres?>" class="form-control form-control-sm" >
															</div>
														</div>
														
													</div>
													
												</div>
												
												</div>
												
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
													<!--
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															Fotografia
														</div>
													</div>	
													-->
													<div class="row">
									
													<div class="form-group">
														
													<span class="btn btn-sm btn-warning btn-file">
														Examinar <input id="image" name="image" type="file" />
													</span>
													<input type="button" class="btn btn-sm btn-primary upload" value="Subir" style="margin-left:0px">
													<?php
														$img = "/img/logo-sin-fondo2.png";
								if($persona->foto!="")$img="/img/agremiado/".$persona->foto;
													?>
													<a href="/img/agremiado/<?php echo $persona->foto?>" target="_blank" class="btn btn-sm btn-secondary"><img src="<?php echo $img?>" id="img_ruta" width="80" height="50" alt="" style="margin-top:10px" /></a>
													<input type="hidden" id="img_foto" name="img_foto" value="" />
													
													<!--
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<a href="{{ route('frontend.index') }}" class="navbar-brand">
															<img src="<?php echo URL::to('/') ?>/img/logo_1.jpg" alt="" width="80" height="50" style="padding:0px;margin:0px">
														</a>
													</div>
													-->
												</div>
														
														<input class="btn btn-sm btn-success float-rigth" value="GUARDAR" name="guardar" type="button" id="btnGuardar" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" />
														
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

					
					<div style="clear:both;padding-top:15px"></div>
					
					<div class="card">
					
					<nav>
						<div class="nav nav-pills" id="nav-tab" role="tablist">
							<a
								class="nav-link active"
								id="my-profile-tab"
								data-toggle="pill"
								href="#my-profile"
								role="tab"
								aria-controls="my-profile"
								aria-selected="true">Datos Generales</a>
							<!--
							<a
								class="nav-link"
								id="two-factor-authentication-tab_"
								data-toggle="pill"
								href="#two-factor-authentication_"
								role="tab"
								aria-controls="two-factor-authentication_"
								aria-selected="false"
								>Trabajo</a>
							-->
							<a
								class="nav-link"
								id="information-tab"
								data-toggle="pill"
								href="#information"
								role="tab"
								aria-controls="information"
								aria-selected="false"
								>Estudio</a>
							
							<a
								class="nav-link"
								id="seguimiento-tab"
								data-toggle="pill"
								href="#seguimiento"
								role="tab"
								aria-controls="seguimiento"
								aria-selected="false"
								>Familiares</a>

							<a
								class="nav-link"
								id="two-factor-authentication-tab"
								data-toggle="pill"
								href="#two-factor-authentication"
								role="tab"
								aria-controls="two-factor-authentication"
								aria-selected="false">Exp. Profesional</a>
							
							<a
								class="nav-link"
								id="traslado-tab"
								data-toggle="pill"
								href="#traslado"
								role="tab"
								aria-controls="traslado"
								aria-selected="false">Traslados</a>
								
							<a
								class="nav-link"
								id="situacion-tab"
								data-toggle="pill"
								href="#situacion"
								role="tab"
								aria-controls="situacion"
								aria-selected="false">Viaje Extranjero</a>

							<a
								class="nav-link"
								id="roles-tab"
								data-toggle="pill"
								href="#roles"
								role="tab"
								aria-controls="traslado"
								aria-selected="false">Roles</a>
							
						</div>
					</nav>
									
					<div class="tab-content" id="my-profile-tabsContent">
						<div class="tab-pane fade pt-3 show active" id="my-profile" role="tabpanel" aria-labelledby="my-profile-tab" style="padding-top:0px!important">
							
							<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Datos de Nacimiento
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Fecha Nac.
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo ($persona->fecha_nacimiento!="")?date("d-m-Y",strtotime($persona->fecha_nacimiento)):""?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Edad
												</div>
												<?php
												/*
												$edad = "";
												if($persona->fecha_nacimiento!=""){
													$fecha_actual = date('Y-m-d');
													$fecha_nacimiento = $persona->fecha_nacimiento;
													$dateDifference = abs(strtotime($fecha_nacimiento) - strtotime($fecha_actual));
													$edad  = floor($dateDifference / (365 * 60 * 60 * 24));
												}
												*/
												?>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="edad" id="edad" readonly="readonly" value="<?php echo $edad?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Sexo
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_sexo" id="id_sexo" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($sexo as $row) {?>
													<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$persona->id_sexo)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Departamento
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="hidden" name="id_ubigeo_nacimiento" id="id_ubigeo_nacimiento" value="<?php echo $persona->id_ubigeo_nacimiento?>">
												<select name="id_departamento" id="id_departamento" class="form-control form-control-sm" onchange="obtenerProvincia()">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($departamento as $row) {?>
													<option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($persona->id_ubigeo_nacimiento,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Provincia
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_provincia" id="id_provincia" class="form-control form-control-sm" onchange="obtenerDistrito()">
													<option value="">--Selecionar--</option>
												</select>
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Distrito
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_distrito" id="id_distrito" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
												</select>
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Lugar
												</div>
												<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="lugar_nacimiento" id="lugar_nacimiento" value="<?php echo $persona->lugar_nacimiento?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Nacionalidad
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_nacionalidad" id="id_nacionalidad" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($nacionalidad as $row) {?>
													<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$persona->id_nacionalidad)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												
											</div>
											
												
										</div>
										
										
									</div>		
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Datos Domiciliario
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Departamento
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												
												<input type="hidden" name="id_ubigeo_domicilio" id="id_ubigeo_domicilio" value="<?php echo $agremiado->id_ubigeo_domicilio?>">
												<select name="id_departamento_domiciliario" id="id_departamento_domiciliario" class="form-control form-control-sm" onchange="obtenerProvinciaDomiciliario()">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($departamento as $row) {?>
													<option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($agremiado->id_ubigeo_domicilio,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Provincia
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_provincia_domiciliario" id="id_provincia_domiciliario" class="form-control form-control-sm" onchange="obtenerDistritoDomiciliario()">
													<option value="">--Selecionar--</option>
												</select>
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Distrito
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_distrito_domiciliario" id="id_distrito_domiciliario" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
												</select>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Direcci&oacute;n
												</div>
												<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="direccion" id="direccion" value="<?php echo $agremiado->direccion?>" class="form-control form-control-sm" >
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												C&oacute;digo Postal
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="codigo_postal" id="codigo_postal" value="<?php echo $agremiado->codigo_postal?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Referencia
												</div>
												<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="referencia" id="referencia" value="<?php echo $agremiado->referencia?>" class="form-control form-control-sm" >
												</div>
												
											</div>
												
										</div>
										
										
									</div>
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Otros
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Telefono Fijo
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="telefono1" id="telefono1" value="<?php echo $agremiado->telefono1?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Telefono Celular
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="celular1" id="celular1" value="<?php echo $agremiado->celular1?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Correo Electronico
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="email1" id="email1" value="<?php echo $agremiado->email1?>" class="form-control form-control-sm" >
												</div>
												</div>
												<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="telefono2" id="telefono2" value="<?php echo $agremiado->telefono2?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="celular2" id="celular2" value="<?php echo $agremiado->celular2?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="email2" id="email2" value="<?php echo $agremiado->email2?>" class="form-control form-control-sm" >
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Informaci&oacute;n Adicional
												</div>
												<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="informacion_adicional" id="informacion_adicional" value="<?php echo $agremiado->informacion_adicional?>" class="form-control form-control-sm" >
												</div>
												
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Inf. Confidencial
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
													<div class="form-group">
													<label class="radio-inline">
													  <input type="radio" name="flag_confidencial" value="1" <?php if($agremiado->flag_confidencial==1)echo "checked='checked'"?>> &nbsp; Si &nbsp;
													</label>
													<label class="radio-inline">
													  <input type="radio" name="flag_confidencial" value="2" <?php if($agremiado->flag_confidencial==2)echo "checked='checked'"?>> &nbsp; No &nbsp;
													</label>
													</div>
												</div>
												
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												AFP
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_seguro_social" id="id_seguro_social" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($seguro_social as $row) {?>
													<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$agremiado->id_seguro_social)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Direcci&oacute;n de correspondencia
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
													<div class="form-group">
														<label class="radio-inline">
														  <input type="radio" name="flag_correspondencia" value="1" <?php if($agremiado->flag_correspondencia==1)echo "checked='checked'"?>> Domicilio
														</label>
														<label class="radio-inline">
														  <input type="radio" name="flag_correspondencia" value="2" <?php if($agremiado->flag_correspondencia==2)echo "checked='checked'"?>> Trabajo
														</label>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Clave
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="clave" id="clave" value="<?php echo $agremiado->clave?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Act. Gremial
												</div>
												<div class="col-lg-1-5 col-md-12 col-sm-12 col-xs-12">
												<select name="id_actividad_gremial" id="id_actividad_gremial" class="form-control form-control-sm" onchange="validarSituacion()">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($actividad_gremial as $row) {?>
													<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$agremiado->id_actividad_gremial)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
													<input class="btn btn-success" value="Suspension" type="button" id="btnSuspension" style="margin-left:0px"/>
													
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Ubicacion
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_ubicacion" id="id_ubicacion" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($ubicacion_cliente as $row) {?>
													<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$agremiado->id_ubicacion)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Aut. Tramite
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_autoriza_tramite" id="id_autoriza_tramite" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($autoriza_tramite as $row) {?>
													<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$agremiado->id_autoriza_tramite)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Categoria
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="id_categoria" id="id_categoria" class="form-control form-control-sm" onchange="habilitarCategoriaTemporal()">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($categoria_cliente as $row) {?>
													<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$agremiado->id_categoria)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Situaci&oacute;n
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="hidden" name="id_situacion_tmp" id="id_situacion_tmp" value="<?php echo $agremiado->id_situacion?>" >
												<select name="id_situacion" id="id_situacion" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($situacion_cliente as $row) {?>
													<option value="<?php echo $row->codigo?>" 
													<?php if($id!=0 && $row->codigo==$agremiado->id_situacion)echo "selected='selected'"?>
													<?php if($id==0 && $row->codigo==74)echo "selected='selected'"?>
													><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Otro
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="desc_situacion_otro" id="desc_situacion_otro" value="<?php echo $agremiado->desc_situacion_otro?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Fecha Fallec.
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="fecha_fallecido" id="fecha_fallecido" value="<?php echo ($agremiado->fecha_fallecido!="")?date("d-m-Y",strtotime($agremiado->fecha_fallecido)):""?>" class="form-control form-control-sm" >
												</div>
											</div>
											
											<div id="divCategoriaTemporal" class="row" style="padding-top:5px;<?php echo (isset($agremiado->id_categoria) && $agremiado->id_categoria==91)?"":"display:none"?>">
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												F. Inicio Temp.
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="fecha_inicio_temp" id="fecha_inicio_temp" value="<?php echo ($agremiado->fecha_inicio_temp!="")?date("d-m-Y",strtotime($agremiado->fecha_inicio_temp)):""?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												F. Fin Temp.
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="fecha_fin_temp" id="fecha_fin_temp" value="<?php echo ($agremiado->fecha_fin_temp!="")?date("d-m-Y",strtotime($agremiado->fecha_fin_temp)):""?>" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Obser. Temp.
												</div>
												<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
												<textarea type="text" name="observacion_temp" id="observacion_temp" rows="1" placeholder="" class="form-control form-control-sm"><?php echo $agremiado->observacion_temp?></textarea>
												</div>
											</div>
											
													
										</div>
										
										
									</div>
		
								</div>
						
							</div>
							
						</div>

						<div class="tab-pane fade pt-3" id="information" role="tabpanel" aria-labelledby="information-tab">
							
							<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Estudios Realizados
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
											<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoEstudio" style="width:120px;margin-right:15px"/>
											
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												
													<div class="card-body">
									
														<div class="table-responsive">
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>Universidad</th>
																<th>Especialidad</th>
																<th>Titulo de Tesis</th>
																<th>F. Egresado</th>
																<th>F. Graduado</th>
																<th>Libro</th>
																<th>Folio</th>
																<th>Opciones</th>
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<?php foreach($agremiado_estudio as $row){?>
															<tr>
																<th><?php echo $row->universidad?></th>
																<th><?php echo $row->especialidad?></th>
																<th><?php echo $row->tesis?></th>
																<th><?php echo $row->fecha_egresado?></th>
																<th><?php echo $row->fecha_graduado?></th>
																<th><?php echo $row->libro?></th>
																<th><?php echo $row->folio?></th>
																<th>
					<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
					<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
					<a href="javascript:void(0)" onclick="eliminarEstudio(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
					</div>
																</th>
															</tr>														
															<?php }?>
														</tbody>							
														</table>
														
													</div>
													
												</div>
												
												</div>
											</div>
											
												
										</div>
										
										
									</div>		
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Idiomas
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoIdioma" style="width:120px;margin-right:15px"/>
											
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												
													<div class="card-body">
									
														<div class="table-responsive">
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>Idioma</th>
																<th>Grado Conocimiento</th>
																<th>Opciones</th>
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<?php foreach($agremiado_idioma as $row){?>
															<tr>
																<th><?php echo $row->idioma?></th>
																<th><?php echo $row->grado?></th>
																<th>
					<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
					<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalIdioma(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
					<a href="javascript:void(0)" onclick="eliminarIdioma(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
					</div>
																</th>
															</tr>						
															<?php }?>
														</tbody>							
														</table>
														
														</div>
													
													</div>
												
												</div>
												
											</div>
												
										</div>
										
										
									</div>
									
								</div>
						
							</div>
							
							
						</div>
						
						<div class="tab-pane fade pt-3" id="seguimiento" role="tabpanel" aria-labelledby="information-tab">
						 
						 	<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Datos Familiares
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
											<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoParentesco" style="width:120px;margin-right:15px"/>
											
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												
													<div class="card-body">
									
														<div class="table-responsive">
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>Parentesco</th>
																<th>Sexo</th>
																<th>Apellidos y Nombres</th>
																<th>F.Nacimiento</th>
																<th>Opciones</th>
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<?php foreach($agremiado_parentesco as $row){?>
															<tr>
																<th><?php echo $row->parentesco?></th>
																<th><?php echo $row->sexo?></th>
																<th><?php echo $row->apellido_nombre?></th>
																<th><?php echo $row->fecha_nacimiento?></th>
																<th>
					<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
					<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalParentesco(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
					<a href="javascript:void(0)" onclick="eliminarParentesco(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
					</div>
																</th>
															</tr>						
															<?php }?>
														</tbody>							
														</table>
														
														</div>
													
													</div>
												
												</div>
												
											</div>
												
										</div>
										
										
									</div>
		
									
								</div>
								
							</div>
							
						 
						</div>

						<div class="tab-pane fade pt-3" id="two-factor-authentication" role="tabpanel" aria-labelledby="two-factor-authentication-tab">
							
							<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Trabajos
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
											<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoTrabajo" style="width:120px;margin-right:15px"/>
											
											<div style="clear:both"></div>
											
											<div class="row">
											
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																								
													<div class="card-body">
									
														<div class="table-responsive">
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>Ruc</th>
																<th>Centro Trabajo</th>
																<th>Rubro</th>
																<th>Cargo</th>
																<th>Departamento</th>
																<th>Provincia</th>
																<th>Distrito</th>
																<th>Direcci&oacute;n</th>
																<th>Referencia</th>
																<!--<th>C.Postal</th>-->
																<th>Tel&eacute;fono</th>
																<th>Celular</th>
																<th>Correo</th>
																<th>Opciones</th>
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<?php foreach($agremiado_trabajo as $row){?>
															<tr>
																<th><?php echo $row->numero_documento?></th>
																<th><?php echo $row->razon_social?></th>
																<th><?php echo $row->rubro_negocio?></th>
																<th><?php echo $row->cargo?></th>
																<th><?php echo $row->departamento?></th>
																<th><?php echo $row->provincia?></th>
																<th><?php echo $row->distrito?></th>
																<th><?php echo $row->direccion?></th>
																<th><?php echo $row->referencia?></th>
																<!--<th><?php //echo $row->codigo_postal?></th>-->
																<th><?php echo ($row->telefono!="0" || $row->telefono!="")?$row->telefono:"-"?></th>
																<th><?php echo $row->celular?></th>
																<th><?php echo $row->email?></th>
																<th>
					<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
					<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalTrabajo(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
					<a href="javascript:void(0)" onclick="eliminarTrabajo(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
					</div>
																</th>
															</tr>						
															<?php }?>
														</tbody>							
														</table>
														
														</div>
													
												</div>
														
												</div>
												
											</div>
											
											
												
										</div>
										
										
									</div>
		
								</div>
						
							</div>
							
						</div>

						
						
						<div class="tab-pane fade pt-3" id="traslado" role="tabpanel" aria-labelledby="traslado-tab">
							
							<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Traslados
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
											<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoTraslado" style="width:120px;margin-right:15px"/>
											
											<div style="clear:both"></div>
											
											<div class="row">
											
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																								
													<div class="card-body">
									
														<div class="table-responsive">
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>Regional</th>
																<th>N&uacute;mero Regional</th>
																<th>Fecha Inicio</th>
																<th>Fecha Fin</th>
																<th>Observaci&oacute;n</th>
																<th>Opciones</th>
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<?php foreach($agremiado_traslado as $row){?>
															<tr>
																<th><?php echo $row->region?></th>
																<th><?php echo $row->numero_regional?></th>
																<th><?php echo $row->fecha_inicio?></th>
																<th><?php echo $row->fecha_fin?></th>
																<th><?php echo $row->observacion?></th>
																<th>
					<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
					<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalTraslado(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
					<a href="javascript:void(0)" onclick="eliminarTraslado(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
					</div>
																</th>
															</tr>						
															<?php }?>
														</tbody>							
														</table>
														
														</div>
													
												</div>
														
												</div>
												
											</div>
											
											
												
										</div>
										
										
									</div>
		
								</div>
						
							</div>
							
						</div>

						<div class="tab-pane fade pt-3" id="roles" role="tabpanel" aria-labelledby="roles-tab">
							
							<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Roles
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
											<!--
											<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoRol" style="width:120px;margin-right:15px"/>
											-->
											<div style="clear:both"></div>
											
											<div class="row">
											
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																								
													<div class="card-body">
									
														<div class="table-responsive">
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>Id</th>
																<th>Rol</th>
																<th>Rol Espec&iacute;fico</th>
																<th>Fecha Inicio</th>
																<th>Fecha Fin</th>
																<th>Observaci&oacute;n</th>
																<!--<th>Opciones</th>-->
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<?php foreach($agremiado_rol as $row){?>
															<tr>
																<th><?php echo $row->id?></th>
																<th><?php echo $row->tipo_concurso//rol?></th>
																<th><?php echo $row->puesto//rol_especifico?></th>
																<th><?php echo $row->fecha_acreditacion_inicio//fecha_inicio?></th>
																<th><?php echo $row->fecha_acreditacion_fin//fecha_fin?></th>
																<th><?php //echo $row->observacion?></th>
																<!--<th>-->
															<!--<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
															<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalRol(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
															<a href="javascript:void(0)" onclick="eliminarRol(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
															</div>-->
																<!--</th>-->
															</tr>						
															<?php }?>
														</tbody>							
														</table>
														
														</div>
													
												</div>
														
												</div>
												
											</div>
											
											
												
										</div>
										
										
									</div>
		
								</div>
						
							</div>
							
						</div>
						
						<div class="tab-pane fade pt-3" id="situacion" role="tabpanel" aria-labelledby="situacion-tab">
							
							<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Viaje Extranjero
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoSituacion" style="width:120px;margin-right:15px"/>
											
											<div style="clear:both"></div>
											
											<div class="row">
											
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																								
													<div class="card-body">
									
														<div class="table-responsive">
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>N&uacute;mero Resoluci&oacute;n</th>
																<th>Fecha Inicio</th>
																<th>Fecha Fin</th>
																<th>Pa&iacute;s</th>
																<th>Opciones</th>
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<?php foreach($agremiado_situacion as $row){?>
															<tr>
																<th><?php echo $row->ruta_documento?></th>
																<th><?php echo $row->fecha_inicio?></th>
																<th><?php echo $row->fecha_fin?></th>
																<th><?php echo $row->pais?></th>
																<th>
					<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
					<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalSituacion(<?php echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
					<a href="javascript:void(0)" onclick="eliminarSituacion(<?php echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
					</div>
																</th>
															</tr>
															<?php }?>
														</tbody>							
														</table>
														
														</div>
													
												</div>
														
												</div>
												
											</div>
											
											
												
										</div>
										
										
									</div>
		
								</div>
						
							</div>
							
						</div>
						
						<div class="tab-pane fade pt-3" id="two-factor-authentication_" role="tabpanel" aria-labelledby="two-factor-authentication-tab_" style="padding-top:0px!important">
							
							<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Datos de Nacimiento
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Fecha Nac.
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Edad
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Sexo
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Departamento
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													//foreach ($estado_expediente as $row) {?>
													<option value="<?php //echo $row->codigo?>"><?php //echo $row->denominacion?></option>
													<?php 
													//}
													?>
												</select>
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Provincia
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Distrito
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Lugar
												</div>
												<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Nacionalidad
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($nacionalidad as $row) {?>
													<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												
											</div>
											
												
										</div>
										
										
									</div>		
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Datos Domiciliario
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Departamento
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Provincia
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Distrito
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Direcci&oacute;n
												</div>
												<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												C&oacute;digo Postal
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Referencia
												</div>
												<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												
											</div>
												
										</div>
										
										
									</div>
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Otros Datos trabajo
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Telefono Fijo
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Telefono Celular
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Correo Electronico
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											
											
												
										</div>
										
										
									</div>
		
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
    
	
	<script src="{{ asset('js/agremiado/create.js') }}"></script>
	<script>

		var id_regional = "<?php echo $agremiado->id_regional?>";
		var id_local = "<?php echo $agremiado->id_local?>";
		var id_agremiado = "<?php echo $id?>"; 
		
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