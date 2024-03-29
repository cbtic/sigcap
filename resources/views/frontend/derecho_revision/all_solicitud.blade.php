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

    #tblSolicitudHU tbody tr{
		font-size:13px
	}

    .form-control:disabled, .form-control[readonly]{
	background-color:#cff4fc!important;
	border-color:#b6effb!important;
	color:#055160!important;
	opacity:1
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

</style>

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Solicitud de Derecho de Revisi&oacute;n</li>
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
                        Derecho de Revisi&oacute;n - Habilitaci&oacute;n Urbana<!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Lista de Derecho de Revisi&oacute;n - Habilitaci&oacute;n Urbana
                    </strong>
                </div>
				
				<form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <!--<meta name="_token" id="_token" content="{{ csrf_token() }}">-->
                <input type="hidden" name="id" id="id" value="0">
				
                <div class="row" style="padding:20px 20px 0px 20px;">
				
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Nombre Proyecto
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="<?php echo $derecho_revision->nombre_proyecto?>" class="form-control form-control-sm celeste" readonly='readonly'>
                    </div>

                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Direcci&oacute;n
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="direccion" id="direccion" value="<?php echo $derecho_revision->direccion?>" class="form-control form-control-sm" readonly='readonly'>
                    </div>

                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Departamento
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="id_ubigeo_domicilio" id="id_ubigeo_domicilio" value="<?php echo $agremiado->id_ubigeo_domicilio?>">
                    <input type="text" name="departamento_domiciliario" id="departamento_domiciliario" value="<?php echo $derecho_revision->departamento_domiciliario?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Provincia
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    <input type="text" name="provincia_domiciliario" id="provincia_domiciliario" value="<?php echo $derecho_revision->provincia_domiciliario?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Distrito
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    <input type="text" name="distrito_domiciliario" id="distrito_domiciliario" value="<?php echo $derecho_revision->distrito_domiciliario?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
					<!--
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    N° CAP
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="numero_cap" id="numero_cap" value="<?php //echo $agremiado->numero_cap?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Proyectista
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="proyectista" id="proyectista" value="<?php //echo $agremiado->desc_cliente?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
					
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    N° Documento
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="numero_documento" id="numero_documento" value="<?php //echo $persona->numero_documento?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
					
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Propietario
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="propietario" id="propietario" value="<?php //echo $persona->nombres?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
					-->
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Municipalidad
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">					
                    <input type="text" name="municipalidad" id="municipalidad" value="<?php echo $derecho_revision->municipalidad?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>

                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Tipo Solicitud
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="tipo_solicitud" id="tipo_solicitud" value="<?php echo $derecho_revision->id_tipo_solicitud?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>

                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Tipo Proyecto
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="tipo_proyecto" id="tipo_proyecto" value="<?php echo $derecho_revision->tipo_proyecto?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>

                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    N&uacute;mero Revisi&oacute;n
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="numero_revision" id="numero_revision" value="<?php echo $derecho_revision->numero_revision?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
                    <!--
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Credipago
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="credipago" id="credipago" value="<?php /*echo $liquidacion->credipago*/?>" class="form-control form-control-sm" <?php /*"readonly='readonly'"*/?> >
                    </div>-->
                    
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    &Aacute;rea Total
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="area_techada" id="area_techada" value="<?php echo $derecho_revision->area_total?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>

                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    Valor de Obra
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <input type="text" name="valor_obra" id="valor_obra" value="<?php echo $derecho_revision->valor_obra?>" class="form-control form-control-sm" readonly='readonly' >
                    </div>
                    

                    
                    <!--
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<select name="estado" id="estado" class="form-control form-control-sm">
							<option value="">Todos</option>
							<option value="1" selected="selected">Activo</option>
							<option value="0">Eliminado</option>
						</select>
					</div>
                    -->
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
						<!--<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />-->
						<input class="btn btn-success" value="Generar Credipago" type="button" id="btnNuevo_solicitud" style="margin-left:15px"/>

					</div>
				</div>

				<div class="row" style="padding:20px 20px 0px 20px;">
				
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Estado Solicitud
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">					
                        <select name="numero_liquidacion" id="numero_liquidacion" class="form-control form-control-sm" onChange="">
                            <option value="">--Selecionar--</option>
                                <?php
                                foreach ($estado_solicitud as $row) {?>
                                    <option value="<?php echo $row->codigo?>"<?php if($row->codigo==$derecho_revision->id_resultado)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php 
                                }
                                ?>
                        </select>
                        </div>
                    </div>    

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Liquidaci&oacute;n
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">					
                        <input type="text" name="numero_liquidacion" id="numero_liquidacion" value="<?php echo $liquidacion->credipago?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> >
                        </div>
                    </div>    

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Municipalidad
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">					
                        <select name="municipalidad" id="municipalidad" class="form-control form-control-sm" onChange="">
                            <option value="">--Selecionar--</option>
                                <?php
                                foreach ($municipalidad as $row) {?>
                                    <option value="<?php echo $row->id?>" <?php if($row->id==$derecho_revision->id_municipalidad)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php 
                                }
                                ?>
                        </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">

                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Nombre Proyecto
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">
                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="<?php echo $derecho_revision->nombre_proyecto?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> >
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Distrito
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        <select name="id_distrito_domiciliario" id="id_distrito_domiciliario" class="form-control form-control-sm" onchange="">
                        <option value="">--Selecionar--</option>
                            <?php
                            foreach ($distrito as $row) {?>
                            <option value="<?php echo $row->id_distrito?>" <?php if($row->id_distrito==$agremiado->id_ubigeo_domicilio)echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
                            <?php 
                            }
                            ?>
                        </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        N° CAP
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">
                            <input type="text" name="numero_cap" id="numero_cap" value="<?php echo $agremiado->numero_cap?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> >
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Proyectista
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">
                            <input type="text" name="proyectista" id="proyectista" value="<?php echo $agremiado->desc_cliente?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> >
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        N° Documento
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">
                            <input type="text" name="numero_documento" id="numero_documento" value="<?php echo $persona->numero_documento?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> >
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Propietario
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">
                            <input type="text" name="propietario" id="propietario" value="<?php echo $persona->nombres?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> >
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Tipo Solicitud
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">
                            <input type="text" name="tipo_solicitud" id="tipo_solicitud" value="<?php echo $derecho_revision->id_tipo_solicitud?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> >
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="padding:0px 10px 0px 10px;">
                        Tipo Proyecto
                        </div>
                        <div class="row" style="padding:0px 10px 0px 10px;">
                            <input type="text" name="tipo_proyecto" id="tipo_proyecto" value="<?php echo $derecho_revision->tipo_proyecto?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> >
                        </div>
                    </div>
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding:15px">
						<input class="btn btn-warning" value="BUSCAR" type="button" id="btnBuscar_solicitud" />
                        <a class="btn btn-success" href="/derecho_revision/consulta_derecho_revision_nuevo" style="margin-left:15px">Nuevo</a>
						<!--<input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo_solicitud" style="margin-left:15px"/>-->

					</div>
				</div>
				
                <div class="card-body">				

                    <div class="table-responsive">
                    <table id="tblSolicitudHU" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                            <th>Nombre Proyecto</th>
                            <th>Tipo Proyecto</th>
                            <th>N&uacute;mero Revisi&oacute;n</th>
                            <th>Municipalidad</th>
                            <th>Proyectista</th>
                            <th>Propietario</th>
                            <th>Fecha Registro</th>
                            <th>Estado Proyecto</th>
                            <th>Estado</th>
							<th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!--table-responsive-->
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
