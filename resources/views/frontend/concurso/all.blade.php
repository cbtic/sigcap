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

.wrapper { 
	/*background:#EFEFEF; */
	/*box-shadow: 1px 1px 10px #999; */
	margin: auto; 
	text-align: center; 
	position: relative;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	margin-bottom: 20px !important;
	width: 800px;
	padding-top: 5px;
}
.scrolls { 
	overflow-x: scroll;
	overflow-y: hidden;
	height: 200px;
	white-space:nowrap
} 
.imageDiv img { 
	box-shadow: 1px 1px 10px #999; 
	margin: 2px;
	max-height: 50px;
	cursor: pointer;
	display:inline-block;
	*display:inline;
	*zoom:1;
	vertical-align:top;
}


.img_ruta{
	position:relative;
	float:left
}

.delete_ruta{
	background-image:url(img/delete.png);
	top:0px;
	left:110px;
	background-size: 100%;
	position:absolute;
	display:block;
	width:30px;
	height:30px;
	cursor:pointer
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
                        Consulta de Concurso <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Lista de Concursos
                    </strong>
                </div><!--card-header-->
				
				<form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				
				<div class="row" style="padding:20px 20px 0px 20px;">
				
					<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
						<?php 
                        if($periodo_activo){
                        ?>
						<input type="hidden" name="id_periodo_bus" id="id_periodo_bus" value="<?php echo $periodo_activo->id?>">
						<select name="id_periodo_bus_" id="id_periodo_bus_" class="form-control form-control-sm" onChange="obtenerComision()" disabled="disabled">
							<option value="">--Periodo--</option>
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
						<select name="id_periodo_bus" id="id_periodo_bus" class="form-control form-control-sm" onChange="obtenerComision()">
							<option value="">--Periodo--</option>
							<?php
							foreach ($periodo as $row) {?>
							<option value="<?php echo $row->id?>" <?php if($row->id==$periodo_ultimo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
							<?php 
							}
							?>
						</select>
						<?php } ?>
					</div>
					
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<select name="id_tipo_concurso_bus" id="id_tipo_concurso_bus" class="form-control form-control-sm" onChange="obtenerSubTipoConcursoBus()">
							<option value="">--TIPO CONCURSO--</option>
							<?php
							foreach ($tipo_concurso as $row) {?>
							<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$concurso->id_tipo_concurso)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
							<?php 
							}
							?>
						</select>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<select name="id_sub_tipo_concurso_bus" id="id_sub_tipo_concurso_bus" class="form-control form-control-sm">
							<option value="">--SUBTIPO CONCURSO--</option>
						</select>
					</div>
					
                    <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
						<select name="estado" id="estado" class="form-control form-control-sm">
							<option value="">Todos</option>
							<option value="1" selected="selected">Activo</option>
							<option value="0">Eliminado</option>
						</select>
					</div>

                    
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
						<input class="btn btn-warning pull-rigth" value="Buscar" type="button" id="btnBuscar" />
						<input class="btn btn-success pull-rigth" value="Nuevo" type="button" id="btnNuevo" style="margin-left:15px" />
					</div>
				</div>
				
                <div class="card-body">				

                    <div class="table-responsive">
                    <table id="tblAfiliado" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                            <!--<th>Id</th>-->
							<th>Periodo</th>
							<th>Tipo Concurso</th>
							<th>SubTipo Concurso</th>
							<th>Fecha Concurso</th>
							<th>Fecha Inscripci&oacute;n Inicio</th>
							<th>Fecha Inscripci&oacute;n Fin</th>
							<th>Fecha Acreditaci&oacute;n Inicio</th>
							<th>Fecha Acreditaci&oacute;n Fin</th>
							<th>Estado</th>
                            <th class="text-center">Acciones</th>
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

<script src="{{ asset('js/concurso/lista.js') }}"></script>

@endpush
