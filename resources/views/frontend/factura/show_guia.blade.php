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
{!! script(asset('js/pesaje.js')) !!}
@stack('after-scripts')

@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.afiliacion.box_title'))

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
                        Detalle de la Guia de Remisión
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
                                                        
														<div class="row">
														
															<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
															
																<div class="divlogoimpresora" style="width:100%">
																	<img class="logoimpresora" src="/img/logo_mmp.png">
																</div>
																<h3>
																	CAP - Lima SRLTDA
																</h3><br>
																<p>AV. NESTOR GAMBETA Nº 6311 - CALLAO</p>
															
															</div>
														
															<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
																
																<p>RUC 20160453908</p>
																
																<strong>
																	
																	<p>
																		<p> GUIA DE REMISIÓN</p>
																	</p>
																	<p><a href="#" target="_blank" class="link-factura">{{ $guia->guia_serie }}-{{ $guia->guia_numero }}</a></p>
																</strong>
		
															</div>
															
														</div>
														
														<div class="row">
														
															<div class="separador">&nbsp;</div>
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																<p>Fecha de emisión: {{ $guia->guia_fecha_emision }}</p>
															</div>
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																<p>Fecha de inicio del traslado: {{ $guia->guia_fecha_traslado }}</p>
															</div>
															<div class="separador">&nbsp;</div>	
															
														</div>
                                                    	
														<div class="row">
														
															<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
																
																<strong>
																	<p>
																		<p> DIRECCION DE PARTIDA</p>
																	</p>
																</strong>
																
																<div class="row">
																
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																		<p>Dirección: {{ $guia->guia_partida_direccion }}</p>
																	</div>
																	
																</div>
																
															</div>
															
															<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
																
																<strong>
																	<p>
																		<p> DIRECCION DE PARTIDA - LLEGADA</p>
																	</p>
																</strong>
																
																<div class="row">
																
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																		<p>Dirección: {{ $guia->guia_llegada_direccion }}</p>
																	</div>
																</div>
																
															</div>
															
														</div>
														
														<div class="row">
														
															<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
																
																<strong>
																	<p>
																		<p> REMITENTE</p>
																	</p>
																</strong>
																
																<div class="row">
																
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																		<p>Apellidos y Nombres / Razón Social: {{ $guia->guia_emisor_razsocial }}</p>
																	</div>
																	
																</div>
																
																<div class="row">
																	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
																		<p>Ruc: {{ $guia->guia_emisor_numdoc }}</p>
																	</div>
																	<div class="separador">&nbsp;</div>	
																
																</div>
																	
															</div>
															
															<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
																
																<strong>
																	<p>
																		<p> DESTINATARIO</p>
																	</p>
																</strong>
																
																<div class="row">
																
																	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
																		<p>Apellidos y Nombres / Razón Social: {{ $guia->guia_receptor_razsocial }}</p>
																	</div>
																	
																</div>
																
																<div class="row">
																	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
																		<p>Ruc: {{ $guia->guia_receptor_numdoc }}</p>
																	</div>
																	<div class="separador">&nbsp;</div>	
																
																</div>
																
															</div>
															
														</div>
														
														
													</div>
                                                    
                                                    
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
                                                                <th width="82%">Descripción</th>
                                                                <th class="text-right" width="10%">Peso</th>
                                                                <!--<th class="text-right" width="15%">Costo Min</th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($guia_detalles as $guia_detalle)
                                                            <tr id="fila{{ $loop->iteration }}">
                                                                <td class="text-center">
                                                                    {{ $guia_detalle->guiad_cantidad }}</td>
                                                                <td class="text-left">
                                                                    {{ $guia_detalle->guiad_descripcion }}
                                                                </td>
                                                                <td class="text-right">{{ $guia->guia_peso_bruto }} TM
                                                                </td>
                                                                <!--<td class="text-right"></td>-->
                                                            </tr>
															<tr>
                                                                <td class="text-left" colspan="3" style="padding-left:140px">
                                                                    Peso Ingreso : {{ $ingreso->peso_ingreso }}
                                                                </td>
                                                            </tr>
															<tr>
                                                                <td class="text-left" colspan="3" style="padding-left:140px">
                                                                    Peso Salida : {{ $ingreso->peso_salida }}
                                                                </td>
                                                            </tr>
															<tr>
                                                                <td class="text-left" colspan="3" style="padding-left:140px">
                                                                    Placa : {{ $guia->guia_vehiculo_placa }}
                                                                </td>
                                                            </tr>
															
                                                            @endforeach
															
															
															
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
    @if(config('access.captcha.contact'))
    @captchaScripts
    @endif
    @endpush
