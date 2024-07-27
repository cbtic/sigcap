<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->

<style>
	#tblCoordinadorSesion tbody tr{
		font-size:13px
	}
    
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
            <li class="breadcrumb-item active">Consulta de Conceptos</li>
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
                        Registro de Coordinador Zonal <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Registro de Coordinador Zonal
                    </strong>
                </div><!--card-header-->
				
				<!--<form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">-->
                <form method="post" action="#" id="frmAfiliacion" name="frmAfiliacion">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="0">
				
				<div class="row" style="padding:20px 20px 0px 20px;">
								
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Regional
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <select name="regional" id="regional" class="form-control form-control-sm" onChange="">
                                        <option value="">--Selecionar--</option>
                                            <?php
                                            foreach ($region as $row) {?>
                                                <option value="<?php echo $row->id?>" <?php if($row->id=='5')echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Periodo
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <?php 
                                if($periodo_activo){
                                ?>
                                <input type="hidden" name="periodo" id="periodo" value="<?php echo $periodo_activo->id?>">
                                <select name="periodo" id="periodo" class="form-control form-control-sm" onChange="" disabled="disabled">
                                    <option value="">--Selecionar--</option>
                                    <?php
									foreach ($periodo as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==$periodo_activo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
									<?php 
                                        }
                                        ?>
                                </select>
                                <?php
                                }else{
                                ?>
                                <select name="periodo" id="periodo" class="form-control form-control-sm" onChange="">
                                    <option value="">--Selecionar--</option>
                                    <?php
									foreach ($periodo as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==$periodo_ultimo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
									<?php 
                                        }
                                        ?>
                                </select>
                                <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    N&deg; CAP
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="numero_cap" id="numero_cap" value="<?php echo $agremiado->numero_cap?>" class="form-control form-control-sm" onChange="obtenerAgremiadoCoordinador()" >
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    DNI
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="dni" id="dni" value="<?php echo $persona->numero_documento?>" class="form-control form-control-sm" readonly='readonly' onChange="" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Ap. Paterno
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="apellido_paterno" id="apellido_paterno" value="<?php echo $persona->apellido_paterno?>" class="form-control form-control-sm" readonly='readonly' onChange="" >
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Ap. Materno
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="apellido_materno" id="apellido_materno" value="<?php echo $persona->apellido_paterno?>" class="form-control form-control-sm" readonly='readonly' onChange="" >
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Nombres
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="nombre" id="nombre" value="<?php echo $persona->nombres?>" class="form-control form-control-sm"  readonly='readonly' onChange="" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Zonal
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
									<select name="zonal" id="zonal" class="form-control form-control-sm">
									  <option value="">--Selecionar--</option>
										<?php
										  foreach ($zonal as $row) {?>
										  <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
										  <?php
											}
											?>
									</select>
                                </div>
                                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    Estado
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                    <select name="estado_coordinador" id="estado_coordinador" class="form-control form-control-sm">
									  <option value="">--Selecionar--</option>
										<?php
										  foreach ($estado as $row) {?>
										  <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
										  <?php
											}
											?>
									</select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
						<!--<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
						
                        <a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                        <input class="btn btn-success" value="Guardar" type="button" id="btnNuevo" style="margin-left:15px"/>

					</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <strong>
                            Lista de Coordinador Zonal
                        </strong>
                    </div>
                    <div class="row" style="padding:20px 20px 0px 20px;">
                            
                        <div class="col-lg-2">
                            <div class="form-group">
                                <?php 
                                if($periodo_activo){
                                ?>
                                <input type="hidden" name="periodo_" id="periodo_" value="<?php echo $periodo_activo->id?>">
                                <select name="periodo_" id="periodo_" class="form-control form-control-sm" onchange="" disabled="disabled">
                                <option value="0">--Selecionar--</option>
                                    <?php
                                    foreach ($periodo as $row) {?>
                                        <option value="<?php echo $row->id?>" <?php if($row->id==$periodo_activo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <?php
                                }else{
                                ?>
                                <select name="periodo_" id="periodo_" class="form-control form-control-sm" onchange="">
                                <option value="0">--Selecionar--</option>
                                    <?php
                                    foreach ($periodo as $row) {?>
                                        <option value="<?php echo $row->id?>" <?php if($row->id==$periodo_ultimo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <input class="form-control form-control-sm" id="numero_cap_" name="numero_cap_" placeholder="N&uacute;mero CAP">
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <input class="form-control form-control-sm" id="agremiado_" name="agremiado_" placeholder="Nombres">
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <select name="id_municipalidad_bus" id="id_municipalidad_bus" class="form-control form-control-sm" >
                                <option value="">--Municipalidad--</option>
                                <?php
                                foreach ($municipalidad as $row) {?>
                                <option value="<?php echo $row->denominacion?>"><?php echo $row->denominacion?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <select name="estado_" id="estado_" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                <option value="1" selected="selected">Activo</option>
                                <option value="2">Cesado</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
						<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
						
                        <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                        <!--<input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>-->

					</div>
                </div>
                                    
                <div class="card-body">

                        <div class="table-responsive">
                        <table id="tblAfiliado" class="table table-hover table-sm">
                            <thead>
                            <tr style="font-size:13px">
                                <th>N°</th>
                                <th>N° CAP</th>
                                <th>Agremiado</th>
                                <th>Zonal</th>
                                <th>Municipalidad</th>
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
                <div class="card">
                    <div class="card-header">
                        <strong>
                            Lista de Programaci&oacute;n de sesiones
                        </strong>
                    </div>
                    <div class="row" style="padding:20px 20px 0px 20px;">
                            
                        <div class="col-lg-2">
                            <div class="form-group">
                                <?php 
                                if($periodo_activo){
                                ?>
                                <input type="hidden" name="periodo_2" id="periodo_2" value="<?php echo $periodo_activo->id?>">
                                <select name="periodo_2_" id="periodo_2_" class="form-control form-control-sm" onchange="" disabled="disabled">
                                <option value="0">--Selecionar--</option>
                                    <?php
                                    foreach ($periodo as $row) {?>
                                        <option value="<?php echo $row->id?>" <?php if($row->id==$periodo_activo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <?php
                                }else{
                                ?>
                                <select name="periodo_2" id="periodo_2" class="form-control form-control-sm" onchange="" disabled="disabled">
                                <option value="0">--Selecionar--</option>
                                    <?php
                                    foreach ($periodo as $row) {?>
                                        <option value="<?php echo $row->id?>" <?php if($row->id==$periodo_ultimo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
                                    <?php 
                                    }
                                    ?>
                                </select>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-lg-1-5 col-md-1 col-sm-12 col-xs-12">
                            <select name="mes_" id="mes_" class="form-control form-control-sm">
                                <option value="">--Seleccionar Mes--</option>
                                <?php
                                foreach ($meses as $numero => $nombre) {
                                    $selected = ($numero == $mes_actual) ? 'selected="selected"' : '';
                                    echo "<option value='{$numero}' {$selected}>{$nombre}</option>";
                                }
                                ?> 
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <input class="form-control form-control-sm" id="agremiado_2" name="agremiado_2" placeholder="Nombres">
                        </div>

                        <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
                            <input class="form-control form-control-sm" id="fecha_inicio_bus" name="fecha_inicio_bus" placeholder="Fecha Desde">
                        </div>
                        <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
                            <input class="form-control form-control-sm" id="fecha_fin_bus" name="fecha_fin_bus" placeholder="Fecha Hasta">
                        </div>
                        
                        <div class="col-lg-2 col-md-1 col-sm-12 col-xs-12">
                            <select name="id_estado_aprobacion_bus" id="id_estado_aprobacion_bus" class="form-control form-control-sm">
                                <option value="">--Estado Aprobaci&oacute;n--</option>
                                <?php
                                foreach ($estado_aprobacion as $row) {?>
                                <option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
                                <?php 
                                }
                                ?>
                            </select>
                        </div>
                        
                        <!--<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <select name="estado_2" id="estado_2" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                <option value="1" selected="selected">Activo</option>
                                <option value="2">Cesado</option>
                            </select>
                        </div>-->
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
						<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar_" />
						
                        <!--<a href="/empresa" class="btn btn-success pull-rigth" style="margin-left:15px"/>NUEVO</a>-->
                        <!--<input class="btn btn-success" value="NUEVO" type="button" id="btnNuevo" style="margin-left:15px"/>-->

					</div>
                </div>
                                    
                <div class="card-body">

                        <div class="table-responsive">
                        <table id="tblCoordinadorSesion" class="table table-hover table-sm">
                            <thead>
                            <tr style="font-size:13px">
                                <th>Periodo</th>
                                <th>Tipo Comisi&oacute;n</th>
                                <th>Coordinador</th>
                                <th>Comisi&oacute;n</th>
                                <th>Fecha Programada</th>
                                <th>Fecha Ejecuci&oacute;n</th>
                                <th>Sesi&oacute;n Programada</th>
                                <th>Estado Sesi&oacute;n</th>
                                <th>Estado Aprobaci&oacute;n</th>
                                <th>Informe</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                    </div><!--table-responsive-->
                    </form>
                </div>
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

<script src="{{ asset('js/coordinador_zonal/lista.js') }}"></script>

@endpush
