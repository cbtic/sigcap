<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->

<style>
	#tblAfiliado tbody tr{
		font-size:13px
	}
    .table-sortable tbody tr {
        cursor: move;
    }
	#global {
        height: 650px !important;
        width: auto;
        border: 1px solid #ddd;
		margin:15px
    }
	
    .margin{

        margin-bottom: 20px;
    }
    .margin-buscar{
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .clickable{
        cursor: pointer;   
    }
    .panel-body{
        display: block;
    }
	
	.dataTables_filter {
	   display: none;
	}

.loader {
	width: 100%;
	height: 100%;
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
/*
.form-control:disabled, .form-control[readonly]{
	background-color:#fff3cd!important;
	border-color:#ffecb5!important;
	color:#664d03!important;
	opacity:1
}
*/
/*.form-control:disabled, .form-control[readonly]{
	background-color:#cff4fc!important;
	border-color:#b6effb!important;
	color:#055160!important;
	opacity:1
}*/

</style>

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Registro de Solicitud de Derecho de Revisi&oacute;n - HU</li>
        </li>
    </ol>
@endsection

@section('content')

<div class="loader"></div>

    <div class="justify-content-center">
        
        <div class="card">

        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        Registro de Solicitud de Derecho de Revisi&oacute;n - HU<!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Datos Generales del Proyecto
                    </strong>
                </div>
				
				<div class="card-body">
			<form method="post" action="#" id="frmSolicitudDerechoRevision" name="frmSolicitudDerechoRevision">
			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<!--<input type="hidden" name="id" id="id" value="<?php //echo $id?>">-->
					
					<div class="row" style="padding-left:10px">

						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Solicitante</label>
								<select name="tipo_solicitante" id="tipo_solicitante" class="form-control form-control-sm" onchange="obtenerSolicitante()">
									<option value="" selected="selected">--Seleccionar--</option>
									<option value="1">Proyectista</option>
									<option value="2">Responsable de Tramite</option>
									<option value="3">Administrado / Propietario</option>
									<!--<option value="">--Selecionar--</option>
									<?/*php
										foreach ($tipo_solicitante as $row) {*/?>
									<option value="<?php /*echo $row->id*/?>" <?php/* if($row->id==$derecho_revision->id_solicitante)echo "selected='selected'"*/?>><?php /*echo $row->denominacion*/?></option>
									<?php
									/*}*/
									?>-->
								</select>
							</div>
						</div>
					
						<div class="col-lg-1">
							<div class="form-group" id="numero_cap_">
								<label class="control-label form-control-sm">N° CAP</label>
								<input id="numero_cap" name="numero_cap" on class="form-control form-control-sm"  value="<?php echo $agremiado->numero_cap?>" type="text" onchange="obtenerProyectista()">
							</div>
							<div class="form-group" id="dni_">
								<label class="control-label form-control-sm">DNI</label>
								<input id="dni" name="dni" on class="form-control form-control-sm"  value="<?php echo $persona->numero_documento?>" type="text" onchange="obtenerProyectista()">
							</div>
						</div>

						<div class="col-lg-3" >
							<div class="form-group "id="agremiado_">
								<label class="control-label form-control-sm">Nombre</label>
								<input id="agremiado" name="agremiado" on class="form-control form-control-sm"  value="<?php echo $persona->nombre?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="persona_">
								<label class="control-label form-control-sm">Nombre/Raz&oacute;n Social</label>
								<input id="persona" name="persona" on class="form-control form-control-sm"  value="<?php echo $persona->nombres?>" type="text" readonly='readonly'>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group" id="situacion_">
								<label class="control-label form-control-sm">Situaci&oacute;n</label>
								<input id="situacion" name="situacion" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_situacion?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="fecha_nacimiento_">
								<label class="control-label form-control-sm">Fecha de Nacimiento</label>
								<input id="fecha_nacimiento" name="fecha_nacimiento" on class="form-control form-control-sm"  value="<?php echo $persona->fecha_nacimiento?>" type="text" readonly='readonly'>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group" id="direccion_agremiado_">
								<label class="control-label form-control-sm">Direcci&oacute;n</label>
								<input id="direccion_agremiado" name="direccion_agremiado" on class="form-control form-control-sm"  value="<?php echo $persona->direccion?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="direccion_persona_">
								<label class="control-label form-control-sm">Direcci&oacute;n</label>
								<input id="direccion_persona" name="direccion_persona" on class="form-control form-control-sm"  value="<?php echo $persona->direccion?>" type="text" readonly='readonly'>
							</div>
						</div>

						<div class="col-lg-1-5">
							<div class="form-group" id="n_regional_">
								<label class="control-label form-control-sm">N° Regional</label>
								<input id="n_regional" name="n_regional" on class="form-control form-control-sm"  value="<?php echo $agremiado->numero_regional?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="celular_">
								<label class="control-label form-control-sm">Celular</label>
								<input id="celular" name="celular" on class="form-control form-control-sm"  value="<?php echo $persona->numero_celular?>" type="text" readonly='readonly'>
							</div>
						</div>

                    </div>
                    <div class="row" style="padding-left:10px">
                    
						<div class="col-lg-2">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Actividad Gremial</label>
								<input id="act_gremial" name="act_gremial" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="email_">
								<label class="control-label form-control-sm">Email</label>
								<input id="email" name="email" on class="form-control form-control-sm"  value="<?php echo $persona->correo?>" type="text" readonly='readonly'>
							</div>
						</div>
					</div>

					<div style="padding: 0px 0px 15px 10px; font-weight: bold">
						Datos del Proyecto
					</div>
					<div class="row" style="padding-left:10px">

						<div class="col-lg-3">
								<label class="control-label form-control-sm">Nombre del Proyecto</label>
								<input id="nombre_proyecto" name="nombre_proyecto" on class="form-control form-control-sm"  value="<?php echo $proyecto->nombre?>" type="text">
						</div>

						<div class="col-lg-2">
								<label class="control-label form-control-sm">Municipalidad</label>
								<select name="municipalidad" id="municipalidad" class="form-control form-control-sm" onChange=""> 
									<option value="">--Selecionar--</option>
									<?php
										foreach ($municipalidad as $row) {
									?>
									<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option> <?php } ?>
								</select>
						</div>

						<div class="col-lg-1">
                            <label class="control-label form-control-sm">N° de Revisi&oacute;n</label>
                            <select name="n_revision" id="n_revision" class="form-control form-control-sm">
                                <option value="" selected="selected">--Seleccionar--</option>
								<option value="1">1</option>
                                <option value="3">3</option>
								<option value="5">5</option>
							</select>
						</div>

						<div class="col-lg-2">
                            <label class="control-label form-control-sm">Departamento</label>
                            <select name="departamento" id="departamento" class="form-control form-control-sm" onChange="obtenerProvincia()">
                                <option value="">--Selecionar--</option>
                                <?php
                                foreach ($departamento as $row) {?>
                                <option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($persona->id_ubigeo_nacimiento,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                                <?php 
                                }
                                ?>
                            </select>
						</div>
					
						<div class="col-lg-2">
                            <label class="control-label form-control-sm">Provincia</label>
                            <select name="provincia" id="provincia" class="form-control form-control-sm" onChange="obtenerDistrito()">
                                <option value="">--Selecionar--</option>
                            </select>
						</div>
                        

						<div class="col-lg-2">
                            <label class="control-label form-control-sm">Distrito</label>
                            <select name="distrito" id="distrito" class="form-control form-control-sm" onChange="">
                                <option value="">--Selecionar--</option>
                            </select>
                        </div>
                    </div>
					<div class="row" style="padding-left:10px">
						<div class="col-lg-1" style=";padding-right:15px">
                            <label class="control-label form-control-sm">Sitio</label>
                            <select name="sitio" id="sitio" class="form-control form-control-sm" onChange="">
                                <option value="">--Selecionar--</option>
                                <?php
                                foreach ($sitio as $row) {?>
                                <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto->id_tipo_sitio)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php
                                }
                                ?>
                            </select>
						</div>

						<div class="col-lg-1" style="padding-left:15px">
                            <label class="control-label form-control-sm">Zona</label>
                            <select name="zona" id="zona" class="form-control form-control-sm" onChange="">
                                <option value="">--Selecionar--</option>
                                <?php
                                foreach ($zona as $row) {?>
                                <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto->manzana)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php
                                }
                                ?>
                            </select>
						</div>

						<div class="col-lg-1">
                            <label class="control-label form-control-sm">Parcela</label>
                            <input id="parcela" name="parcela" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
						</div>

						<div class="col-lg-1">
                            <label class="control-label form-control-sm">SuperManzana</label>
                            <input id="superManzana" name="superManzana" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
						</div>
					
						<div class="col-lg-1">
                            <label class="control-label form-control-sm">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control form-control-sm" onChange="">
                                <option value="">--Selecionar--</option>
                                <?php
                                foreach ($tipo as $row) {?>
                                <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto->numero)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php
                                }
                                ?>
                            </select>
						</div>
					
						<div class="col-lg-3">
                            <label class="control-label form-control-sm">Direccion</label>
                            <input id="direccion_proyecto" name="direccion_proyecto" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
						</div>

						<div class="col-lg-1">
                            <label class="control-label form-control-sm">Lote</label>
                            <input id="lote" name="lote" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
						</div>

						<div class="col-lg-1">
                            <label class="control-label form-control-sm">SubLote</label>
                            <input id="sublote" name="sublote" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
						</div>
                       
						<div class="col-lg-1">
                            <label class="control-label form-control-sm">Fila</label>
                            <input id="fila" name="fila" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
						</div>

					</div>
					
					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<!--<a href="javascript:void(0)" onClick="btnSolicitudDerechoRevision()" class="btn btn-sm btn-success">Registrar</a>-->
								<input class="btn btn-sm btn-success float-rigth" value="REGISTRAR" name="guardar" type="button" id="btnSolicitudDerechoRevision" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" />
							</div>
							
						</div>
					</div>

					<div style="clear:both;padding-top:15px"></div>
					
						<div class="card">
						
						<nav>
							<div class="nav nav-pills" id="nav-tab" role="tablist">
								<a
									class="nav-link active"
									id="proyectista_propietario-tab"
									data-toggle="pill"
									href="#proyectista_propietario"
									role="tab"
									aria-controls="proyectista_propietario"
									aria-selected="true">Proyectistas y Propietario</a>
								
								<a
									class="nav-link"
									id="informacion_proyecto-tab"
									data-toggle="pill"
									href="#informacion_proyecto"
									role="tab"
									aria-controls="informacion_proyecto"
									aria-selected="false"
									>Informaci&oacute;n del proyecto</a>
								
								<a
									class="nav-link"
									id="datos_comprobante-tab"
									data-toggle="pill"
									href="#datos_comprobante"
									role="tab"
									aria-controls="datos_comprobante"
									aria-selected="false"
									>Datos del Comprobante</a>
								
							</div>
						</nav>
						<div class="tab-content" id="my-profile-tabsContent">
							<div class="tab-pane fade pt-3 show active" id="proyectista_propietario" role="tabpanel" aria-labelledby="proyectista_propietario-tab">
								
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Proyectistas
														</strong>
														
													</div>
												</div>
											</div>

											<!--<div class="card-body" style="margin-top:15px;margin-bottom:15px">-->
											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoProyectista" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblSolicitud" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>N° CAP</th>
																	<th>Nombres</th>
																	<th>Celular</th>
																	<th>Email</th>
																	<!--<th>Firma</th> agregar despues-->
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php /*foreach($proyectista as $row){*/?>
																<!--<tr>
																	<th><?php //echo $row->universidad?></th>
																	<th><?php //echo $row->especialidad?></th>
																	<th><?php //echo $row->tesis?></th>
																	<th><?php //echo $row->fecha_egresado?></th>
																	<th><?php //echo $row->fecha_graduado?></th>
																	<th><?php //echo $row->libro?></th>
																	<th><?php //echo $row->folio?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->													
																<?php/* }*/?>
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
															Propietario
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoPropietario" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblSolicitud" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Persona</th>
																	<th>N&uacute;mero Documento</th>
																	<th>Nombres</th>
																	<th>celular</th>
																	<th>Email</th>
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php //foreach($agremiado_idioma as $row){?>
																<!--<tr>
																	<th><?php //echo $row->idioma?></th>
																	<th><?php //echo $row->grado?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalIdioma(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarIdioma(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->					
																<?php //}?>
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

							<div class="tab-pane fade pt-3" id="informacion_proyecto" role="tabpanel" aria-labelledby="informacion_proyecto-tab">
							
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Informaci&oacute;n del Proyecto
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoinfoProyecto" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblSolicitud" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Tramite</th>
																	<th>Tipo de Habilitacion Urbana</th>
																	<th>Etapas</th>
																	<th>Modalidad de Aprobaci&oacute;n</th>
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php //foreach($agremiado_estudio as $row){?>
																<!--<tr>
																	<th><?php //echo $row->universidad?></th>
																	<th><?php //echo $row->especialidad?></th>
																	<th><?php //echo $row->tesis?></th>
																	<th><?php //echo $row->fecha_egresado?></th>
																	<th><?php //echo $row->fecha_graduado?></th>
																	<th><?php //echo $row->libro?></th>
																	<th><?php //echo $row->folio?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->													
																<?php //}?>
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
							<div class="tab-pane fade pt-3" id="datos_comprobante" role="tabpanel" aria-labelledby="datos_comprobante-tab">
							
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Datos del Comprobante
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoComprobante" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblSolicitud" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Persona</th>
																	<th>N&uacute;mero Documento</th>
																	<th>Nombre/Razon Social</th>
																	<th>Direcci&oacute;n</th>
																	<th>Departamento</th>
																	<th>Provincia</th>
																	<th>Distrito</th>
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php //foreach($agremiado_estudio as $row){?>
																<!--<tr>
																	<th><?php //echo $row->universidad?></th>
																	<th><?php //echo $row->especialidad?></th>
																	<th><?php //echo $row->tesis?></th>
																	<th><?php //echo $row->fecha_egresado?></th>
																	<th><?php //echo $row->fecha_graduado?></th>
																	<th><?php //echo $row->libro?></th>
																	<th><?php //echo $row->folio?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->													
																<?php //}?>
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

						</div>
						
					</div>
					</form>
				</div><!--card-body-->
            </div>

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

<script src="{{ asset('js/derecho_revision/lista.js') }}"></script>

@endpush
