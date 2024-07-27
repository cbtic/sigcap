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
	/*
    #global {        
        width: 95%;        
        margin: 15px 15px 15px 15px;     
        height: 380px !important;        
        border: 1px solid #ddd;
        overflow-y: scroll !important;
    }
	*/
	#global {
        height: 650px !important;
        width: auto;
        border: 1px solid #ddd;
		margin:15px
       /* background: #f1f1f1;*/
        /*overflow-y: scroll !important;*/
    }
	
    .margin{

        margin-bottom: 20px;
    }
    .margin-buscar{
        margin-bottom: 5px;
        margin-top: 5px;
    }

    /*.row{
        margin-top:10px;
        padding: 0 10px;
    }*/
    .clickable{
        cursor: pointer;   
    }

    /*.panel-heading div {
        margin-top: -18px;
        font-size: 15px;        
    }
    .panel-heading div span{
        margin-left:5px;
    }*/
    .panel-body{
        display: block;
    }
	
	.dataTables_filter {
	   display: none;
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

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Empresas</li>
        </li>
    </ol>
@endsection

@section('content')

    <!--<ol class="breadcrumb" style="padding-left:120px;margin-top:0px">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Afiliados</li>
        </li>
    </ol>
    -->

<div class="loader"></div>

    <div class="justify-content-center">
        
        <div class="card">

        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        Consulta de Programaci&oacute;n de Sesi&oacute;n <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Lista de Programaci&oacute;n de Sesiones
                    </strong>
                </div><!--card-header-->
				
				<form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				
				<div class="row" style="padding:20px 20px 0px 20px;">
					<!--
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<select name="id_regional_bus" id="id_regional_bus" class="form-control form-control-sm">
							<option value="">--Regi&oacute;n--</option>
							<?php
							//foreach ($region as $row) {?>
							<option value="<?php //echo $row->id?>"><?php //echo $row->denominacion?></option>
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
						<select name="id_periodo_bus_" id="id_periodo_bus_" class="form-control form-control-sm" onChange="obtenerComisionBus()" disabled="disabled">
							<option value="0">--Periodo--</option>
							<?php
							foreach ($periodo as $row) {?>
							<option value="<?php echo $row->id?>" <?php if($row->id == $periodo_activo->id)echo "selected='selected'";?> ><?php echo $row->descripcion?></option>
							<?php 
							}
							?>
						</select>
						<?php
                        }else{
                        ?>
						<select name="id_periodo_bus" id="id_periodo_bus" class="form-control form-control-sm" onChange="obtenerComisionBus()" disabled="disabled">
							<option value="0">--Periodo--</option>
							<?php
							foreach ($periodo as $row) {?>
							<option value="<?php echo $row->id?>" <?php if($row->id == $periodo_ultimo->id)echo "selected='selected'";?> ><?php echo $row->descripcion?></option>
							<?php 
							}
							?>
						</select>
						<?php } ?>
					</div>
					
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<select name="tipo_comision_bus" id="tipo_comision_bus" class="form-control form-control-sm" onchange="obtenerComisionBus()">
							<option value="0">--Tipo Comisi&oacute;n--</option>
								<?php
								foreach ($tipo_comision as $row) {?>
									<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
								<?php
								}
								?>
						</select>
					</div>
					
					<div class="col-lg-3 col-md-2 col-sm-12 col-xs-12">
						<select name="id_comision_bus" id="id_comision_bus" class="form-control form-control-sm">
							<option value="0">--Comisi&oacute;n--</option>
						</select>
					</div>
					
					<div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="fecha_inicio_bus" name="fecha_inicio_bus" placeholder="Fecha Desde">
					</div>
					<div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="fecha_fin_bus" name="fecha_fin_bus" placeholder="Fecha Hasta">
					</div>
					
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    	<select name="id_tipo_sesion_bus" id="id_tipo_sesion_bus" class="form-control form-control-sm" onChange="">
							<option value="">--Tipo Programci&oacute;n--</option>
							<?php
							foreach ($tipo_programacion as $row) {?>
							<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
							<?php 
							}
							?>
						</select>
					</div>
						
				</div>
				
				<div class="row" style="padding:20px 20px 0px 20px;">
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-right:0px">
                    	<select name="id_estado_sesion_bus" id="id_estado_sesion_bus" class="form-control form-control-sm">
							<option value="">Estado Sesi&oacute;n</option>
							<?php
							foreach ($estado_sesion as $row) {?>
							<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
							<?php 
							}
							?>
						</select>
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    	<select name="id_estado_aprobacion_bus" id="id_estado_aprobacion_bus" class="form-control form-control-sm">
							<option value="">Estado Aprobaci&oacute;n</option>
							<?php
							foreach ($estado_aprobacion as $row) {?>
							<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
							<?php 
							}
							?>
						</select>
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    	<select name="cantidad_delegado" id="cantidad_delegado" class="form-control form-control-sm">
							<option value="">--Can.Delegado--</option>
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
						</select>
					</div>
					
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    	<select name="id_situacion_bus" id="id_situacion_bus" class="form-control form-control-sm">
							<option value="">--Situaci&oacute;n--</option>
							<?php
							foreach ($situacion as $row) {?>
							<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
							<?php 
							}
							?>
						</select>
					</div>
					
					<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
						<select name="campo" id="campo" class="form-control form-control-sm">
							<option value="t1.fecha_programado">--Campo--</option>
							<option value="t1.fecha_programado">Fecha Programada</option>
							<option value="t8.denominacion">Tipo Comisi&oacute;n</option>
							<option value="t4.denominacion||'' ''||t4.comision">Comisi&oacute;n</option>
							<option value="t2.denominacion">Sesi&oacute;n Programada</option>
							<option value="t3.denominacion">Estado Sesi&oacute;n</option>
							<option value="t7.denominacion">Estado Aprobaci&oacute;n</option>
						</select>
					</div>
					
					<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
						<select name="orden" id="orden" class="form-control form-control-sm">
							<option value="asc">Ascendente</option>
							<option value="desc">Descendente</option>
						</select>
					</div>
					
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding-right:0px;padding-left:0px">
						<input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
						<input class="btn btn-success pull-rigth" value="N. Sesi&oacute;n" type="button" id="btnNuevo" style="margin-left:10px" />
						<input class="btn btn-danger pull-rigth" value="Ejecutar" type="button" id="btnEjecutar" style="margin-left:10px" />
						<!--<input class="btn btn-info" value="Importar Dictamenes" id="btnImportarDictamenes" style="margin-left:10px"/>-->
					</div>
				</div>
				
                <div class="card-body">

                    <div class="table-responsive">
                    <table id="tblAfiliado" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
							<th>Periodo</th>
							<th>Tipo Comisi&oacute;n</th>
							<th>Comisi&oacute;n</th>
							<th>Fecha Programada</th>
							<th>Fecha Ejecuci&oacute;n</th>
                            <!--<th>Hora Inicio</th>
							<th>Hora Fin</th>-->
							<th>Sesi&oacute;n Programada</th>
                            <th>Estado Sesi&oacute;n</th>
							<th>Estado Aprobaci&oacute;n</th>
							<th>Num Delegado</th>
							<th>Num Situaci&oacute;n</th>
							<th>Observaci&oacute;n</th>
							<th>Dictamen</th>
							<th>Editar</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
					
					<table id="tblDictamen" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
							<!--<th>C&oacute;digo</th>-->
							<th>Distrito</th>
							<th>Exp. Municipal</th>
							<th>Tipo de Solicitud</th>
							<th>N&deg; Liquidaci&oacute;n</th>
							<th>Monto</th>
							<th>Dictamen</th>
							<th>Revis&oacute;n</th>
							<th>Proyectista</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
					
					
					
                </div><!--table-responsive-->
                </form>



                </div><!--card-body-->
            </div><!--card-->
        <!--</div>--><!--col-->
    <!--</div>--><!--row-->

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

<script src="{{ asset('js/sesion/lista_sesion.js') }}"></script>

@endpush
