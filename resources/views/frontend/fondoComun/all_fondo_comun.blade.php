<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->

<style>

	table, tr td {
		/*border: 1px solid red*/
	}
	tbody {
		display: block;
		height: 520px;
		overflow: auto;
	}
	thead, tbody tr, tfoot tr {
		display: table;
		width: 100%;
		table-layout: fixed;/* even columns width , fix width of table too*/
	}
	thead {
		width: calc( 100% - 1em )/* scrollbar is average 1em/16px width, remove it from thead width */
	}
	table {
		width: 500px;
	}


	#tblAfiliado tbody tr {
		font-size: 13px
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
		margin: 15px
			/* background: #f1f1f1;*/
			/*overflow-y: scroll !important;*/
	}

	.margin {

		margin-bottom: 20px;
	}

	.margin-buscar {
		margin-bottom: 5px;
		margin-top: 5px;
	}

	/*.row{
        margin-top:10px;
        padding: 0 10px;
    }*/
	.clickable {
		cursor: pointer;
	}

	/*.panel-heading div {
        margin-top: -18px;
        font-size: 15px;        
    }
    .panel-heading div span{
        margin-left:5px;
    }*/
	.panel-body {
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
		position: absolute;
		background-color: #000;
		opacity: 0.6;
		filter: alpha(opacity=40);
		display: none;
	}

	.dataTables_processing {
		position: absolute;
		top: 50%;
		left: 50%;
		width: 500px !important;
		font-size: 1.7em;
		border: 0px;
		margin-left: -17% !important;
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
	<li class="breadcrumb-item active">Fondo Com&uacute;n</li>
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
			<form class="form-horizontal" method="post" action="" id="frmAfiliacion" autocomplete="off">

				<div class="row">
					<div class="col-sm-5">
						<h4 class="card-title mb-0 text-primary">
							Fondo Com&uacute;n  <!--<small class="text-muted">Usuarios activos</small>-->
						</h4>
					</div><!--col-->
				</div>

				<div class="row justify-content-center">

					<div class="col col-sm-12 align-self-center">

						<div class="card">
							<div class="card-header">
								<strong>
									Fondo Com&uacute;n
								</strong>
							</div><!--card-header-->


							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

							<div class="row" style="padding:20px 20px 0px 20px;">

							
								<div class="col-lg-3 col-md-2 col-sm-12 col-xs-12">
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
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<select name="id_municipalidad" id="id_municipalidad" class="form-control form-control-sm">
										<option value="">--Seleccionar Municipalidad--</option>
										<//?php
										foreach ($municipalidad as $row) { ?>
											<option value="<//?php echo $row->id ?>" <//?php /*if($row->id==$comision->id_municipalidad)echo "selected='selected'"*/ ?>><//?php echo $row->denominacion ?></option>
										<//?php}?>
									</select>
								</div>

									-->

								<!--

									-->

								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding-right:0px">
									<input class="btn btn-warning pull-rigth" value="Buscar" type="button"  id="btnBuscar" />									
								</div>

								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="padding-right:0px">
									<input class="btn btn-success pull-rigth" value="Calcular" type="button"  id="btnCalcular" />
								</div>

							</div>

							<div class="row" style="padding:20px 20px 0px 20px;">
								<!--
								<div class="col-lg-6">
									<div class="form-group">
										<select name="id_comision" id="id_comision" class="form-control form-control-sm" onChange="">
											<option value="">--Seleccionar Comisi&oacute;n--</option>
											<?php
											foreach ($comision as $row) { ?>
												<option value="<?php echo $row->id ?>"><?php echo $row->comision . " " . $row->denominacion ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
										-->


							</div>

								
							
						</div>

						<div class="card-body">
							<div id="divPlanilla" class="table-responsive">
								<table id="tblPlanilla" class="table table-hover table-sm">
									<thead>
										<tr style="font-size:13px">
											<th>Municipalidad</th>
											<th>Importe Bruto</th>
											<th>IGV 18%</th>
											<th>Comisi&oacute;n CAP RL 30%</th>
											<th>Fondo Asistencia 2%</th>
											<th>Saldo a favor de Delegados</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div><!--table-responsive-->

						</div>
					</div>

					@endsection

					<div id="openOverlayOpc" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">

								<div class="modal-body" style="padding: 0px;margin: 0px">

									<div id="diveditpregOpc"></div>

								</div>

							</div>

						</div>

					</div>
				</div>
			</form>
		</div>
	</div>

	@push('after-scripts')
	
				<script src="{{ asset('js/FondoComun.js') }}"></script>
												
<!--
	<script>
		function cargarFondoComun() {

			$("#divPlanilla").html("");
			$.ajax({
				//url: "/concurso/obtener_concurso_documento/"+id_concurso_inscripcion,
				url: "/fondoComun/obtener_fondo_comun",
				data: $("#frmAfiliacion").serialize(),
				type: "POST",
				success: function(result) {
					$("#divPlanilla").html(result);
				}
			});

		}

		function fn_calcular() {
			//var anio = $('#anio').val();
			//var mes = $('#mes').val();
			var p = {};
			p.anio = $('#anio').val();
			p.mes = $('#mes').val();

			//alert(mes);
			$.ajax({
				url: "/fondoComun/calcula_fondo_comun",
				type: "GET",
				data: p,
				success: function(result) {
					//if(result="success")obtenerPlanDetalle(id_plan);
					cargarFondoComun();
				}
			});
		}


	</script>
	-->

	@endpush