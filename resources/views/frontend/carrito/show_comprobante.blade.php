<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->

<style>
	#tblAfiliado tbody tr{
		font-size:13px
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

.container {
    margin-right: auto;
    margin-left: auto;
    padding-right: 20px;
    padding-left: 20px;
    width: 100%
}

@media (min-width: 576px) {
    .container {
        max-width:540px
    }
}

@media (min-width: 768px) {
    .container {
        max-width:720px
    }
}

@media (min-width: 992px) {
    .container {
        max-width:960px
    }
}

@media (min-width: 1200px) {
    .container {
        max-width:1140px!important
    }
}

.btn-secondary:hover, .modal-footer .btn-secondary:hover {
    color: white;
    background: #373F41!important;
}

.divlogoimpresora {
    display: none;
}

/***************************/

/*
 VERSION PARA IMPRESORAS
*/
@page  {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

@media  print {
  
  .titulo{
    display:none
  }

  .footer{
    display:none
  }

  .card-body {
    padding: 0px!important;
  }
    
  html, body {
    width: 80mm !important; 
    min-height: 100vh;      
    margin: 2px !important;
    padding: 0 !important;

  }
  
    *, :after, :before {
        color: #FFF!important;
        text-shadow: none!important;
        /*background: blue!important;*/
        -webkit-box-shadow: none!important;
        box-shadow: none!important;
        font-family:sans-serif;
    }
    
    p,table, th, td {
        color: black !important;
        /*font-size: 36px !important;*/
        font-family:sans-serif;
    }
    
    .resaltado {
        color: black !important;
        /*font-size: 36px !important;*/
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
        width: 350px !important;
        height: 125px !important;
    }
    h3{
        color: black !important;
        /*font-size: 52px !important;*/
        text-align: center;
        font-family:sans-serif;
    }

    .separador {
        /*display: block;*/
        /*margin-top: 20px;*/
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

    .no-divider {
        page-break-inside: avoid;
        break-inside: avoid;
    }
    
}

.footer {
    background-color: #1C77B9 !important;
}

</style>

@extends('frontend.layouts.app_carrito')

@section('title', 'Carrito')

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Agremiados</li>
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






<div id="pageFormularios" class="container">
	
	<section class="seccion-principal seccion-formularios">
		<h1 class="titulo">
			<div class="wizard">
				<div class="item active"><i class="icon fas fa-search" aria-hidden="true" title="Buscar"></i></div>
				<div class="item active"><i class="icon fas fa-edit" aria-hidden="true" title="Completar datos"></i></div>
				<div class="item"><i class="icon fas fa-shopping-cart" aria-hidden="true" title="Carrito"></i></div>
				<div class="item"><i class="icon fa-money-bill" aria-hidden="true" title="Medios de Pago"></i></div>
				<div class="item"><i class="icon fas fa-receipt" aria-hidden="true" title="Resumen de pago"></i></div>
			</div>
			
			<span class="titulo-entidad">

                @switch($factura->tipo)
                    @case('FT')
                    Factura
                    @break
                    @case('BV')
                    Boleta
                    @break
                    @case('NC')
                    Nota de Crédito
                    @break
                    @default
                    No esta identificado el tipo de documento
                @endswitch

            </span>
			
			<!--<small class="descriptivo">Información del pago</small>-->
			<img class="curva" src="/imagenes/new/curva.svg" aria-hidden="true">
		</h1>

        <div class="row" style="width: 100%;">
            
            <div class="col-lg-12 col-md-12 col-sm-8 pb-0">
                <div class="card">
                    <div class="card-body">
                                           
                        
                        <form class="form-horizontal" method="post" action=""
                        id="frmFacturacion" name="frmFacturacion" autocomplete="off">

                        
                        <input type="hidden" name="id_pedido" value="{{$id}}" id="id_pedido">
                        <input type="hidden" name="TipoF" id="TipoF" value="">
                        <input type="hidden" name="trans" id="trans" value="FA">

                        @csrf

                        <div id="divComprobante" class="row justify-content-center" style="min-height:500px">
                            
                            <form class="form-horizontal" method="post" action="{{ route('frontend.comprobante.send')}}"
                                id="frmPesaje" autocomplete="off">
                                <input type="hidden" id="idFormaPago" name="idFormaPago" value="{{$factura->id_forma_pago}}"/>
                                <input type="hidden" id="idtipocomprobante" name="idtipocomprobante" value="{{$factura->tipo}}"/>

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
                                                                <h3 class="divlogoimpresora">
                                                                {{ $factura->serie }}-{{ $factura->numero }}
                                                                </h3>

                                                                    <p class="d-print-none"><a href="/{{ $factura->ruta_comprobante }}" target="_blank" class="link-factura">{{ $factura->serie }}-{{ $factura->numero }}</a></p>    
                                                                
                                                                </strong>

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
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                                                                <td>FECHA DE EMISIÓN:</td>
                                                                <td style="text-align: right;"><span class="resaltado">  {{ date('d-m-Y H:i:s',strtotime($factura->fecha)) }} </span></td>
                                                                </tr>
                                                                @if($datos->numero_cap!="")
                                                                <tr>
                                                                <td>CAP :</td>
                                                                <td style="text-align: right;"><span class="resaltado">{{ $datos->numero_cap }}</span></td>
                                                                </tr>
                                                                @endif
                                                                </tbody>
                                                                </table>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--card-body-->
                                                </div>
                                                <!--card-->
                                            </div>
                                        </div>
                                    
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
                                                                        <th class="text-right" width="15%">P.Unitario</th>
                                                                        <th class="text-right" width="10%">Dcto.</th>
                                                                        <!--<th class="text-right" width="10%">V.Unitario</th>   -->                                                                                                                     
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

                                                                        <td class="text-right">{{ number_format($factura_detalle->precio_venta,2)  }}
                                                                        </td>

                                                                        <td class="text-right">{{ $factura_detalle->descuento }}
                                                                        </td>
        <!--
                                                                        <td class="text-right">{{ number_format($factura_detalle->pu,2) }}
                                                                        </td>
                                                            -->                                                                                                                     
                                                                        <td class="text-right">{{ number_format($factura_detalle->importe,2) }}
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    <tr id="fila_sub_total">
                                                                        <td class="text-right" colspan="4">
                                                                            @if($factura->impuesto!=0)
                                                                                {{"  OP.GRAVADAS "}}
                                                                            @else
                                                                                {{"  OP.INAFECTAS "}}
                                                                            @endif                                                        
                                                                        <span class="moneda"><?php echo $modeda?></span> </td>
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
                                            @if($factura->tipo_operacion =="1001")
                                            <div class="separador">&nbsp;</div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <table>
                                                <tbody>
                                                <tr>
                                                <td style="vertical-align: top;">BENEFICIARIO :</td>
                                                <td style="text-align: left;">COLEGIO DE ARQUITECTOS DEL PERU-REGIONAL LIMA</td>
                                                </tr>
                                                <div class="separador">&nbsp;</div>
                                                <tr>
                                                <td style="vertical-align: top;">CUENTAS:</td>
                                                <td style="text-align: left;"> Abonar en Cta. Banco Interbank Soles : CCI:</td>
                                                </tr>
                                                <tr>
                                                <td style="vertical-align: top;">COMENTARIOS TRIBUTARIOS :</td>
                                                <td style="text-align: left;"> OPERACIÓN SUJETA A DETRACCIÓN R.S. - 183- 2004/SUNAT Cta. para Detracción Banco de la Nación Cta. Cte.M.N. No. 00-000-488801 a nombre del Colegio de Arquitectos del Perú Regional Lima,  Ruc: 20172977911. Porcentaje: 12%, Código 037, Detracción: S/ <span class="resaltado">{{   number_format( round($factura->total * 12/100,2), 2, '.', '') }}</span>                                         
                                                    </td>
                                                </tr>
                                                </tbody>
                                                </table>
                                            </div>
                                            @endif

                                        
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" id="divListaCredito" style="display:none">
                                            
                                                <div class="card">

                                                    <div class="card-header">
                                                        <strong>                                            
                                                            Información del crédito
                                                        </strong>
                                                    </div>
                                                    <div class="card-body">

                                                        <div class="table-responsive overflow-auto" style="max-height: 500px;">                                                   
                                                            <table id="tblcuotas" class="table table-hover" >
                                                                
                                                                <thead>                                                            
                                                                    <tr>
                                                                        <th class="text-center" width="8%">item</th>
                                                                        <th width="37%">Monto</th>
                                                                        <th width="37%">Fecha Venc.</th>                                                                    
                                                                    </tr>
                                                                </thead>
                                                                
                                                                

                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="separador">&nbsp;</div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <p>Usuario: <span class="resaltado">{{ $datos->usuario }}</span></p>
                                            </div>

                                            <div class="separador">&nbsp;</div>
                                            <hr style="width:90%", size="3", color=black>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <p>Representación impresa generada en el sisteman de SUNAT, puede verificarla
                                                    utilizando su clave SOL</p>
                                                <p>Sírvase a verificar su comprobante de pago, en caso de cambio o devolución 
                                                    solo se procederá siempre y cuando se solicita en el mismo mes de emisión del 
                                                    comprobante (se cobran gastos administrativos y bancarios).</p>
                                                <p>PARA MAYOR INFORMACIÓN PUEDE CONTACTARSE AL 6271200 ANEXO 181,182 Y 184 O AL CORREO caja@limacap.org.</p>


                                            </div>



                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                                <!--<a class='flotante' href='#' onclick="print()"><img src='/img/btn_print.png' border="0" /></a>
                                <a class='flotante' href="/{{ $factura->ruta_comprobante }}" target="_blank"><img src='/img/btn_print.png' border="0" /></a>-->
                                @if (!empty($factura->ruta_comprobante))
                                    <a class="flotante" href="/{{ $factura->ruta_comprobante }}" target="_blank"><img src="/img/btn_print.png" border="0" /></a>
                                @else
                                    <script>
                                        window.location.href = "{{ route('frontend.pedido') }}";
                                    </script>
                                @endif
                                <!--<a class='flotante' href='#'><img src='/img/deshacer.png' border="0" /></a>-->
                                <br>
                            </form>
                        </div>
                            
                            
                        </div>

                        </form>

                    </div>
                </div>
            </div>

	</section>
	
	<section class="seccion-sidebar">
		
	</section>
</div>

</main>
		<div class="fondo-curva">
			<img src="https://pagalo.pe/imagenes/new/curva.svg" class="curva"></div>
		</div>

<div class="btn-sidebar" id="btn-sidebar" data-toggle="modal" data-target="#modalSidebar" style="display: none;"><i class="icon icon-pagalo-info" aria-hidden="true" title="Informacion"></i></div>
	<div class="modal-sidebar modal fade" id="modalSidebar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="opcion-cerrar close" data-dismiss="modal" aria-label="Cerrar" title="" data-toggle="tooltip" data-original-title="Cerrar">
						<i class="icon icon-pagalo-close" aria-hidden="true"></i>
					</button>
					<div class="contenido"></div>
				</div>
			</div>
		</div>
	</div>

	
	<footer>
		


<div class="footer">
	<div class="container">
		<div class="row">
			
			<div class="col-lg-6 col-12 footer-izquierdo">
				<div class="brand">
					<a href="/home" title="CAP">
						<img class="logo" src="<?php echo URL::to('/') ?>/img/logo-sin-fondo2.png" width="500" height="100" alt="CAP">
					</a>
				</div>
				<!--<strong class="titulo">Colegio de Arquitectos del Per&uacute; | Regional Lima</strong>
				<span class="enlace-mobile link link-sm collapsed" data-toggle="collapse" href="#footerInfo" role="button" aria-expanded="false" aria-controls="footerInfo">Contáctenos<i class="icon icon-pagalo-chevron-up" aria-hidden="true"></i></span>
				<div class="contacto collapse" id="footerInfo">
					<p>Mesa de ayuda: (01) 442-4470 - (01) 440-5305 - Línea gratuita: 0-800-10700</p>
					<p>Oficina Principal: Av. San Felipe 999, Jesús María 15072. Central telefónica: (01) 627 - 1200.</p>
					<p>Atención en oficinas administrativas: lunes a viernes de 8:00 a 17:00 horas.</p>
					<p>Atención en Oficina de Trámite Documentario: lunes a viernes de 8:00 a 17:00 horas.</p>
				</div>-->
			</div>

            <div class="col-lg-6 col-12">
                <strong class="titulo" style="color:white">Colegio de Arquitectos del Per&uacute; | Regional Lima</strong>
                <div class="contacto" id="footerInfo">
					<!--<p>Mesa de ayuda: (01) 442-4470 - (01) 440-5305 - Línea gratuita: 0-800-10700</p>-->
					<p style="color:white">Oficina Principal: Av. San Felipe 999, Jesús María 15072. Central telefónica: (01) 627 - 1200.</p>
					<p style="color:white">Atención en oficinas administrativas: lunes a viernes de 8:00 a 17:00 horas.</p>
					<p style="color:white">Atención en Oficina de Trámite Documentario: lunes a viernes de 8:00 a 17:00 horas.</p>
				</div>

			</div>
			
			
		</div>
	</div>
</div>


<div class="modal-faq modal fade fullscreen-lg" id="modalAgencias" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="opcion-cerrar close" data-dismiss="modal" aria-label="Cerrar" title="" data-toggle="tooltip" data-original-title="Cerrar">
					<i class="icon icon-pagalo-close" aria-hidden="true"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="iframe-modal-container">
					<iframe src="" id="iframeAgencias" class="iframe-modal" scrolling="no"></iframe>
				</div>
			</div>
			
		</div>
	</div>
</div>


<div class="modal-faq modal fade fullscreen-xs" id="modalFaq" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="opcion-cerrar close" data-dismiss="modal" aria-label="Cerrar" title="" data-toggle="tooltip" data-original-title="Cerrar">
					<i class="icon icon-pagalo-close" aria-hidden="true"></i>
				</button>
				<h3 class="titulo">Preguntas Frecuentes</h3>
			</div>
			<div class="modal-body">
				

<div class="list-group" id="accordionFaq">
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseAlfa" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseAlfa" id="headingAlfa">
            <span class="num">1.</span>
            <span class="texto">¿Qué es <strong>Págalo.pe</strong>?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingAlfa" class="respuesta collapse" data-parent="#accordionFaq" id="collapseAlfa">
            <div class="expansion-panel-body">
                <p><strong>Págalo.pe</strong> es una plataforma digital para simplificar el pago de tasas y servicios para trámites en diferentes entidades públicas, sin necesidad de ir a una agencia del Banco de la Nación.</p>
                <p>Es muy sencillo, tan solo ingresa y regístrate en la página web <strong>www.pagalo.pe</strong> y podrás pagar una o varias tasas al instante con cualquier tarjeta Visa, MasterCard o American Express de cualquier entidad financiera, billetera electrónica YAPE o en efectivo en nuestros Agentes Multired.</p>
                <p>Posteriormente recibirás en tu correo electrónico (en formato PDF) el voucher del cargo de tu tarjeta de débito ó crédito por la compra efectuada y la constancia de pago individual por cada tasa pagada.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseBeta" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseBeta" id="headingBeta">
            <span class="num">2.</span>
            <span class="texto">¿Qué puedo pagar en <strong>Págalo.pe</strong>?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        
        <div aria-labelledby="headingBeta" class="respuesta collapse" data-parent="#accordionFaq" id="collapseBeta">
            <div class="expansion-panel-body">
                <ul>
                    <li><strong>Pago de tasas:</strong> Paga por tus trámites ante las entidades públicas.</li>
                    <li><strong>Multas:</strong> Paga tus multas de Indecopi, multas electorales, multas de Migraciones, multas PNP.</li>
                    <li><strong>Servicios:</strong> Paga tus aportes al SIS, ESSALUD, entre otras.</li>
                    <li><strong>SUNAT:</strong> Paga el Número de pago Sunat - NPS, Número de pago de detracciones - NPD, Nuevo Registro Único Simplificado - NRUS, Pago de valor, Boleta de pagos varios y Arrendamiento.</li>
                </ul>
                <blockquote><a href="https://www.bn.com.pe/ciudadanos/servicios-adicionales/tasas-pagalo-pe.pdf" target="tasas" class="link link-sm">Conoce aquí todas las tasas disponibles a pagar (PDF)</a> <i class="icon icon-pagalo-external"></i></blockquote>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapsUno" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseGamma" id="headingUno">
            <span class="num">3.</span>
            <span class="texto">¿Cómo usar <strong>Págalo.pe</strong>?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingUno" class="respuesta collapse" data-parent="#accordionFaq" id="collapseGamma">
            <div class="expansion-panel-body">
                <ol>
                    <li>Ingresa tu usuario y contraseña. Si aún no tienes cuenta regístrate aquí.</li>
                    <li>Busca y selecciona el trámite que deseas pagar y agrégalo al carrito de compras.</li>
                    <li>Paga al instante con cualquier tarjeta Visa, Mastercard o American Express.</li>
                    <li>Recibirás en tu correo la constancia de pago, la cual debes presentar a la entidad seleccionada.</li>
                </ol>
               <!--<blockquote><span id="linkVideo" data-toggle="modal" data-src="https://www.youtube.com/embed/NFWSFbqL0A0" data-target="#modalVideo" class="link link-sm link-video">Ver video gu&iacute;a <i class="icon icon-pagalo-video"></i></span></blockquote>-->
                <blockquote><span id="linkVideo" data-toggle="modal" data-src="https://www.youtube.com/embed/6faiVzbvfgY" data-target="#modalVideo" class="link link-sm link-video">Ver video guía <i class="icon icon-pagalo-video"></i></span></blockquote>
 
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapsUno" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseUno" id="headingUno">
            <span class="num">4.</span>
            <span class="texto">¿Registrarse como usuario a <strong>Págalo.pe</strong> (afiliarse) tiene algún costo?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingUno" class="respuesta collapse" data-parent="#accordionFaq" id="collapseUno">
            <div class="expansion-panel-body">
                <p>No, el proceso de registro como usuario de <strong>Págalo.pe</strong> es gratuito y no significará para usted costo alguno (ni en el momento de la afiliación, ni en un momento posterior).</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseDos" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseDos" id="headingDos">
            <span class="num">5.</span>
            <span class="texto">¿Hay forma de recuperar mi clave de acceso en caso de olvido?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingDos" class="respuesta collapse" data-parent="#accordionFaq" id="collapseDos">
            <div class="expansion-panel-body">
                <p>Sí, para tal efecto debes hacer clic sobre el link "Recuperar contraseña" y la aplicación informática le solicitará registre la dirección de correo electrónico con la que se afilió a <strong>Págalo.pe</strong> a donde le enviará un código de verificación que deberá registrar junto a su nueva clave de acceso para confirmar la operación.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseTres" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseTres" id="headingTres">
            <span class="num">6.</span>
            <span class="texto">¿Puedo pagar varias tasas a la vez como parte de una misma transacción (compra online)?
            </span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingTres" class="respuesta collapse" data-parent="#accordionFaq" id="collapseTres">
            <div class="expansion-panel-body">
                <p>Sí, <strong>Págalo.pe</strong> permite seleccionar varias tasas y agregarlas a un carrito de compras, de tal forma que finalmente se efectúa un solo cargo a su tarjeta
                de débito/crédito.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseCuatro" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseCuatro" id="headingCuatro">
            <span class="num">7.</span>
            <span class="texto">¿Cuántas tasas puede agregar al carrito de compras como parte de una misma transacción (compra online)?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingCuatro" class="respuesta collapse" data-parent="#accordionFaq" id="collapseCuatro">
            <div class="expansion-panel-body"><p>Usted puede agregar hasta 9 ítems (tasas) al carrito de compras.</p></div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseCinco" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseCinco" id="headingCinco">
            <span class="num">8.</span>
            <span class="texto">¿Puedo pagar varios servicios a la vez como parte de una misma transacción (compra online)? </span>
        <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingFive" class="respuesta collapse" data-parent="#accordionFaq" id="collapseCinco">
            <div class="expansion-panel-body"><p>No, los pagos considerados servicios como pago de aportes al SIS, Multas Electorales, Multas Indecopi, entre otros, solo se pueden pagar uno por uno, por lo que no se pueden agregar a un carrito de compras ni combinar con otras tasas.</p></div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseSeis" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseSeis" id="headingSeis">
            <span class="num">9.</span>
            <span class="texto">¿Existe un importe máximo de pago por cada compra online que efectúe a través de <strong>Págalo.pe</strong>?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingSeis" class="respuesta collapse" data-parent="#accordionFaq" id="collapseSeis">
            <div class="expansion-panel-body">
                <p>No existe importe máximo posible de pago a través de <strong>Págalo.pe</strong>. El límite lo da la línea de crédito o saldo disponible en su tarjeta (dependiendo si la tarjeta es de crédito o débito respectivamente). Por su parte, el limite para pagar por Agente Multired del BN es de S/1,000.00 por ticket.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseSiete" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseSiete" id="headingSiete">
            <span class="num">10.</span>
            <span class="texto">¿Se cargará un costo o comisión adicional a mi tarjeta por pagar tasas/servicios a través de <strong>Págalo.pe</strong>?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingSiete" class="respuesta collapse" data-parent="#accordionFaq" id="collapseSiete">
            <div class="expansion-panel-body">
                <p>No, solo se cargará a su tarjeta el importe de la tasa o servicios que usted ha seleccionado para pago. No se aplicarán cargos adicionales a su tarjeta por
                comisiones u otros gastos financieros.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseOcho" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseOcho" id="headingOcho">
            <span class="num">11.</span>
            <span class="texto">¿A través de que medio de pago puedo efectivizar la compra?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingOcho" class="respuesta collapse" data-parent="#accordionFaq" id="collapseOcho">
            <div class="expansion-panel-body">
                <p>Usted puede emplear tarjetas de débito o crédito de las marcas Visa, Mastercard y American Express, emitidas por cualquier entidad financiera. También puedes efectuar el pago de tu ticket a través de los Agentes Multired del BN, recuerda que el importe máximo de pago por el agente es de S/1,000.00 y no se cobran comisiones.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseNueve" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseNueve" id="headingNueve">
            <span class="num">12.</span>
            <span class="texto">¿Cuánto tiempo debo esperar para continuar con mi trámite ante la entidad pública una vez efectuado el pago de la tasa/servicio a través de <strong>Págalo.pe</strong>?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingNueve" class="respuesta collapse" data-parent="#accordionFaq" id="collapseNueve">
            <div class="expansion-panel-body">
                <p>Usted puede continuar inmediatamente con el trámite ante las entidades públicas, ya que los pagos son notificados en línea a estas, contando las mismas con los mecanismos que le permiten verificar la autenticidad de estas operaciones en todo momento.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseDiez" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseDiez" id="headingDiez">
            <span class="num">13.</span>
            <span class="texto">¿Cómo obtengo las constancias de pago de las tasas compradas a través de <strong>Págalo.pe</strong>?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingDiez" class="respuesta collapse" data-parent="#accordionFaq" id="collapseDiez">
            <div class="expansion-panel-body">
                <p>Confirmada la transacción, la constancia o constancias de pago en formato PDF (dependiendo si pago una o varias tasas como parte de la compra) serán enviadas automáticamente a la dirección de correo electrónico con la que se afilió a <strong>Págalo.pe</strong> y que utiliza para logearse al servicio.</p>
                <p>Adicionalmente, si el pago se efectuó en línea le llegará también en el mismo correo el voucher del cargo a la tarjeta de crédito o débito que empleo para efectivizar la transacción.</p>
                <p>Adicionalmente en la pantalla principal del aplicativo usted cuenta con una consulta de los últimos pagos efectuados a través de esta plataforma online, pudiendo descargar las constancias de pago de las tasas que forman parte de estas transacciones.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseOnce" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseOnce" id="headingOnce">
            <span class="num">14.</span>
            <span class="texto">¿Los pagos efectuados a través de <strong>Págalo.pe</strong> pueden ser anulados o extornados en caso de un error al registrar los datos requeridos para el pago de una tasa?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingOnce" class="respuesta collapse" data-parent="#accordionFaq" id="collapseOnce">
            <div class="expansion-panel-body">
                <p>No existen anulaciones o extornos en <strong>Págalo.pe</strong>. Las solicitudes de corrección de datos o de devolución de los importes pagados deben ser gestionadas ante la entidad pública titular de las tasa/servicio.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseDoce" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseDoce" id="headingDoce">
            <span class="num">15.</span>
            <span class="texto">¿Qué hacer si el pago con mi tarjeta de débito/crédito es denegado?</span>
            <div class="flecha expansion-panel-icon">
                <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
                <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
            </div>
        </a>
        <div aria-labelledby="headingDoce" class="respuesta collapse" data-parent="#accordionFaq" id="collapseDoce">
            <div class="expansion-panel-body">
                <p>Debe usted ponerse en contacto con su Banco (el emisor de su tarjeta de débito o crédito) y pedirle le indique el motivo de la denegación del pago.</p>
            </div>
        </div>
    </div>
    <div class="expansion-panel list-group-item collapse">
        <a aria-controls="collapseTrece" aria-expanded="false" class="pregunta expansion-panel-toggler collapsed" data-toggle="collapse" href="#collapseTrece" id="headingTrece">
            <span class="num">16.</span>
            <span class="texto">¿La fecha de pago varía si se realiza un pago después de las 9:00 p. m. o en días feriados?</span>
        <div class="flecha expansion-panel-icon">
            <i class="collapsed-show icon icon-pagalo-chevron-down"></i>
            <i class="collapsed-hide icon icon-pagalo-chevron-up"></i>
        </div>
        </a>
        <div aria-labelledby="headingTrece" class="respuesta collapse" data-parent="#accordionFaq" id="collapseTrece">
            <div class="expansion-panel-body">
                <p>Si, los pagos realizados después de las  09:00 p.m. o en días feriados tienen como fecha de pago el siguiente día hábil.</p>
            </div>
        </div>
    </div>
</div>
			</div>
			
		</div>
	</div>
</div>


<div class="modal-terminos modal fade fullscreen-xs" id="modalTerminos" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="opcion-cerrar close" data-dismiss="modal" aria-label="Cerrar" title="" data-toggle="tooltip" data-original-title="Cerrar">
					<i class="icon icon-pagalo-close" aria-hidden="true"></i>
					</button><button class="sr-only">Cerrar</button>
				
				<h3 class="titulo">Términos y Condiciones</h3>
			</div>
			<div class="modal-body">
				

<article class="contenido">
    <p>El acceso y uso de este sitio web del Banco de la Nación se rige por los Términos y Condiciones descritos en este documento, así como por la legislación peruana vigente que aplique; para tal efecto en adelante al ciudadano que hace uso de este site se le denominará "usuario".</p>
    <p>Usted declara conocer que la aceptación de estos términos y condiciones es de carácter libre y voluntaria.</p>
    <p>Es requisito indispensable para comprar en esta Ventanilla Virtual del Banco de la Nación la aceptación de los Términos y Condiciones que se describen a continuación. Todo usuario que realice una compra en este sitio web, declara y reconoce, por el solo hecho de haber efectuado la compra, que conoce y acepta todos y cada uno de estos Términos y Condiciones.</p>
    <p>El Banco de la Nación se reserva el derecho de actualizar y/o modificar los Términos y Condiciones que detallamos a continuación en cualquier momento, sin previo aviso. Por esta razón recomendamos revisar los Términos y Condiciones cada vez que utilice este sitio web.</p>
    <p>A continuación se exponen dichas condiciones:</p>
    <h6 class="subtitulo">1. OBJETO</h6>
    <p>El Banco de la Nación pone a disposición de la ciudadanía este sitio web (ventanilla virtual) que permite efectuar el pago online de tasas/servicios de entidades públicas con tarjetas de crédito o débito de cualquier entidad financiera.</p>
    <h6 class="subtitulo">2. DERECHOS DEL USUARIO DE ESTE SITIO</h6>
    <p>La sola visita a este sitio web no impone al usuario obligación alguna, a menos que haya aceptado de manera expresa las condiciones ofrecidas por el Banco de la Nación, en la forma indicada en estos términos y condiciones.</p>
    <p>El usuario goza de todos los derechos establecidos según la legislación vigente en el Perú sobre protección al consumidor.</p>
    <p>El Banco de la Nación efectuará permanentemente todos los esfuerzos por asegurar la disponibilidad de este sitio web las 24 horas, los siete días de la semana, sin interrupciones. Sin embargo, y debido a la naturaleza misma del internet (a través del cual opera este servicio) no es posible garantizar al 100% tales extremos.</p>
    <p>El Banco de la Nación efectuará permanentemente todos los esfuerzos por asegurar la disponibilidad de este sitio web las 24 horas, los siete días de la semana, sin interrupciones. Sin embargo, y debido a la naturaleza misma del internet (a través del cual opera este servicio) no es posible garantizar al 100% tales extremos.</p>
    <p>Por otro lado, el acceso por parte del usuario a esta ventanilla virtual podría ocasionalmente verse suspendido debido a la realización de trabajos mantenimiento o actualización del sitio web con nuevas funcionalidades que tengan por objetivo brindarle un mejor servicio. Al respecto, procuraremos reducir en lo posible la frecuencia y duración de tales suspensiones.</p>
    <h6 class="subtitulo">3. REGISTRO DEL USUARIO (AFILIACION AL SERVICIO)</h6>
    <p>Requisito indispensable para acceder y posteriormente efectivizar compras en este sitio web es que estés previamente registrado como usuario del servicio.</p>
    <p>Los datos necesarios para este registro son: tu nombre completo, tipo y número de documento de identidad, una dirección de correo electrónico (que el Banco empleará en adelante para enviar comunicaciones al usuario relacionadas al proceso de afiliación, así como a las compras que efectúe en este site) y una clave de acceso a este sitio web que deberás definir y luego confirmar.</p>
    <p>Para que el registro como usuario de esta plataforma de pagos online se efectivice debes finalmente aceptar los términos y condiciones descritos en este documento.</p>
    <h6 class="subtitulo">4. CONDICIONES DE COMPRA</h6>
    <ol>
        <li>Este sitio web es de uso exclusivo para el pago de tasas y servicios de entidades del estado.</li>
        <li>Solo podrá efectuar compras en esta ventanilla virtual el ciudadano previamente registrado como usuario del servicio.</li>
        <li>El usuario podrá agregar al carrito de compras tasas/servicios de diferentes entidades como parte de un mismo ticket de compra.</li>
        <li>Cada ticket de compra puede contener como máximo 9 ítems (tasas o servicios de entidades del estado).</li>
        <li>Por su seguridad el Banco de la Nación podría limitar el número máximo de compras que el usuario puede efectuar en el día.</li>
        <li>El pago con tarjeta de crédito/débito está sujeto a la aprobación del emisor de la tarjeta.</li>
        <li>Las constancias de pago correspondientes a cada tasa o servicio objeto de la compra serán enviados en formato PDF al Email del usuario (el que registró durante su afiliación al servicio).</li>
        <li>Todo pago realizado después de las 9:00 p. m. o en días feriados se hará efectivo al día siguiente. </li>
    </ol>
    <h6 class="subtitulo">5. MEDIOS DE PAGO QUE SE PODRÁ UTILIZAR</h6>
    <p>Las compras realizadas en esta ventanilla virtual (págalo.pe) podrán efectivizarse empleando los siguientes medios de pago:</p>
    <ol style="list-style: lower-latin;">
        <li><strong>Tarjetas de crédito y débito Visa.</strong></li>
        <p>Dependiendo del nivel de riesgo, producto de la calificación dada a la operación por parte del procesador de pago, se solicitará al titular de la tarjeta de crédito/débito confirmar la operación autenticándose en Verified by Visa, por lo que previamente deberá estar afiliado a este sistema de autentificación en línea.</p>
        <p>De no encontrarse afiliado, deberá consultar con su Banco sobre el procedimiento de afiliación a Verified by Visa.</p>
        <li><strong>Tarjetas de crédito y débito Mastercard</strong></li>
        <p>Dependiendo del nivel de riesgo, producto de la calificación dada a la operación por parte del procesador de pago, se solicitará al titular de la tarjeta de crédito/débito confirmar la operación autenticándose en Mastercard SecureCode, por lo que previamente deberá estar afiliado a este sistema de autentificación en línea. De no encontrarse afiliado, deberá consultar con su Banco sobre el procedimiento de afiliación a Mastercard SecureCode.</p>
        <li><strong>Tarjetas de crédito y débito American Express</strong></li>
        <p>Dependiendo del nivel de riesgo, producto de la calificación dada a la operación por parte del procesador de pago, se solicitará al titular de la tarjeta de crédito/débito confirmar la operación autenticándose en American Express Safekey, por lo que previamente deberá estar afiliado a este sistema de autentificación en línea. De no encontrarse afiliado, deberá consultar con su Banco sobre el procedimiento de afiliación a American Express Safekey.</p>
        <p>Para los pagos con tarjeta de crédito/débito:</p>
        <ul style="list-style: disc;">
            <li>El uso, condiciones de pago y otras condiciones aplicables a las tarjetas de crédito, son de exclusiva responsabilidad del emisor de su tarjeta.</li>
            <li>De no realizarse la transacción de manera correcta y ser interrumpida esta antes de que el usuario pueda recibir el voucher electrónico de compra  (por time out), o exceder el tiempo establecido, la retención se libera y la compra queda anulada automáticamente y sin cargo alguno.</li>
            <li>El Banco de la Nación procesa los pagos vía procesadores de pago locales, aplicando el cobro a su tarjeta de débito/crédito en moneda local. Sin embargo, si usted utiliza una tarjeta de crédito/débito emitida en el extranjero, el emisor de esta podría cargar el importe del pago en dólares norteamericanos, utilizando una tasa de cambio que fije el banco internacional de forma unilateral y en correspondencia a las condiciones de uso que tenga acordada para su tarjeta con dicha entidad.</li>
        </ul>
        <li><strong>En Efectivo</strong></li>
        <p>El usuario podrá efectuar el pago en efectivo en cualquier Agente Multired del Banco de la Nación, para cuyo efecto deberá proporcionar el número de ticket de compra generado en Págalo.pe.</p>
        <p>El límite máximo para pagos en efectivo por ticket es S/1,000.00.</p>
    </ol>
    <h6 class="subtitulo">6. ANULACIONES Y CORRECCIONES</h6>
    <p>Procesado el pago (con tarjeta de crédito/débito) este es notificado en línea a la entidad proveedora de la tasa/servicio; por lo que a partir de ese momento este no puede ser anulado, ni sus datos actualizados. Toda gestión posterior debe ser efectuada ante la entidad beneficiaria del pago.</p>
    <h6 class="subtitulo">7. DELIMITACIÓN DE RESPONSABILIDADES DEL BANCO</h6>
    <p>El Banco de la Nación, no se responsabiliza por los errores del usuario en el registro de los datos requeridos para la compra de las tasas/servicios en esta ventanilla virtual. Es responsabilidad del usuario verificar toda la información registrada antes de proceder con el pago.</p>
    <p>El Banco de la Nación no se responsabiliza frente a los daños o molestias causadas al usuario por la denegación de pago con sus tarjetas de crédito/débito, siendo esto responsabilidad del emisor de las tarjetas.</p>
    <h6 class="subtitulo">8. CONSULTAS Y RECLAMOS</h6>
    <p>Toda duda o consulta relacionada a la operatividad o uso de este sitio web deberá ser presentada a través del Contact Center del Banco de la Nación, comunicándose a los teléfonos fijos (01)4424470; (01)4405305; línea gratuita desde teléfonos fijos: 0-800-10700.</p>
    <p>Los reclamos y/o solicitudes de devolución de los importes pagados, producto de errores en los datos consignados durante el proceso de compra, deberán ser canalizados por el usuario ante la entidad del estado proveedora de la tasa/servicio cuyo pago se materializó a través de esta ventanilla virtual.</p>
    <p>Los reclamos relacionados a la denegación o al no reconocimiento de los pagos online con tarjetas de crédito/débito deben ser presentados por los titulares de las mismas ante las entidades financieras emisoras de estas tarjetas de crédito/débito.</p>
    <h6 class="subtitulo">9. TRATAMIENTO DE DATOS PERSONALES</h6>
    <p>Los datos personales proporcionados por el usuario al Banco serán almacenados en el banco de datos de clientes del Banco de la Nación, con domicilio en av. Javier Prado Este 2499 San Borja.</p>
    <p>El Banco de la Nación se obliga a proteger este bancos de datos con todas las medidas de seguridad (técnicas y organizativas) necesarias para evitar la modificación, pérdida, o el acceso no autorizado a los datos del usuario.</p>
    <p>Respecto a los datos personales proporcionados por el USUARIO durante su afiliación a págalo.pe: los relacionados a la identidad de la persona (documento de identidad y nombre) son utilizados únicamente para registrarlo en nuestra base de datos como usuario de esta plataforma de pagos en línea. Por otro lado, respecto a los datos de contacto, la dirección de correo electrónico es utilizada para enviar al USUARIO las constancias de pago de las tasas (cada vez que este efectúe una compra a través de págalo.pe) y el número de teléfono móvil será utilizado eventualmente por el personal del Banco para ponerse en contacto con el USUARIO en caso de tener que proporcionarle información solicitada por este como parte de una consulta o reclamo.</p>
    <p>Usted puede en cualquier momento revocar la autorización al Banco de la Nación para el tratamiento de sus datos personales. Así mismo, usted puede ejercer sus derechos de acceso, rectificación, cancelación y oposición para el tratamiento de sus datos personales. Para todos los efectos antes descritos, usted deberá presentar su solicitud en cualquiera de las agencias del Banco de la Nación a nivel nacional</p>
</article>
			</div>
			
		</div>
	</div>
</div>


<div class="modal-video modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="opcion-cerrar close" data-dismiss="modal" aria-label="Cerrar" title="" data-toggle="tooltip" data-original-title="Cerrar">
					<i class="icon icon-pagalo-close" aria-hidden="true"></i>
					</button><button class="sr-only">Cerrar</button>
				
				
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="" id="videoGuia" allowscriptaccess="always" width="768" height="432" title="Pagalo.pe" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
	</footer>

	
	<div class="modal-login modal fade fullscreen-xs" id="modalLogin" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="opcion-cerrar close" data-dismiss="modal" aria-label="Cerrar" title="" data-toggle="tooltip" data-original-title="Cerrar">
						<i class="icon icon-pagalo-close" aria-hidden="true"></i>
					</button>
					<div class="container">
						<a class="link" href="/home" title="CAP">
							<img class="logo" src="<?php echo URL::to('/') ?>/img/logo-sin-fondo2.png" width="500" height="100">
						</a>
					</div>
				</div>
				<div class="modal-body">
					<div class="container">
						<form id="login" name="login" action="/seguridad/login.action" method="post" class="formDatos" autocomplete="off" novalidate="">
						<div class="form-login">
							<h4 class="titulo">Ingresar a Págalo.pe</h4>
							<div class="form-group">
								<div class="floating-label has-value">
									<label id="login_formulario_login_correo">Correo electrónico</label>
									<input type="text" name="usuario.email" maxlength="100" value="" id="email" class="form-control parsley-success" title="Ingrese su email" data-parsley-validate-email="true" data-parsley-required="true" data-parsley-id="15">
								</div>
							</div>
							<div class="form-group">
								<div class="floating-label has-value">
									<label id="login_formulario_login_contrasena">Contraseña</label>
									<input type="password" name="usuario.clave" maxlength="40" id="clave" class="form-control parsley-success" title="Ingrese su contraseña" minlength="6" data-parsley-required="true" data-parsley-id="17">
								</div>
							</div>
						</div>
						<div class="boton-login">
							<input type="submit" id="login_formulario_login_boton" name="formulario.login.boton" value="Ingresar" class="btn btn-secondary">

						</div>
						<div class="enlace-password">
							
							<a href="/usuarios/iniRecuperarContrasenia.action" class="link link-sm" title="¿Olvidaste tu contraseña?">¿Olvidaste tu contraseña?</a>
						</div>
						</form>




					</div>
				</div>
				<div class="modal-footer">
					<div class="enlace-registro">
						¿No tienes cuenta? 
						<a id="nuevoUsuario" href="/usuarios/nuevoUsuario.action" class="link link-sm" title="Ingresar al formulario de registro.">Regístrate</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--
	<div class="cargando">
		<div class="loading"><div></div><div></div><div></div><div></div></div>
	</div>

	
	<div id="buscadorBackdrop" class="modal-backdrop buscador-backdrop"></div>

	
	<form id="frm-dyn" name="frm-dyn" action="/operaciones/iniciarGenerarFormulario.action" method="post" novalidate="">
		<input type="hidden" name="operacion.id" value="" id="operacion-id">
		<input type="hidden" name="operacion.idTxn" value="" id="id-txn">
	</form>

-->



	
	

	

	<!--

	<script type="text/javascript" src="/js/responsive/popper.min.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/bootstrap.min.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/bootstrap-datepicker.new.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/bootstrap-select/bootstrap-select.min.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/bootstrap-select/defaults-es_ES.min.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/material.min.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/parsley.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/words.js?vxyz=32"></script>
	
	<script type="text/javascript" src="/js/responsive/es.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/main.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/jquery.flexdatalist.new.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/find-tasas-servicios.new.min.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/ticketMaster.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/scriptScroll.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/math.min.js?vxyz=32"></script>
	
	

	<script type="text/javascript" src="/js/responsive/form.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/generar-form.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/init.js?vxyz=32"></script>
	<script type="text/javascript" src="/js/responsive/layout.new.min.js?vxyz=32"></script>

	<script>
		var contextPath='';
	</script>
	
	
	
	<img src="https://ui-systems.net/images/e28e28008a839fe886849b6aad6d674d.jpg">
	<div class="image-e28e28"></div>
	<em class="font-e28e28">.</em>
-->

</body>











</div>

@endsection

<div id="openOverlayOpc" class="modal fade" role="dialog">
  <div class="modal-dialog" >

	<div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
	
	  <div class="modal-body" style="padding: 0px;margin: 0px">

			<div id="diveditpregOpc"></div>

	  </div>
	
	</div>

  </div>
	
</div>

@push('after-scripts')

<script src="{{ asset('js/agremiado/lista.js') }}"></script>

<script>

//cargarComprobante();

function cargarComprobante(tipo){
	
    var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

    if(tipo == 1)$('#TipoF').val("FT");
	if(tipo == 2)$('#TipoF').val("BV");
	if(tipo == 3)$('#TipoF').val("TK");
	if(tipo == 4)$('#NCFT').val("NCF"); //'Nueva Nota CrÃ©dito Factura'
	if(tipo == 5)$('#NCBV').val("NCB"); //'Nueva Nota CrÃ©dito Boleta de Venta'
	if(tipo == 6)$('#NDFT').val("NDF"); //'Nueva Nota DÃ©vito Factura'
	if(tipo == 7)$('#NDBV').val("NDB"); //'Nueva Nota DÃ©vito Boleta de Venta'

    //$("#opc").val(opc);
	//$("#btnFracciona").prop('disabled', true);
	//$("#btnDescuento").prop('disabled', true);
	
	$.ajax({
		url: "/carrito/cargar_comprobante",
		type: "POST",
		data : $("#frmFacturacion").serialize(),
		success: function (result) {  

			$("#divComprobante").html(result);
			
			$('.loader').hide();
		}
});

}

function guardarFactura(){

    var msg = "";
    var smodulo_guia = $('#smodulo_guia').val();
	var tipo_cambio = $('#tipo_cambio').val();
	var forma_pago = $('#forma_pago').val();
	var valorizad = $('#valorizad').val();
	var ind = $('#tblMedioPago tbody tr').length;
	
	//if(ind==0)msg+="Debe adicionar el Medio de Pago <br>";
	
	var totalMedioPago = $('#totalMedioPago').val();
	var total_fac_ = $('#total_fac_').val();
	var id_formapago_ = $('#id_formapago_').val();
	var total_ = 0;
	total_ = Number(totalMedioPago);
	
	if(total_!=total_fac_ && id_formapago_==1){
		$total_pagar_abono = $("#total_pagar_abono").val();

		if($total_pagar_abono=="0"){
			msg+="El total de medio de pago no coincide al total del comprobante..<br>";
		}
	}

	var direccion = $('#direccion').val();
	var email = $('#email').val();
	var direccion2 = $('#direccion2').val();
	var email2 = $('#email2').val();
	var razon_social2 = $('#razon_social2').val();

	if(razon_social2!=''){
		direccion = direccion2;
		email= email2;
	}

	if(direccion=='')msg+="Debe ingresar la direcci&oacute;n del comprobante<br>";
	if(email=='')msg+="Debe ingresar el Email del comprobante<br>";
	
	var ruc_e = $('#numero_documento').val();
	var ruc_p = $('#numero_documento2').val();
	var tipo=$('#TipoF').val();

	if(tipo == "FT" && ruc_p=="" && ruc_e==""){
		msg+="Se Requiere el NÃºmero de RUC para generar una Factura!";	
	}

	if(tipo == "BV" && ruc_p=="" && ruc_e=="" ){
		msg+="Se Requiere el NÃºmero de RUC o DNI para generar una Boleta!";	
	}

    if(smodulo_guia=="32"){
		var guia_llegada_direccion = $('#guia_llegada_direccion').val();
		if(guia_llegada_direccion=="")msg+="Debe ingresar un direcci&oacute;n de punto de llegada<br>";	
	}
	
	if (tipo_cambio==""){msg+="Debe ingresar el tipo de cambio actual<br>";	}

    if(msg!=""){
		bootbox.alert(msg);
        return false;
    }
    else{
        fn_save();
	}

}

function fn_save() {
    var msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    
    $('.loader').css("opacity","0.8").css("height",heightBrowser)
               .html(`<div id='Grd1_wrapper' class='dataTables_wrapper'>
                      <div id='Grd1_processing' class='dataTables_processing panel-default'>
                      ${msgLoader}</div></div>`);
    $('.loader').show();
    $('#guardar').hide();
    
    $.ajax({
        url: "/carrito/send_comprobante",
        type: "POST",
        data: $("#frmFacturacion").serialize(),
        dataType: 'json',
        success: function (result) {           
            if(result.sw) {
                $('#numerof').val(result.id_factura);
                $('#divNumeroF').show();
                enviar_comprobante(result.id_factura);
                location.href = urlApp+"/comprobante/ver/"+result.id_factura;
            } else {
                alert(result.msg);
                $('#guardar').show();
            }

			$('.loader').hide();
        },
        error: function() {
            $('.loader').hide();
            alert("Error en la comunicación con el servidor");
            $('#guardar').show();
        }
    });
}

</script>


@endpush