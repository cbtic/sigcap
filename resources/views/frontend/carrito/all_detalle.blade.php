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

.footer {
    background-color: #1C77B9 !important;
}

/***************************/

.btn-linear:hover {
    color:#FFFFFF!important
}

</style>

<script type="text/javascript">

const transactionId = '123456789';
const merchantCode = 'MERCHANT123';
const orderNumber = 'ORDER001';
const merchantBuyerId = 'mc1991'; 
const dateTimeTransaction = '1670258741603000'; 

const iziConfig = {
  config: {
    transactionId: transactionId,//'{TRANSACTION_ID}',
    action: 'pay',
    merchantCode: merchantCode,//'{MERCHANT_CODE}',
    order: {
      orderNumber: orderNumber,//'{ORDER_NUMBER}',
      currency: 'PEN',
      amount: '1.50',
      processType: 'AT',
      merchantBuyerId: merchantBuyerId,//'{MERCHANT_CODE}',
      dateTimeTransaction: dateTimeTransaction,//'1670258741603000',
    },
    billing: {
      firstName: 'Juan',
      lastName: 'Wick Quispe',
      email: 'jwickq@izi.com',
      phoneNumber: '958745896',
      street: 'Av. Jorge Chávez 275',
      city: 'Lima',
      state: 'Lima',
      country: 'PE',
      postalCode: '15038',
      documentType: 'DNI',
      document: '21458796',
    },
    render: {
      typeForm: 'pop-up'
   },
  },
};

    try {

        const checkout = new Izipay({ config: iziConfig });

    } catch ({Errors, message, date}) {

        console.log({Errors, message, date});

    }

    
    const callbackResponsePayment = (response) => console.log(response);

    try {
    checkout &&
        checkout.LoadForm({
        authorization: 'TU_TOKEN_SESSION',
        keyRSA: 'KEY_RSA',
        callbackResponse: callbackResponsePayment,
        });
    } catch ({Errors, message, date}) {
    console.log({Errors, message, date});
    }
    

</script>

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




<div id="pageCarrito" class="container">
	
	<section class="seccion-principal seccion-carrito">
		<h1 class="titulo">
			
			<div class="wizard">
				<div class="item active"><i class="icon fas fa-search" aria-hidden="true" title="Buscar"></i></div>
				<div class="item active"><i class="icon fas fa-edit" aria-hidden="true" title="Completar datos"></i></div>
				<div class="item active"><i class="icon fas fa-shopping-cart" aria-hidden="true" title="Carrito"></i></div>
				<div class="item"><i class="icon fas fa-money-bill" aria-hidden="true" title="Medios de Pago"></i></div>
				<div class="item"><i class="icon fas fa-receipt" aria-hidden="true" title="Resumen de pago"></i></div>
			</div>
			
			
			Carrito de compras
			<small class="descriptivo">
				<span class="carrito-cantidad">1</span>
				<span class="carrito-descripcion">
				
					artículo seleccionado
				
				
				</span>
			</small>
			<img class="curva" src="https://pagalo.pe/imagenes/new/curva.svg" aria-hidden="true">
		</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

		<div class="card">
            
            <!--
            <div class="form-group" style="margin-bottom:0px">
                <a class="btn btn-secondary" style="display:block;float:right" href="/carrito" id="add-pay">Agregar otro pago</a>
            </div>
            -->

			<div class="card-body">
					<div id="divTablaCarrito">
    
    <div class="container">
		
        <div class="tablaflex tablaflex-carrito" id="tablaCarrito">
			
        <div class="thead">
				<div class="row">
					<div class="col col-num">#</div>
                    <div class="col col-documento">Cantidad</div>
					<div class="col col-tasa">Concepto</div>
                    <div class="col col-entidad">Vencimiento</div>
					<div class="col col-costo">Precio</div>
                    <div class="col col-costo">V.Venta</div>
                    <div class="col col-costo">IGV</div>
					<div class="col col-costo">Total</div>
					<div class="col col-opciones">Eliminar</div>
				</div>
			</div>
			<input type="hidden" name="toRedirect" value="" id="toRedirect">
			<input type="hidden" name="idItemToRedirect" value="" id="idItemToRedirect">
			
			
			<div class="tbody">

				
				
					<?php 
                    if($carrito_items){
                    $tot_reg = count($carrito_items);
                    $n = 0;
                    foreach($carrito_items as $key=>$row){
                        $disabled = "";
                        $n++;
                        //if ($n!=1)$disabled = "disabled";
                        if ($tot_reg != $n)$disabled = "disabled";
                    ?>
					
					<div class="row">
						<div class="col col-num">{{$key+1}}</div>
                        <div class="col col-documento">{{$row->cantidad}}</div>
						<div class="col col-tasa">{{$row->nombre}}</div>
                        <div class="col col-entidad"><span class="tag tag-list" style="width:100%" title="" data-toggle="tooltip" data-original-title="RENIEC">{{$row->fecha_vencimiento}}</span></div>
						<div class="col col-costo">{{$row->precio_unitario}}</div>
                        <div class="col col-costo">{{$row->valor_venta}}</div>
                        <div class="col col-costo">{{$row->impuesto}}</div>
                        <div class="col col-costo">{{$row->total}}</div>
						<div class="col col-opciones">
							<div class="responsive">
								<button type="button" class="opciones-carrito close">
									<i class="item-cerrar icon icon-pagalo-close"></i>
									<i class="item-menu icon icon-pagalo-options"></i>
									<span class="sr-only">Eliminar</span>
								</button>
							</div>
							<div class="acciones">
                                <!--
								<a href="javascript:void(0)" onclick="eliminarItem({{$row->id}})" data-toggle="tooltip" data-placement="top" title="" class="link link-icon" data-original-title="Eliminar">
									<i class="icon fa fa-trash" aria-hidden="true"></i>
                                </a>
                                -->
                                <form action="{{ url('carrito/eliminar', $row->id) }}" method="POST" >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" <?php echo $disabled?> class="btn link link-icon" style="border:0px;background-color:#FFFFFF;padding:0 0px;min-width:3.5rem"><i class="icon fa fa-trash" aria-hidden="true"></i></a></button>
                                </form>
                            
							</div>
						</div>
						<div class="col col-id">0</div>
					</div>
					<?php 
                        }
                        }else{
                            ?>
                            <p>No existen items de pago generados.</p>
                            <?php 
                        }
                    ?>

				
			</div>
			<!-- <div class="thead">
				<div class="row">
					<div class="col">
						Total a pagar: S/ 41.00
					</div>
				</div>
			</div> -->
		</div>
	</div>

	<!--<p class="alert alert-sm alert-info alert-horario">Todo pago realizado después de las 9:00 p. m. o en días feriados se hará efectivo al día siguiente.</p>-->

    <p class="alert alert-sm alert-info alert-horario">Todos los pagos son realizados a través de un servicio de pago en línea confiable con los diferentes metodos de pago.</p>
	<!--
	<div class="carrito-terminos">
		<div id="alertTerminos" class="alert alert-sm alert-warning alert-terminos" style="display: none;">Debes aceptar los términos y condiciones para continuar con el pago.</div>
		<div id="terminos">
			<label class="chk-label"><input type="checkbox" id="chk-terminos" data-parsley-multiple="chk-terminos" data-parsley-id="10"> <div class="chk-terminos-text">Aceptar los <span class="link" data-toggle="modal" data-target="#modalTerminos">Términos y Condiciones</span></div></label>
		</div>
	</div>
    -->
	
    <h6 class="total-carrito">
		OP.Gravadas: S/ <?php echo $subtotal?>
	</h6>
    <h6 class="total-carrito">
		IGV: S/ <?php echo $impuesto_total?>
	</h6>
	<h6 class="total-carrito">
		Total a pagar: S/ <?php echo $total_general?>
	</h6>

<script type="text/javascript">
    /*
	$(document).ready(function(){
		// var mobileQuery = 992;
		// if($(window).width() < mobileQuery) {
			$("body").on("click",".tablaflex-carrito .item-menu", function(){
				$(".tablaflex-carrito .activo").removeClass("activo");
				$(this).parents(".col-opciones").addClass("activo");
			});

			$("body").on("click",".tablaflex-carrito .item-cerrar", function(){
				$(this).parents(".col-opciones").removeClass("activo");
			});
		// }
	});
    */
</script>

<input type="hidden" name="maxOper" value="9" id="maxOper">
<input type="hidden" name="numOper" value="1" id="numOper">
<input type="hidden" name="codMoneda" value="1" id="codMoneda">


					</div>

                <a class="btn btn-secondary" href="/carrito" id="add-pay">AGREGAR OTRO PAGO</a>
                
                <!--
                btn-linear
				<form id="fGenTicket" name="fGenTicket" action="/operaciones/genTicketGlobal.action" method="post" novalidate="">				
				<div class="botones-carrito">
					<div class="form-group-btn">
						<button type="button" class="btn btn-primary" id="btnGenTicket">Pagar</button>
					</div>
				</div>
				</form>
                -->
                <br><br>
                <?php if($total_general>0){?>
                <input type="checkbox" name="ckbTerms" id="ckbTerms" onclick="visaNetEc3()"> 
                <label for="ckbTerms">Acepto los <a href="#" data-toggle="modal" data-target="#modalTerminos">Términos y condiciones</a></label>

                <!--<form id="frmVisaNet" action="http://localhost/PagoWebPhp/finalizar.php?amount=<?php //echo $total_general;?>&purchaseNumber=<?php //echo $purchaseNumber?>">-->
                <form id="frmVisaNet" action="{{ url('carrito/finalizar') }}" method="POST">    
                    @csrf
                    <script src="<?php echo $urlJs?>" 
                        data-sessiontoken="<?php echo $sesion;?>"
                        data-channel="web"
                        data-merchantid="<?php echo $merchantId?>"
                        data-merchantlogo="<?php echo URL::to('/') ?>/img/CAP_logofinal-2021.png"
                        data-purchasenumber="<?php echo $purchaseNumber;?>"
                        data-amount="<?php echo $total_general; ?>"
                        data-expirationminutes="5"
                        data-timeouturl="<?php echo URL::to('/') ?>/carrito"
                    ></script>
                    <input type="hidden" name="amount" value="{{ $total_general }}">
                    <input type="hidden" name="purchaseNumber" value="{{ $purchaseNumber }}">
                </form>
                <?php }?>


			</div>
		</div>
	</section>
	
	<section class="seccion-sidebar" style="visibility: visible;">
		<div class="card" style="position: absolute; top: 218.203px;">
			<h4 class="titulo"><i class="icon fas fa-info-circle" aria-hidden="true"></i> Información</h4>
			<div class="card-body">
				<h6 class="subtitulo">¿Algo más que deba saber?</h6>
				<p>Recuerda revisar bien los datos ingresados y aceptar los términos y condiciones antes de proceder con el pago.</p>
				<p class="alert alert-sm alert-info alert-horario">Todos los pagos son realizados a través de un servicio de pago en línea confiable con los diferentes metodos de pago.</p>
			</div>
		</div>
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
			
			<div class="col-lg-8 col-12 footer-izquierdo">
				<div class="brand">
					<a href="/home" title="CAP">
						<img class="logo" src="<?php echo URL::to('/') ?>/img/logo-sin-fondo.png" width="500" height="100" alt="CAP">
					</a>
				</div>
				<strong class="titulo">Colegio de Arquitectos del Per&uacute; | Regional Lima</strong>
				<span class="enlace-mobile link link-sm collapsed" data-toggle="collapse" href="#footerInfo" role="button" aria-expanded="false" aria-controls="footerInfo">Contáctenos<i class="icon icon-pagalo-chevron-up" aria-hidden="true"></i></span>
				<div class="contacto collapse" id="footerInfo">
					<!--<p>Mesa de ayuda: (01) 442-4470 - (01) 440-5305 - Línea gratuita: 0-800-10700</p>-->
					<p>Oficina Principal: Av. San Felipe 999, Jesús María 15072. Central telefónica: (01) 627 - 1200.</p>
					<p>Atención en oficinas administrativas: lunes a viernes de 8:00 a 17:00 horas.</p>
					<p>Atención en Oficina de Trámite Documentario: lunes a viernes de 8:00 a 17:00 horas.</p>
				</div>
			</div>
			
			<!--<div class="col-lg-4 col-12 footer-derecho">
				<div class="footer-menu">
					<div class="row">
						<div class="col">
							<h4 class="subtitulo">Págalo.pe</h4>
						</div>
					</div>
					<div class="row">
						<div class="opciones">
							<ul class="col-lg-6 col-12">
								<li><span class="open-modal-faq-1 link link-sm">¿Qué es?</span></li>
								<li><span class="open-modal-faq-2 link link-sm vista-previa link-video" data-toggle="modal" data-src="https://www.youtube.com/embed/6faiVzbvfgY" data-target="#modalVideo">¿Cómo pagar?</span></li>
								<li><span class="open-modal-faq-3 link link-sm">¿Qué puedo pagar?</span></li>
							</ul>
							<ul class="col-lg-6 col-12">
								<li><span class="link link-sm link-agencias" data-toggle="modal" data-src="https://appmovil.bn.com.pe/Ubicanos/" data-target="#modalAgencias">Ubicar agencias</span></li>
								<li><span class="link link-sm link-faq" data-toggle="modal" data-target="#modalFaq">Preguntas frecuentes</span></li>
								<li><span class="link link-sm link-terminos" data-toggle="modal" data-target="#modalTerminos">Términos y condiciones</span></li>
							</ul>
						</div>	
					</div>
				</div>
			</div>-->
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
					<i class="fas fa-times" aria-hidden="true"></i>
					</button><button class="sr-only">Cerrar</button>
				
				<h4 class="titulo">Términos y Condiciones de Uso del Carrito de Compras en Línea<br>COLEGIO DE ARQUITECTOS DEL PERU REGIONAL LIMA</h4>
			</div>
			<div class="modal-body">
                <article class="contenido">
                    <h6 class="subtitulo">1. Aceptación de los Términos</h6>
                    <p>El uso del carrito de compras en línea del Colegio Profesional COLEGIO DE ARQUITECTOS DEL PERU REGIONAL LIMA implica la aceptación plena y sin reservas de los presentes Términos y Condiciones. El usuario reconoce haber leído, comprendido y aceptado la presente política antes de realizar cualquier pago.</p>
                    <h6 class="subtitulo">2. Definiciones</h6>
                    <p>Usuario: Profesional colegiado o tercero autorizado que utiliza la plataforma.</p>
                    <p>Plataforma: Sitio web y sistema de carrito de compras en línea del Colegio Profesional.</p>
                    <p>Servicios: Pago de cuotas ordinarias, extraordinarias, derechos de trámites, certificaciones y demás servicios que el Colegio Profesional disponga.</p>
                    <h6 class="subtitulo">3. Registro y Autenticación</h6>
                    <p>El acceso al carrito de compras requiere autenticación mediante credenciales únicas e intransferibles del usuario.</p>
                    <p>El usuario es responsable de la confidencialidad de sus credenciales y del uso indebido que terceros pudieran hacer de ellas.</p>
                    <h6 class="subtitulo">4. Métodos de Pago</h6>
                    <p>Se aceptan únicamente los medios de pago habilitados en la plataforma (tarjetas de crédito/débito, transferencias en línea, billeteras digitales u otros autorizados).</p>
                    <p>Las transacciones son procesadas a través de pasarelas de pago certificadas con estándares de seguridad (PCI DSS, TLS/SSL).</p>
                    <p>El Colegio Profesional no almacena ni gestiona datos sensibles de las tarjetas de crédito/débito.</p>
                    <h6 class="subtitulo">5. Seguridad de la Información</h6>
                    <p>La plataforma utiliza cifrado SSL/TLS para proteger la confidencialidad de las comunicaciones.</p>
                    <p>Los datos personales y financieros son tratados conforme a la Ley N.° 29733 de Protección de Datos Personales.</p>
                    <p>Se realizan auditorías periódicas de seguridad para mitigar riesgos de fraude, robo de identidad o accesos no autorizados.</p>
                    <h6 class="subtitulo">6. Responsabilidad del Usuario</h6>
                    <p>El usuario se compromete a:</p>
                    <ul>
                        <li>Utilizar la plataforma únicamente para fines lícitos y autorizados.</li>
                        <li>No realizar fraudes, intentos de acceso indebido ni actividades que comprometan la seguridad del sistema.</li>
                        <li>Verificar la exactitud de la información ingresada antes de efectuar un pago.</li>
                </ul>
                    <h6 class="subtitulo">7. Confirmación de Pagos y Comprobantes</h6>
                    <p>Una vez confirmado el pago, el usuario recibirá un comprobante electrónico (boleta o factura, según corresponda) en el correo electrónico registrado.</p>
                    <p>El Colegio Profesional no se responsabiliza por errores en los datos ingresados por el usuario que afecten la emisión de comprobantes.</p>
                    <h6 class="subtitulo">8. Política de Reembolsos</h6>
                    <p>Los pagos efectuados no son reembolsables, salvo error imputable al Colegio Profesional o cobro indebido.</p>
                    <p>Todo reclamo deberá presentarse por escrito a través de los canales oficiales en un plazo máximo de 7 días hábiles después de la operación.</p>
                    <h6 class="subtitulo">9. Protección de Datos Personales</h6>
                    <p>Los datos recopilados serán utilizados exclusivamente para la gestión administrativa, financiera y colegiada.</p>
                    <p>El usuario puede ejercer sus derechos de acceso, rectificación, cancelación y oposición (ARCO) mediante solicitud escrita dirigida al Colegio Profesional.</p>
                    <h6 class="subtitulo">10. Limitación de Responsabilidad</h6>
                    <p>El Colegio Profesional no será responsable por fallas técnicas, interrupciones del servicio o problemas ajenos a su control (fallas de Internet, pasarelas de pago externas, etc.).</p>
                    <p>El Colegio Profesional tampoco garantiza la disponibilidad continua del sistema, aunque hará sus mejores esfuerzos por mantenerlo activo y seguro.</p>
                    <h6 class="subtitulo">11. Modificaciones de los Términos</h6>
                    <p>El Colegio Profesional podrá modificar los presentes Términos y Condiciones en cualquier momento, comunicando los cambios a través de la plataforma. El uso continuado del servicio implica la aceptación de las modificaciones.</p>
                    <h6 class="subtitulo">12. Jurisdicción y Ley Aplicable</h6>
                    <p>Los presentes Términos y Condiciones se rigen por las leyes de la República del Perú. Cualquier controversia será resuelta en los tribunales competentes del distrito judicial de Lima Cercado.</p>
                    <h6 class="subtitulo" style="text-align:right">Colegio de Arquitectos del Perú - Regional Lima</h6>
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

var frmVisa = document.getElementById('frmVisaNet');

if (document.body.contains(frmVisa)) {
    document.getElementById('frmVisaNet').setAttribute("style", "display:none");
}
function visaNetEc3() {
    if (document.getElementById('ckbTerms').checked) {
        document.getElementById('frmVisaNet').setAttribute("style", "display:auto");
    } else {
        document.getElementById('frmVisaNet').setAttribute("style", "display:none");
    }
}
</script>

@endpush