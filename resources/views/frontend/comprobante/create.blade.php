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

<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->

<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    var urlApp = "<?php echo URL::to('/') ?>";
    //alert(urlApp);

    if (history.forward(1)) {
        location.replace(history.forward(1));
    }

    $(document).ready(function() {

        var total_fac = $("#total_fac").val();

       // alert(total_fac);
        
        OcultarTarjeta();

        $('#addFiltro').on('click', function() {
            var addFiltro = $('#addFiltro').attr("aria-pressed");
            $("#fsFiltro").hide();
            if (addFiltro == "false") {
                $("#fsFiltro").show();
            }
        });

        $('#id_formapago_').change(function() {
            // console.log('Opción seleccionada:', $(this).val());
            //print_r($(this).val());
            if ($(this).val() == 1) {

                OcultarTarjeta();
            }

            if ($(this).val() == 2) {
                MostrarTarjeta();

                $('#numcuota_').val("1");
                var $total=$('#total_fac').val();
                alert($('#totalP').val());
                $('#totalcredito_').val($total)
                $('#plazo_ ').val("30");
                generarCuotas();
            }
            //
        });


    });

    function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function MostrarTarjeta() {
        var tarjeta = document.getElementById('card_cuotas');
        tarjeta.style.display = 'inline';
    }

    function OcultarTarjeta() {
        var tarjeta = document.getElementById('card_cuotas');
        tarjeta.style.display = 'none';
    }

    var cuentaproductos = 0;

    function pad(str, max) {
		str = str.toString();
		return str.length < max ? pad("0" + str, max) : str;
	}

    function sumarDias(fecha, dias) {
		fecha.setDate(fecha.getDate() + dias);
		return fecha;
	}
    function FormatFecha(fecha) {
		//let date = new Date()
		let date = new Date(fecha)
		let day = date.getDate()
		let month = date.getMonth() + 1
		let year = date.getFullYear()

		let fechaFormat
		if (month < 10) {
			fechaFormat = `${year}-0${month}-${day}`
		} else {
			fechaFormat = `${year}-${month}-${day}`
		}
		return fechaFormat;
	}


    function generarCuotas() {

        var n = 0;
        var nroCuotas = $('#numcuota_').val();
        var total = $('#totalcredito_').val();
        var plazo =$('#plazo_').val();
        var d = new Date();
        //fecha_cuota = FormatFecha(sumarDias(d, plazo))

        for (let i = 0; i < nroCuotas; i++) {
            n++; 
            fecha_cuota = FormatFecha( sumarDias(d, 30));
           
            total_frac = parseFloat((total) / (nroCuotas)).toFixed(1);
           
            $('#tblConceptos tr:last').after('<tr id="fila' + pad(n, 2) + '"> <td width="5%">' + n + '</td>   <td width="10%"> <input type="text"  name="importe_" id="importe_" value="'+ total_frac+'" class="form-control form-control-sm"></td>  </td>   <td width="10%"> <input type="date"  name="fechacuota_" id="fechacuota_" value="'+fecha_cuota+'" class="form-control form-control-sm"></td>  </tr> ');
            $('#tblConceptos tr:last').after('<td> <input type="hidden" name="fraccionamiento[' + n + '][Monto]" value=""> </td>');
        }

    }
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

    .btn-xsm {
        font-size: 11px !important;
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

    .flotante {
        display: inline;
        position: fixed;
        bottom: 0px;
        right: 0px;
    }

    .flotanteC {
        display: inline;
        position: fixed;
        bottom: 65px;
        right: 0px;
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


@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app')



@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Facturacion</li>
    <li class="breadcrumb-item active">Editar</li>
    </li>
</ol>
@endsection

@section('content')

<div class="loader"></div>

<div class="justify-content-center">
    <!--<div class="container-fluid">-->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        <?php echo $titulo ?>
                        <!--Edita Factura-->
                        <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div>
                <!--col-->
            </div>
            <div class="row justify-content-center">
                <div class="col col-sm-12 align-self-center">
                    <form class="form-horizontal" method="post" action="{{ route('frontend.comprobante.create')}} " id="frmFacturacion" name="frmFacturacion" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="trans" id="trans" value="<?php echo $trans; ?>">
                        <input type="hidden" name="TipoF" value="<?php if ($trans == 'FA') {
                                                                        echo $TipoF;
                                                                    } ?>">
                        <input type="hidden" name="vestab" value="1">
                        <input type="hidden" name="totalF" value="<?php if ($trans == 'FA') {
                                                                        echo $total;
                                                                    } ?>">
                        <input type="hidden" name="ubicacion" value="<?php if ($trans == 'FA') {
                                                                            echo $ubicacion;
                                                                        } ?>">
                        <input type="hidden" name="persona" value="<?php if ($trans == 'FA') {
                                                                        echo $persona;
                                                                    } ?>">
                        <input type="hidden" name="id_caja" value="<?php if ($trans == 'FA') {
                                                                        echo $id_caja;
                                                                    } ?>">
                        <input type="hidden" name="MonAd" value="<?php if ($trans == 'FA') {
                                                                        echo $MonAd;
                                                                    } ?>">
                        <input type="hidden" name="adelanto" value="<?php if ($trans == 'FA') {
                                                                        echo $adelanto;
                                                                    } ?>">
                        <input type="hidden" name="id_factura" value="<?php if ($trans == 'FE') {
                                                                            echo $facturas->id;
                                                                        } ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div id="" class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div id="" class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            Datos del Cliente
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="fsFiltro" class="card-body">
                                                <div id="" class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Serie</label>
                                                            <select name="serieF" id="serieF" class="form-control form-control-sm">
                                                                <?php if ($trans == 'FA' || $trans == 'FN') { ?>
                                                                    <?php foreach ($serie as $row) : ?>
                                                                        <option value="<?php echo $row->denominacion ?>"><?php echo $row->denominacion ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php } ?>
                                                                <?php if ($trans == 'FE') { ?>
                                                                    <option value="<?php echo $comprobante->serie ?>"><?php echo $comprobante->serie ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" name="divNumeroF" id="divNumeroF">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Número</label>
                                                            <input type="text" name="numerof" readonly id="numerof" value="<?php if ($trans == 'FE') {
                                                                                                                                echo $comprobante->numero;
                                                                                                                            } ?>" placeholder="" class="form-control form-control-sm text-center">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Fecha Emisión</label>
                                                            <?php if ($trans == 'FA' || $trans == 'FN') { ?>
                                                                <input type="text" name="fechaF" id="fechaF" value="<?php echo date("d/m/Y") ?>" placeholder="" class="form-control form-control-sm datepicker">
                                                            <?php } ?>
                                                            <?php if ($trans == 'FE') { ?>
                                                                <input type="text" name="fechaFE" id="fechaFE" value="<?php echo date("d/m/Y", strtotime($comprobante->fecha)) ?>" placeholder="" class="form-control form-control-sm text-center" readonly>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">


                                                        <label class="form-group">Tipo Operaci&oacute;n</label>
                                                        <select name="id_tipooperacion_" id="id_tipooperacion_" class="form-control form-control-sm" onChange="">
                                                            <option value="">--Selecionar--</option>
                                                            <?php
                                                            foreach ($tipooperacion as $row) { ?>
                                                                <option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == 1) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">

                                                        <label class="form-group">Forma de pago</label>
                                                        <select name="id_formapago_" id="id_formapago_" class="form-control form-control-sm" onChange="">
                                                            <option value="">--Selecionar--</option>
                                                            <?php
                                                            foreach ($formapago as $row) { ?>
                                                                <option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == 1) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div id="" class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <label class="form-control-sm">RUC/DNI</label>
                                                        <div class="input-group">
                                                            <input type="text" name="numero_documento" readonly id="numero_documento" value="<?php if ($trans == 'FA') {
                                                                                                                                                    echo $empresa->ruc;
                                                                                                                                                }
                                                                                                                                                if ($trans == 'FE') {
                                                                                                                                                    echo $comprobante->cod_tributario;
                                                                                                                                                } ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                        <button type="button" data-toggle="modal" data-target="#duenoCargaModal" id="" class="btn btn-link btn-xsm">Buscar Empresa</button>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Razón Social/Nombre</label>
                                                            <input type="text" name="numero_documento" readonly id="numero_documento" value="<?php if ($trans == 'FA') {
                                                                                                                                                    echo $empresa->razon_social;
                                                                                                                                                }
                                                                                                                                                if ($trans == 'FE') {
                                                                                                                                                    echo $comprobante->destinatario;
                                                                                                                                                } ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Dirección</label>
                                                            <input type="text" name="direccion" readonly id="numero_documento" value="<?php if ($trans == 'FA') {
                                                                                                                                            echo $empresa->direccion;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FE') {
                                                                                                                                            echo $comprobante->direccion;
                                                                                                                                        } ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Email</label>
                                                            <input type="text" name="direccion" readonly id="numero_documento" value="<?php if ($trans == 'FA') {
                                                                                                                                            echo $empresa->email;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FE') {
                                                                                                                                            echo $comprobante->correo_des;
                                                                                                                                        } ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row" style="display:none">
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Tipo de Operación</label>
                                                            <select name="tipo_documento" id="serieF" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                                                <option value="ft">
                                                                    <?php echo "Venta Interna" ?></option>
                                                                <option value="bl">
                                                                    <?php echo "Exportación" ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Orden Compra</label>
                                                            <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Solicitante</label>
                                                            <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row" style="display:none">
                                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Serie GR</label>
                                                            <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Número GR</label>
                                                            <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Tipo Guia</label>
                                                            <select name="tipo_documento" id="serieF" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                                                <option value="ft">
                                                                    <?php echo "Venta Interna" ?></option>
                                                                <option value="bl">
                                                                    <?php echo "Exportación" ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Serie TR</label>
                                                            <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Número TR</label>
                                                            <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Tipo Documento</label>
                                                            <select name="tipo_documento" id="serieF" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                                                <option value="ft">
                                                                    <?php echo "Venta Interna" ?></option>
                                                                <option value="bl">
                                                                    <?php echo "Exportación" ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->


                                    </div>

                                </div>
                            </div>
                            <br>
                        </div>
                        <div id="" class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>
                                            <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                            Detalle Resumen
                                            <?php
                                            if ($trans == 'FN') { ?>
                                                <button type="button" id="addRow" style="margin-left:10px" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Agregar Item(s)</button>
                                            <?php } ?>
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive overflow-auto" style="max-height: 500px;">
                                            <table id="tblDetalle" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-right" width="5%">#</th>
                                                        <th class="text-center" width="10%">Cant.</th>
                                                        <th width="40%">Descripción</th>
                                                        <th width="40%">%Dscto.</th>
                                                        <th class="text-right" width="15%">PU</th>
                                                        <th class="text-right" width="15%">IGV</th>
                                                        <th class="text-right" width="15%">P.Venta</th>
                                                        <th class="text-right" width="15%">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $n = 0;
                                                    $smodulo = "";
                                                    if ($trans == 'FA' || $trans == 'FE') { ?>
                                                        <?php foreach ($facturad as $key => $fac) {
                                                            //		$smodulo = $fac['smodulo'];
                                                        ?>
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][id]" value="<?php echo $fac['id'] ?>" />
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][fecha]" value="<?php echo $fac['fecha'] ?>" />
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][denominacion]" value="<?php echo $fac['denominacion'] ?>" />
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][descripcion]" value="<?php echo $fac['descripcion'] ?>" />
                                                            s
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][monto]" value="<?php echo $fac['monto'] ?>" />
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][moneda]" value="<?php echo $fac['moneda'] ?>" />
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][id_moneda]" value="<?php echo $fac['id_moneda'] ?>" />
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][descuento]" value="<?php echo $fac['descuento'] ?>" />
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][cod_contable]" value="<?php echo $fac['cod_contable'] ?>" />

                                                            <tr>
                                                                <td class="text-right"><?php $n = $n + 1;
                                                                                        echo $n; ?></td>
                                                                <td class="text-center"><?php if ($trans == 'FA') {
                                                                                            echo $fac['cantidad'];
                                                                                        }
                                                                                        if ($trans == 'FE') {
                                                                                            echo $fac['cantidad'];
                                                                                        } ?></td>
                                                                <td class="text-left">
                                                                    <?php
                                                                    if ($trans == 'FA') {
                                                                        echo $fac['descripcion'];
                                                                    }
                                                                    if ($trans == 'FE') {
                                                                        echo $fac['descripcion'];
                                                                    } ?>
                                                                </td>

                                                                <td class="text-left"><?php if ($trans == 'FA') {
                                                                                            echo $fac['descuento'];
                                                                                        }
                                                                                        if ($trans == 'FE') {
                                                                                            echo $fac['descuento'];
                                                                                        } ?></td>

                                                                <td class="text-right"><?php if ($trans == 'FA') {
                                                                                            if ($adelanto == 'S') {
                                                                                                echo ($MonAd - $MonAd * 0.18);
                                                                                            } else {
                                                                                                echo $fac['pu'];
                                                                                            }
                                                                                        }
                                                                                        if ($trans == 'FE') {
                                                                                            echo number_format($fac['importe'], 2);
                                                                                        } ?></td>
                                                                <td class="text-right"><?php if ($trans == 'FA') {
                                                                                            if ($adelanto == 'S') {
                                                                                                echo ($MonAd * 0.18);
                                                                                            } else {
                                                                                                echo $fac['igv'];
                                                                                            }
                                                                                        }
                                                                                        if ($trans == 'FE') {
                                                                                            echo number_format($fac['igv_total'], 2);
                                                                                        } ?></td>
                                                                <td class="text-right"><?php if ($trans == 'FA') {
                                                                                            if ($adelanto == 'S') {
                                                                                                echo ($MonAd - $MonAd * 0.18);
                                                                                            } else {
                                                                                                echo $fac['pv'];
                                                                                            }
                                                                                        }
                                                                                        if ($trans == 'FE') {
                                                                                            echo number_format($fac['pu'], 2);
                                                                                        } ?></td>
                                                                <td class="text-right"><?php if ($trans == 'FA') {
                                                                                            if ($adelanto == 'S') {
                                                                                                echo $MonAd;
                                                                                            } else {
                                                                                                echo $fac['total'];
                                                                                            }
                                                                                        }
                                                                                        if ($trans == 'FE') {
                                                                                            echo number_format($fac['importe'], 2);
                                                                                        } ?></td>

                                                                <?php
                                                                if ($trans == 'FN') { ?>
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
                                                                <?php } ?>
                                                            </tr>
                                                            <input type="hidden" name="facturad[<?php echo $key ?>][item]" value="<?php echo $n ?>" />
                                                        <?php } ?>
                                                    <?php } ?>

                                                    <input type="hidden" name="smodulo_guia" id="smodulo_guia" value="<?php echo $smodulo ?>" />

                                                </tbody>
                                            </table>
                                        </div>
                                        <!--table-responsive-->
                                    </div>
                                    <!--card-body-->
                                </div>
                                <!--card-->
                            </div>
                            <!--card-->
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>
                                            <!--@lang('labels.frontend.asistencia.box_asistencia')-->
                                            Información de Pago
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tblPago" class="table table-hover">
                                                <tbody>
                                                    <tr style="display:none">
                                                        <th></th>
                                                        <th>Anticipos</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"><span id="anticipos"></span> 0.00</th>
                                                    </tr>
                                                    <tr style="display:none">
                                                        <th></th>
                                                        <th>Descuentos</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"><span id="descuentos"></span> 0.00</th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th>Ope Gravadas</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"><span id="gravadas"></span> <?php if ($trans == 'FA') {
                                                                                                                echo number_format($stotal, 2);
                                                                                                            }
                                                                                                            if ($trans == 'FE') {
                                                                                                                echo number_format($comprobante->subtotal, 2);
                                                                                                            } ?></th>
                                                    </tr>
                                                    <tr style="display:none">
                                                        <th></th>
                                                        <th>Ope Inafectas</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"><span id="inafectas"></span> 0.00</th>
                                                    </tr>
                                                    <tr style="display:none">
                                                        <th></th>
                                                        <th>Ope Exoneradas</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"><span id="exoneradas"></span> 0.00</th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th>I.G.V.</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"><span id="igv"></span> <?php if ($trans == 'FA') {
                                                                                                            echo number_format($igv, 2);
                                                                                                        }
                                                                                                        if ($trans == 'FE') {
                                                                                                            echo number_format($comprobante->impuesto, 2);
                                                                                                        } ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th>Total</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-right"><span id="totalP"></span> <?php if ($trans == 'FA') {
                                                                                                                echo number_format($total, 2);
                                                                                                            }
                                                                                                            if ($trans == 'FE') {
                                                                                                                echo number_format($comprobante->total, 2);
                                                                                                            } ?></th>
                                                        
                                                        <input type="hidden" name="total_fac" id="total_fac" value="<?php echo number_format($total, 2); ?>">                                                                                                            
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--table-responsive-->
                                    </div>
                                    <!--card-body-->
                                </div>
                                <!--card-->



                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <button type="button" id="guardar" class="btn btn-primary btn-block" onclick="$('#guardar').prop('disabled', true); setTimeout(function(){$('#guardar').prop('disabled', false);},5000); ;guardarFactura()">GUARDAR COMPROBANTE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div id="" class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div id="" class="row">
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <strong>
                                                    Cobros y Vencimientos
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="fsFiltro" class="card-body">
                                        <div id="" class="row">
                                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Estado de Pago</label>
                                                    <select name="tipo_documento" id="serieF" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                                        <option value="P">
                                                            <?php echo "Pendiente" ?></option>
                                                        <option value="C">
                                                            <?php echo "Cancelado" ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">F. Pago</label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Fecha Vence</label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">F. Recepción</label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--card-body-->
                                </div>
                                <!--card-->


                                <?php if ($smodulo == 32) { ?>
                                    <div class="card" style="margin-top:15px">
                                        <div class="card-header">
                                            <div id="" class="row">
                                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                    <strong>
                                                        Datos de la Guia
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="fsFiltro" class="card-body">
                                            <div id="" class="row">
                                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="form-control-sm">Direcci&oacute;n del punto de llegada</label>
                                                        <input type="text" name="guia_llegada_direccion" id="guia_llegada_direccion" value="" placeholder="" class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>






                            </div>
                            <!--card-->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div id="" class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <strong>
                                                    Impuestos
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="fsFiltro" class="card-body">
                                        <div id="" class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Descuento Global</label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>

                                        </div>
                                        <div id="" class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Monto de Percepción</label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm"></label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Monto Total</label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="" class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">porcentaje Detracción</label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Monto Detracción</label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm"></label>
                                                    <input type="text" name="numero_documento" id="numero_documento" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Tipo de Detraccion:</label>
                                                    <select name="tipo_documento" id="serieF" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                                        <option value="">
                                                            <?php echo "" ?></option>
                                                        <option value="004">
                                                            <?php echo "Operación sujeta al Sistema de Pago de Obligaciones Tributarias con el Gobierno Central" ?></option>
                                                        <option value="017">
                                                            <?php echo "Operación sujeta al Sistema de Pago de Obligaciones Tributarias con el Gobierno Central – Servicio de Transporte de Pasajeros" ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Afecta a:</label>
                                                    <select name="tipo_documento" id="serieF" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                                        <option value="">
                                                            <?php echo "" ?></option>
                                                        <option value="022">
                                                            <?php echo "Otro servicios empresariales" ?></option>
                                                        <option value="017">
                                                            <?php echo "Contratos de construcción" ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-control-sm">Medio de Pago:</label>
                                                    <select name="tipo_documento" id="serieF" class="form-control form-control-sm" onchange="validaTipoDocumento()">
                                                        <option value="">
                                                            <?php echo "" ?></option>
                                                        <option value="004">
                                                            <?php echo "Efectivo" ?></option>
                                                        <option value="017">
                                                            <?php echo "Deposito en cuenta" ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--card-body-->
                                </div>
                                <!--card-->
                            </div>
                        </div>

                        <div class="card"  id="card_cuotas">
                            <div class="card-header">
                                <div id="" class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <strong>
                                            Cuotas
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <div id="fsFiltro" class="card-body">
                                <div id="" class="row">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-control-sm">Nume. Cuotas</label>
                                            <input type="text" name="numcuota_" id="numcuota_" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-control-sm">Monto total del credito</label>
                                            <input type="text" name="totalcredito_" id="totalcredito_" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-control-sm">Plazo en dias</label>
                                            <input type="text" name="plazo_" id="plazo_" value="" placeholder="" class="form-control form-control-sm">
                                            
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-control-sm"></label>
                                            <button type="button" id="btnFraciona" name="btnFraciona" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#vehiculoModal" onclick="generarCuotas()">
                                                    <i class="fas fa-plus-circle"></i> Cuotas
                                            </button>
                                        </div>
                                    </div>
                                    

                                    <?php $seleccionar_todos = "style='display:block'"; ?>
                                    <div class="table-responsive">
                                        <table id="tblConceptos" class="table table-hover table-sm">
                                            <thead>
                                                <tr style="font-size:13px">
                                                    <th>Id</th>
                                                    <th>Importe</th>
                                                    <th>Fecha</th>                                                    
                                                </tr>

                                            </thead>
                                            <tbody style="font-size:13px">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--card-body-->
                        </div>


                </div>
            </div>


            <!--   <a class='flotante' name="guardar" id="guardar" onclick="guardarFactura()" href='#' ><img src='/img/btn_save.png' border="0"/></a>--> <br>
            </form>
        </div>
    </div>
</div>

</div>

<!--row-->
@endsection



@push('after-scripts')

<script src="{{ asset('js/factura.js') }}"></script>
@endpush