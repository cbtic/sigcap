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

</style>

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Registro de Revisor Urbano</li>
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
                        Registro de Revisor Urbano <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
            <div class="col col-sm-12 align-self-center">

                <div class="card">
                    <div class="card-header">
                        <strong>
                            Datos del Arquitecto
                        </strong>
                    </div>
				
                    <form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id" value="0">
                    
                    <div class="row" style="padding:20px 20px 0px 20px;">
				
                        <div class="row">					
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                        N&deg; CAP
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" name="numero_cap" id="numero_cap" value="<?php echo $agremiado->numero_cap?>" class="form-control form-control-sm" <?php "readonly='readonly'"?> onkeydown="verificarEnter(event)" >
                                    </div>

                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Tipo Documento
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" onchange="" disabled='disabled'>
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($tipo_documento as $row) {?>
                                        <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$persona->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    </div>

                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    N&deg; Doc
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="numero_documento" id="numero_documento" value="<?php echo $persona->numero_documento?>" class="form-control form-control-sm" readonly='readonly'<?php  ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Ap. Paterno
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="apellido_paterno" id="apellido_paterno" value="<?php echo $persona->apellido_paterno?>" class="form-control form-control-sm" readonly='readonly'>
                                    </div>

                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Ap. Materno
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="apellido_materno" id="apellido_materno" value="<?php echo $persona->apellido_materno?>" class="form-control form-control-sm" readonly='readonly'>
                                    </div>
                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Nombres
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="nombres" id="nombres" value="<?php echo $persona->nombres?>" class="form-control form-control-sm" readonly='readonly'>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    N&deg; Regional
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="numero_regional" id="numero_regional" value="<?php echo $agremiado->numero_regional?>" class="form-control form-control-sm" readonly='readonly' <?php ?>>
                                    </div>

                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Regional
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <select name="id_regional" id="id_regional" class="form-control form-control-sm" onchange="" disabled='disabled'>
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($region as $row) {?>
                                        <option value="<?php echo $row->id?>" <?php if($row->id==$agremiado->id_regional)echo "selected='selected'" ?> ><?php echo $row->denominacion?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    </div>

                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Fecha Colegiado
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="fecha_colegiado" id="fecha_colegiado" value="<?php echo $agremiado->fecha_colegiado?>" class="form-control form-control-sm" readonly='readonly' <?php  "readonly='readonly'"?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Ubicacion
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <select name="id_ubicacion" id="id_ubicacion" class="form-control form-control-sm" onchange="" disabled='disabled'>
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
                                    Situacion
                                    </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <select name="id_situacion" id="id_situacion" class="form-control form-control-sm" onchange="" disabled='disabled'>
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        foreach ($situacion_cliente as $row) {?>
                                        <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$agremiado->id_situacion)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					</form>
					
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row justify-content-center">
        
            <div class="col col-sm-12 align-self-center">

                <div class="card">
                    <div class="card-header">
                        <strong>
                            Registro de ITF
                        </strong>
                    </div>
				
                    <form class="form-horizontal" method="post" action="" id="frmRevisorUrbano" autocomplete="off">
                    <!--<input type="hidden" name="id" id="id" value="0">-->
                    
                    <div class="row" style="padding:20px 20px 0px 20px;">
				
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                            C&oacute;digo ITF
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="codigo_itf" id="codigo_itf" value="" class="form-control form-control-sm">
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
                                <!--<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />-->
                                <input class="btn btn-success" value="Generar C&oacute;digo RU" type="button" id="btnNuevo" style="margin-left:15px"/>
                            </div>

                            <!--<div style="float:left;padding-top:7px">C&oacute;digo RU</div>
                                <div style="float:left" class="col-lg-2 md-form md-outline input-with-post-icon">
                                <input class="form-control form-control-sm" id="codigo_ru" name="codigo_ru" readonly="readonly">
                                </div>
                            </div>-->
                        </div>
                    </div>
					</form>
                </div>

            <div class="card-body">

                <div class="row justify-content-center">
        
                    <div class="col col-sm-12 align-self-center">

                        <div class="card">
                            <div class="card-header">
                                <strong>
                                    Lista de C&oacute;digo RU
                                </strong>
                            </div><!--card-header-->

                    <form class="form-horizontal" method="post" action="" id="frmCodigoRU" autocomplete="off">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    
                    <div class="row" style="padding:20px 20px 0px 20px;">

                        <div class="col-lg-1 col-md-4 col-sm-12 col-xs-12">
							<input class="form-control form-control-sm" id="numero_cap_bus" name="numero_cap_bus" placeholder="N° de CAP">
						</div>

                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
							<input class="form-control form-control-sm" id="agremiado_bus" name="agremiado_bus" placeholder="Agremiado">
						</div>

                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
							<input class="form-control form-control-sm" id="codigo_itf_bus" name="codigo_itf_bus" placeholder="C&oacute;digo ITF">
						</div>

                        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
							<input class="form-control form-control-sm" id="codigo_ru_bus" name="codigo_ru_bus" placeholder="C&oacute;digo RU">
						</div>

                        <div class="col-lg-2 col-md-1 col-sm-12 col-xs-12">
							<select name="situacion_pago" id="situacion_pago" class="form-control form-control-sm">
                                <option value="" selected="selected">--Selecionar Situaci&oacute;n Venta--</option>
                                <option value="0">PENDIENTE</option>
								<option value="1">PAGADO</option>
                                <option value="2">EXONERADO</option>
                                <option value="3">ANULADO</option>
                                
								<!--<option value="">Todos</option>
								<option value="1" selected="selected">Pendientes</option>
                                <option value="0">Eliminado</option>
								<option value="2">Pagados</option>-->
							</select>
						
                        </div>

                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
							<select name="estado" id="estado" class="form-control form-control-sm">
                                <option value="">Todos</option>
								<option value="1" selected="selected">Activo</option>
                                <option value="0">Inactivo</option>
								<!--<option value="">Todos</option>
								<option value="1" selected="selected">Pendientes</option>
                                <option value="0">Eliminado</option>
								<option value="2">Pagados</option>-->
							</select>
						
                        </div>
						<div class="col-lg-2 col-md-1 col-sm-12 col-xs-12" style="padding-right:0px">
							<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
                            <input class="btn btn-sm btn-secondary float-rigth" value="Descargar" name="descargar" type="button" id="btnDescargar" style="padding-left:15px;padding-right:15px;margin-right:10px;" /> 
						
						</div>

                    </div>
					
                <div class="card-body">				

                    <div class="table-responsive">
                    <table id="tblAfiliado" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                            <th>CAP</th>
                            <th>Nombre</th>
                            <th>Fecha Colegiado</th>
                            <th>Situaci&oacute;n</th>
                            <th>C&oacute;digo ITF</th>
                            <th>C&oacute;digo RU</th>
                            <th>Fecha</th>
                            <th>Serie</th>
                            <th>N&uacute;mero</th>
                            <th>Sit. Documento Venta</th>
                            <th>Estado</th>
							<th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!--table-responsive-->
                
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

<script src="{{ asset('js/revisorUrbano/lista.js') }}"></script>

@endpush
