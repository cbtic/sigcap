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
            <li class="breadcrumb-item active">Asignacion de Cuentas</li>
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
                        Asignacion de Cuentas <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                    Lista de Cuentas Asignadas
                    </strong>
                </div><!--card-header-->
				
				<form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				
				<div class="row" style="padding:20px 20px 0px 20px;">

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <select name="tipo_planilla_bus" id="tipo_planilla_bus" class="form-control form-control-sm">
                            <option value="">--Seleccionar Tipo Planilla--</option>
                            <?php foreach ($tipo_planilla as $row) { ?>
                                <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <select name="cuenta_bus" id="cuenta_bus" class="form-control form-control-sm">
                            <option value="">--Seleccionar Cuenta--</option>
                            <?php foreach ($plan_contable as $row) { ?>
                                <option value="<?php echo $row->id?>"><?php echo $row->cuenta."-".$row->denominacion ?></option>
                            <?php } ?>
                        </select>
                    </div>
				
                    <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
						<input class="form-control form-control-sm" id="denominacion_b" name="denominacion_b" placeholder="Denominación">
					</div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <select name="tipo_cuenta_bus" id="tipo_cuenta_bus" class="form-control form-control-sm">
                            <option value="">--Seleccionar Tipo--</option>
                            <?php foreach ($tipo_cuenta as $row) { ?>
                                <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <select name="centro_costo_bus" id="centro_costo_bus" class="form-control form-control-sm">
                            <option value="">--Seleccionar Centro Costo--</option>
                            <?php foreach ($centro_costo as $row) { ?>
                                <option value="<?php echo $row->id?>"><?php echo $row->codigo."-".$row->denominacion ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <select name="partida_presupuestal_bus" id="partida_presupuestal_bus" class="form-control form-control-sm">
                            <option value="">--Seleccionar Partida Presupuestal--</option>
                            <?php foreach ($partida_presupuestal as $row) { ?>
                                <option value="<?php echo $row->id?>"><?php echo $row->codigo."-".$row->denominacion ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row" style="padding:20px 20px 0px 20px;">

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <select name="codigo_financiero_bus" id="codigo_financiero_bus" class="form-control form-control-sm">
                            <option value="">--Seleccionar C&oacute;digo Financiero--</option>
                            <?php foreach ($codigo_financiero as $row) { ?>
                                <option value="<?php echo $row->id?>"><?php echo $row->codigo."-".$row->denominacion ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <select name="medio_pago_bus" id="medio_pago_bus" class="form-control form-control-sm">
                            <option value="">--Seleccionar Medio de Pago--</option>
                            <?php foreach ($medio_pago as $row) { ?>
                                <option value="<?php echo $row->codigo?>"><?php echo $row->codigo."-".$row->denominacion ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <select name="origen_b" id="origen_b" class="form-control form-control-sm">
                            <option value="">--Seleccionar Origen--</option>
                            <?php foreach ($origen as $row) { ?>
                                <option value="<?php echo $row->codigo?>"><?php echo $row->codigo."-".$row->denominacion ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <input type="hidden" name="tipo_planilla_bus" id="tipo_planilla_bus" value="">
                    <input type="hidden" name="cuenta_bus" id="cuenta_bus" value="">
                    <input type="hidden" name="tipo_cuenta_bus" id="tipo_cuenta_bus" value="">
                    <input type="hidden" name="centro_costo_bus" id="centro_costo_bus" value="">
                    <input type="hidden" name="partida_presupuestal_bus" id="partida_presupuestal_bus" value="">
                    <input type="hidden" name="codigo_financiero_bus" id="codigo_financiero_bus" value="">
                    <input type="hidden" name="medio_pago_bus" id="medio_pago_bus" value="">
                    <input type="hidden" name="origen_b" id="origen_b" value="">
                                 
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<select name="estado_b" id="estado_b" class="form-control form-control-sm">
							<option value="">Todos</option>
							<option value="1" selected="selected">Activo</option>
							<option value="0">Eliminado</option>
						</select>
					</div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
						<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
						
                        <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                        <input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>

					</div>
				</div>
				
                <div class="card-body">

                    <div class="table-responsive">
                    <table id="tblAfiliado" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                     
                            <th>Tipo Planilla</th>
                            <th>Cuenta</th>
                            <th>Denominaci&oacute;n</th>                            
                            <th>Tipo</th>
                            <th>Centro Costo</th>                            
							<th>Partida Pres.</th>
                            <th>Cod. Financiero</th>
                            <th>Medio Pago</th>
                            <th>Origen</th>
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

<script src="{{ asset('js/AsignacionCuenta.js') }}"></script>

@endpush
