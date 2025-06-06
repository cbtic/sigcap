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
							Reportes <!--<small class="text-muted">Usuarios activos</small>-->
						</h4>
					</div><!--col-->
				</div>

				<div class="row justify-content-center">

					<div class="col col-sm-12 align-self-center">

						<div class="card">
							<div class="card-header">
								<strong>
									Reportes
								</strong>
							</div><!--card-header-->


							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

							<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="<?php echo $tipo_reporte?>">	

							<div class="row" style="padding:20px 20px 0px 20px;">

							<!--
					
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
-->
								<div id="div_fecha_ini" class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Fecha Inicio</label>
										<input class="form-control form-control-sm" id="fecha_ini" name="fecha_ini" value="<?php echo date("d-m-Y")?>" placeholder="Fecha Inicio">										
									</div>
								</div>
								
								<div id="div_fecha_fin" class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Fecha Fin</label>
										<input class="form-control form-control-sm" id="fecha_fin" name="fecha_fin" value="<?php echo date("d-m-Y")?>" placeholder="Fecha fin">
									</div>
								</div>

								<div id="div_fecha_cierre" class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Fecha Cierre</label>
										<input class="form-control form-control-sm" id="fecha_cierre" name="fecha_cierre" value="<?php echo "31-12-".(date("Y")-1)?>" placeholder="Fecha Cierre">
									</div>
								</div>

								<div id="div_fecha_consulta" class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Fecha Consulta</label>
										<input class="form-control form-control-sm" id="fecha_consulta" name="fecha_consulta" value="<?php echo (date("d-m-Y"))?>" placeholder="Fecha Consulta">
									</div>
								</div>
								
								<div id="div_usuario" class="col-lg-2 col-md-1 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Usuario</label>
										<select name="id_usuario" id="id_usuario" class="form-control form-control-sm" onchange="obtenerCaja()">
											<option value="">Todos</option>
											<?php foreach($caja_usuario as $row):?>
											<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
										</select>
									</div>
								</div>

								<div id="div_caja" class="col-lg-2 col-md-1 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Caja</label>
										<select name="id_caja" id="id_caja" class="form-control form-control-sm">
											<option value="">Todos</option>
										</select>
									</div>
								</div>

								<div id="div_forma_pago" class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
									<label class="form-group">Forma de pago</label>
									<select name="id_formapago" id="id_formapago" class="form-control form-control-sm" onChange="">
										<option value="">Todos</option>
										<?php
										foreach ($formapago as $row) { ?>
											<option value="<?php echo $row->codigo ?>"><?php echo $row->denominacion ?></option>
										<?php
										}
										?>
									</select>
								</div>

								<div id="div_estado_pago" class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
									<label class="form-group">Estado de pago</label>
									<select name="id_estadopago" id="id_estadopago" class="form-control form-control-sm" onChange="">
										<option value="">Todos</option>
										<option value="P">Pendiente</option>
										<option value="C">Cancelado</option>

									</select>
								</div>
								<?php if($reporte[0]->id_tipo!=3){ ?>
								<div id="div_concepto" class="col-lg-3 col-md-1 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Conceptos</label>
										<select name="id_concepto" id="id_concepto" class="form-control form-control-sm" >
											<option value="">Todos</option>
											<?php foreach($concepto as $row):?>
											<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
										</select>
									</div>
								</div>
								<?php }else{ ?>
								<div id="div_concepto" class="col-lg-3 col-md-1 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Conceptos</label>
										<select name="id_concepto" id="id_concepto" class="form-control form-control-sm" >
											<option value="">Todos</option>
											<?php foreach($concepto as $row):?>
											<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
										</select>
									</div>
								</div>
								<?php }?>
								
									
<!--
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<input class="btn btn-warning pull-rigth" value="Buscar" type="button"  id="btnBuscar" />									
								</div>
											-->
<!--								
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<input class="btn btn-success pull-rigth" value="Excel" type="button"  id="btnCalcular" />
								</div>
											-->
							</div>
								
							
						</div>
						
						<div class="card-body">
							<div id="divReporte" class="table-responsive">
								<table id="tblReporte" class="table table-hover table-sm">
									<?php
										$mostrarPdf = false;
										foreach ($reporte as $row) {
											if ($row->id_tipo != 3) {
												$mostrarPdf = true;
												break;
											}
										}
									?>
									<thead>
										<tr style="font-size:13px">
											<th>id</th>
											<th>Reporte</th>
											<?php if($mostrarPdf){ ?>
												<th>PDF</th>
											<?php } ?>
											<th>Excel</th>
										</tr>
									</thead>
									<tbody>
										<?php $n = 0;		?>
											<?php foreach ($reporte as $row) { ?>

												<tr>
													<td class="text-left"><?php $n = $n + 1;
																			echo $n; ?>
													</td>

													<td class="text-left">
														<?php														
															echo $row->descripcion //echo $row; ?>
													</td>
													<!--
													<td class="text-left">
														<form class="form-horizontal" method="post" action="{{route('frontend.comprobante.nd_edita')}}" id="frmPagos_nd" name="frmPagos_nd" autocomplete="off">		
	
															<input class="btn btn-info pull-rigth" value="Reporte" type="button" id="btnBoleta" onclick="">
														</form>
													
													</td>
													-->
													
												<?php if($row->id_tipo!=3){ ?>
													<td class="text-left" style="vertical-align:middle">
														<a href="javascript:void(0);"  
																					   onclick="abrirPdfReporte('<?php echo addslashes($row->id); ?>', '<?php echo addslashes($row->por_usuario); ?>', '<?php echo addslashes($row->id_tipo); ?>' )"
														style="font-size: 12px; text-decoration: underline; color: blue;">
															Ver Informe
														</a>
													</td>
													<td>
														<a href="javascript:void(0);"  
																					   onclick="descargarReporte('<?php echo addslashes($row->id); ?>', '<?php echo addslashes($row->por_usuario); ?>', '<?php echo addslashes($row->id_tipo); ?>' )"
														style="font-size: 12px; text-decoration: underline; color: blue;">
															Descargar Excel
														</a>
													</td>
												<?php }else{ ?>
													<td class="text-left" style="vertical-align:middle">
														<a href="javascript:void(0);"  
															onclick="descargarExcel('<?php echo addslashes($row->id); ?>', '<?php echo addslashes($row->por_usuario); ?>', '<?php echo addslashes($row->id_tipo); ?>' )"
														style="font-size: 12px; text-decoration: underline; color: blue;">
															<?php if($row->funcion=='rt' || $row->funcion=='ra' ){?>
															Descargar Excel
															<?php }else if($row->funcion=='rd'){?>
															Descargar CSV
															<?php }?>
														</a>
													</td>
												<?php } ?>
													
												</tr>
												
											<?php } ?>
										

										

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
	
				<script src="{{ asset('js/reporte.js') }}"></script>
												


	@endpush