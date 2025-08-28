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

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

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
		<div class="card">
			<div class="card-body">
				
				
				<form id="fEditarItem" name="fEditarItem" action="/operaciones/editarItemCarrito.action" method="post" novalidate="">
					<input type="hidden" name="idItem" value="" id="idItem">
					<input type="hidden" name="accionItem" value="insertar" id="accionItem">
					<div id="divTablaCarrito">
						
						



	<div class="container">
		<div class="tablaflex tablaflex-carrito" id="tablaCarrito">
			<div class="thead">
				<div class="row">
					<div class="col col-num">
						#
						
					</div>
					<div class="col col-tasa">Concepto</div>
                    <div class="col col-entidad">Vencimiento</div>
					<div class="col col-costo">Precio</div>
                    <div class="col col-costo">Cantidad</div>
					<div class="col col-documento">Total</div>
					<div class="col col-opciones">Eliminar</div>
				</div>
			</div>
			<input type="hidden" name="toRedirect" value="" id="toRedirect">
			<input type="hidden" name="idItemToRedirect" value="" id="idItemToRedirect">
			
			
			<div class="tbody">

				
				
					<?php 
                    if($carrito_items){
                    foreach($carrito_items as $key=>$row){?>
					
					<div class="row">
						<div class="col col-num">{{$key+1}}</div>
						<div class="col col-tasa">{{$row->nombre}}</div>
                        <div class="col col-entidad"><span class="tag tag-list" style="width:100%" title="" data-toggle="tooltip" data-original-title="RENIEC">{{$row->fecha_vencimiento}}</span></div>
						<div class="col col-costo">{{$row->precio_unitario}}</div>
						<div class="col col-documento">{{$row->cantidad}}</div>
                        <div class="col col-documento">{{$row->total}}</div>
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
								<a href="javascript:void(0)" onclick="faccionItem(0,'editar')" data-toggle="tooltip" data-placement="top" title="" class="link link-icon" data-original-title="Editar">
									<i class="icon icon-pagalo-edit" aria-hidden="true"></i></a>
                                -->
								<a href="javascript:void(0)" onclick="faccionItem(0,'eliminar')" data-toggle="tooltip" data-placement="top" title="" class="link link-icon" data-original-title="Eliminar">
									<i class="icon fa fa-trash" aria-hidden="true"></i></a>
								<!--
                                <a href="javascript:void(0)" onclick="faccionItem(0,'duplicar')" data-toggle="tooltip" data-placement="top" title="" class="link link-icon" data-original-title="Duplicar">
									<i class="icon icon-pagalo-duplicate" aria-hidden="true"></i></a>
                                -->
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
				</form>

                <a class="btn btn-linear" href="/carrito" id="add-pay">Agregar otro pago</a>
                
                <!--
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
                <label for="ckbTerms">Acepto los <a href="#" target="_blank">Términos y condiciones</a></label>

                <!--<form id="frmVisaNet" action="http://localhost/PagoWebPhp/finalizar.php?amount=<?php //echo $total_general;?>&purchaseNumber=<?php //echo $purchaseNumber?>">-->
                <form id="frmVisaNet" action="{{ url('carrito/finalizar') }}" method="POST">    
                    @csrf
                    <script src="<?php echo $urlJs?>" 
                        data-sessiontoken="<?php echo $sesion;?>"
                        data-channel="web"
                        data-merchantid="<?php echo $merchantId?>"
                        data-merchantlogo="http://127.0.0.1:8000/img/logo-sin-fondo2.png"
                        data-purchasenumber="<?php echo $purchaseNumber;?>"
                        data-amount="<?php echo $total_general; ?>"
                        data-expirationminutes="5"
                        data-timeouturl="http://127.0.0.1:8000/carrito"
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
					<a href="/home" title="Págalo.pe - Banco de la Nación">
						<img class="logo" src="http://127.0.0.1:8000/img/logo-sin-fondo.png" width="500" height="100" alt="Págalo.pe - Banco de la Nación">
					</a>
				</div>
				<strong class="titulo">Banco de la Nación | Ministerio de Economía y Finanzas</strong>
				<span class="enlace-mobile link link-sm collapsed" data-toggle="collapse" href="#footerInfo" role="button" aria-expanded="false" aria-controls="footerInfo">Contáctenos<i class="icon icon-pagalo-chevron-up" aria-hidden="true"></i></span>
				<div class="contacto collapse" id="footerInfo">
					<p>Mesa de ayuda: (01) 442-4470 - (01) 440-5305 - Línea gratuita: 0-800-10700</p>
					<p>Oficina Principal: Av. Javier Prado Este 2499, San Borja. Central telefónica: 519-20 00.</p>
					<p>Atención en oficinas administrativas: lunes a viernes de 8:30 a 17:30 horas. Refrigerio de: 13 a 14 horas.</p>
					<p>Atención en Oficina de Trámite Documentario: lunes a viernes de 9:00 a 17:00 horas (horario corrido).</p>
				</div>
			</div>
			
			<div class="col-lg-4 col-12 footer-derecho">
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
						<a class="link" href="/home" title="Págalo.pe">
							<img class="logo" src="http://127.0.0.1:8000/img/logo-sin-fondo2.png" width="500" height="100">
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