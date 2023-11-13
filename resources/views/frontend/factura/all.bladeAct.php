<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->

<style>
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

</style>

@extends('frontend.layouts.app1')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Facturacion</li>
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
    <div class="justify-content-center">

        <div class="card">

        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        Consultar Facturas <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">

        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Lista de Facturación
                    </strong>
                    <strong>
                        <button type="button"
                            class="btn btn-primary btn-sm"
                            data-toggle="modal"
                            data-target="#exampleModal2">
                                Nuevo
                        </button>
                    </strong>
                    <strong>
                        <button type="button"
                            class="btn btn-success btn-sm"
                            data-toggle="modal"
                            data-target="#exampleModal">
                                Exporta
                        </button>
                    </strong>
                </div><!--card-header-->

				<div class="col-md-12" style="padding-top:10px">
					<input class="form-control" id="system-search" name="q" placeholder="Buscar ...">
				</div>
                <div class="card-body">

                    <div class="table-responsive">
                    <table id="tblFactura" class="table table-hover table-sm">
                        <thead>
                        <tr>
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
                            <!--<th>Observaciones</th>-->
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($facturas as $row): ?>
                                <tr style="font-size:13px">
                                    <td class="text-left"><?php echo $row->fac_serie?></td>
                                    <td class="text-left"><?php echo $row->fac_numero?></td>
                                    <td class="text-left"><?php echo $row->fac_tipo?></td>
									<td class="text-left"><?php echo $row->fac_fecha?></td>
                                    <td class="text-left"><?php echo $row->fac_cod_tributario?></td>
									<td class="text-left"><?php echo $row->fac_destinatario?></td>
									<td class="text-right"><?php echo number_format($row->fac_subtotal,2)?></td>
                                    <td class="text-right"><?php echo number_format($row->fac_impuesto,2)?></td>
                                    <td class="text-right"><?php echo number_format($row->fac_total,2)?></td>
                                    <td class="text-left"><?php echo $row->fac_estado_pago?></td>
                                    <td class="text-left"><?php echo $row->fac_anulado?></td>
                                    <!--<td class="text-left"><?php echo $row->fac_observacion?></td>-->

									<td class="text-center">
                                        <div class="form-group">
                                            {!! Form::open(['url' => 'factura/create', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                            {{ Form::hidden('fac_id', $row->id) }}
                                            {{ Form::hidden('Trans', 'FE') }}
                                            {!! Form::submit('Editar') !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-group">
                                            {!! Form::open(['url' => 'factura/create', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                            {{ Form::hidden('fac_id', $row->id) }}
                                            {{ Form::hidden('Trans', 'FN') }}
                                            {!! Form::submit('Anular') !!}
                                            {!! Form::close() !!}
                                        </div>
                                        <!--
                                        <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Anular Factura</b>">
                                            <a href="/ver_receta_atendida/1/" class="btn btn-danger btn-xs"><i class="fa fa-xing"></i></a>
                                        </div>
                            -->
                                    </td>
                                </tr>
                            <?php endforeach;?>

                        </tbody>
                    </table>
                </div><!--table-responsive-->

                </div><!--card-body-->
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
                                        <div id="" class="row">
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    {!! Form::open(['url' => 'factura/create', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                                    {{ Form::hidden('TipoF', 'FTFT') }}
                                                    {{ Form::hidden('Trans', 'FN') }}
                                                    {!! Form::submit('Factura') !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <!-- <button type="button" id="Save" style="height:30px!important;line-height:10px" class="btn btn-info btn-xs" ><i class="fa fa-file"></i> Boleta</button>-->
                                                    {!! Form::open(['url' => 'factura/create', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                                    {{ Form::hidden('TipoF', 'BVBV') }}
                                                    {{ Form::hidden('Trans', 'FN') }}
                                                    {!! Form::submit('Boleta') !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div id="" class="row">
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <!--<button type="button" id="Save" style="height:30px!important;line-height:10px" class="btn btn-primary btn-xs" ><i class="fa fa-file"></i> NC Factura</button>-->
                                                    {!! Form::open(['url' => 'factura/create', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                                    {{ Form::hidden('TipoF', 'NCFT') }}
                                                    {{ Form::hidden('Trans', 'FN') }}
                                                    {!! Form::submit('NC Factura') !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <!--<button type="button" id="Save" style="height:30px!important;line-height:10px" class="btn btn-info btn-xs" ><i class="fa fa-file"></i> NC Boleta</button>-->
                                                    {!! Form::open(['url' => 'factura/create', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                                    {{ Form::hidden('TipoF', 'NCBV') }}
                                                    {{ Form::hidden('Trans', 'FN') }}
                                                    {!! Form::submit('NC Boleta') !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div id="" class="row">
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <!--<button type="button" id="Save" style="height:30px!important;line-height:10px" class="btn btn-primary btn-xs" ><i class="fa fa-file"></i> ND Factura</button>-->
                                                    {!! Form::open(['url' => 'factura/create', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                                    {{ Form::hidden('TipoF', 'NDFT') }}
                                                    {{ Form::hidden('Trans', 'FN') }}
                                                    {!! Form::submit('ND Factura') !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <!--<button type="button" id="Save" style="height:30px!important;line-height:10px" class="btn btn-info btn-xs" ><i class="fa fa-file"></i> ND Boleta</button>-->
                                                    {!! Form::open(['url' => 'factura/create', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                                                    {{ Form::hidden('TipoF', 'NDBV') }}
                                                    {{ Form::hidden('Trans', 'FN') }}
                                                    {!! Form::submit('ND Boleta') !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
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
<script type="text/javascript">
$(document).ready(function () {
	$('#tblFactura').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search").keyup(function() {
			var dataTable = $('#tblFactura').dataTable();
		   dataTable.fnFilter(this.value);
		});
});
</script>
@endpush
