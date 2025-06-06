<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->

<style>
	#tblTablaMaestra tbody tr{
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

</style>

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Tabla Maestra</li>
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
                            Consulta de Tabla Maestra <!--<small class="text-muted">Usuarios activos</small>-->
                        </h4>
                    </div><!--col-->
                </div>

                <div class="row justify-content-center">
            
                    <div class="col col-sm-12 align-self-center">

                        <div class="card">
                            <div class="card-header">
                                <strong>
                                    Lista de Tabla Maestra
                                </strong>
                            </div><!--card-header-->
                            
                            <form class="form-horizontal" method="post" action="" id="frmTablaMaestra" autocomplete="off">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            
                            <div style="padding:20px 20px 0px 20px;">
                            
                                <div class="row">
                            
                                    <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                                        <input class="form-control form-control-sm" id="denominacion_bus" name="denominacion_bus" placeholder="Denominaci&oacute;n">
                                    </div>

                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                        <select name="tipo_nombre_bus" id="tipo_nombre_bus" class="form-control form-control-sm" onChange="">
                                            <option value="">--Selecionar Tipo Nombre--</option>
                                                <?php
                                                foreach ($tipo_nombre as $row) {?>
                                                    <option value="<?php echo $row->tipo?>"><?php echo $row->tipo_nombre?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                        <select name="estado_bus" id="estado_bus" class="form-control form-control-sm">
                                            <option value="">Todos</option>
                                            <option value="1" selected="selected">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    
                                    </div>
                                    <div class="col-lg-2 col-md-1 col-sm-12 col-xs-12" style="padding-right:0px">
                                        <input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
                                        
                                        <input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>
                
                                    </div>
                                </div>
                            
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                <table id="tblTablaMaestra" class="table table-hover table-sm">
                                    <thead>
                                    <tr style="font-size:13px">
                                        <th>Id</th>
                                        <th>Tipo</th>
                                        <th>Denominaci&oacute;n</th>
                                        <th>Codigo</th>
                                        <th>Tipo Nombre</th>
                                        <th>Orden</th>
                                        <th>Predeterminado</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
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

<script src="{{ asset('js/tabla_maestra/lista.js') }}"></script>

@endpush
