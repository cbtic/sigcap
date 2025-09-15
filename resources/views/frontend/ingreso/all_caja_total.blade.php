<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->
<style type="text/css">
    .dataTables_length {
        float: left !important;
    }

    .tooltip>.tooltip-inner {
        background-color: #5cb85c !important;
        color: #FFFFFF;
        border: 1px solid #5cb85c !important;
        padding: 4px;
        font-size: 11px;
    }

    .tooltip.top>.tooltip-arrow {
        border-top: 2px solid #5cb85c !important;
    }

    .tooltip.bottom>.tooltip-arrow {
        border-bottom: 2px solid #5cb85c !important;
    }

    .tooltip.left>.tooltip-arrow {
        border-left: 2px solid #5cb85c !important;
    }

    .tooltip.right>.tooltip-arrow {
        border-right: 2px solid #5cb85c !important;
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

    .selected {
        background-color: brown;
        color: #FFF;
    }

    /*
    #btnBoleta{
        padding: 3px!important;
        font-size: 10px;

    }
*/
    #tblPago .form-horizontal {
        margin-bottom: 0px !important;
        padding-bottom: 0px !important;
    }

    .auto_height {
        /* CSS */
        width: 100%;
    }
</style>

@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
	<li class="breadcrumb-item text-primary">Inicio</li>
	<li class="breadcrumb-item active">Cuadre de Caja</li>
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
							Cuadre de Caja  <!--<small class="text-muted">Usuarios activos</small>-->
						</h4>
					</div><!--col-->
				</div>

				<div class="row justify-content-center">

					<div class="col col-sm-12 align-self-center">

						<div class="card">
							<div class="card-header">
								<strong>
									Cuadre de Caja
								</strong>
							</div><!--card-header-->


							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

							<div class="row" style="padding:20px 20px 0px 20px;">
							
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Fecha</label>
										<input class="form-control form-control-sm" id="fecha" name="fecha" value="<?php echo date("d-m-Y")?>" placeholder="Fecha">										
									</div>
								</div>



								<div class="col-lg-3 col-md-1 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-control-sm">Caja</label>
										<select name="id_usuario_caja" id="id_usuario_caja" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($caja_usuario as $row):?>
											<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
										</select>
									</div>
								</div>
									


								<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12" style="padding-right:0px">
									<input class="btn btn-warning pull-rigth" value="Buscar" type="button"  id="btnBuscar" />
									
								</div>

							</div>

						</div>

						<div class="card-body">
							<div id="divCaja" class="table-responsive">
								<table id="tblCaja" class="table table-hover table-sm">
									<thead>
										<tr style="font-size:13px">
											<th>Situación</th>
											<th>Documento</th>
											<th>Total</th>
											<th>Cantidad</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div><!--table-responsive-->
						</div>

						<div class="card-body">
							<div id="divCondicion" class="table-responsive">
								<table id="tlbCondicion" class="table table-hover table-sm">
									<thead>
										<tr style="font-size:13px">
											<th>Condición</th>
											<!--
											<th>Toral US$</th>
											<th>Total S/</th>
											-->
											<th>Total en Soles</th>
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
		<script src="{{ asset('js/caja.js') }}"></script>											
	@endpush