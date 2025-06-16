<!--<script src="<?php echo URL::to('/') ?>/js/manifest.js"></script>
<script src="<?php echo URL::to('/') ?>/js/vendor.js"></script>
<script src="<?php echo URL::to('/') ?>/js/frontend.js"></script>-->


<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!--<link rel="stylesheet" type="text/css" href="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.css">-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
<!--<script src="<?php echo URL::to('/') ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-switch-button/css/bootstrap-switch-button.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-switch-button/js/bootstrap-switch-button.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
	#tblAfiliado tbody tr{
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
    }
	
    .margin{

        margin-bottom: 20px;
    }
    .margin-buscar{
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .clickable{
        cursor: pointer;   
    }
    .panel-body{
        display: block;
    }
	
	.dataTables_filter {
	   display: none;
	}

.loader {
	width: 100%;
	height: 100%;
	overflow: hidden; 
	top: 0px;
	left: 0px;
	z-index: 10000;
	text-align: center;
	position:fixed; 
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

.color-letra {
    color: #1538C8;
}

/*
.form-control:disabled, .form-control[readonly]{
	background-color:#fff3cd!important;
	border-color:#ffecb5!important;
	color:#664d03!important;
	opacity:1
}
*/
/*.form-control:disabled, .form-control[readonly]{
	background-color:#cff4fc!important;
	border-color:#b6effb!important;
	color:#055160!important;
	opacity:1
}*/

.firma-imagen {
    display: block;
    max-width: 20%;
    height: auto;
    margin-top: 5px;
    /*border: 2px solid #000;
    border-radius: 5px;*/
}

.firma-imagen-asociado {
    display: block;
    max-width: 65%;
    height: auto;
    margin-top: 5px;
    /*border: 2px solid #000;
    border-radius: 5px;*/
}

.firma-no-registrada {
    color: red;
    margin-top: 5px;
}

.toggle-btn {
	background-color: #28a745; /* Verde por defecto */
	color: white;
	border: none;
	padding: 10px 20px;
	font-size: 16px;
	cursor: pointer;
	border-radius: 5px;
	transition: background-color 0.5s ease;
	width: 70px;
	text-align: center;
}

.toggle-btn.no {
	background-color: #dc3545; /* Rojo cuando está en NO */
}

.btn-verde {
	background-color: transparent;
	color: #28A745;
	border: 1px solid #28A745;
	transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-verde i {
	transition: color 0.3s ease;
}

.btn-verde:hover {
	background-color: #28A745;
	color: white;
}

.btn-verde:hover i {
	color: white;
}

.btn-plomo {
	background-color: transparent;
	color: gray;
	border: 1px solid gray;
	transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-plomo i {
	transition: color 0.3s ease;
}

.btn-plomo:hover {
	background-color: gray;
	color: white;
}

.btn-plomo:hover i {
	color: white;
}

.btn-rojo {
	background-color: transparent;
	color: #DC3545;
	border: 1px solid #DC3545;
	transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-rojo i {
	transition: color 0.3s ease;
}

.btn-rojo:hover {
	background-color: #DC3545;
	color: white;
}

.btn-rojo:hover i {
	color: white;
}

.btn-celeste {
	background-color: transparent;
	color: #17A2B8;
	border: 1px solid #17A2B8;
	transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-celeste i {
	transition: color 0.3s ease;
}

.btn-celeste:hover {
	background-color: #17A2B8;
	color: white;
}

.btn-celeste:hover i {
	color: white;
}

.btn-azul {
	background-color: transparent;
	color: #1538C8;
	border: 1px solid #1538C8;
	transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-azul i {
	transition: color 0.3s ease;
}

.btn-azul:hover {
	background-color: #1538C8;
	color: white;
}

.btn-azul:hover i {
	color: white;
}

/*
 VERSION PARA IMPRESORAS
*/
@page {
  margin: 0;
}

@media print {
	/*
  html, body {
    width: 80mm;
    height: 297mm;
  }
  */
	
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
        font-size: 16px !important;
        font-family:sans-serif;
    }
	
    .resaltado {
        color: black !important;
        font-size: 36px !important;
        font-weight: bold;
    }
	
    .divlogoimpresora {
        display: block !important;
    }
	
    .logoimpresora {
        margin-left: auto;
        margin-right: auto;
        margin-top: 0px;
        margin-bottom: 5px;
        display: block;
        width: 250px !important;
        height: 55px !important;
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
	
	#div_solicitud{
		display: none !important
	}
	
	.c-header.c-header-light.c-header-fixed{
		display: none !important
	}
	
	#btnHome{
		display: none !important
	}

	#btnPrint{
		display: none !important
	}

	#btnModificarSolicitud{
		display: none !important
	}

	#btnAnulacion{
		display: none !important
	}

	#btnSolicitudes{
		display: none !important
	}

	#btnLiquidacion{
		display: none !important
	}

	#btnAprobarPago{
		display: none !important
	}

	#btnAprobarLiquidacion{
		display: none !important
	}

	#btnDenegarSolicitud{
		display: none !important
	}

	#btnRegresar{
		display: none !important
	}
	
	#btnPrint{
		display: none !important
	}
	
	.bottom{
		display: none !important
	}
	
	.cubicaje{
		display: none !important
	}
	.form-control{
		border:0px !important;
		font-weight:bold !important;
		color:#000000 !important;
	}
	
	.card-header strong{
		padding: 10px 10px !important;
		font-weight:bold !important;
		color:#000000 !important;
		font-size: 22px !important;
		border:0px !important;
	}
	
	.card-header{
		border:0px !important;
	}
	.card{
		border:0px !important;
	}
	
	.c-footer{
		display: none !important
	}

	#divCubicaje{
		max-height: 5000px !important
	}
	
	#tblSolicitud tbody tr.even{
		display: none !important
	}
	/*
	#tblSolicitud{
		display: block !important
	}
	*/
	
}

</style>

<script>

function formatoMoneda_(num) {
    return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

/*document.addEventListener('DOMContentLoaded', () => {
	const toggleButton = document.getElementById('toggleButton');
	const respuestaInput = document.getElementById('respuesta');
	const fileInputs = document.getElementById('fileInputs');

	toggleButton.addEventListener('click', () => {
		toggleButton.classList.toggle('no');

		if (toggleButton.classList.contains('no')) {
			toggleButton.textContent = 'No';
			respuestaInput.value = 0;
			fileInputs.style.display = 'none';
		} else {
			toggleButton.textContent = 'Si';
			respuestaInput.value = 1;
			fileInputs.style.display = 'block';
		}
	});
});*/

/*function calculoVistaPrevia(){
    var igv_valor_ = <?php //echo $parametro[0]->igv?> * 100;
    var valor_minimo_edificaciones = <?php //echo $parametro[0]->valor_minimo_edificaciones?>;
    var uit_edificaciones = <?php //echo $parametro[0]->valor_uit?>;
    var sub_total_minimo = valor_minimo_edificaciones * uit_edificaciones;
    var igv_valor = <?php //echo $parametro[0]->igv?>;
    var igv_minimo	= igv_valor * sub_total_minimo;
    var total_minimo = sub_total_minimo + igv_minimo;
    $('#minimo').val(formatoMoneda_(total_minimo));
    $('#igv').val(igv_valor_+"%");
    //var_dump($total_minimo);exit;
    
    var valor_obra_= <?php //echo $liquidacion[0]->valor_obra?>;
    var porcentaje_calculo_edificacion = <?php //echo $parametro[0]->porcentaje_calculo_edificacion?>;
    var sub_total= valor_obra_* porcentaje_calculo_edificacion;
    //var sub_total_formateado = number_format(sub_total, 2, '.', ',');
    var igv_total=sub_total*igv_valor;
    //var igv_total_formateado = number_format(igv_total, 2, '.', ',');
    //var_dump($total_minimo);exit;
    var total=sub_total+igv_total;
    //var total_formateado = number_format(total, 2, '.', ',');
    $('#sub_total').val(sub_total);
    $('#igv_').val(igv_total);
    $('#total').val(formatoMoneda_(total));
    
    if(total<total_minimo){
        var total_ = total_minimo;
        var valor_minimo_edificaciones= <?php //echo $parametro[0]->valor_minimo_edificaciones?>;
        var uit_minimo= <?php //echo $parametro[0]->valor_uit?>;
        var sub_total_minimo=valor_minimo_edificaciones*uit_minimo;
        var igv_minimo=sub_total_minimo*igv_valor;
        //$sub_total_formateado_ = number_format($sub_total_minimo, 2, '.', ',');
        //$igv_total_formateado_ = number_format($igv_minimo, 2, '.', ',');
        //$total_formateado_ = number_format($total_minimo, 2, '.', ',');
        $('#sub_total').val(formatoMoneda_(sub_total));
        $('#igv_').val(formatoMoneda_(igv_total));
        $('#total').val(formatoMoneda_(total));
        $('#sub_total2').val(formatoMoneda_(sub_total_minimo));
        $('#igv2').val(formatoMoneda_(igv_minimo));
        $('#total2').val(formatoMoneda_(total_minimo));
    }else{
		$('#sub_total').val(formatoMoneda_(sub_total));
        $('#igv_').val(formatoMoneda_(igv_total));
        $('#total').val(formatoMoneda_(total));
        $('#sub_total2').val(formatoMoneda_(sub_total));
        $('#igv2').val(formatoMoneda_(igv_total));
        $('#total2').val(formatoMoneda_(total));
	}
    //var_dump($total_minimo);exit;
}*/

function calcularReintegro(){

	if($('#instancia').val()==250){
		if($('#valor_reintegro').val()!=''){
			var reintegro=parseFloat($('#valor_reintegro').val());
			var igv_=parseFloat($('#igv').val());
			var valor_edificaciones=parseFloat($('#factor').val());

			var sub_totalR=reintegro*valor_edificaciones;
			var igv_totalR=sub_totalR*igv_/100;
			var totalR=sub_totalR+igv_totalR;
			
			
			if(totalR<parseFloat($('#minimo').val())){
				
				var total_minimo = parseFloat($('#minimo').val());
				var igv_minimo = total_minimo*igv_/100;
				var sub_total_minimo = total_minimo - igv_minimo;

				var sub_totalR=reintegro*valor_edificaciones;
				var igv_totalR=sub_totalR*igv_/100;
				var totalR=sub_totalR+igv_totalR;

				$('#total2').val(formatoMoneda_(total_minimo));
				$('#igv2').val(formatoMoneda_(igv_minimo));
				$('#sub_total2').val(formatoMoneda_(sub_total_minimo));
				$('#total').val(formatoMoneda_(totalR));
				$('#igv_').val(formatoMoneda_(igv_totalR));
				$('#sub_total').val(formatoMoneda_(sub_totalR));
				
			}else{

				//var sub_totalR_formateado = number_format(sub_totalR, 2, '.', ',');
				//var igv_totalR_formateado = number_format(igv_totalR, 2, '.', ',');
				//var totalR_formateado = number_format(totalR, 2, '.', ',');
				$('#total2').val(formatoMoneda_(totalR));
				$('#igv2').val(formatoMoneda_(igv_totalR));
				$('#sub_total2').val(formatoMoneda_(sub_totalR));
				$('#total').val(formatoMoneda_(totalR));
				$('#igv_').val(formatoMoneda_(igv_totalR));
				$('#sub_total').val(formatoMoneda_(sub_totalR));
			}
			
		}
	}
}

/*$(document).ready(function () {
	$('#id_review_request-is_typical_plants').on('change', function () {
		if ($(this).prop('checked')) {
			$('#switch-container').removeClass('btn-danger off').addClass('btn-success on');
		} else {
			$('#switch-container').removeClass('btn-success on').addClass('btn-danger off');
		}
	});
});*/

</script>


@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Solicitud de Derecho de Revisi&oacute;n</li>
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
                    <h4 class="card-title mb-0" style="color: #1538C8;"  id ="div_solicitud">
                        Detalle de Solicitud de Derecho de Revisi&oacute;n<!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>
			<div class="row">
				<div style="margin-top:15px" class="form-group">
					<div class="col-sm-12 controls">
						<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
							<!--<button id="btnHome" type="button" class="btn btn-outline btn-sm btn-verde" data-toggle="modal" style="border: solid 1px; color:#28A745; margin-top:0px; width: 30px; height: 30px;">
								<i class="fas fa-home"></i>
							</button>-->
							
							@if ($datos_derecho_revision[0]->id_resultado == 1)

							<a href="/account/" onclick="" style="border: solid 1px; color:#28A745; margin-top:0px; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-verde" id="btnHome">
								<i class="fas fa-home"></i>
							</a>

							<button id="btnPrint" type="button" class="btn btn-outline btn-sm btn-plomo" style="border: solid 1px; color:gray; margin-top:0px; width: 30px; height: 30px; margin-left: 10px" onclick ="imprimirSolicitudPdf()">
								<i class="fas fa-print"></i>
							</button>
							
							<button id="btnModificarSolicitud" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-history icono-rojo">  Modificar Solicitud</i>
							</button>

							<button id="btnAnulacion" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-times icono-rojo">  Solicitar Anulaci&oacute;n</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#17A2B8; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-celeste" id="btnSolicitudes">
								<i class="fa fa-pencil-ruler"> Solicitudes</i>
							</a>

							<button id="btnAprobarLiquidacion" type="button" class="btn btn-outline btn-sm btn-azul" style="border: solid 1px; color:#1538C8; margin-top:0px; width: 150px; height: 30px; margin-left: 10px" onclick="activarAprobarLiquidacion()">
								<i class="fas fa-file-pdf">  Aprobar Liquidaci&oacute;n</i>
							</button>

							<button id="btnDenegarSolicitud" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-left: 10px; width: 150px; height: 30px; display: inline-flex; align-items: center; justify-content: center" onclick="activarBotonDenegar()">
								<i class="fas fa-exclamation-circle">  Denegar Solicitud</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#DC3545; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-rojo" id="btnRegresar">
								<i class="fas fa-arrow-left"> Regresar</i>
							</a>

							<a onclick="visualizarObservacion()" data-toggle="modal" style="border: solid 1px; color:#28A745; margin-left:10px; width: 120px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-verde" id="btnObservaciones">
								<i class="fas fa-clipboard"> Observaciones</i>
							</a>

							@endif

							@if ($datos_derecho_revision[0]->id_resultado == 2)

							<a href="/account/" onclick="" style="border: solid 1px; color:#28A745; margin-top:0px; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-verde" id="btnHome">
								<i class="fas fa-home"></i>
							</a>

							<button id="btnPrint" type="button" class="btn btn-outline btn-sm btn-plomo" style="border: solid 1px; color:gray; margin-top:0px; width: 30px; height: 30px; margin-left: 10px">
								<i class="fas fa-print"></i>
							</button>
							
							<button id="btnAnulacion" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-times icono-rojo">  Solicitar Anulaci&oacute;n</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#17A2B8; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-celeste" id="btnSolicitudes">
								<i class="fa fa-pencil-ruler"> Solicitudes</i>
							</a>
							
							<button id="btnAprobarPago" type="button" class="btn btn-outline btn-sm btn-verde"style="border: solid 1px; color:#28A745; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-dollar-sign">  Aprobar Pago</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#DC3545; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-rojo" id="btnRegresar">
								<i class="fas fa-arrow-left"> Regresar</i>
							</a>

							<a onclick="visualizarObservacion()" data-toggle="modal" style="border: solid 1px; color:#28A745; margin-left:10px; width: 120px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-verde" id="btnObservaciones">
								<i class="fas fa-clipboard"> Observaciones</i>
							</a>

							@endif

							@if ($datos_derecho_revision[0]->id_resultado == 3)

							<a href="/account/" onclick="" style="border: solid 1px; color:#28A745; margin-top:0px; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-verde" id="btnHome">
								<i class="fas fa-home"></i>
							</a>

							<button id="btnPrint" type="button" class="btn btn-outline btn-sm btn-plomo" style="border: solid 1px; color:gray; margin-top:0px; width: 30px; height: 30px; margin-left: 10px">
								<i class="fas fa-print"></i>
							</button>

							<button id="btnModificarSolicitud" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-history icono-rojo">  Modificar Solicitud</i>
							</button>

							<button id="btnAnulacion" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-times icono-rojo">  Solicitar Anulaci&oacute;n</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#17A2B8; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-celeste" id="btnSolicitudes">
								<i class="fas fa-pencil-ruler"> Solicitudes</i>
							</a>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#DC3545; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-rojo" id="btnRegresar">
								<i class="fas fa-arrow-left"> Regresar</i>
							</a>

							<a onclick="visualizarObservacion()" data-toggle="modal" style="border: solid 1px; color:#28A745; margin-left:10px; width: 120px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-verde" id="btnObservaciones">
								<i class="fas fa-clipboard"> Observaciones</i>
							</a>

							@endif

							@if ($datos_derecho_revision[0]->id_resultado == 4 || $datos_derecho_revision[0]->id_resultado == 5)

							<a href="/account/" onclick="" style="border: solid 1px; color:#28A745; margin-top:0px; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-verde" id="btnHome">
								<i class="fas fa-home"></i>
							</a>

							<button id="btnPrint" type="button" class="btn btn-outline btn-sm btn-plomo" style="border: solid 1px; color:gray; margin-top:0px; width: 30px; height: 30px; margin-left: 10px">
								<i class="fas fa-print"></i>
							</button>

							<button id="btnReintegro" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-history icono-rojo">  Solicitar Reintegro</i>
							</button>

							<button id="btnAnulacion" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-times icono-rojo">  Solicitar Anulaci&oacute;n</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#17A2B8; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-celeste" id="btnSolicitudes">
								<i class="fas fa-pencil-ruler"> Solicitudes</i>
							</a>

							<button id="btnLiquidacion" type="button" class="btn btn-outline btn-sm btn-azul" style="border: solid 1px; color:#1538C8; margin-top:0px; width: 120px; height: 30px; margin-left: 10px">
								<i class="fas fa-file-pdf">  Liquidaci&oacute;n</i>
							</button>

							<button id="btnEnviarLiquidacion" type="button" class="btn btn-outline btn-sm btn-verde" style="border: solid 1px; color:#28A745; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-at">  Enviar Liquidaci&oacute;n</i>
							</button>

							<button id="btnAsignarComision" type="button" class="btn btn-outline btn-sm btn-verde" style="border: solid 1px; color:#28A745; margin-top:0px; width: 190px; height: 30px; margin-left: 10px">
								<i class="fas fa-book-reader">  Asignar a Comisi&oacute;n T&eacute;cnica</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#DC3545; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-rojo" id="btnRegresar">
								<i class="fas fa-arrow-left"> Regresar</i>
							</a>

							@endif

							@if ($datos_derecho_revision[0]->id_resultado == 6)

							<a href="/account/" onclick="" style="border: solid 1px; color:#28A745; margin-top:0px; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-verde" id="btnHome">
								<i class="fas fa-home"></i>
							</a>

							<button id="btnPrint" type="button" class="btn btn-outline btn-sm btn-plomo" style="border: solid 1px; color:gray; margin-top:0px; width: 30px; height: 30px; margin-left: 10px">
								<i class="fas fa-print"></i>
							</button>

							<button id="btnReintegro" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-history icono-rojo">  Solicitar Reintegro</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#17A2B8; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-celeste" id="btnSolicitudes">
								<i class="fas fa-pencil-ruler"> Solicitudes</i>
							</a>

							<button id="btnLiquidacion" type="button" class="btn btn-outline btn-sm btn-azul" style="border: solid 1px; color:#1538C8; margin-top:0px; width: 120px; height: 30px; margin-left: 10px">
								<i class="fas fa-file-pdf">  Liquidaci&oacute;n</i>
							</button>

							<button id="btnEnviarLiquidacion" type="button" class="btn btn-outline btn-sm btn-verde" style="border: solid 1px; color:#28A745; margin-top:0px; width: 150px; height: 30px; margin-left: 10px">
								<i class="fas fa-at">  Enviar Liquidaci&oacute;n</i>
							</button>

							<a href="/derecho_revision/consulta_derecho_revision/" onclick="" style="border: solid 1px; color:#DC3545; margin-left: 10px; width: 100px; height: 30px; display: inline-flex; align-items: center; justify-content: center;" class="btn btn-outline btn-sm btn-rojo" id="btnRegresar">
								<i class="fas fa-arrow-left"> Regresar</i>
							</a>

							@endif
						</div>
						
					</div>
				</div>
			</div>

        <div class="row justify-content-center">

			<div class="col col-sm-12 align-self-left" id="denegar_liquidacion">
				<h4 style="color:rgb(255, 0, 0)">Denegar Liquidaci&oacute;n</h4>
				<div class="row">
					<div class="col-lg-9">
						<label class="control-label form-control-sm color-letra">Observaciones</label>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-9">
						<textarea name="observaciones" cols="40" rows="4" class="form-control upper-case" id="observaciones" style="height: 126px;">{{ $observaciones ? $observaciones->observacion : '' }}</textarea>
					</div>
					<div class="col-lg-3" style="padding-bottom:20px">
						<button id="btnDenegarLiquidacion" type="button" class="btn btn-outline btn-sm btn-rojo" style="border: solid 1px; color:#DC3545; margin-top:0px; width: 190px; height: 30px; margin-left: 5px" onClick="save_denegacion_solicitud()">
							<i class="fas fa-times icono-rojo" style="font-size:16px">  Denegar Liquidaci&oacute;n</i>
						</button>
					</div>
				</div>
			</div>

			<div class="col col-sm-12 align-self-left" id="aprobar_liquidacion">
				<h4 style="color:rgb(0, 0, 255)">Aprobar Liquidaci&oacute;n</h4>
				<div class="row">
					<div class="col-lg-2">
						<label class="control-label form-control-sm color-letra">N&uacute;mero de Liquidaci&oacute;n</label>
						<input name="numero_liquidacion" id="numero_liquidacion" class="form-control" value="<?php echo $liquidacion->credipago ?>">
					</div>
					<div class="col-lg-2">
						<label class="control-label form-control-sm color-letra">Fecha de Liquidaci&oacute;n</label>
						<input name="fecha_liquidacion" id="fecha_liquidacion" class="form-control"  value="<?php echo isset($liquidacion) ? date('d-m-Y', strtotime($liquidacion->fecha)) : ''; ?>">
					</div>
					<div class="col-lg-2">
						<label class="control-label form-control-sm color-letra">Hora de Liquidaci&oacute;n</label>
						<input name="hora_liquidacion" id="hora_liquidacion" class="form-control" value="<?php echo $liquidacion->fecha ?>">
					</div>
					<div class="col-lg-2">
						<label class="control-label form-control-sm color-letra">Monto de Liquidaci&oacute;n</label>
						<input name="monto_liquidacion" id="monto_liquidacion" class="form-control" value="<?php echo $liquidacion->total ?>" readonly="readonly">
					</div>
					<div class="col-lg-2" style="padding-bottom:20px">
						<button id="btnAprobarLiquidacion" type="button" class="btn btn-outline btn-sm btn-azul" style="border: solid 1px; color:#1538C8; margin-top:40px; width: 190px; height: 30px; margin-left: 5px" onClick="save_aprobar_solicitud()">
							<i class="fa fa-save icono-azul" style="font-size:16px">  Aprobar Liquidaci&oacute;n</i>
						</button>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label form-control-sm color-letra">Nota</label>
						<input name="nota_liquidacion" id="nota_liquidacion" class="form-control" value="<?php //echo $liquidacion->credipago ?>">
					</div>
				</div>
			</div>
        
			<div class="col col-sm-12 align-self-center" style="padding-top:15px">

				<div class="card">
					<div class="card-header" style="color: white; background: #1538C8;">
						<strong>
							Solicitud N° {{ $datos_derecho_revision[0]->codigo_solicitud }} - Proyecto {{ $datos_derecho_revision[0]->codigo }} - Tercera Revision
						</strong>
					</div>
					
					<div class="card-body">
						<form method="post" action="#" enctype="multipart/form-data" id="frmVisualizarSolicitudDerechoRevision" name="frmVisualizarSolicitudDerechoRevision">
						<div class="row">

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
								
								<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
								<!--<input type="hidden" name="id_solicitud_reintegro" id="id_solicitud_reintegro" value="0">-->
								<input type="hidden" name="id" id="id" value="<?php echo $id?>">
								<!--<input type="hidden" name="codigo_proyecto" id="codigo_proyecto" value="<?php //echo $proyecto2->codigo?>">-->

								<div class="row" style="padding-left:10px">
									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Estado de la Solicitud</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->estado_solicitud }}</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Liquidaci&oacute;n</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->estado_liquidacion }}</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Tipo de Solicitud</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->tipo_solicitud }}</b></label>
									</div>
								</div>

								<div class="row" style="padding-left:10px">
									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Revisi&oacute;n</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->instancia }}</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Nombre del Proyecto</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->nombre_proyecto }}</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Direcci&oacute;n</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->estado_solicitud }}</b></label>
									</div>
								</div>

								<div class="row" style="padding-left:10px">
									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Departamento</label><br>
										<label class="control-label form-control-sm"><b>{{ $departamento }}</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Provincia</label><br>
										<label class="control-label form-control-sm"><b>{{ $provincia }}</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Distrito</label><br>
										<label class="control-label form-control-sm"><b>{{ $distrito }}</b></label>
									</div>
								</div>

								<div class="row" style="padding-left:10px">
									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Municipalidad</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->municipalidad }}</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Fecha de Registro</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->fecha_registro }}</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Hora de Registro</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_derecho_revision[0]->hora_registro }}</b></label>
									</div>
								</div>

								<!--<div class="row" style="padding-left:10px">
									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">N&uacute;mero de Liquidaci&oacute;n (Credipago)</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Fecha de Liquidaci&oacute;n</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Monto Liquidaci&oacute;n</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>
								</div>-->

								<div class="row" style="padding-left:10px">
									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">Instancia</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>{{ $datos_derecho_revision[0]->numero_revision }}</b></label>
									</div>

									<div class="col-lg-2" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">N° de Ampliaciones de Plazo</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-2" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">N° de Apelaciones</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-2" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">N° de Reconsideraciones</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">N° de Sesiones Extaordinarias</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>Estado de la Solicitud</b></label>
									</div>
								</div>

								<div class="row" style="padding-left:10px">
									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">Plano de Ubicaci&oacute;n</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>Descargar</b></label>
									</div>

									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">FUE</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>Descargar</b></label>
									</div>

									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">Presupuesto</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>Descargar</b></label>
									</div>

									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">Carta de Desistimiento</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>Descargar</b></label>
									</div>

								</div>
								<div class="row" style="text-align: center; display: block; margin-top: 15px">
									<strong>
										Proyectistas y Profesionales Responsables
									</strong>
								</div>

								<div class="row" style="margin-top: 15px; background: #203A73; color: white;">
									<div class="col-lg-12 text-center">
										<strong>Proyectista Principal</strong>
									</div>
								</div>

								<div class="row" style="margin-top: 5px;">
									<div class="col-lg-12 p-0">
										<table id="tblProyectistaPrincipal" class="table table-hover table-sm" style="width: 100%;">
											<thead style="border: solid 1px #DEE2E6; background: #1538C8;">
												<tr style="font-size:13px;">
													<th style="color: white; width: 40%">Nombres</th>
													<th style="color: white; width: 10%">Colegiatura</th>
													<th style="color: white; width: 20%">Telf./Celular</th>
													<th style="color: white; width: 20%">Correo Electr&oacute;nico</th>
													<th style="color: white; width: 10%">Firma</th>
												</tr>
											</thead>
											<tbody>
												<td>{{ $datos_proyectista_principal[0]->nombres }}</td>
												<td>{{ $datos_proyectista_principal[0]->numero_cap }}</td>
												<td>{{ $datos_proyectista_principal[0]->celular1 }}</td>
												<td>{{ $datos_proyectista_principal[0]->email1 }}</td>
												<td>@if(!empty($datos_proyectista_principal[0]->firma)) <span class="text-success">Validada</span> @else <span class="text-danger">No Validada</span> @endif</td>
											</tbody>
										</table>
									</div>
								</div>
								@if (!empty($datos_proyectista_asociado) && count($datos_proyectista_asociado) > 0)
									
								<div class="row" style="margin-top: 15px; background: #203A73; color: white;">
									<div class="col-lg-12 text-center">
										<strong>Proyectistas Adjuntos</strong>
									</div>
								</div>

								<div class="row" style="margin-top: 5px;">
									<div class="col-lg-12 p-0">
										<table id="tblProyectistaPrincipal" class="table table-hover table-sm" style="width: 100%;">
											<thead style="border: solid 1px #DEE2E6; background: #1538C8;">
												<tr style="font-size:13px;">
													<th style="color: white; width: 40%">Nombres</th>
													<th style="color: white; width: 10%">Colegiatura</th>
													<th style="color: white; width: 20%">Telf./Celular</th>
													<th style="color: white; width: 20%">Correo Electr&oacute;nico</th>
													<th style="color: white; width: 10%">Firma</th>
												</tr>
											</thead>
											
											<tbody>
												@foreach ($datos_proyectista_asociado as $proyectista_asociado)
												<tr>
													<td>{{ $proyectista_asociado->nombres ?? '-'  }}</td>
													<td>{{ $proyectista_asociado->numero_cap ?? '-'  }}</td>
													<td>{{ $proyectista_asociado->celular1 ?? '-'  }}</td>
													<td>{{ $proyectista_asociado->email1 ?? '-'  }}</td>
													<td>@if(!empty($proyectista_asociado->firma)) <span class="text-success">Validada</span> @else <span class="text-danger">No Validada</span> @endif</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@endif

								<div class="row" style="margin-top: 15px; background: #203A73; color: white;">
									<div class="col-lg-12 text-center">
										<strong>Profesional de Seguridad</strong>
									</div>
								</div>

								<div class="row" style="margin-top: 5px;">
									<div class="col-lg-12 p-0">
										<table id="tblProyectistaPrincipal" class="table table-hover table-sm" style="width: 100%;">
											<thead style="border: solid 1px #DEE2E6; background: #1538C8;">
												<tr style="font-size:13px;">
													<th style="color: white; width: 40%">Nombres</th>
													<th style="color: white; width: 10%">Colegiatura</th>
													<th style="color: white; width: 20%">Telf./Celular</th>
													<th style="color: white; width: 20%">Correo Electr&oacute;nico</th>
													<th style="color: white; width: 10%">Firma</th>
												</tr>
											</thead>
											<tbody>
												<td>asd</td>
												<td>asd</td>
												<td>asd</td>
												<td>asd</td>
												<td>asd</td>
											</tbody>
										</table>
									</div>
								</div>

								@if (!empty($datos_propietario_array) && count($datos_propietario_array) > 0)

								<div class="row" style="text-align: center; display: block; margin-top: 15px">
									<strong>
										Administrado
									</strong>
								</div>

								<div class="row" style="margin-top: 5px;">
									<div class="col-lg-12 p-0">
										<table id="tblProyectistaPrincipal" class="table table-hover table-sm" style="width: 100%;">
											<thead style="border: solid 1px #DEE2E6; background: #1538C8;">
												<tr style="font-size:13px;">
													<th style="color: white; width: 40%">Raz&oacute;n Social</th>
													<th style="color: white; width: 10%">RUC</th>
													<th style="color: white; width: 20%">Tipo Persona</th>
													<th style="color: white; width: 20%">Telf./Celular</th>
													<th style="color: white; width: 10%">Correo Electr&oacute;nico</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($datos_propietario_array as $datos_propietario)
													<tr>
														<td>{{ $datos_propietario->propietario ?? '-'  }}</td>
														<td>{{ $datos_propietario->numero_documento_propietario ?? '-'  }}</td>
														<td>{{ $datos_propietario->tipo_propietario ?? '-'  }}</td>
														<td>{{ $datos_propietario->celular_propietario ?? '-'  }}</td>
														<td>{{ $datos_propietario->correo_propietario ?? '-'  }}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@endif

								<div class="row" style="text-align: center; display: block; margin-top: 15px">
									<strong>
										Datos T&eacute;cnicos del Proyecto
									</strong>
								</div>
								<div class="row" style="padding-left:10px; margin-top: 15px">
									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">N° de Pisos</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>{{ $datos_derecho_revision[0]->numero_piso }}</b></label>
									</div>

									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">N° de S&oacute;tanos</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>{{ $datos_derecho_revision[0]->numero_sotano }}</b></label>
									</div>

									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">Azoteas</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>{{ $datos_derecho_revision[0]->azotea }}</b></label>
									</div>

									<div class="col-lg-3" style ="border: solid 1px #DEE2E6">
										<label class="control-label form-control-sm color-letra" style="text-align: center; display: block">Semis&oacute;tano</label>
										<label class="control-label form-control-sm" style="text-align: center; display: block"><b>{{ $datos_derecho_revision[0]->semisotano }}</b></label>
									</div>

								</div>
								
								<div class="row" style="padding-left:10px; margin-top: 15px">
									<div class="col-lg-3">
										<label class="control-label form-control-sm color-letra">Repetici&oacute;n por plantas T&iacute;picas</label>
										@if ($datos_derecho_revision != 0)
											<label class="control-label form-control-sm"><b>No sujeto a Repetición por Plantas Típicas</b></label>
										@else
											<label class="control-label form-control-sm"><b>Sujeto a Repetición por Plantas Típicas</b></label>
										@endif
									</div>
								</div>
								@if (!empty($datos_uso_edificacion) && count($datos_uso_edificacion) > 0)
								<div class="row" style="margin-top: 15px; background: #203A73; color: white;">
									<div class="col-lg-12 text-center">
										<strong>Uso de la Edificaci&oacute;n</strong>
									</div>
								</div>

								<div class="row" style="margin-top: 5px;">
									<div class="col-lg-12 p-0">
										<table id="tblProyectistaPrincipal" class="table table-hover table-sm" style="width: 100%;">
											<thead style="border: solid 1px #DEE2E6; background: #1538C8;">
												<tr style="font-size:13px;">
													<th style="color: white; width: 5%">#</th>
													<th style="color: white; width: 30%">Tipo de Uso</th>
													<th style="color: white; width: 20%">Sub-Tipo de Uso</th>
													<th style="color: white; width: 45%">&Aacute;rea Techada m<sup>2</sup></th>
												</tr>
											</thead>
											<tbody>
											@php 
												$total_area_techada = 0;
											@endphp
											@foreach ($datos_uso_edificacion as $uso_edificacion)
												@php
													$subtotal = $uso_edificacion->area_techada ?? 0;
													$total_area_techada += $subtotal;
												@endphp
												<tr>
													<td class="color-letra">{{ $uso_edificacion->row_num ?? '-'  }}</td>
													<td class="color-letra">{{ $uso_edificacion->uso_edificacion ?? '-'  }}</td>
													<td class="color-letra">{{ $uso_edificacion->sub_tipo_edificacion ?? '-'  }}</td>
													<td class="color-letra">{{ $uso_edificacion->area_techada ?? '-'  }}</td>
												</tr>
											@endforeach
											</tbody>
											<tfoot>
												<tr style="font-size:13px">
													<td colspan="3"></td>
													<td class="color-letra" style ="font-size: 18px"><b>&Aacute;rea Techada Total: {{ number_format($total_area_techada, 2) }} m<sup>2</sup><b></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								@endif

								@if (!empty($datos_presupuesto_array) && count($datos_presupuesto_array) > 0)
								<div class="row" style="margin-top: 15px; background: #203A73; color: white;">
									<div class="col-lg-12 text-center">
										<strong>Presupuesto</strong>
									</div>
								</div>

								<div class="row" style="margin-top: 5px;">
									<div class="col-lg-12 p-0">
										<table id="tblProyectistaPrincipal" class="table table-hover table-sm" style="width: 100%;">
											<thead style="border: solid 1px #DEE2E6; background: #1538C8;">
												<tr style="font-size:13px;">
													<th style="color: white; width: 5%">#</th>
													<th style="color: white; width: 20%">Tipo de Obra</th>
													<th style="color: white; width: 15%">&Aacute;rea Techada m<sup>2</sup></th>
													<th style="color: white; width: 15%">Valor Unitario</th>
													<th style="color: white; width: 45%">Presupuesto</th>
												</tr>
											</thead>
											<tbody>
											@php 
												$total_presupuesto = 0;
											@endphp
											@foreach ($datos_presupuesto_array as $datos_presupuesto)
												@php
													$subtotal = ($datos_presupuesto->area_techada ?? 0) * ($datos_presupuesto->valor_unitario ?? 0);
													$total_presupuesto += $subtotal;
												@endphp
												<?	$presupuesto = ?>
												<td class="color-letra">{{ $datos_presupuesto->row_num ?? '-'  }}</td>
												<td class="color-letra">{{ $datos_presupuesto->tipo_obra ?? '-'  }}</td>
												<td class="color-letra">{{ $datos_presupuesto->area_techada ?? '-'  }}</td>
												<td class="color-letra">{{ $datos_presupuesto->valor_unitario ?? '-'  }}</td>
												<td class="color-letra">{{ number_format($subtotal, 2) }}</td>
											@endforeach
											</tbody>
											<tfoot>
												<tr style="font-size:13px">
													<td colspan="4"></td>
													<td class="color-letra" style ="font-size: 18px"><b>Valor Total de Obra: S/ {{ number_format($total_presupuesto, 2) }}</b></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								@endif
								<div class="row" style="text-align: center; display: block; margin-top: 15px">
									<strong>
										Datos del Comprobante de Pago
									</strong>
								</div>
								@if ($datos_propietario_array[0]->tipo_propietario == 'JURIDICA')
								<div class="row" style="padding-left:10px">
									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Raz&oacute;n Social</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_propietario_array[0]->propietario }}</b></label><br>
										<label class="control-label form-control-sm color-letra">Departamento</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">RUC</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_propietario_array[0]->numero_documento_propietario }}</b></label><br>
										<label class="control-label form-control-sm color-letra">Provincia</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Direcci&oacute;n Fiscal</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_propietario_array[0]->direccion_propietario }}</b></label><br>
										<label class="control-label form-control-sm color-letra">Distrito</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>
								</div>
								@endif
								@if ($datos_propietario_array[0]->tipo_propietario == 'NATURAL')
								<div class="row" style="padding-left:10px">
									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Nombres</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_propietario_array[0]->propietario }}</b></label><br>
										<label class="control-label form-control-sm color-letra">Departamento</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">DNI</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_propietario_array[0]->numero_documento_propietario }}</b></label><br>
										<label class="control-label form-control-sm color-letra">Provincia</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>

									<div class="col-lg-4">
										<label class="control-label form-control-sm color-letra">Direcci&oacute;n</label><br>
										<label class="control-label form-control-sm"><b>{{ $datos_propietario_array[0]->direccion_propietario }}</b></label><br>
										<label class="control-label form-control-sm color-letra">Distrito</label><br>
										<label class="control-label form-control-sm"><b>Estado de la Solicitud</b></label>
									</div>
								</div>
								@endif

							</div>
							
						</div>
					</form>
					</div>
			</div><!--card-body-->
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

<script src="{{ asset('js/derecho_revision/derechoRevisionEficicacion.js') }}"></script>

@endpush
