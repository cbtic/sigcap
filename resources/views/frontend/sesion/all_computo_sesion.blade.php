<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->

<style>
	#tblAfiliado,#tblComputoCerrado tbody tr{
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
            <li class="breadcrumb-item active">C&oacute;mputo de Sesiones</li>
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
						C&oacute;mputo de Sesiones <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
						C&oacute;mputo de Sesiones
                    </strong>
                </div><!--card-header-->
				
				<form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				
				<div class="row" style="padding:20px 20px 0px 20px;">
				
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
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
						<div class="col-lg-4 col-md-2 col-sm-12 col-xs-12">
							<?php 
							if($periodo_activo){
							?>
							<input type="hidden" name="id_periodo_bus" id="id_periodo_bus" value="<?php echo $periodo_activo->id?>">
							<select name="id_periodo_bus_" id="id_periodo_bus_" class="form-control form-control-sm" onChange="obtenerComisionBus();obtenerAnioPerido();obtenerPuestoBus()" disabled="disabled">
								<option value="">--Periodo--</option>
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
							<select name="id_periodo_bus" id="id_periodo_bus" class="form-control form-control-sm" onChange="obtenerComisionBus();obtenerAnioPerido();obtenerPuestoBus()">
								<option value="">--Periodo--</option>
								<?php
								foreach ($periodo as $row) {?>
								<option value="<?php echo $row->id?>" <?php if($row->id == $periodo_ultimo->id)echo "selected='selected'";?> ><?php echo $row->descripcion?></option>
								<?php 
								}
								?>
							</select>
							<?php } ?>
						</div>

						<div class="col-lg-4 col-md-2 col-sm-12 col-xs-12">
							<select name="anio" id="anio" class="form-control form-control-sm">
								@foreach ($anio as $anio)
									<option value="{{ $anio }}">{{ $anio }}</option>
								@endforeach
							</select>
						</div>

						<div class="col-lg-4 col-md-2 col-sm-12 col-xs-12">
							<select name="mes" id="mes" class="form-control form-control-sm">
								@foreach ($mes as $key=>$mes)
									<option value="{{ $key }}">{{ $mes }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row" style="padding:20px 20px 0px 20px;">
						<div class="col-lg-8">
							<div class="form-group">
								<select name="id_comision_bus" id="id_comision_bus" class="form-control form-control-sm" onChange="">
									<option value="">--Seleccionar Comisi&oacute;n--</option>
									<?php
									foreach ($comision as $row) {?>
									<option value="<?php echo $row->id?>"><?php echo $row->comision." ".$row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<select name="id_puesto_bus" id="id_puesto_bus" class="form-control form-control-sm">
								<option value="">--Puesto--</option>
								<?php
								//foreach ($puesto as $row) {?>
								<!--<option value="<?php //echo $row->codigo?>"><?php //echo $row->denominacion?></option>-->
								<?php 
								//}
								?>
							</select>
						</div>
						
						<!--
						<div class="col-lg-6">
							<div class="form-group">
								<select name="id_delegado" id="id_delegado" class="form-control form-control-sm" onChange="">
									<option value="">--Seleccionar Delegado--</option>
									<?php
									//foreach ($concurso_inscripcion as $row) {?>
									<option value="<?php //echo $row->id?>"><?php //echo $row->numero_cap." - ".$row->apellido_paterno." ".$row->apellido_materno." ".$row->nombres." - ".$row->puesto?></option>
									<?php 
									//}
									?>
								</select>
							</div>
						</div>
						-->
					</div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
                    <table id="tblComputoCerrado" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
							<th>N° C&oacute;mputo</th>
							<th>Año</th>
							<th>Mes</th>
							<th>Fecha C&oacute;mputo</th>
							<th>Mes Actual</th>
							<th>Meses Ant.</th>
							<th>Reporte</th>
							<th>Eliminar</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
				</div>
					
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

				</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-right:0px">
						<input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
						<input class="btn btn-secondary pull-rigth" value="Vista Previa Computo" type="button" id="btnVistaPreviaComputo" style="margin-left:15px" />
						<input class="btn btn-secondary pull-rigth" value="Vista Previa Calendario" type="button" id="btnVistaPreviaCalendario" style="margin-left:15px" />
						<input class="btn btn-danger pull-rigth" value="Finalizar Computo" type="button" id="btnNuevo" style="margin-left:15px" />
						
						<input class="btn btn-secondary pull-rigth" value="Movilidad Delegados" type="button" id="btnVistaPreviaMovilidad" style="margin-left:15px" />
						<input class="btn btn-secondary pull-rigth" value="Delegado Coordinadores" type="button" id="btnVistaPreviaCoordinador" style="margin-left:15px" />
						<input class="btn btn-secondary pull-rigth" value="Calendario C Z" type="button" id="btnVistaPreviaCalendarioCoordinadorZonal" style="margin-left:15px" />
						
					</div>
				</div>
				
                <div class="card-body">

                    <div class="table-responsive">
                    <table id="tblAfiliado" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
							<th>Municipalidad</th>
							<th>Comisi&oacute;n</th>
							<th>Delegado</th>
							<th>N&uacute;mero CAP</th>
							<th>Puesto</th>
							<th>Coordinador</th>
							<th>Sesiones Computadas</th>
							<th>Sesiones Adicionales</th>
							<th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
					
					<table class="table table-hover table-sm" style="width:50%!important" align="right">
                        <thead>
                        <tr style="font-size:13px">
							<th>Sesiones delegados</th>
							<th><span id="sesion_delegados"></span></th>
                        </tr>
						<tr style="font-size:13px">
							<th>Sesiones coordinador zonal</th>
							<th><span id="sesion_coordinador_zonal"></span></th>
                        </tr>
						<tr style="font-size:13px">
							<th>Total de sesiones</th>
							<th><span id="sesion_total"></span></th>
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

<script src="{{ asset('js/sesion/lista_computo.js') }}"></script>
<script>
obtenerComisionBus();
obtenerAnioPerido();
obtenerPuestoBus();
</script>
@endpush
