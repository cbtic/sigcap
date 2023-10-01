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

                        <input type="hidden" name="id_expediente" id="id_expediente" value="">
						
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
															<input type="text" name="numero_cap" id="numero_cap" value="<?php echo $agremiado->numero_cap?>" class="form-control form-control-sm" >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Libro
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
														</div>
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															N&deg; Regional
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Libro
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Regional
															</div>
															<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
															<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
																<option value="">--Selecionar--</option>
																<?php
																foreach ($region as $row) {?>
																<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
																<?php 
																}
																?>
															</select>
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Documento
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
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
															<input type="text" name="numero_documento" id="numero_documento" value="<?php echo $persona->numero_documento?>" class="form-control form-control-sm" >
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
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Fecha Colegiado
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Folio
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Fecha Actualiza
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Zona
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
																<option value="">--Selecionar--</option>
																<?php
																foreach ($tipo_zona as $row) {?>
																<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
																<?php 
																}
																?>
															</select>
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Grupo Sang
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
														</div>
														
														<div class="row">
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															N&deg; RUC
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															Estado Civil
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
																<option value="">--Selecionar--</option>
																<?php
																foreach ($estado_civil as $row) {?>
																<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
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
															Nombre
															</div>
															<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
															<input type="text" name="nombres" id="nombres" value="<?php echo $persona->nombres?>" class="form-control form-control-sm" >
															</div>
														</div>
														
													</div>
													
												</div>
												
												</div>
												
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
													
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															Fotografia
														</div>
													</div>	
														
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<a href="{{ route('frontend.index') }}" class="navbar-brand">
																<img src="<?php echo URL::to('/') ?>/img/logo_1.jpg" alt="" width="80" height="50" style="padding:0px;margin:0px">
															</a>
														</div>
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
								
							<a
								class="nav-link"
								id="two-factor-authentication-tab_"
								data-toggle="pill"
								href="#two-factor-authentication_"
								role="tab"
								aria-controls="two-factor-authentication_"
								aria-selected="false"
								>Trabajo</a>

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
								id="two-factor-authentication-tab"
								data-toggle="pill"
								href="#two-factor-authentication"
								role="tab"
								aria-controls="two-factor-authentication"
								aria-selected="false">Traslados</a>
								
							<a
								class="nav-link"
								id="two-factor-authentication-tab"
								data-toggle="pill"
								href="#two-factor-authentication"
								role="tab"
								aria-controls="two-factor-authentication"
								aria-selected="false">Viaje Extranjero</a>
							
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
												<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($sexo as $row) {?>
													<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
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
												<select name="id_departamento" id="id_departamento" class="form-control form-control-sm" onchange="obtenerProvincia()">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($departamento as $row) {?>
													<option value="<?php echo $row->id_departamento?>"><?php echo $row->desc_ubigeo ?></option>
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
												<select name="id_departamento_domiciliario" id="id_departamento_domiciliario" class="form-control form-control-sm" onchange="obtenerProvinciaDomiciliario()">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($departamento as $row) {?>
													<option value="<?php echo $row->id_departamento?>"><?php echo $row->desc_ubigeo ?></option>
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
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												C&oacute;digo Postal
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
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Informaci&oacute;n Adicional
												</div>
												<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Inf. Confidencial
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												AFP
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($seguro_social as $row) {?>
													<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Direcci&oacute;n de correspondencia
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Clave
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Act. Gremial
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($actividad_gremial as $row) {?>
													<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Ubicacion
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($ubicacion_cliente as $row) {?>
													<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Aut. Tramite
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($autoriza_tramite as $row) {?>
													<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
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
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Situacion
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<select name="estado_exp" id="estado_exp" class="form-control form-control-sm" onchange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($situacion_cliente as $row) {?>
													<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
													<?php 
													}
													?>
												</select>
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Otro
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
												Fecha Fallecido
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

						<div class="tab-pane fade pt-3" id="information" role="tabpanel" aria-labelledby="information-tab">
							
							<div class="row" style="padding-top:0px">

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Datos Empresa
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												RUC
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Modalidad
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
											</div>
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Centro trabajo
												</div>
												<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
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
												
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Rubro Negocio
												</div>
												<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
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
												
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Cargo
												</div>
												<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
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
												
											</div>
											
												
										</div>
										
										
									</div>		
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Datos Domicilio trabajo
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
											</div>
											
											<div class="row">
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												Referencia
												</div>
												<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
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
												C&oacute;digo Postal
												</div>
												<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
												<input type="text" name="anio" id="anio" value="" class="form-control form-control-sm" >
												</div>
												
											</div>
												
										</div>
										
										
									</div>
									<!--
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
									-->
									
									<div class="card">
										<div class="card-header">
											<div id="" class="row">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<strong>
														Otros Estudios
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
											
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																								
													<div class="card-body">
									
														<div class="table-responsive">
														<!--table-hover-grid-->
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>Estudio</th>
																<th>Grado Conocimiento</th>
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<tr>
																<th>OTROS ESTUDIOS</th>
																<th>INTERMEDIO</th>
															</tr>														
															<tr>
																<th>OTROS ESTUDIOS</th>
																<th>INTERMEDIO</th>
															</tr>														
															<tr>
																<th>OTROS ESTUDIOS</th>
																<th>INTERMEDIO</th>
															</tr>
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

								<div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
		
									<div class="card-body">
									
										<div class="table-responsive">
											<input type="hidden" name="idSeguimiento" id="idSeguimiento" value="0">
											<table id="tblSeguimiento" class="table table-hover table-sm">
											<thead>
											<tr style="font-size:13px">
												<th>Fecha seguimiento</th>
												<th>Observaci&oacute;n</th>
												<th>Fecha proximo seguimiento</th>
												<th>Estado</th>
											</tr>
											</thead>
											<tbody style="font-size:13px">
											</tbody>
											</table>
											
										</div>
								
									</div>
								</div>
								
								<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
									
									<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoSeg" style="width:120px;margin-right:15px"/>
									
									<br />
												
									<input class="btn btn-sm btn-danger float-right" value="ELIMINAR" name="guardar" type="button" id="btnEliminarSeg" style="width:120px;margin-top:20px;margin-right:15px" />
												
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
														Traslados
													</strong>
													
												</div>
											</div>
										</div>

										<div class="card-body" style="margin-top:15px;margin-bottom:15px">
										
											<div style="clear:both"></div>
											
											<div class="row">
											
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																								
													<div class="card-body">
									
														<div class="table-responsive">
														<!--table-hover-grid-->
														<table id="tblSolicitud" class="table table-hover table-sm">
														<thead>
															<tr style="font-size:13px">
																<th>Regional</th>
																<th>Numero Regional</th>
																<th>Fecha Inicio</th>
																<th>Fecha Fin</th>
																<th>Observaci&oacute;n</th>
															</tr>
														</thead>
														<tbody style="font-size:13px">
															<tr>
																<th>REGIONAL LIMA</th>
																<th>8239</th>
																<th>28/02/1969</th>
																<th>28/02/1969</th>
																<th>Obs</th>
															</tr>
															<tr>
																<th>REGIONAL LIMA</th>
																<th>8239</th>
																<th>28/02/1969</th>
																<th>28/02/1969</th>
																<th>Obs</th>
															</tr>
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
	
	@endpush