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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    var urlApp = "<?php echo URL::to('/') ?>";
    //alert(urlApp);

    if (history.forward(1)) {
        location.replace(history.forward(1));
    }

    $(document).ready(function() {

        $('#addFiltro').on('click', function() {
            var addFiltro = $('#addFiltro').attr("aria-pressed");
            $("#fsFiltro").hide();
            if (addFiltro == "false") {
                $("#fsFiltro").show();
            }
        });

        $('#id_formapago_').change(function() {
            // Tu lógica aquí
            toggleTarjeta()
            //console.log('Opción seleccionada:', $(this).val());
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

    function toggleTarjeta() {
        var tarjeta = document.getElementById('card_cuotas');
        tarjeta.style.display = (tarjeta.style.display == 'none' || tarjeta.style.display === '') ? 'block' : 'none';
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
                        <small class="text-muted">Nota de Credito</small>
                        <!--Edita Factura-->
                        <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div>
                <!--col-->
            </div>
            <div class="row justify-content-center">
                <div class="col col-sm-12 align-self-center">
                    
                    <form class="form-horizontal" method="post" action="{{ route('frontend.comprobante.nc_edita')}} " id="frmNC" name="frmNC" autocomplete="off">
                        
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="trans" id="trans" value="<?php echo $trans; ?>">
                        <input type="hidden" name="tipoF" value="NC">
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
                        <input type="hidden" name="id_caja" value="<?php if ($trans == 'FA' or $trans == 'FN') {
                                                                        echo $id_caja;
                                                                    } ?>">
                        <input type="hidden" name="MonAd" value="<?php if ($trans == 'FA') {
                                                                        echo $MonAd;
                                                                    } ?>">
                        <input type="hidden" name="adelanto" value="<?php if ($trans == 'FA') {
                                                                        echo $adelanto;
                                                                    } ?>">
                        <input type="hidden" name="id_factura" value="<?php if ($trans == 'FE') {
                                                                            echo $comprobante->id;
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
                                                            <select readonly name="serieF" id="serieF" class="form-control form-control-sm">
                                                                <?php if ($trans == 'FA' ) { ?>
                                                                    <?php foreach ($serie as $row) : ?>
                                                                        <option value="<?php echo $row->denominacion ?>"><?php echo $row->denominacion ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php } ?>
                                                                <?php if ($trans == 'FE') { ?>
                                                                    <option value="<?php echo $comprobante->serie ?>"><?php echo $comprobante->serie ?></option>
                                                                <?php } ?>

                                                                <?php if ($trans == 'FN') { ?>
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
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-group">Tipo de Nota</label>                               
                                                            <select name="tiponota_" id="tiponota_" class="form-control form-control-sm" onChange="actualizaimportes()" >
                                                                <option value="">--Selecionar--</option>
                                                                <?php
                                                                foreach ($tipooperacion as $row) { ?>
                                                                    <option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == 1) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">

                                                            <label class="form-group">Motivo</label>
                                                            <input type="text" name="motivo_" id="motivo_" value="{{old('clinum')}}" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="" class="row">
                                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                        <label class="form-control-sm">RUC/DNI</label>
                                                        <div class="input-group">
                                                            <input type="text" name="numero_documento" readonly id="numero_documento" value="<?php echo $comprobante->cod_tributario;?> " placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                        <button type="button" data-toggle="modal" data-target="#duenoCargaModal" id="" class="btn btn-link btn-xsm">Buscar Empresa</button>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Razón Social/Nombre</label>
                                                            <input type="text" name="razon_social" readonly id="razon_social" value="<?php echo $comprobante->destinatario;?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Dirección</label>
                                                            <input type="text" name="direccion" readonly id="direccion" value="<?php if ($trans == 'FA') {
                                                                                                                                            echo $empresa->direccion;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FE') {
                                                                                                                                            echo $comprobante->direccion;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FN') {
                                                                                                                                            echo $direccion;
                                                                                                                                        }
                                                                                                                                         ?>" placeholder="" class="form-control form-control-sm">
                                                                                                                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="form-control-sm">Email</label>
                                                            <input type="text" name="correo" readonly id="correo" value="<?php if ($trans == 'FA') {
                                                                                                                                            echo $empresa->email;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FE') {
                                                                                                                                            echo $comprobante->correo_des;
                                                                                                                                        }
                                                                                                                                        if ($trans == 'FN') {
                                                                                                                                            echo $correo;
                                                                                                                                        } ?>" placeholder="" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                               
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->

                                        <div id="fsFiltro" class="card-body">
                                            <div id="" class="row">
                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="form-control-sm">Serie</label>
                                                        <select readonly name="serieF" id="serieF" class="form-control form-control-sm">
                                                            <?php if ($trans == 'FA') { ?>
                                                                <?php foreach ($serie as $row) : ?>
                                                                    <option value="<?php echo $row->denominacion ?>"><?php echo $row->denominacion ?></option>
                                                                    <option value="<?php echo $comprobante->serie ?>"><?php echo $comprobante->serie ?></option>
                                                                <?php endforeach; ?>
                                                            <?php } ?>
                                                            <?php if ($trans == 'FE') { ?>
                                                                <option value="<?php echo $comprobante->serie ?>"><?php echo $comprobante->serie_ncnd ?></option>
                                                            <?php } ?>

                                                            <?php if ($trans == 'FN') { ?>
                                                                <option value="<?php echo $comprobante->serie ?>"><?php echo $comprobante->serie ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" name="divNumeroF" id="divNumeroF">
                                                    <div class="form-group">
                                                        <label class="form-control-sm">Número</label>
                                                        <input type="text" name="numerof1" readonly id="numerof1" value="<?php if ($trans == 'FN') {
                                                                                                                            echo $comprobante->numero;
                                                                                                                        }  
                                                                                                                            if ($trans == 'FE') {
                                                                                                                            echo $comprobante->id_numero_ncnd;
                                                                                                                        } ?>" placeholder="" class="form-control form-control-sm text-center">
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" name="divNumeroF" id="divNumeroF">
                                                    <div class="form-group">
                                                        
                                                        <input type="hidden" name="id_comprobante_ncdc" readonly id="id_comprobante_ncdc" value="<?php if ($trans == 'FN') {
                                                                                                                            echo $comprobante->id;
                                                                                                                        }  
                                                                                                                            if ($trans == 'FE') {
                                                                                                                            echo $comprobante->id;
                                                                                                                        } ?>" placeholder="" class="form-control form-control-sm text-center">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <br>

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
                                                            <th class="text-center" width="5%">Cant.</th>
                                                            <th width="40%">Descripción</th>
                                                            <th width="15%">Total</th>
                                                            <th class="text-center" width="15%">PU</th>
                                                            <th class="text-right" width="10%">IGV</th>
                                                            
                                                            <th class="text-right" width="15%">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $n = 0;
                                                        $smodulo = "";
                                                        if ($trans == 'FA' || $trans == 'FE' || $trans == 'FN') { ?>
                                                            <?php foreach ($facturad as $key => $fac) {
                                                                //		$smodulo = $fac['smodulo'];
                                                            ?>
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][id]" value="<?php echo $fac['id'] ?>" />
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][fecha]" value="<?php echo $fac['fecha'] ?>" />
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][denominacion]" value="<?php echo $fac['denominacion'] ?>" />
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][descripcion]" value="<?php echo $fac['descripcion'] ?>" />
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][tipoF]" value="ND" />
                                                                
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][monto]" value="<?php echo $fac['monto'] ?>" />
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][moneda]" value="<?php echo $fac['moneda'] ?>" />
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][id_moneda]" value="<?php echo $fac['id_moneda'] ?>" />
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][descuento]" value="<?php echo $fac['descuento'] ?>" />
                                                                <input type="hidden" name="facturad[<?php echo $key ?>][cod_contable]" value="<?php echo $fac['cod_contable'] ?>" />

                                                                <input type="hidden" id="facturad_pu" name="facturad[<?php echo $key ?>][importe]" value="<?php echo $fac['pu'] ?>" />
                                                                <input type="hidden" id="facturad_igv" name="facturad[<?php echo $key ?>][igv]" value="<?php echo $fac['igv_total'] ?>" />
                                                                <input type="hidden" id="facturad_total" name="facturad[<?php echo $key ?>][total]" value="<?php echo $fac['importe'] ?>" />


                                                                <tr>
                                                                    <td class="text-right"><?php $n = $n + 1;
                                                                                            echo $n; ?></td>
                                                                    <td class="text-center"><?php if ($trans == 'FA') {
                                                                                                echo $fac['cantidad'];
                                                                                            }
                                                                                            if ($trans == 'FE' || $trans == 'FN') {
                                                                                                echo $fac['cantidad'];
                                                                                            } ?></td>
                                                                    <td class="text-left">
                                                                        <?php
                                                                        if ($trans == 'FA') {
                                                                            echo $fac['descripcion'];
                                                                        }
                                                                        if ($trans == 'FE' || $trans == 'FN') {
                                                                            echo $fac['descripcion'];
                                                                        } ?>
                                                                    </td>
                                                                    
                                                                    <td class="text-right">                                                                        
                                                                        <input type="text" readonly name="importeantd[]"  id="importeantd<?php echo $key?>" value="<?php echo number_format($fac['importe'], 2)?>" placeholder="" class="form-control form-control-sm text-center"  >
                                                                    
                                                                    </td>

                                                                                                                                      <!--  <td class="text-right"></td>
                                                                                            -->
                                                                    <td>
                                                                    <input type="text" name="imported[]"         id="imported<?php echo $key?>" onkeyup="calcular_total(<?php echo $key?>)" value="<?php if ($trans == 'FN') {
                                                                                                                            echo 0;
                                                                                                                        }  
                                                                                                                            if ($trans == 'FE') {
                                                                                                                                echo number_format($fac['pu'], 2);
                                                                                                                        } ?>" placeholder="" class="form-control form-control-sm text-center"  >
                                                                                        
                                                                                        </td>

                                                                    <td class="text-right">                                                                        
                                                                        <input type="text" readonly name="igvd[]"  id="igvd<?php echo $key?>" value="<?php echo number_format(0,2)?>" placeholder="" class="form-control form-control-sm text-center"  >
                                                                    
                                                                    </td>

                                                                    
                                                                    <td>
                                                                    <input type="text" name="totald[]"  id="totald<?php echo $key?>" onkeyup="calcular_total_2(<?php echo $key?>)" value="<?php if ($trans == 'FN') {
                                                                                                                            echo 0;
                                                                                                                        }  
                                                                                                                            if ($trans == 'FE') {
                                                                                                                                echo number_format($fac['importe'], 2);
                                                                                                                        } ?>" placeholder="" class="form-control form-control-sm text-center"  >
                                                                                        
                                                                                        </td>
                                                                    
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
                                                            <th> <input type="text" name="gravadas" readonly id="gravadas" value="<?php if ($trans == 'FN') {
                                                                                                                                echo number_format( $comprobante->subtotal,2);
                                                                                                                            } ?>" placeholder="" class="form-control form-control-sm text-center">
                                                        </th>

                                                            
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

                                                            <th> <input type="text" name="igv" readonly id="igv" value="<?php if ($trans == 'FN') {
                                                                                                                                echo number_format( $comprobante->impuesto,2);
                                                                                                                            } ?>" placeholder="" class="form-control form-control-sm text-center">
                                                        </th>

                                                            
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>Total</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th> <input type="text" name="totalP" readonly id="totalP" value="<?php if ($trans == 'FN') {
                                                                                                                                echo number_format( $comprobante->total,2);
                                                                                                                            } ?>" placeholder="" class="form-control form-control-sm text-center">
                                                        </th>

                        
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
                                            <button type="button" id="guardar" class="btn btn-primary btn-block" onclick="$('#guardar').prop('disabled', true); setTimeout(function(){$('#guardar').prop('disabled', false);},5000); ;guardarnc()">GUARDAR COMPROBANTE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

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

<script src="{{ asset('js/facturaND.js') }}"></script>
@endpush