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
                        Asiento Planillas <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

            <div class="row justify-content-center">
            
                <div class="col col-sm-12 align-self-center">

                    <div class="card">
                        <div class="card-header">
                            <strong>
                            Lista de Asientos
                            </strong>
                        </div><!--card-header-->
                        
                        <form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        
                            <div class="row" style="padding:20px 20px 0px 20px;">
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <select name="Tipo_b" id="Tipo_b" class="form-control form-control-sm">
                                        
                                        <option value="1" selected="selected">ASIENTO DE PROVISION</option>
                                        <option value="2">ASIENTO DE CANCELACION</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<?php 
									if($periodo_activo){
									?>
									<input type="hidden" name="id_periodo" id="id_periodo" value="<?php echo $periodo_activo->id?>">
									<select name="id_periodo_" id="id_periodo_" class="form-control form-control-sm" onChange="obtenerAnioPeriodo()" disabled="disabled">
										<option value="">--Periodo--</option>
										<?php
										foreach ($periodo as $row) {?>
										<option value="<?php echo $row->id?>" 
										<?php if($row->id == $periodo_activo->id)echo "selected='selected'";?> ><?php echo $row->descripcion?></option>
										<?php 
										}
										?>
									</select>
									
									<?php
									}else{
									?>
									<select name="id_periodo" id="id_periodo" class="form-control form-control-sm" onChange="obtenerAnioPerido()">
										<option value="">--Periodo--</option>
										<?php
										foreach ($periodo as $row) {?>
										<option value="<?php echo $row->id?>" 
										<?php if($row->id == $periodo_ultimo->id)echo "selected='selected'";?> ><?php echo $row->descripcion?></option>
										<?php 
										}
										?>
									</select>
									<?php } ?>
								</div>

								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<select name="anio" id="anio" class="form-control form-control-sm">
										@foreach ($anio as $anio)
											<option value="{{ $anio }}">{{ $anio }}</option>
										@endforeach
									</select>

								</div>

								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<select name="mes" id="mes" class="form-control form-control-sm">
										@foreach ($mes as $key=>$mes)
											<option value="{{ $key }}">{{ $mes }}</option>
										@endforeach
									</select>
								</div>

  <!--                          
                                <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                                    <input class="form-control form-control-sm" id="denominacion_b" name="denominacion_b" placeholder="Denominación">
                                </div>
                                    -->

                                <input type="hidden" name="cuenta_b" id="cuenta_b" value="">
                                <input type="hidden" name="tipo_cuenta_b" id="tipo_cuenta_b" value="">
                                <input type="hidden" name="centro_costo_b" id="centro_costo_b" value="">
                                <input type="hidden" name="partida_presupuestal_b" id="partida_presupuestal_b" value="">
                                <input type="hidden" name="codigo_financiamiento_b" id="codigo_financiamiento_b" value="">
                                <input type="hidden" name="medio_pago_b" id="medio_pago_b" value="">
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
                                    
                                    <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>
                                    <input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>-->

                                </div>
                            </div>
                        
                            <div class="card-body">
                                <div  id="divPlanilla" class="table-responsive">
                                    <table id="tblPlanilla" class="table table-hover table-sm">
                                        <thead>
                                            <tr style="font-size:13px">
                                        
                                                <th>Cuenta</th>
                                                <th>Nombre</th>                            
                                                <th>Debe</th>
                                                <th>Haber</th>                            
                                                <th>Moneda</th>
                                                <th>Tipo Cambio</th>
                                                <th>Equivalente</th>
                                                <th>Tipo Doc.</th>
                                                <th>Numero</th>
                                                <th>Código</th>
                                                <th>Razon Social</th>
                                                <th>C.C.</th>
                                                <th>Presupuesto</th>
                                                <th>F.E</th>
                                                <th>Glosa</th>
                                                <th>M. Pago</th>
                                                <th>Estado</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--table-responsive-->
                        </form>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-->
        </div><!--row-->

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

<script src="{{ asset('js/AsientoPlanilla.js') }}"></script>

@endpush
