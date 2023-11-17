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
            <li class="breadcrumb-item active">Comisi&oacute;n</li>
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
                            Comisiones T&eacute;cnicas <!--<small class="text-muted">Usuarios activos</small>-->
                        </h4>
                    </div><!--col-->
                </div>

                <div class="row justify-content-center">
        
                    <div class="col col-sm-12 align-self-center">

                        <div class="card">
                            <div class="card-header">
                                <strong>
                                    Criterios de B&uacute;squeda
                                </strong>
                            </div><!--card-header-->
				
				            <form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    
                                <div class="row" style="padding:20px 20px 0px 20px;">
                    
                                    <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                                        <input class="form-control form-control-sm" id="periodo_ini" name="periodo_ini" placeholder="Periodo Inicio">
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                                        <input class="form-control form-control-sm" id="periodo_fin" name="periodo_fin" placeholder="Periodo Fin">
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                        <input class="form-control form-control-sm" id="tipo_agrupacion" name="tipo_agrupacion" placeholder="Tipo de Agrupaci&oacute;n">
                                    </div>
                                    
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <select name="estado" id="estado" class="form-control form-control-sm">
                                            <option value="">Todos</option>
                                            <option value="1" selected="selected">Activo</option>
                                            <option value="0">Eliminado</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                                        <input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
                                        <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                                        <!--<input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>-->
                                    </div>
                                </div>
                            </form>
				        </div>
                    </div>
                </div>
                

                <form class="form-horizontal" method="post" action="" id="frmComision" autocomplete="off">
                <div class="row justify-content-left">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                    <div class="col col-sm-4 align-self-left">

                        <div class="card">
                            <div class="card-header">
                                <div class="row" style="padding:20px 20px 0px 20px;">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <select name="periodo" id="periodo" class="form-control form-control-sm" onChange="obtenerPeriodo" >
                                                <option value="">--Selecionar Periodo--</option>
                                                    <?php
                                                    foreach ($periodoComision as $row) {?>
                                                        <option value="<?php echo $row->id?>" <?php if($row->id==$comision->id_periodo_comisiones)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
                                                    <?php 
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                                        <!--<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />-->
                                        <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                                        <!--<input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>-->
                                    </div>
                                </div>
                            </div><!--card-header-->
				
				            <div class="col-lg-12 col-md-4 col-sm-12 col-xs-12" style="padding:0px">
							
                                <div class="col-md-12" style="padding-top:10px">
                                    <input class="form-control" id="system-search" name="q" placeholder="Buscar ...">
                                </div>
                                
                                <div class="table-responsive" style="overflow-y: visible; height:470px;width:100%">
                                    <table id="tblMunicipalidad" class="table table-sm">
                                        <thead>
                                            <tr style="font-size:13px">
                                                <th>Seleccionar</th>
                                                <th>Denominaci&oacute;n</th>
                                                <th>Tipo de Muni</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div><!--table-responsive-->
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                                    <!--<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />-->
                                    <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                                    <input class="btn btn-success" value="CREAR" type="button" id="btnNuevo" style="margin-left:15px;margin-top:10px;margin-bottom:10px"/>
                                </div>
                            </div>
				        </div>
                    </div>
                </form>

                <div class="col col-sm-4 align-self-right">

                    <div class="card">
                        <div class="card-header">
                            <div class="row" style="padding:20px 20px 0px 20px;">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    
                                    <input class="form-control form-control-sm" id="denominacion_integra" name="denominacion_integra" placeholder="Denominaci&oacute;n">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                                    <input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
                                    <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                                    <!--<input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>-->
                                </div>
                            </div>
                        </div><!--card-header-->
            
                        <div class="col-md-12 col-md-4 col-sm-12 col-xs-12" style="padding:0px">

                            <div class="col-md-12" style="padding-top:10px">
                                <input class="form-control" id="system-search2" name="buscarIntegrada" placeholder="Buscar ...">
                            </div>
                            <div class="table-responsive" style="overflow-y: visible; height:470px;width:100%">
                                <table id="tblMunicipalidadIntegrada" class="table table-sm">
                                    <thead>
                                        <tr style="font-size:13px">
                                            <th>Seleccionar</th>
                                            <th>Denominaci&oacute;n</th>
                                            <th>Tipo Agrup</th>
                                            <th>Movilidad</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div><!--table-responsive-->
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                            <!--<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />-->
                            <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                            <input class="btn btn-success" value="CREAR COMISION" type="button" id="btnNuevoComision" style="margin-left:15px;margin-top:10px;margin-bottom:10px"/>
                        </div>
                    </div>
                </div>
                <div class="col col-sm-4 align-self-left">

                    <div class="card">
                        <div class="card-header">
                            <div class="row" style="padding:20px 20px 0px 20px;">
                                <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                    <input class="form-control form-control-sm" id="denominacion_muni" name="denominacion_muni" placeholder="Denominaci&oacute;n">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                                    <input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
                                    <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                                    <!--<input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>-->
                                </div>
                            </div>
                        </div><!--card-header-->
        
                        <!--<div class="card-body">-->
                        <div class="col-md-12" style="padding-top:10px">
                            <input class="form-control" id="system-search3" name="buscarIntegrada" placeholder="Buscar ...">
                        </div>
                        <div class="table-responsive" style="overflow-y: visible; height:470px;width:100%">
                            <table id="tblComision" class="table table-hover table-sm">
                                <thead>
                                    <tr style="font-size:13px">
                                        <!--<div class="row">
                                            <div class="col-md-2">Seleccionar</div>
                                            
                                            <div class="col-md-6">Denominaci&oacute;n</div>
                                            
                                            <div class="col-md-4">Estado</div></div>-->
                                        <th>Seleccionar</th>
                                        <th>Denominaci&oacute;n</th>
                                        <th>Tipo Agrup</th>
                                        <th>Movilidad</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div><!--table-responsive-->
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                            <input class="btn btn-success" value="Dar de Baja" type="button" id="btnBuscar" style="margin-left:15px;margin-top:10px;margin-bottom:10px"/>
                                <!--<input class="btn btn-success" value="CREAR COMISION" type="button" id="btnNuevoComision" style="margin-left:15px;margin-top:10px;margin-bottom:10px"/>-->
                                
                                <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                                <!--<input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

<script src="{{ asset('js/comision/lista.js') }}"></script>

@endpush
