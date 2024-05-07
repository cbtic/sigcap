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

.divlogoimpresora {
    display: none;
}

.separador {
    display: none;
}

/*
 VERSION PARA IMPRESORAS
*/
@page {
  margin: 0;
}

@media print {
  html, body {
    width: 80mm;
    height: 297mm;
  }

    *, :after, :before {
        color: #FFF!important;
        text-shadow: none!important;
        background: blue!important;
        -webkit-box-shadow: none!important;
        box-shadow: none!important;
        font-family:sans-serif;
    }
    p,table, th, td {
        color: black !important;
        font-size: 36px !important;
        font-family:sans-serif;
    }
    .resaltado {
        color: black !important;
        font-size: 36px !important;
        font-weight: bold;
    }

    .divlogoimpresora {
        display: block;
    }

    .logoimpresora {
        margin-left: auto;
        margin-right: auto;
        margin-top: 50px;
        margin-bottom: 50px;
        display: block;
        width: 250px !important;
        height: 250px !important;
    }
    h3{
        color: black !important;
        font-size: 52px !important;
        text-align: center;
        font-family:sans-serif;
    }

    .separador {
        display: block;
        margin-top: 20px;
    }

    .navbar.navbar-expand-lg.navbar-dark.bg-primary.mb-0 {
        display: none
    }
    h4,ol{
        display: none !important
    }

    .flotante,.flotanteC {
        display: none !important
    }
}
</style>

@stack('before-scripts')

@stack('after-scripts')

@extends('frontend.layouts.app')



@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Facturacion</li>
    <li class="breadcrumb-item active">Mostrar</li>
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
                        Detalle de la Factura
                        <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div>
                <!--col-->
            </div>
            <div class="row justify-content-center">
                <div class="col col-sm-12 align-self-center">
                    <form class="form-horizontal" method="post" action="{{ route('frontend.comprobante.send')}}"
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
                                                        @if ($factura->tipo != 'TK')
                                                        <div class="divlogoimpresora" style="width:100%">
                                                            <img class="logoimpresora" src="/img/logo-sin-fondo.png">
                                                        </div>
                                                        <h3>
                                                            COLEGIO DE ARQUITECTOS DEL PERU-REGIONAL LIMA
                                                        </h3><br>
                                                        @endif
                                                        <p>AV. SAN FELIPE NRO. 999 LIMA - LIMA - JESUS MARIA</p>
                                                        <p>RUC 20172977911</p>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            <p>
                                                                @switch($factura->tipo)
                                                                @case('FT')
                                                                <p> FACTURA ELECTRONICA</p>
                                                                @break

                                                                @case('BV')
                                                                <p>BOLETA ELECTRONICA</p>
                                                                @break

                                                                @case('TK')
                                                                <p>BOLETA ELECTRONICA</p>
                                                                @break

                                                                @case('FT')
                                                                <p>FACTURA ELECTRONICA</p>
                                                                @break

                                                                @case('NC')
                                                                <p>NOTA DE CREDITO</p>
                                                                @break

                                                                @case('ND')
                                                                <p>NOTA DE DEBITO</p>
                                                                @break

                                                                @default
                                                                <p>No esta identificado el tipo de documento</p>
                                                                @endswitch
                                                            </p>
                                                            <p><a href="/{{ $factura->ruta_comprobante }}" target="_blank" class="link-factura">{{ $factura->serie }}-{{ $factura->numero }}</a></p>                                                        </strong>

                                                    </div>
													
													<?php 
														$modeda = "S/";
														if($factura->moneda_id==1)$modeda = "$.";
													
														if($factura->nro_guia!=""){
													?>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <strong>
                                                            <p>
                                                                <p> GUIA DE REMISIÓN</p>
                                                            </p>
                                                            <p>
															
															<a style="float:left" href="/factura/show_guia/<?php echo $id_guia?>" target="_blank" class="link-factura">{{ $factura->serie_guia }}-{{ $factura->nro_guia }}</a>
															
															<a style="float:left" href="/factura/show_guia/<?php echo $id_guia?>" target="_blank" class="link-factura">&nbsp;&nbsp;Ver Guia
															<i style="float:left;margin-left:25px;padding-top:3px;cursor:pointer;color:#007bff" class="fas fa-search"></i>
															</a>
															
															</p>
                                                        </strong>

                                                    </div>
													<?php 
														}
													?>
													
                                                  
                                                    
                                                    <?php if ($factura->tipo == 'FT'|| $factura->tipo == 'BV' || $factura->tipo == 'NC' || $factura->tipo == 'ND'){?>
                                            
                                                        <table>
                                                        <tbody>
                                                        <tr>
                                                        <td>RUC/DNI:</td>
                                                        <td style="text-align: right;"><span  class="resaltado">{{ $factura->cod_tributario }}</span></td>
                                                        </tr>
                                                        <div class="separador">&nbsp;</div>
                                                        <tr>
                                                        <td>ADQUIRIENTE:</td>
                                                        <td style="text-align: right;"> <span class="resaltado">{{ $factura->destinatario }}</span></td>
                                                        </tr>
                                                        <tr>
                                                        <td>DIRECCION:</td>
                                                        <td style="text-align: right;"><span class="resaltado">{{ $factura->direccion }}</span></td>
                                                        </tr>
                                                        <tr>
                                                        <td>FECHA DE EMISIÓN :</td>
                                                        <td style="text-align: right;"><span class="resaltado">{{ $factura->fecha }}</span></td>
                                                        </tr>
                                                        <tr>
                                                        <td>CAP :</td>
                                                        <td style="text-align: right;"><span class="resaltado">{{ $datos->numero_cap }}</span></td>
                                                        </tr>
                                                        </tbody>
                                                        </table>
                                                               
                                                    
                                                    <div class="separador">&nbsp;</div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <p> </p>
                                                    </div>
                                                    <div class="separador">&nbsp;</div>
                                                </div>
                                            </div>
                                            <div id="fsFiltro" class="card-body">

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
                                            <div class="card-body">
                                                <div >
                                                    <table id="tblProductos" class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" width="8%">Cant.</th>
                                                                <th width="37%">Descripción</th>
                                                                <th class="text-right" width="15%">PU</th>
                                                                <th class="text-right" width="10%">Dcto.</th>                                                                
                                                                <!--<th class="text-right" width="15%">IGV</th> -->
                                                                <th class="text-right" width="15%">Monto</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($factura_detalles as $factura_detalle)
                                                            <tr id="fila{{ $loop->iteration }}">
                                                                <td class="text-center">
                                                                    {{ $factura_detalle->cantidad }} 
                                                                    
                                                                    @if($factura_detalle->id_concepto ==="26475")
                                                                        {{" Revisiones "}}
                                                                    @endif
                                                                    
                                                            
                                                                    
                                                                
                                                                </td>
                                                                <td class="text-left">
                                                                    {{ $factura_detalle->descripcion }}
                                                                </td>

                                                                <td class="text-right">{{ number_format(($factura_detalle->pu+$factura_detalle->igv_total)/$factura_detalle->cantidad,2)  }}
                                                                </td>

                                                                <td class="text-right">{{ $factura_detalle->descuento }}
                                                                </td>

                                                                <!--
                                                                <td class="text-right">
                                                                    {{ number_format($factura_detalle->facd_igv_total,2) }}</td>
                                                                -->
                                                                <td class="text-right">
                                                                    {{ number_format($factura_detalle->importe,2) }}</td>
                                                            </tr>
                                                            @endforeach
                                                            <tr id="fila_sub_total">
                                                                <td class="text-right" colspan="4">OP.GRAVADAS <span class="moneda"><?php echo $modeda?></span> </td>
                                                                <td class="text-right">{{ number_format($factura->subtotal,2)  }}</td>
                                                            </tr>
                                                            <tr id="fila_igv">
                                                                <td class="text-right" colspan="4">IGV(18%) <span class="moneda"><?php echo $modeda?></span> </td>
                                                                <td class="text-right">{{ number_format($factura->impuesto,2) }}</td>
                                                            </tr>
                                                            <tr id="fila_total">
                                                                <td class="text-right" colspan="4">IMPORTE TOTAL <span class="moneda"><?php echo $modeda?></span> </td>
                                                                <td class="text-right"><span class="resaltado">{{ number_format($factura->total,2) }}</span></td>


                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--table-responsive-->
                                            </div>
                                            <!--card-body-->
                                        </div>
                                        <!--card-->
                                    </div>
                                    
                                    <div class="separador">&nbsp;</div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <p>Son: <span class="resaltado">{{ $factura->letras }}</span></p>
                                                    </div>
                                                    
                                                    <div>
                                                    
                                                    <table id="tblcuotas" class="table table-hover" >
                                                        <caption>Información del crédito</caption>
                                                        <thead>
                                                        
                                                            <tr>
                                                                <th class="text-center" width="8%">item</th>
                                                                <th width="37%">Monto</th>
                                                                <th width="37%">Fecha Venc.</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                    @foreach ($cronograma as $cronograma_v)
                                                            <tr id="fila{{ $loop->iteration }}">
                                                                <td class="text-center">
                                                                    {{ $cronograma_v->item }} 
                                                                    
                                                                
                                                                </td>
                                                                <td class="text-left">
                                                                    {{ $cronograma_v->monto }} 
                                                                </td>

                                                                <td class="text-left">
                                                                    {{ $cronograma_v->fecha_vencimiento }} 
                                                                </td>
                                                           </tr>
                                                            @endforeach
                                                    </div>

                                    <div class="separador">&nbsp;</div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <p>Usuario: <span class="resaltado">{{ $datos->usuario }}</span></p>
                                                    </div>

                                    <hr style="width:90%", size="3", color=black>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <p>Representación impresa generada en el sisteman de SUNAT, puede verificarla
                                            utilizando su clave SOL</p>

                                    </div>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                        <a class='flotante' href='#' onclick="print()"><img src='/img/btn_print.png' border="0" /></a>
                        <!--<a class='flotante' href='#'><img src='/img/deshacer.png' border="0" /></a>-->
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--row-->
    @endsection

    @push('after-scripts')

    @endpush
