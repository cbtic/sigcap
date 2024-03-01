<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<style>
	#tblPesaje tbody tr{
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



@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Supervisi&oacute;n</li>
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
                        Consultar Facturas<!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">

        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        <!--@lang('labels.frontend.lista_afiliacion.box_title')-->
						Lista de Facturaci&oacute;n
                    </strong>
                </div><!--card-header-->

				<form class="form-horizontal" method="post" action="{{ route('frontend.comprobante.send')}}" id="frmAfiliacion" autocomplete="off">
                 

				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

				<div class="row" style="padding:20px 20px 0px 20px;">

					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<div class="form-group">
                            <label class="form-control-sm">Fecha inicio</label>
							<input class="form-control form-control-sm" id="fecha_ini" name="fecha_ini" value="<?php echo date("d-m-Y")?>" placeholder="Fecha Inicio">
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
						<div class="form-group">
							<label class="form-control-sm">Fecha Fin</label>
							<input class="form-control form-control-sm" id="fecha_fin" name="fecha_fin" value="" placeholder="Fecha fin">
						</div>
					</div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="form-control-sm">Tipo Documento</label>
                            <select name="tipo_documento" id="tipo_documento"
                                class="form-control form-control-sm"
                                onchange="validaTipoDocumento()">                                
                                <option
                                    value="FT">
                                    <?php echo "Factura"?></option>
                                <option
                                    value="BV">
                                    <?php echo "Boleta"?></option>
                                <option
                                    value="NC">
                                    <?php echo "Nota de Credito"?></option>
                                <option
                                    value="ND">
                                    <?php echo "Nota de Debito"?></option>
                                <option
                                    value="TK">
                                    <?php echo "Ticket"?></option>
                                <option selected="selected"
                                    value="">
                                    <?php echo "Todos"?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="form-control-sm">Serie</label>
                            <input type="text" name="serie"
                                id="serie" value="{{old('clinum')}}"
                                placeholder="" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="form-control-sm">Numero</label>
                            <input type="text" name="numero"
                                id="numero" value="{{old('clinum')}}"
                                placeholder="" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="form-control-sm">Razon Social</label>
                            <input type="text" name="razon_social"
                                id="razon_social" value="{{old('clinum')}}"
                                placeholder="" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="form-control-sm">Estado de Pago</label>
                            <select name="estado_pago" id="estado_pago"
                                class="form-control form-control-sm"
                                onchange="validaTipoDocumento()">
                                <option
                                    value="C">
                                    <?php echo "Cancelado"?></option>
                                <option
                                    value="P">
                                    <?php echo "Pendiente"?></option>
                                <option selected="selected"
                                    value="">
                                    <?php echo "Todos"?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="form-control-sm">Anulado</label>
                            <select name="anulado" id="anulado"
                                class="form-control form-control-sm"
                                onchange="validaTipoDocumento()">
                                <option
                                    value="S">
                                    <?php echo "Si"?></option>
                                <option
                                    value="N">
                                    <?php echo "No"?></option>
                                <option selected="selected"
                                    value="">
                                    <?php echo "Todos"?></option>
                            </select>
                        </div>
                    </div>



					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-top:30px">
						<input class="btn btn-warning pull-rigth" value="Buscar" type="button"   id="btnBuscar" />
                    </div>
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-top:30px">						
                        <input class="btn btn-success pull-rigth" value="Nuevo" type="button" id="btnNuevo1" data-toggle="modal" data-target="#exampleModal2" style="margin-left:15px" />

                    </div>
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-top:30px">
						<input class="btn btn-success pull-rigth" value="Excel" type="button" id="btnExcel" onclick="reporteFactura()"/>
					</div>
<!--
					@hasanyrole('contabilidad')
					@else
					<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12" style="padding-top:30px">
						<input class="btn btn-success pull-rigth" value="Excel" type="button" id="btnExcel" onclick="reporteFactura()"/>
					</div>
                    @endhasanyrole
-->
				</div>

                <div class="card-body">

                    <div class="table-responsive">
                    <table id="tblFactura" class="table table-hover table-sm">
                        <thead>
                        <tr style="font-size:13px">
                            <th>Serie</th>
                            <th>Nro.</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Ruc</th>
                            <th>Razón Social</th>							
                            <th class="text-right">SubTotal</th>
                            <th class="text-right">IGV</th>
                            <th class="text-right">Total</th>
                            <th>Estado</th>
                            <th>Anulado</th>
                            <th>Caja</th>
                            <th>Usuario</th>
                            <th>Sunat</th>
							<th class="text-left">Factura</th>
                        </tr>
                        </thead>
                        <tbody style="font-size:13px">

                        </tbody>
                    </table>
                    </div>
                </div>



                <!--card-body-->
            </div><!--card-->
        <!--</div>--><!--col-->
    <!--</div>--><!--row-->

         <!-- Modal -->
         <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Seleccione Tipo de Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-body">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                  
<!--
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
-->
                </div>
            </div>
        </div>


@endsection



@push('after-scripts')

<script src="{{ asset('js/FacturaLista.js') }}"></script>
@endpush

