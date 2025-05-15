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

</style>

<script>

function formatoMoneda_(num) {
    return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

document.addEventListener('DOMContentLoaded', () => {
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
});

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

$(document).ready(function () {
	$('#id_review_request-is_typical_plants').on('change', function () {
		if ($(this).prop('checked')) {
			$('#switch-container').removeClass('btn-danger off').addClass('btn-success on');
		} else {
			$('#switch-container').removeClass('btn-success on').addClass('btn-danger off');
		}
	});
});

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
                    <h4 class="card-title mb-0" style="color: #1538C8;">
                        Solicitud de Derecho de Revisi&oacute;n<!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
			<div class="col col-sm-12 align-self-center">

				<div class="card">
					<div class="card-header" style="color: #1538C8;">
						<strong>
							Datos Generales del Proyecto
						</strong>
					</div>
					
					<div class="card-body">
					<form method="post" action="#" enctype="multipart/form-data" id="frmRegistroSolicitudDerechoRevision" name="frmRegistroSolicitudDerechoRevision">
					<div class="row">

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
						
						<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
						<!--<input type="hidden" name="id_solicitud_reintegro" id="id_solicitud_reintegro" value="0">-->
						<input type="hidden" name="id" id="id" value="<?php echo $id?>">
						<!--<input type="hidden" name="codigo_proyecto" id="codigo_proyecto" value="<?php //echo $proyecto2->codigo?>">-->

						<div class="row" style="padding-left:10px">
								<div class="col-lg-3">
									<label class="control-label form-control-sm color-letra">Municipalidad</label>
									<select name="municipalidad" id="municipalidad" class="form-control form-control-sm"> 
										<?php
										$valorSeleccionado = isset($derechoRevision_->id_municipalidad) ? $derechoRevision_->id_municipalidad : '';
										?>
										<option value="">--Selecionar--</option>
										<?php
											foreach ($municipalidad as $row) {
										?>
										<option value="<?php echo $row->id ?>" <?php echo ($valorSeleccionado == $row->id) ? 'selected="selected"' : ''; ?>><?php echo $row->denominacion ?></option> <?php } ?>
									</select>
								</div>
						
								<div class="col-lg-2">
									<label class="control-label form-control-sm color-letra">N° de Revisi&oacute;n</label>
									<select name="n_revision" id="n_revision" class="form-control form-control-sm" onChange="obtenerSolicitud()" value="<?php //echo $derechoRevision_->numero_revision?>">
									<?php
										$valorSeleccionado = isset($derechoRevision_->numero_revision) ? $derechoRevision_->numero_revision : '';
										?>
										<option value="">--Selecionar--</option>
										<?php
											foreach ($numero_revision as $row) {
										?>
										<option value="<?php echo $row->codigo ?>" <?php echo ($valorSeleccionado == $row->codigo) ? 'selected="selected"' : ''; ?>><?php echo $row->denominacion ?></option> <?php } ?>
									</select>
								</div>

								<div class="col-lg-3" id="div_codigo_proyecto">
									<label class="control-label form-control-sm color-letra">C&oacute;digo de Proyecto</label>
									<input id="codigo_proyecto" name="codigo_proyecto" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->nombre?>" type="text" onchange="buscarSolicitudbyCodigoProyecto()">
								</div>

								<div class="col-lg-3" id="div_numero_expediente">
									<label class="control-label form-control-sm color-letra">N&uacute;mero de Liquidaci&oacute;n</label>
									<input id="numero_liquidacion" name="numero_liquidacion" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->nombre?>" type="text" onchange="buscarSolicitudbyNumeroLiquidacion()">
								</div>
								
						</div>
						<div class="row" style="padding-left:10px">

							<div class="col-lg-5">
								<label class="control-label form-control-sm color-letra">Nombre del Proyecto</label>
								<input id="nombre_proyecto" name="nombre_proyecto" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->nombre?>" type="text">
							</div>

							<!--<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">Tipo</label>
								<select name="tipo_direccion" id="tipo_direccion" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									//foreach ($tipo as $row) {?>
									<option value="<?php //echo $row->codigo?>" <?php //if($row->codigo==$proyecto2->id_tipo_direccion)echo "selected='selected'"?>><?php //echo $row->denominacion?></option>
									<?php
									//}
									?>
								</select>
							</div>
						
							<div class="col-lg-5">
								<label class="control-label form-control-sm color-letra">Direccion</label>
								<input id="direccion_proyecto" name="direccion_proyecto" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->direccion?>" type="text">
							</div>-->

							<div class="col-lg-2">
								<label class="control-label form-control-sm color-letra">Departamento</label>
								<select name="departamento" id="departamento" class="form-control form-control-sm" onChange="obtenerProvinciaReintegro()">
									<?php //if($id>0){ ?>
									<option value="">--Selecionar--</option>
									<?php
									foreach ($departamento as $row) {?>
									<option value="<?php echo $row->id_departamento?>" <?php //if($row->id_departamento==substr($derechoRevision_->id_ubigeo,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
									<?php 
										}
									//}else {?>
										<!--<option value="">--Selecionar--</option>-->
										<?php
										//foreach ($departamento as $row) {?>
										<!--<option value="<?php //echo $row->id_departamento?>" <?php //if($row->id_departamento==15)echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>-->
										<?php 
										//}
									//}
									?>

								</select>
							</div>
						
							<div class="col-lg-2">
								<label class="control-label form-control-sm color-letra">Provincia</label>
								<select name="provincia" id="provincia" class="form-control form-control-sm" onChange="obtenerDistritoReintegro()">
									<option value="">--Selecionar--</option>
								</select>
							</div>
							

							<div class="col-lg-2">
								<label class="control-label form-control-sm color-letra">Distrito</label>
								<select name="distrito" id="distrito" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
								</select>
							</div>
						</div>
						<div class="row" style="padding-left:10px">
							<div class="col-lg-1" style=";padding-right:15px">
								<label class="control-label form-control-sm color-letra">Sitio</label>
								<select name="sitio" id="sitio" class="form-control form-control-sm" onChange="">
									<option value="">--Seleccionar--</option>
									<?php
									foreach ($sitio as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$proyecto2->id_tipo_sitio)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>

							<div class="col-lg-2">
								<label class="control-label form-control-sm color-letra">Detalle Sitio</label>
								<input id="direccion_sitio" name="direccion_sitio" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->sitio_descripcion?>" type="text">
							</div>

							<div class="col-lg-1" style="padding-left:15px">
								<label class="control-label form-control-sm color-letra">Zona</label>
								<select name="zona" id="zona" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($zona as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$proyecto2->id_zona)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>

							<div class="col-lg-2">
								<label class="control-label form-control-sm color-letra">Detalle Zona</label>
								<input id="direccion_zona" name="direccion_zona" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->zona_descripcion?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">Parcela</label>
								<input id="parcela" name="parcela" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->parcela?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">SuperManzana</label>
								<input id="superManzana" name="superManzana" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->super_manzana?>" type="text">
							</div>
						
							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">Tipo</label>
								<select name="tipo" id="tipo" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$proyecto2->id_tipo_direccion)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						
							<div class="col-lg-3">
								<label class="control-label form-control-sm color-letra">Direccion</label>
								<input id="direccion_proyecto" name="direccion_proyecto" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->direccion?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">Lote</label>
								<input id="lote" name="lote" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->lote?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">SubLote</label>
								<input id="sublote" name="sublote" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->sub_lote?>" type="text">
							</div>
						
							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">Fila</label>
								<input id="fila" name="fila" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->fila?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">Zonificaci&oacute;n</label>
								<input id="zonificacion" name="zonificacion" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->zonificacion?>" type="text">
							</div>
						</div>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Proyectista Principal
						</div>	
						<div class="row" style="padding-left:10px">
							<div class="col-lg-1" hidden>
								<label class="control-label form-control-sm color-letra">Tipo Proyectista</label>
								<select name="tipo_proyectista_principal" id="tipo_proyectista_principal" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_proyectista as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php //if(isset($proyectista->id_tipo_profesional) && $row->codigo==$proyectista->id_tipo_profesional) {echo "selected='selected'";}
									//else if (isset($profesionales_otro->id_tipo_profesional) && $row->codigo==$profesionales_otro->id_tipo_profesional) {echo "selected='selected'";}?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
							<?php if ($rol_proyectista[0]->nombre_rol == 'Proyectista' || $rol_proyectista[0]->nombre_rol == 'Administrator') : ?>
							<div class="col-lg-3" >
								<div class="form-group "id="agremiado_">
									<label class="control-label form-control-sm color-letra">Nombre</label>
									<input id="agremiado_principal" name="agremiado_principal" on class="form-control form-control-sm"  value="<?php echo $agremiado_principal->nombres.' '. $agremiado_principal->apellido_paterno.' '. $agremiado_principal->apellido_materno?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="numero_cap_">
									<label class="control-label form-control-sm color-letra">N° CAP<?php //echo $datos_proyectista[0]->tipo_colegiatura?></label>
									<input id="numero_cap" name="numero_cap" on class="form-control form-control-sm"  value="<?php echo $agremiado_principal->numero_cap?>" type="text" onchange="obtenerProyectista()"readonly='readonly'>
									<input id="tipo_colegiatura_principal" name="tipo_colegiatura_principal" value="<?php //echo $datos_proyectista[0]->tipo_colegiatura?>" type="hidden" >
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="situacion_">
									<label class="control-label form-control-sm color-letra">Situaci&oacute;n</label>
									<input id="situacion_principal" name="situacion_principal" on class="form-control form-control-sm"  value="<?php echo $agremiado_principal->situacion?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-1">
								<div class="form-group" id="direccion_agremiado_">
									<label class="control-label form-control-sm color-letra">T&eacute;lefono</label>
									<input id="direccion_agremiado_principal" name="direccion_agremiado_principal" on class="form-control form-control-sm"  value="<?php echo $agremiado_principal->celular?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group" id="n_regional_">
									<label class="control-label form-control-sm color-letra">Email</label>
									<input id="email_agremiado_principal" name="email_agremiado_principal" on class="form-control form-control-sm"  value="<?php echo $agremiado_principal->email?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" id="n_regional_">
									<label class="control-label form-control-sm color-letra">Firma</label>
									<?php if (!empty($agremiado_principal->firma)) : ?>
										<img src="<?php echo asset('img/agremiado/' . $agremiado_principal->firma); ?>" 
											alt="Firma del agremiado" 
											class="firma-imagen">
									<?php else : ?>
										<p class="firma-no-registrada">No Registrada</p>
									<?php endif; ?>
								</div>
							</div>
							<?php elseif ($rol_proyectista[0]->nombre_rol == 'Administrado') : ?>

								<div class="col-lg-3" >
								<div class="form-group "id="agremiado_">
									<label class="control-label form-control-sm color-letra">Nombre</label>
									<input id="agremiado_principal" name="agremiado_principal" on class="form-control form-control-sm"  value="" type="text" readonly="readonly">
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="numero_cap_">
									<label class="control-label form-control-sm color-letra">N° CAP<?php //echo $datos_proyectista[0]->tipo_colegiatura?></label>
									<input id="numero_cap" name="numero_cap" on class="form-control form-control-sm"  value="" type="text" onchange="obtenerProyectista()">
									<input id="tipo_colegiatura_principal" name="tipo_colegiatura_principal" value="<?php //echo $datos_proyectista[0]->tipo_colegiatura?>" type="hidden" >
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="situacion_">
									<label class="control-label form-control-sm color-letra">Situaci&oacute;n</label>
									<input id="situacion_principal" name="situacion_principal" on class="form-control form-control-sm"  value="" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-1">
								<div class="form-group" id="direccion_agremiado_">
									<label class="control-label form-control-sm color-letra">T&eacute;lefono</label>
									<input id="direccion_agremiado_principal" name="direccion_agremiado_principal" on class="form-control form-control-sm"  value="" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group" id="n_regional_">
									<label class="control-label form-control-sm color-letra">Email</label>
									<input id="email_agremiado_principal" name="email_agremiado_principal" on class="form-control form-control-sm"  value="" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" id="n_regional_">
									<label class="control-label form-control-sm color-letra">Firma</label>
									<?php /*if (!empty($agremiado_principal->firma)) : ?>
										<img src="<?php echo asset('img/agremiado/' . $agremiado_principal->firma); ?>" 
											alt="Firma del agremiado" 
											class="firma-imagen">
									<?php else : ?>
										<p class="firma-no-registrada">No Registrada</p>
									<?php endif; */?>
								</div>
							</div>

							<?php endif; ?>
							<!--<div class="col-lg-2">
								<div class="form-group" id="act_gremial_">
									<label class="control-label form-control-sm color-letra">Actividad Gremial</label>
									<input id="act_gremial_agremiado_principal" name="act_gremial_agremiado_principal" on class="form-control form-control-sm"  value="<?php //echo $agremiado_principal->actividad?>" type="text" readonly='readonly'>
								</div>
								<div class="form-group" id="email_">
									<label class="control-label form-control-sm color-letra">Email</label>
									<input id="email" name="email" on class="form-control form-control-sm" value="<?php //echo $persona->correo?>" type="text" readonly='readonly'>
								</div>
							</div>-->
							<div class="col-lg-1" hidden>
								<label class="control-label form-control-sm color-letra">Principal_asociado</label>
								<select name="principal_asociado" id="principal_asociado" class="form-control form-control-sm" onChange="">
									<option value="0">--Selecionar--</option>
									<?php
									foreach ($principal_asociado as $row_) {?>
									<option value="<?php echo $row_->codigo?>" <?php //if(isset($proyectista->id_tipo_profesional) && $row_->codigo==$proyectista->id_tipo_proyectista) {echo "selected='selected'";}
									//else if (isset($profesionales_otro->id_tipo_profesional) && $row_->codigo==$profesionales_otro->id_tipo_proyectista)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
							
						<?php //if(count($proyectista_solicitud)>1){?>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Proyectista Asociados
						</div>
							
						<?php //} ?>
						<div id="proyectista_asociado_container">
							<div class="row" style="padding-left:10px">
								<div class="col-lg-1" hidden>
									<label class="control-label form-control-sm">Tipo Proyectista</label>
									<select name="tipo_proyectista_row[]" id="tipo_proyectista_row" class="form-control form-control-sm" onChange="">
										<option value="0">--Selecionar--</option>
										<?php
										foreach ($tipo_proyectista as $row_) {?>
										<option value="<?php echo $row_->codigo?>" <?php //if($row_->codigo==$row->id_tipo_profesional)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-lg-3" >
									<div class="form-group "id="agremiado_">
										<label class="control-label form-control-sm color-letra">Nombre</label>
										<input id="agremiado_row" name="agremiado_row[]" on class="form-control form-control-sm"  value="<?php //echo $row->agremiado?>" type="text" readonly='readonly'>
									</div>
								</div>
								<div class="col-lg-1">
									<div class="form-group" id="numero_cap_">
										<label class="control-label form-control-sm color-letra">N° CAP<?php //echo $row->tipo_colegiatura?></label>
										<input id="numero_cap_row" name="numero_cap_row[]" on class="form-control form-control-sm"  value="<?php //echo $row->numero_cap?>" type="text" onchange="obtenerProyectista(this)">
										<input id="tipo_colegiatura_row" name="tipo_colegiatura_row[]" value="<?php //echo $row->tipo_colegiatura?>" type="hidden">
									</div>
								</div>
								<div class="col-lg-1">
									<div class="form-group" id="situacion_">
										<label class="control-label form-control-sm color-letra">Situaci&oacute;n</label>
										<input id="situacion_row" name="situacion_row[]" on class="form-control form-control-sm"  value="<?php //echo $row->situacion?>" type="text" readonly='readonly'>
									</div>
								</div>
								<!--<div class="col-lg-1">
									<label class="control-label form-control-sm color-letra">Profesi&oacute;n</label>
									<select name="principal_asociado_row" id="principal_asociado_row" class="form-control form-control-sm" onChange="">
										<option value="0">--Selecionar--</option>
										<?php
										//foreach ($principal_asociado as $row_) {?>
										<option value="<?php //echo $row_->codigo?>" <?php //if($row_->codigo==$row->id_tipo_proyectista)echo "selected='selected'"?>><?php //echo $row_->denominacion?></option>
										<?php
										//}
										?>
									</select>
								</div>-->

								<div class="col-lg-1">
									<div class="form-group" id="direccion_agremiado_">
										<label class="control-label form-control-sm color-letra">T&eacute;lefono</label>
										<input id="telefono_row" name="telefono_row[]" on class="form-control form-control-sm"  value="<?php //echo $row->celular1?>" type="text" readonly='readonly'>
									</div>
								</div>

								<div class="col-lg-3">
									<div class="form-group" id="n_regional_">
										<label class="control-label form-control-sm color-letra">Email</label>
										<input id="email_row" name="email_row[]" on class="form-control form-control-sm"  value="<?php //echo $row->email1?>" type="text" readonly='readonly'>
									</div>
								</div>
								<div class="col-lg-1">
									<div class="form-group" id="firma_agremiado_">
										<label class="control-label form-control-sm color-letra">Firma</label>
										<?php if (!empty($agremiado_principal->firma)) : ?>
											<img id="firma_row" name="firma_row" src=""
												
												class="firma-imagen-asociado">
										<?php else : ?>
											<p class="firma-no-registrada">No Registrada</p>
										<?php endif; ?>
									</div>
								</div>
								<!--<div class="col-lg-1" hidden>
									<label class="control-label form-control-sm color-letra">Principal_asociado</label>
									<select name="principal_asociado_row" id="principal_asociado_row" class="form-control form-control-sm" onChange="">
										<option value="0">--Selecionar--</option>
										<?php
										//foreach ($principal_asociado as $row_) {?>
										<option value="<?php //echo $row_->codigo?>" <?php //if($row_->codigo==$row->id_tipo_proyectista)echo "selected='selected'"?>><?php //echo $row_->denominacion?></option>
										<?php
										//}
										?>
									</select>
								</div>-->
							</div>
						</div>
						<div class="col-lg-4">
								<div class="row" style="padding-left:10px">
									<a href="javascript:void(0)" onClick="AddProyectistaAsociado()" class="btn btn-sm btn-success">Agregar</a>	
								</div>
							</div>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Profesional del Proyecto de Seguridad
						</div>
							
						<?php //} ?>
							
						<div class="row" style="padding-left:10px">
							<div class="col-lg-1" hidden>
								<label class="control-label form-control-sm">Tipo Proyectista</label>
								<select name="tipo_proyectista_seguridad" id="tipo_proyectista_seguridad" class="form-control form-control-sm" onChange="">
									<option value="0">--Selecionar--</option>
									<?php
									foreach ($tipo_proyectista as $row_) {?>
									<option value="<?php echo $row_->codigo?>" <?php //if($row_->codigo==$row->id_tipo_profesional)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-lg-3" >
								<div class="form-group "id="agremiado_">
									<label class="control-label form-control-sm color-letra">Nombre</label>
									<input id="agremiado_seguridad" name="agremiado_seguridad" on class="form-control form-control-sm"  value="<?php //echo $row->agremiado?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="numero_cap_">
									<label class="control-label form-control-sm color-letra">N° CAP<?php //echo $row->tipo_colegiatura?></label>
									<input id="numero_cap_seguridad" name="numero_cap_seguridad[]" on class="form-control form-control-sm"  value="<?php //echo $row->numero_cap?>" type="text" onchange="obtenerProyectistaSeguridad()">
									<!--<input id="tipo_colegiatura_row" name="tipo_colegiatura_row[]" value="<?php //echo $row->tipo_colegiatura?>" type="hidden">-->
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="situacion_">
									<label class="control-label form-control-sm color-letra">Situaci&oacute;n</label>
									<input id="situacion_seguridad" name="situacion_seguridad" on class="form-control form-control-sm"  value="<?php //echo $row->situacion?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-1">
								<div class="form-group" id="direccion_agremiado_">
									<label class="control-label form-control-sm color-letra">T&eacute;lefono</label>
									<input id="telefono_seguridad" name="telefono_seguridad" on class="form-control form-control-sm"  value="<?php //echo $row->celular1?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group" id="n_regional_">
									<label class="control-label form-control-sm color-letra">Email</label>
									<input id="email_seguridad" name="email_seguridad" on class="form-control form-control-sm"  value="<?php //echo $row->email1?>" type="text" readonly='readonly'>
								</div>
							</div>
							<!--<div class="col-lg-2">
								<div class="form-group" id="act_gremial_">
									<label class="control-label form-control-sm color-letra">Actividad Gremial</label>
									<input id="act_gremial_seguridad" name="act_gremial_seguridad" on class="form-control form-control-sm"  value="<?php //echo $row->actividad?>" type="text" readonly='readonly'>
								</div>
							</div>-->
							<div class="col-lg-1" hidden>
								<label class="control-label form-control-sm color-letra">Principal_asociado</label>
								<select name="principal_asociado_seguridad" id="principal_asociado_seguridad" class="form-control form-control-sm" onChange="">
									<option value="0">--Selecionar--</option>
									<?php
									foreach ($principal_asociado as $row_) {?>
									<option value="<?php echo $row_->codigo?>" <?php //if($row_->codigo==$row->id_tipo_proyectista)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						
						<div style="padding: 10px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Propietario/Administrado
						</div>	
						<?php if ($rol_proyectista[0]->nombre_rol == 'Proyectista' || $rol_proyectista[0]->nombre_rol == 'Administrator') : ?>
						<div class="row" style="padding-left:10px">
							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">Tipo Documento</label>
								<select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" onchange="obtenerPropietario_()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_documento as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$propietario_solicitud[0]->id_tipo_propietario)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>

							<div class="col-lg-1">
								<div class="form-group" id="dni_propietario_">
								<label class="control-label form-control-sm color-letra">DNI</label>
								<input id="dni_propietario" name="dni_propietario" on class="form-control form-control-sm" value="<?php //echo isset($propietario_solicitud) && $propietario_solicitud[0]->id_tipo_propietario=='78' ? $propietario_solicitud[0]->numero_documento : '';?>" type="text" onchange="obtenerDatosDni()">
								</div>
								<div class="form-group" id="ruc_propietario_">
									<label class="control-label form-control-sm color-letra">RUC</label>
									<input id="ruc_propietario" name="ruc_propietario" on class="form-control form-control-sm"  value="<?php //if($propietario_solicitud[0]->id_tipo_propietario=='79') echo $propietario_solicitud[0]->numero_documento;?>" type="text" onchange="obtenerDatosRuc()">
								</div>
							</div>

							<div class="col-lg-3" >
							<div class="form-group" id="nombre_propietario_">
								<label class="control-label form-control-sm color-letra">Nombre</label>
								<input id="nombre_propietario" name="nombre_propietario" on class="form-control form-control-sm"  value="<?php //echo $propietario_solicitud[0]->propietario?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="razon_social_propietario_">
									<label class="control-label form-control-sm">Raz&oacute;n Social</label>
									<input id="razon_social_propietario" name="razon_social_propietario" on class="form-control form-control-sm"  value="<?php //echo $propietario_solicitud[0]->propietario?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-3" >
								<div class="form-group" id="direccion_dni_">
									<label class="control-label form-control-sm color-letra">Direcci&oacute;n</label>
									<input id="direccion_dni" name="direccion_dni" on class="form-control form-control-sm"  value="<?php //echo $propietario_solicitud[0]->direccion?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="direccion_ruc_">
									<label class="control-label form-control-sm color-letra">Direcci&oacute;n</label>
									<input id="direccion_ruc" name="direccion_ruc" on class="form-control form-control-sm"  value="<?php //echo $propietario_solicitud[0]->direccion?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>
							
							<div class="col-lg-1" >
								<div class="form-group" id="celular_dni_">
									<label class="control-label form-control-sm color-letra">Celular</label>
									<input id="celular_dni" name="celular_dni" on class="form-control form-control-sm"  value="<?php //echo $propietario_solicitud[0]->numero_celular?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="telefono_ruc_">
									<label class="control-label form-control-sm color-letra">Tel&eacute;fono</label>
									<input id="telefono_ruc" name="telefono_ruc" on class="form-control form-control-sm"  value="<?php //echo $propietario_solicitud[0]->numero_celular?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-2" >
								<div class="form-group" id="email_dni_">
									<label class="control-label form-control-sm color-letra">Email</label>
									<input id="email_dni" name="email_dni" on class="form-control form-control-sm"  value="<?php //echo $propietario_solicitud[0]->correo?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="email_ruc_">
									<label class="control-label form-control-sm color-letra">Email</label>
									<input id="email_ruc" name="email_ruc" on class="form-control form-control-sm"  value="<?php //echo $propietario_solicitud[0]->correo?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>
						</div>

						<?php elseif ($rol_proyectista[0]->nombre_rol == 'Administrado') : ?>
						<div class="row" style="padding-left:10px">
							<div class="col-lg-1">
								<label class="control-label form-control-sm color-letra">Tipo Documento</label>
								<select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm">
									<option value="">--Seleccionar--</option>
									<?php
									foreach ($tipo_documento as $row) {
										$selected = '';
										if (isset($id_persona) && $row->codigo == 78) {
											$selected = "selected='selected'";
										} elseif (isset($id_empresa) && $row->codigo == 79) {
											$selected = "selected='selected'";
										}
										?>
										<option value="<?php echo $row->codigo ?>" <?php echo $selected ?>><?php echo $row->denominacion ?></option>
										<?php
									}
									?>
								</select>
							</div>

							<div class="col-lg-1">
								<div class="form-group" id="dni_propietario_">
								<label class="control-label form-control-sm color-letra">DNI</label>
								<input id="dni_propietario" name="dni_propietario" on class="form-control form-control-sm" value="<?php echo isset($id_persona) ? $numero_documento_administrado : '';?>" type="text" onchange="">
								</div>
								<div class="form-group" id="ruc_propietario_">
									<label class="control-label form-control-sm color-letra">RUC</label>
									<input id="ruc_propietario" name="ruc_propietario" on class="form-control form-control-sm"  value="<?php echo isset($id_empresa) ? $numero_documento_administrado : '';?>" type="text" onchange="">
								</div>
							</div>

							<div class="col-lg-3" >
							<div class="form-group" id="nombre_propietario_">
								<label class="control-label form-control-sm color-letra">Nombre</label>
								<input id="nombre_propietario" name="nombre_propietario" on class="form-control form-control-sm"  value="<?php echo isset($id_persona) ? $datos_administrado->nombres : '';?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="razon_social_propietario_">
									<label class="control-label form-control-sm">Raz&oacute;n Social</label>
									<input id="razon_social_propietario" name="razon_social_propietario" on class="form-control form-control-sm"  value="<?php echo isset($id_empresa) ? $datos_administrado->razon_social : '';?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-3" >
								<div class="form-group" id="direccion_dni_">
									<label class="control-label form-control-sm color-letra">Direcci&oacute;n</label>
									<input id="direccion_dni" name="direccion_dni" on class="form-control form-control-sm"  value="<?php echo isset($id_persona) ? $datos_administrado->direccion : '';?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="direccion_ruc_">
									<label class="control-label form-control-sm color-letra">Direcci&oacute;n</label>
									<input id="direccion_ruc" name="direccion_ruc" on class="form-control form-control-sm"  value="<?php echo isset($id_empresa) ? $datos_administrado->direccion : '';?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>
							
							<div class="col-lg-1" >
								<div class="form-group" id="celular_dni_">
									<label class="control-label form-control-sm color-letra">Celular</label>
									<input id="celular_dni" name="celular_dni" on class="form-control form-control-sm"  value="<?php echo isset($id_persona) ? $datos_administrado->numero_celular : '';?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="telefono_ruc_">
									<label class="control-label form-control-sm color-letra">Tel&eacute;fono</label>
									<input id="telefono_ruc" name="telefono_ruc" on class="form-control form-control-sm"  value="<?php echo isset($id_empresa) ? $datos_administrado->telefono : '';?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-2" >
								<div class="form-group" id="email_dni_">
									<label class="control-label form-control-sm color-letra">Email</label>
									<input id="email_dni" name="email_dni" on class="form-control form-control-sm"  value="<?php echo isset($id_persona) ? $datos_administrado->correo : '';?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="email_ruc_">
									<label class="control-label form-control-sm color-letra">Email</label>
									<input id="email_ruc" name="email_ruc" on class="form-control form-control-sm"  value="<?php echo isset($id_empresa) ? $datos_administrado->email : '';?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>
						</div>
						<?php endif;?>

						<div style="padding: 0px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Datos del Proyecto
						</div>

						<div class="col-lg-3" style=";padding-right:15px">
							<label class="control-label form-control-sm color-letra">Datos T&eacute;cnicos del proyecto</label>
							<select name="tipo_proyecto" id="tipo_proyecto" class="form-control form-control-sm" onChange="">
								<option value="">--Selecionar--</option>
								<?php
								foreach ($tipo_proyecto as $row) {?>
								<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$derechoRevision_->id_tipo_tramite)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Uso de la Edificaci&oacute;n
						</div>
							
						<div class="row">
							<div class="col-lg-8" style=";padding-right:15px">
								<div class="row" style="padding-left:10px">
									<div class="col-lg-12" id="uso-container">
										
									<?php 
										//foreach($datos_usoEdificaciones as $key=>$row){
										//$sub_tipo_uso = App\Models\TablaMaestra::getMaestroByTipoAndSubTipo(111,$row->id_tipo_uso);
									?>
										<div class="row uso-row">
											<div class="col-lg-4" style=";padding-right:15px">
											<label class="control-label form-control-sm color-letra">Tipo de Uso</label>
											<select name="tipo_uso[]" id="tipo_uso" class="form-control form-control-sm" onChange="obtenerSubTipoUso(this)">
												<option value="">--Seleccionar--</option>
												<?php
												foreach ($tipo_uso as $row_) {?>
												<option value="<?php echo $row_->codigo?>" <?php //if($row_->codigo==$row->id_tipo_uso)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="col-lg-4" style=";padding-right:15px">
											<label class="control-label form-control-sm color-letra">Sub-Tipo de Uso</label>
											<select name="sub_tipo_uso[]" id="sub_tipo_uso" class="form-control form-control-sm" onChange="">
												<option value="">--Seleccionar--</option>
												<?php
												/*foreach ($sub_tipo_uso as $row_) {?>
												<option value="<?php echo $row_->codigo?>" <?php //if($row_->codigo==$row->id_sub_tipo_uso)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
												<?php
												}*/
												?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="control-label form-control-sm color-letra">&Aacute;rea Techada</label>
											<input id="area_techada" name="area_techada[]" on class="form-control form-control-sm"  value="<?php //echo number_format($row->area_techada, 2, '.', ',');?>" type="text" onchange="">
										</div>
										<div style="margin-top:37px" class="form-group">
											<div class="col-sm-12 controls">
												<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
													<a href="javascript:void(0)" onClick="AddFilaUso()" class="btn btn-sm btn-success">Agregar</a>
													<!--
													<button class="btn btn-sm btn-danger" style="margin-left:10px" onclick="removeFilaUso(event,this.parentNode)">Eliminar</button>
													-->
												</div>
											</div>
										</div>
											<button class="btn btn-sm btn-danger" onclick="removeFilaPresupuestoEdit(this)" style="margin-top: 37px; margin-bottom: 37px;">Eliminar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Presupuesto
						</div>
							
						<div class="row">
							<div class="col-lg-8" style=";padding-right:15px">
									
								<div class="row" style="padding-left:10px">
									<div class="col-lg-12" id="presupuesto-container">
									
										<div class="row presupuesto-row">
											<div class="col-lg-4" style=";padding-right:15px">
												<label class="control-label form-control-sm color-letra">Tipo de Obra</label>
												<select name="tipo_obra[]" id="tipo_obra" class="form-control form-control-sm" onChange="activarSubTipoObra(this);obtenerSubTipoObra(this)">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($tipo_obra as $row_) {?>
													<option value="<?php echo $row_->codigo?>" <?php //if($row_->codigo==$row->id_tipo_obra)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
													<?php
													}
													?>
												</select>
											</div>

											<div class="col-lg-2" style=";padding-right:15px; display: none;" id="div_sub_tipo_obra">
												<label class="control-label form-control-sm color-letra">Sub-Tipo Obra</label>
												<select name="sub_tipo_obra[]" id="sub_tipo_obra" class="form-control form-control-sm" onChange="">
													<option value="">--Seleccionar--</option>
													<?php
													?>
												</select>
											</div>

											<div class="col-lg-2">
												<label class="control-label form-control-sm color-letra">&Aacute;rea Techada m2</label>
												<input id="area_techada_presupuesto" name="area_techada_presupuesto[]" on class="form-control form-control-sm"  value="<?php //echo number_format($row->area_techada, 2, '.', ',');?>" type="text">
											</div>
											<div class="col-lg-2">
												<label class="control-label form-control-sm color-letra">Valor Unitario S/</label>
												<input id="valor_unitario" name="valor_unitario[]" on class="form-control form-control-sm"  value="<?php //echo number_format($row->valor_unitario, 2, '.', ',');?>" type="text">
											</div>
											<div class="col-lg-2">
												<label class="control-label form-control-sm color-letra">Presupuesto</label>
												<input id="presupuesto" name="presupuesto[]" on class="form-control form-control-sm"  value="<?php //echo number_format($row->total_presupuesto, 2, '.', ',');?>" type="text" readonly='readonly'>
											</div>
											<div style="margin-top:37px" class="form-group">
												<div class="col-sm-12 controls">
													<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
														<a href="javascript:void(0)" onClick="AddFilaPresupuesto()" class="btn btn-sm btn-success">Agregar</a>
													</div>
												</div>
											</div>
											
											<button class="btn btn-sm btn-danger" onclick="removeFilaPresupuestoEdit(this)" style="margin-top: 37px; margin-bottom: 37px;">Eliminar</button>
											
										</div>
									
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px; display:flex; justify-content:flex-end">
									<div class="col-lg-3">
										<label class="control-label form-control-sm color-letra">Valor Total de Obra S/</label>
										<input id="valor_total_obra" name="valor_total_obra" on class="form-control form-control-sm"  value="<?php //echo number_format($derechoRevision_->valor_obra, 2, '.', ',');?>" type="text" readonyl="readonly">
									</div>
								</div>
							</div>
							<div class="col-lg-2" style=";padding-right:15px; border-left:2px solid #ccc;">
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm color-letra">&Aacute;rea Techada Total de la Edificaci&oacute;n</label>
										<input id="area_techada_total" name="area_techada_total" on class="form-control form-control-sm"  value="<?php //echo number_format($derechoRevision_->area_total, 2, '.', ',');?>" type="text" readonly='readonly'>
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm color-letra">Azotea</label>
										<input id="azotea" name="azotea" on class="form-control form-control-sm"  value="<?php echo isset($derechoRevision_->azotea) && $derechoRevision_->azotea !== '' ? $derechoRevision_->azotea : 0; ?>" type="text">
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm color-letra">N° de Pisos</label>
										<input id="n_pisos" name="n_pisos" on class="form-control form-control-sm"  value="<?php echo isset($derechoRevision_->numero_piso) && $derechoRevision_->numero_piso !== '' ? $derechoRevision_->numero_piso : 0; ?>" type="text">
									</div>
								</div>
							</div>
							<div class="col-lg-2" style=";padding-right:15px">
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm color-letra">N° S&oacute;tanos</label>
										<input id="n_sotanos" name="n_sotanos" on class="form-control form-control-sm"  value="<?php echo isset($derechoRevision_->numero_sotano) && $derechoRevision_->numero_sotano !== '' ? $derechoRevision_->numero_sotano : 0; ?>" type="text">
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm color-letra">Semis&oacute;tano</label>
										<input id="semisotano" name="semisotano" on class="form-control form-control-sm"  value="<?php echo isset($derechoRevision_->semisotano) && $derechoRevision_->semisotano !== '' ? $derechoRevision_->semisotano : 0; ?>" type="text">
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm color-letra">Fecha Registro</label>
										<input id="fecha_registro" name="fecha_registro" on class="form-control form-control-sm"  value="<?php echo date('d-m-Y'); ?>" type="text" readonly='readonly'>
									</div>
								</div>
							</div>
						</div>
						<div style="padding: 15px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Repetici&oacute;n por Plantas T&iacute;picas
						</div>
							<button type="button" id="toggleButton" class="toggle-btn no">No</button>

							<input type="hidden" name="respuesta" id="respuesta" value="0">
						<div>
						<div id="fileInputs" style="display: none;">
							<label class="control-label form-control-sm color-letra;" style="font-weight: bold; color: #1538C8;">Planos de Distribución de Plantas T&iacute;picas:</label>
							<input type="file"  class="form-control-file btn btn-sm btn-success" style="background-color: #FFFFFF !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black;" id="btnPlanoDistribucion1" name="btnPlanoDistribucion1">
							<input type="file"  class="form-control-file btn btn-sm btn-success" style="background-color: #FFFFFF !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black;" id="btnPlanoDistribucion2" name="btnPlanoDistribucion2">
							<input type="file"  class="form-control-file btn btn-sm btn-success" style="background-color: #FFFFFF !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black;" id="btnPlanoDistribucion3" name="btnPlanoDistribucion3">
							<input type="file"  class="form-control-file btn btn-sm btn-success" style="background-color: #FFFFFF !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black;" id="btnPlanoDistribucion4" name="btnPlanoDistribucion4">
							<label class="control-label form-control-sm color-letra" style="font-weight: bold; color: #1538C8;">Declaraci&oacute;n Jurada Firmada:</label>
							<input type="file"  class="form-control-file btn btn-sm btn-success" style="background-color: #FFFFFF !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black;" id="btnDeclaracion" name="btnDeclaracion">
						
						</div>
							<label class="control-label form-control-sm" style="font-size:10px">MARCAR ESTA OPCI&Oacute;N SI EL PROYECTO EST&Aacute; SUJETO A REPETICI&Oacute;N POR PLANTAS T&Iacute;PICAS</label>
						<div>
						</div>
							<label class="control-label form-control-sm" style="font-size:10px">NOTA: LOS COSTOS ELEGIDOS DEL CUADRO DE VALORES UNITARIOS, REFLEJAR&Aacute;N LOS ACABADOS REALES Y FINALES DE OBRA</label>
						</div>
						<div style="padding: 15px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Archivos Obligatorios
						</div>
						<div class="row" style="padding-left:10px">
							<div class="col-sm-4">
								<label class="control-label form-control-sm color-letra">Plano de Ubicaci&oacute;n</label>
								<input type="file" class="form-control-file btn btn-sm btn-success" style="background-color: #FFFFFF !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black" id="btnPlanoUbicacion" name="btnPlanoUbicacion">
								<label class="control-label form-control-sm" style="font-size:10px">*Archivo Obligatorio de Plano de Ubicaci&oacute;n</label>
							</div>
							<div class="col-sm-4">
								<label class="control-label form-control-sm color-letra">FUE COMPLETO</label>
								<input type="file" class="form-control-file btn btn-sm btn-success" style="background-color: #FFFFFF !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black" id="btnFue" name="btnFue">
								<label class="control-label form-control-sm" style="font-size:10px;">*Archivo Obligatorio del Formulario &Uacute;nico de Edificaciones</label>
								<label class="control-label form-control-sm" style="font-size:12px; color:red; display: block;">Firmado por el/los proyectistas arquitectos</label>
							</div>
							<div class="col-sm-4">
								<label class="control-label form-control-sm color-letra">Presupuesto</label>
								<input type="file" class="form-control-file btn btn-sm btn-success" style="background-color: #FFFFFF !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black" id="btnPresupuesto" name="btnPresupuesto">
								<label class="control-label form-control-sm" style="font-size:10px">*Archivo Obligatorio del Presupuesto</label>
								<label class="control-label form-control-sm" style="font-size:12px; color:red">La validaci&oacute;n del presupuesto va a ser nuevamente revisado y confirmado con los planos completos ingresados a la municipalidad por la Comisi&oacute;n.</label>
							</div>
						</div>
						<div style="padding: 15px 0px 15px 10px; font-weight: bold; color: #1538C8;">
							Archivos Adicionales
						</div>
						<label class="control-label form-control-sm">Adjunte archivos adicionales relacionados a la solicitud (Planos, Documentos Digitalizados, Archivos de Hojas de cálculo, etc.)</label>
						<div class="col-lg-12" id="archivos_adicionales_container">
							<div class="row" style="padding-left:10px">
								<div class="col-lg-5">
									<label class="control-label form-control-sm color-letra">Descripci&oacute;n del Archivo</label>
									<input id="descripcion_archivo" name="descripcion_archivo[]" on class="form-control form-control-sm"  value="<?php //echo $liquidacion[0]->situacion?>" type="text">
								</div>
								<div class="col-lg-3" style="background-color: #F6F6F6 !important;">
									<div class="form-group">
										<label class="control-label form-control-sm color-letra">Archivo</label>
										<input type="file" class="form-control-file btn btn-sm btn-success" style="background-color: #F6F6F6 !important; border: none !important; padding: 0 !important; box-shadow: none !important; color:black" id="btnArchivoAdicional" name="btnArchivoAdicional[]">
									</div>
								</div>

							</div>
							
						</div>
						<div class="col-lg-12">
							<div class="row" style="padding-left:10px">
								<a href="javascript:void(0)" onClick="AddFilaArchivoAdicional()" class="btn btn-sm btn-success">Agregar</a>	
							</div>
						</div>
						<div style="margin-top:15px" class="form-group">
							<div class="col-sm-12 controls">
								<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
									<!--<a href="javascript:void(0)" onClick="btnSolicitudDerechoRevision()" class="btn btn-sm btn-success">Registrar</a>-->
									<input class="btn btn-sm btn-success float-rigth" value="Enviar Solicitud" name="guardar" type="button" id="btnSolicitudEdificacion" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" />
								</div>
								
							</div>
						</div>
					</div>
						
					</div>
					</div>
				</form>
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
