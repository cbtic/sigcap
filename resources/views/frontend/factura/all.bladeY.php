<!--<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--
<script src="<?php echo URL::to('/') ?>/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/adminlte.min.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/demo.js"></script>
<script src="<?php echo URL::to('/') ?>/dist/js/js.util.grid.js"></script>
<script src="<?php echo URL::to('/') ?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link media="all" type="text/css" rel="stylesheet" href="https://app-gsf.saludpol.gob.pe:29692/css/datatables/dataTables.bootstrap.min.css">
<script src="https://app-gsf.saludpol.gob.pe:29692/js/datatables/datatables.min.js"></script>

<!--<script src="<?php echo URL::to('/') ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>-->
<!--<script src="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>-->
<link rel="stylesheet"
    href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" type="text/css"
    href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#addFiltro').on('click', function () {
        var addFiltro = $('#addFiltro').attr("aria-pressed");
        $("#fsFiltro").hide();
        if(addFiltro == "false"){
            $("#fsFiltro").show();
        }
    });
});
</script>

<style type="text/css">
body {
    background-color: #bdc3c7;
}

.table-fixed {
    width: 100%;
    background-color: #f3f3f3;
}

.table-fixed tbody {
    height: 200px;
    overflow-y: auto;
    width: 100%;
}

.table-fixed thead,
.table-fixed tbody,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
    display: block;
}

.table-fixed tbody td {
    float: left;
}

.table-fixed thead tr th {
    float: left;
    background-color: #f39c12;
    border-color: #e67e22;
}

/* Begin - Overriding styles for this page */
.card-body {
    padding: 0 1.25rem !important;
}

.form-control-sm {
    line-height: 1.1 !important;
    margin: 0 !important;
}

.form-group {
    margin-bottom: 0.5rem !important;
}

.breadcrumb {
    padding: 0.2rem 2rem !important;
    margin-bottom: 0 !important;
}

.card-header {
    padding: 0.2rem 1.25rem !important;
}

.pesajeIngreso {
    line-height: 2.8;
}

.fecha_ingreso_salida {
    color: blue;
    font-size: 14px;
    font-style: italic;
}

br {
    line-height: 30px;
}

/* End - Overriding styles for this page */
</style>

@stack('before-scripts')
{!! script(asset('js/pesaje.js')) !!}
@stack('after-scripts')

@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Facturacion</li>
    </li>
</ol>
@endsection

@section('content')

<div class="justify-content-center">
    <!--<div class="container-fluid">-->

    <div class="card">

        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        Registro de Facturas
                        <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div>
                <!--col-->
            </div>

            <div class="row justify-content-center">
                <div class="col col-sm-12 align-self-center">
                    <form class="form-horizontal" method="post" action="{{ route('frontend.contact.send')}}"
                        id="frmPesaje" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<!--                                                        <strong>
                                                            Filtro
                                                        </strong>-->
                                                        <strong>
                                                            <button type="button" id="addFiltro" class="btn btn-lg btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off">Filtro</button>
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fsFiltro" class="card-body" style="display:none">

                                                <div id="" class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Tipo Documento</label>
                                                            <select name="tipo_documento" id="tipo_documento"
                                                                class="form-control form-control-sm"
                                                                onchange="validaTipoDocumento()">
                                                                <option
                                                                    value="ft">
                                                                    <?php echo "Factura"?></option>
                                                                <option
                                                                    value="bl">
                                                                    <?php echo "Boleta"?></option>
                                                                <option
                                                                    value="nc">
                                                                    <?php echo "Nota de Credito"?></option>
                                                                <option
                                                                    value="nd">
                                                                    <?php echo "Nota de Debito"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Serie</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Numero</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Razon Social</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
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
                                                                    value="P">
                                                                    <?php echo "Cancelado"?></option>
                                                                <option
                                                                    value="p">
                                                                    <?php echo "Pendiente"?></option>
                                                                <option
                                                                    value="t">
                                                                    <?php echo "Todos"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Anulado</label>
                                                            <select name="estado_pago" id="estado_pago"
                                                                class="form-control form-control-sm"
                                                                onchange="validaTipoDocumento()">
                                                                <option
                                                                    value="s">
                                                                    <?php echo "Si"?></option>
                                                                <option
                                                                    value="n">
                                                                    <?php echo "No"?></option>
                                                                <option
                                                                    value="t">
                                                                    <?php echo "Todos"?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="" class="row">

                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">F. Desde</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">F. Hasta</label>
                                                            <input type="text" name="numero_documento"
                                                                id="numero_documento" value="{{old('clinum')}}"
                                                                placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <br>
                                                        <button type="button"
                                                            class="btn btn-warning btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal">
                                                            Buscar
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                </div>
                                <br>

                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>
                                                    <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                                    Lista de Facturas/Boletas
                                                </strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="tblDevolucion" class="table table-hover">
                                                    <!--<table id="example" class="table table-list-search table-hover" style="font-size: 11px !important;" >-->
                                                        <thead>
                                                            <tr>
                                                                <th>Serie</th>
                                                                <th>Nro.</th>
                                                                <th>Tipo</th>
                                                                <th>Fecha</th>
                                                                <th>Ruc</th>
                                                                <th>Razon Social</th>
                                                                <!--<th>Moneda</th>-->
                                                                <th>SubTotal</th>
                                                                <th>Impuesto</th>
                                                                <th>Total</th>
                                                                <th>Estado</th>
                                                                <th>Anulado</th>
                                                                <th>Observaciones</th>
                                                                <th>Editar</th>
                                                                <th>Anular</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($facturas as $f)
                                                            <tr>
                                                                <td>{{$f->fac_serie}}</td>
                                                                <td>{{$f->fac_numero}}</td>
                                                                <td>{{$f->fac_tipo}}</td>
                                                                <td>{{date("d/m/Y", strtotime($f->fac_fecha))}}</td>
                                                                <td>{{$f->fac_cod_tributario}}</td>
                                                                <td>{{$f->fac_destinatario}}</td>
                                                                <!--<td>{{$f->fac_moneda}}</td>-->
                                                                <td>{{$f->fac_subtotal}}</td>
                                                                <td>{{$f->fac_impuesto}}</td>
                                                                <td>{{$f->fac_total}}</td>
                                                                <td>{{$f->fac_estado_pago}}</td>
                                                                <td>{{$f->fac_anulado}}</td>
                                                                <td>{{$f->fac_observacion}}</td>
                                                                <td class="text-center">
                                                                    <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Editar Factura</b>">
                                                                        <a href="/editar_receta_vale/1" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div data-toggle="tooltip" data-placement="top" data-html="true" title="<b>Anular Factura</b>">
                                                                        <a href="/ver_receta_atendida/1/" class="btn btn-danger btn-xs"><i class="fa fa-xing"></i></a>
                                                                    </div>
                                                                </td>
                                        <!--
                                                                <td class="text-right">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
                                                                        <a href="" class="btn btn-sm btn-success">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-backdrop="false" data-target="#delete-log-modal" data-log-date="">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                        -->
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                {!! $facturas->links() !!}
                                                <!--table-responsive-->
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                        <div id="" class="row">
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>

                        <br>

                        <div id="" class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <br>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--col-->


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
        <!--ModalEnd-->


        <!--ModalEnd-->

        <!-- Modal -->

        <!--ModalEnd-->
    </div>
    <!--row-->
    @endsection

    @push('after-scripts')
    @if(config('access.captcha.contact'))
    @captchaScripts
    @endif
    @endpush
