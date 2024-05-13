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

</style>

<script>

function formatoMoneda(num) {
    return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function calculoVistaPrevia(){
    var igv_valor_ = <?php echo $parametro[0]->igv?> * 100;
    var valor_minimo_edificaciones = <?php echo $parametro[0]->valor_minimo_edificaciones?>;
    var uit_edificaciones = <?php echo $parametro[0]->valor_uit?>;
    var sub_total_minimo = valor_minimo_edificaciones * uit_edificaciones;
    var igv_valor = <?php echo $parametro[0]->igv?>;
    var igv_minimo	= igv_valor * sub_total_minimo;
    var total_minimo = sub_total_minimo + igv_minimo;
    $('#minimo').val(formatoMoneda(total_minimo));
    $('#igv').val(igv_valor_+"%");
    //var_dump($total_minimo);exit;
    
    var valor_obra_= <?php echo $liquidacion[0]->valor_obra?>;
    var porcentaje_calculo_edificacion = <?php echo $parametro[0]->porcentaje_calculo_edificacion?>;
    var sub_total= valor_obra_* porcentaje_calculo_edificacion;
    //var sub_total_formateado = number_format(sub_total, 2, '.', ',');
    var igv_total=sub_total*igv_valor;
    //var igv_total_formateado = number_format(igv_total, 2, '.', ',');
    //var_dump($total_minimo);exit;
    var total=sub_total+igv_total;
    //var total_formateado = number_format(total, 2, '.', ',');
    $('#sub_total').val(sub_total);
    $('#igv_').val(igv_total);
    $('#total').val(formatoMoneda(total));
    
    if(total<total_minimo){
        var total_ = total_minimo;
        var valor_minimo_edificaciones= <?php echo $parametro[0]->valor_minimo_edificaciones?>;
        var uit_minimo= <?php echo $parametro[0]->valor_uit?>;
        var sub_total_minimo=valor_minimo_edificaciones*uit_minimo;
        var igv_minimo=sub_total_minimo*igv_valor;
        //$sub_total_formateado_ = number_format($sub_total_minimo, 2, '.', ',');
        //$igv_total_formateado_ = number_format($igv_minimo, 2, '.', ',');
        //$total_formateado_ = number_format($total_minimo, 2, '.', ',');
        $('#sub_total').val(formatoMoneda(sub_total));
        $('#igv_').val(formatoMoneda(igv_total));
        $('#total').val(formatoMoneda(total));
        $('#sub_total2').val(formatoMoneda(sub_total_minimo));
        $('#igv2').val(formatoMoneda(igv_minimo));
        $('#total2').val(formatoMoneda(total_minimo));
    }else{
		$('#sub_total').val(formatoMoneda(sub_total));
        $('#igv_').val(formatoMoneda(igv_total));
        $('#total').val(formatoMoneda(total));
        $('#sub_total2').val(formatoMoneda(sub_total));
        $('#igv2').val(formatoMoneda(igv_total));
        $('#total2').val(formatoMoneda(total));
	}
    //var_dump($total_minimo);exit;
}

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

			$('#total2').val(formatoMoneda(total_minimo));
			$('#igv2').val(formatoMoneda(igv_minimo));
			$('#sub_total2').val(formatoMoneda(sub_total_minimo));
			$('#total').val(formatoMoneda(totalR));
			$('#igv_').val(formatoMoneda(igv_totalR));
			$('#sub_total').val(formatoMoneda(sub_totalR));
			
		}else{

			//var sub_totalR_formateado = number_format(sub_totalR, 2, '.', ',');
			//var igv_totalR_formateado = number_format(igv_totalR, 2, '.', ',');
			//var totalR_formateado = number_format(totalR, 2, '.', ',');
			$('#total2').val(formatoMoneda(totalR));
			$('#igv2').val(formatoMoneda(igv_totalR));
			$('#sub_total2').val(formatoMoneda(sub_totalR));
			$('#total').val(formatoMoneda(totalR));
			$('#igv_').val(formatoMoneda(igv_totalR));
			$('#sub_total').val(formatoMoneda(sub_totalR));
		}
		
	}
}
}


</script>


@extends('frontend.layouts.app')

@section('title', ' | ' . __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Solicitud de Derecho de Revisi&oacute;n - Reintegro</li>
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
                    <h4 class="card-title mb-0 text-primary">
                        Solicitud de Reintegro de Derecho de Revisi&oacute;n<!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        Datos Generales del Proyecto
                    </strong>
                </div>
				
				<div class="card-body">
			<form method="post" action="#" id="frmSolicitudDerechoRevisionReintegroall" name="frmSolicitudDerechoRevisionReintegroall">
			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<!--<input type="hidden" name="id" id="id" value="<?php //echo $derecho_revision->id?>">-->
					<input type="hidden" name="id_solicitud_reintegro" id="id_solicitud_reintegro" value="<?php echo $id?>">
					<input type="hidden" name="codigo_proyecto" id="codigo_proyecto" value="<?php echo $proyecto2->codigo?>">

					<div class="row" style="padding-left:10px">
						<div class="row" style="padding-left:10px">
							<div class="col-lg-5">
								<label class="control-label form-control-sm">Municipalidad</label>
								<select name="municipalidad" id="municipalidad" class="form-control form-control-sm" onChange="obtenerUbigeo()"> 
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
					
							<div class="col-lg-4">
								<label class="control-label form-control-sm">N° de Revisi&oacute;n</label>
								<select name="n_revision" id="n_revision" class="form-control form-control-sm" value="<?php echo $derechoRevision_->numero_revision?>">
								<?php
								$valorSeleccionado = isset($derechoRevision_->numero_revision) ? $derechoRevision_->numero_revision : '';
								?>
								<option value="" <?php echo ($valorSeleccionado == '') ? 'selected="selected"' : ''; ?>>--Seleccionar--</option>
								<option value="1" <?php echo ($valorSeleccionado == '1') ? 'selected="selected"' : ''; ?>>1</option>
								<option value="3" <?php echo ($valorSeleccionado == '3') ? 'selected="selected"' : ''; ?>>3</option>
								<option value="5" <?php echo ($valorSeleccionado == '5') ? 'selected="selected"' : ''; ?>>5</option>
								</select>
							</div>
						</div>
						</div>
						<div class="row" style="padding-left:10px">

							<div class="col-lg-5">
								<label class="control-label form-control-sm">Nombre del Proyecto</label>
								<input id="nombre_proyecto" name="nombre_proyecto" on class="form-control form-control-sm"  value="<?php echo $proyecto2->nombre?>" type="text">
							</div>

						
							<div class="col-lg-5">
								<label class="control-label form-control-sm">Direccion</label>
								<input id="direccion_proyecto" name="direccion_proyecto" on class="form-control form-control-sm"  value="<?php echo $proyecto2->direccion?>" type="text">
							</div>

							<div class="col-lg-2">
								<label class="control-label form-control-sm">Departamento</label>
								<select name="departamento" id="departamento" class="form-control form-control-sm" onChange="obtenerProvincia()" disabled='disabled'>
									<?php if($id>0){ ?>
									<option value="">--Selecionar--</option>
									<?php
									foreach ($departamento as $row) {?>
									<option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==substr($derechoRevision_->id_ubigeo,0,2))echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
									<?php 
										}
									}else {?>
										<option value="">--Selecionar--</option>
										<?php
										foreach ($departamento as $row) {?>
										<option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==15)echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
										<?php 
										}
									}
									?>

								</select>
							</div>
						
							<div class="col-lg-2">
								<label class="control-label form-control-sm">Provincia</label>
								<select name="provincia" id="provincia" class="form-control form-control-sm" onChange="obtenerDistrito()">
									<option value="">--Selecionar--</option>
								</select>
							</div>
							

							<div class="col-lg-2">
								<label class="control-label form-control-sm">Distrito</label>
								<select name="distrito" id="distrito" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
								</select>
							</div>
						</div>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Proyectista Principal
						</div>	
						<div class="row" style="padding-left:10px">
							<div class="col-lg-3" >
								<div class="form-group "id="agremiado_">
									<label class="control-label form-control-sm">Nombre</label>
									<input id="agremiado" name="agremiado" on class="form-control form-control-sm"  value="<?php echo $datos_persona->apellido_paterno.' '. $datos_persona->apellido_materno.' '.$datos_persona->nombres?>" type="text" readonly='readonly'>
								</div>
								<div class="form-group" id="persona_">
									<label class="control-label form-control-sm">Nombre/Raz&oacute;n Social</label>
									<input id="persona" name="persona" on class="form-control form-control-sm"  value="<?php //echo $persona->nombres?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="numero_cap_">
									<label class="control-label form-control-sm">N° CAP</label>
									<input id="numero_cap" name="numero_cap" on class="form-control form-control-sm"  value="<?php echo $datos_agremiado->numero_cap?>" type="text" onchange="obtenerProyectista()"readonly='readonly'>
								</div>
								<div class="form-group" id="dni_">
									<label class="control-label form-control-sm">DNI</label>
									<input id="dni" name="dni" on class="form-control form-control-sm"  value="<?php //echo $persona->numero_documento?>" type="text" onchange="obtenerPropietario()">
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="situacion_">
									<label class="control-label form-control-sm">Situaci&oacute;n</label>
									<input id="situacion" name="situacion" on class="form-control form-control-sm"  value="<?php echo $datos_agremiado->situacion?>" type="text" readonly='readonly'>
								</div>
								<div class="form-group" id="fecha_nacimiento_">
									<label class="control-label form-control-sm">Fecha de Nacimiento</label>
									<input id="fecha_nacimiento" name="fecha_nacimiento" on class="form-control form-control-sm"  value="<?php echo $datos_persona->fecha_nacimiento?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group" id="direccion_agremiado_">
									<label class="control-label form-control-sm">T&eacute;lefono</label>
									<input id="direccion_agremiado" name="direccion_agremiado" on class="form-control form-control-sm"  value="<?php echo $datos_agremiado->celular1?>" type="text" readonly='readonly'>
								</div>
								<div class="form-group" id="direccion_persona_">
									<label class="control-label form-control-sm">Direcci&oacute;n</label>
									<input id="direccion_persona" name="direccion_persona" on class="form-control form-control-sm"  value="<?php echo $datos_persona->direccion?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-1-5">
								<div class="form-group" id="n_regional_">
									<label class="control-label form-control-sm">Email</label>
									<input id="n_regional" name="n_regional" on class="form-control form-control-sm"  value="<?php echo $datos_agremiado->email?>" type="text" readonly='readonly'>
								</div>
								<div class="form-group" id="celular_">
									<label class="control-label form-control-sm">Celular</label>
									<input id="celular" name="celular" on class="form-control form-control-sm"  value="<?php //echo $datos_persona->numero_celular?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="act_gremial_">
									<label class="control-label form-control-sm">Actividad Gremial</label>
									<input id="act_gremial" name="act_gremial" on class="form-control form-control-sm"  value="<?php echo $datos_agremiado->actividad?>" type="text" readonly='readonly'>
								</div>
								<div class="form-group" id="email_">
									<label class="control-label form-control-sm">Email</label>
									<input id="email" name="email" on class="form-control form-control-sm"  value="<?php //echo $persona->correo?>" type="text" readonly='readonly'>
								</div>
							</div>
						</div>

						<div style="padding: 0px 0px 15px 10px; font-weight: bold">
							Datos del Proyecto
						</div>

						<div class="col-lg-3" style=";padding-right:15px">
							<label class="control-label form-control-sm">Datos T&eacute;cnicos del proyecto</label>
							<select name="tipo_proyecto" id="tipo_proyecto" class="form-control form-control-sm" onChange="">
								<option value="">--Selecionar--</option>
								<?php
								foreach ($tipo_proyecto as $row) {?>
								<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$derechoRevision_->id_tipo_tramite)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
								<?php
							    }
								?>
							</select>
						</div>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Uso de la Edificaci&oacute;n
						</div>
						<div class="row" style="padding-left:10px">
							<div class="col-lg-3" style=";padding-right:15px">
								<label class="control-label form-control-sm">Tipo de Uso</label>
								<select name="tipo_uso" id="tipo_uso" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_uso as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$datos_usoEdificaciones->id_tipo_uso)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-lg-3" style=";padding-right:15px">
								<label class="control-label form-control-sm">Sub-Tipo de Uso</label>
								<select name="sub_tipo_uso" id="sub_tipo_uso" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($sub_tipo_uso as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$datos_usoEdificaciones->id_sub_tipo_uso)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">&Aacute;rea Techada</label>
								<input id="area_techada" name="area_techada" on class="form-control form-control-sm"  value="<?php echo $datos_usoEdificaciones->area_techada?>" type="text">
							</div>
						</div>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Presupuesto
						</div>
						<div class="row" style="padding-left:10px">
							<div class="col-lg-3" style=";padding-right:15px">
								<label class="control-label form-control-sm">Tipo de Obra</label>
								<select name="tipo_obra" id="tipo_obra" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_obra as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$datos_presupuesto->id_tipo_obra)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">&Aacute;rea Techada m2</label>
								<input id="area_techada_presupuesto" name="area_techada_presupuesto" on class="form-control form-control-sm"  value="<?php echo $datos_presupuesto->area_techada?>" type="text">
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Valor Unitario S/</label>
								<input id="valor_unitario" name="valor_unitario" on class="form-control form-control-sm"  value="<?php echo $datos_presupuesto->valor_unitario?>" type="text">
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Presupuesto</label>
								<input id="presupuesto" name="presupuesto" on class="form-control form-control-sm"  value="<?php echo $datos_presupuesto->total_presupuesto?>" type="text">
							</div>
						</div>
						<div class="row" style="padding-left:10px;padding-top:10px">
							<div class="col-lg-1">
								<label class="control-label form-control-sm">&Aacute;rea Techada Total</label>
								<input id="area_techada_total" name="area_techada_total" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->area_total?>" type="text">
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">N° S&oacute;tanos</label>
								<input id="n_sotanos" name="n_sotanos" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->numero_sotano?>" type="text">
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Azotea</label>
								<input id="azotea" name="azotea" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->azotea?>" type="text">
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Semis&oacute;tano</label>
								<input id="semisotano" name="semisotano" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->semisotano?>" type="text">
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">N° de Pisos</label>
								<input id="n_pisos" name="n_pisos" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->numero_piso?>" type="text">
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Fecha Registro</label>
								<input id="fecha_registro" name="fecha_registro" on class="form-control form-control-sm"  value="<?php echo date('Y-m-d', strtotime($derechoRevision_->fecha_registro)); ?>" type="text" readonly='readonly'>
							</div>
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Valor Total de Obra S/</label>
								<input id="valor_total_obra" name="valor_total_obra" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->valor_obra?>" type="text">
							</div>
						</div>
						<div style="padding: 15px 0px 15px 10px; font-weight: bold">
							C&aacute;lculo Liquidaci&oacute;n
						</div>
						<div class="row" style="padding-left:10px">
							<div class="col-lg-3">
								<div class="form-group">
									<label class="control-label form-control-sm">Tipo Liquidaci&oacute;n 1</label>
									<select name="tipo_liquidacion1" id="tipo_liquidacion1" class="form-control form-control-sm">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($tipo_liquidacion as $row) {
											if (in_array($row->codigo, [135,142,136,138,306,137,143,258])){
										?>
										<option value="<?php echo $row->codigo?>" <?php if($row->codigo=='135')echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label class="control-label form-control-sm">Instancia</label>
									<select name="instancia" id="instancia" class="form-control form-control-sm" onChange="habilitar_reintegro()">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($instancia as $row) {?>
										<option value="<?php echo $row->codigo?>" <?php if($row->codigo=='250')echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<label class="control-label form-control-sm">Tipo Liquidaci&oacute;n 2</label>
									<select name="tipo_liquidacion2" id="tipo_liquidacion2" class="form-control form-control-sm">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($tipo_liquidacion as $row) {
											if (in_array($row->codigo, [143,258])){
										?>
										<option value="<?php echo $row->codigo?>" <?php if($row->codigo=='258')echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div id="valor_reintegro_" name="valor_reintegro_">
									<label class="control-label form-control-sm">Valor Reintegro S/.</label>
									<input id="valor_reintegro" name="valor_reintegro" on class="form-control form-control-sm"  value="<?php //echo $liquidacion[0]->situacion?>" type="text" onChange="calcularReintegro()">
								</div>
							</div>
						</div>
						<div class="row" style="padding-left:10px;padding-top:15px">
							<div class="col-lg-6" style="padding:10px; border:1px solid #ccc;">
								<div class="row" style="padding-left:10px;">
									<div class="col-lg-6">
										<label class="control-label form-control-sm">Factor</label>
										<input id="factor" name="factor" on class="form-control form-control-sm"  value="<?php echo $parametro[0]->porcentaje_calculo_edificacion?>" type="text" readonly='readonly'>
									</div>
									<div class="col-lg-6">
										<label class="control-label form-control-sm">M&iacute;mino</label>
										
										<input id="minimo" name="minimo" on class="form-control form-control-sm"  value="<?php //echo $total_minimo?>" type="text" readonly='readonly'>
									</div>
								</div>
								<div class="row" style="padding-left:10px;">
									<div class="col-lg-6">
										<label class="control-label form-control-sm">% IGV</label>
										
										<input id="igv" name="igv" on class="form-control form-control-sm"  value="<?php //echo $igv_valor . '%'?>" type="text" readonly='readonly'>
									</div>
									<div class="col-lg-6">
										<label class="control-label form-control-sm">M&aacute;ximo</label>
										<input id="maximo" name="maximo" on class="form-control form-control-sm"  value="<?php //echo $liquidacion[0]->situacion?>" type="text" readonly='readonly'>
									</div>
								</div>
								<div class="row" style="padding-left:10px;">
									<div class="col-lg-12">
										<label class="control-label form-control-sm">Observaci&oacute;n</label>
										<input id="observacion" name="observacion" on class="form-control form-control-sm"  value="<?php //echo $liquidacion[0]->situacion?>" type="text" readonly='readonly'>
									</div>
								</div>
							</div>
							<div class="col-lg-6" style="padding:10px; border:1px solid #ccc;">
								<div class="row" style="padding-left:10px;">
									<div class="col-lg-6">
										<label class="control-label form-control-sm">Sub Total</label>
										
										<input id="sub_total" name="sub_total" on class="form-control form-control-sm"  value="<?php //echo $sub_total_formateado?>" type="text" readonly='readonly'>
									</div>
									<div class="col-lg-6">
										<label class="control-label form-control-sm">Sub Total</label>
										<input id="sub_total2" name="sub_total2" on class="form-control form-control-sm"  value="<?php //echo $sub_total_formateado_?>" type="text" readonly='readonly'>
									</div>
								</div>
								<div class="row" style="padding-left:10px;">
									<div class="col-lg-6">
										<label class="control-label form-control-sm">IGV</label>
										<?php
										
										
										?>
										<input id="igv_" name="igv_" on class="form-control form-control-sm"  value="<?php //echo $igv_total_formateado?>" type="text" readonly='readonly'>
									</div>
									<div class="col-lg-6">
										<label class="control-label form-control-sm">IGV</label>
										<input id="igv2" name="igv2" on class="form-control form-control-sm"  value="<?php //echo $igv_total_formateado_?>" type="text" readonly='readonly'>
									</div>
								</div>
								<div class="row" style="padding-left:10px;">
									<div class="col-lg-6">
										<label class="control-label form-control-sm">Total</label>
										<?php
										
										?>
										<input id="total" name="total" on class="form-control form-control-sm"  value="<?php //echo $total_formateado?>" type="text" readonly='readonly'>
									</div>
									<div class="col-lg-6">
										<label class="control-label form-control-sm">Total a Pagar Soles</label>
										<input id="total2" name="total2" on class="form-control form-control-sm"  value="<?php //echo $total_formateado_?>" type="text" onchange="cambioPlantaTipica()">
									</div>
								</div>
							</div>
						</div>
						<!--<div class="row" style="padding-left:10px">
							<div class="col-lg-1" style=";padding-right:15px">
								<label class="control-label form-control-sm">Sitio</label>
								<select name="sitio" id="sitio" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									//foreach ($sitio as $row) {?>
									<option value="<?php //echo $row->codigo?>" <?php //if($row->codigo==$proyecto2->id_tipo_sitio)echo "selected='selected'"?>><?php //echo $row->denominacion?></option>
									<?php
									//}
									?>
								</select>
							</div>

							<div class="col-lg-2">
								<label class="control-label form-control-sm">Detalle Sitio</label>
								<input id="direccion_sitio" name="direccion_sitio" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->sitio_descripcion?>" type="text">
							</div>

							<div class="col-lg-1" style="padding-left:15px">
								<label class="control-label form-control-sm">Zona</label>
								<select name="zona" id="zona" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									//foreach ($zona as $row) {?>
									<option value="<?php //echo $row->codigo?>" <?php //if($row->codigo==$proyecto2->id_zona)echo "selected='selected'"?>><?php //echo $row->denominacion?></option>
									<?php
									//}
									?>
								</select>
							</div>

							<div class="col-lg-2">
								<label class="control-label form-control-sm">Detalle Zona</label>
								<input id="direccion_zona" name="direccion_zona" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->zona_descripcion?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm">Parcela</label>
								<input id="parcela" name="parcela" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->parcela?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm">SuperManzana</label>
								<input id="superManzana" name="superManzana" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->super_manzana?>" type="text">
							</div>
							
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Tipo</label>
								<select name="tipo" id="tipo" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									//foreach ($tipo as $row) {?>
									<option value="<?php //echo $row->codigo?>" <?php //if($row->codigo==$proyecto2->id_tipo_direccion)echo "selected='selected'"?>><?php //echo $row->denominacion?></option>
									<?php
									//}
									?>
								</select>
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm">Lote</label>
								<input id="lote" name="lote" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->lote?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm">SubLote</label>
								<input id="sublote" name="sublote" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->sub_lote?>" type="text">
							</div>
						
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Fila</label>
								<input id="fila" name="fila" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->fila?>" type="text">
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm">Zonificaci&oacute;n</label>
								<input id="zonificacion" name="zonificacion" on class="form-control form-control-sm"  value="<?php //echo $proyecto2->zonificacion?>" type="text">
							</div>

						</div>-->
						<div style="margin-top:15px" class="form-group">
							<div class="col-sm-12 controls">
								<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
									<!--<a href="javascript:void(0)" onClick="btnSolicitudDerechoRevision()" class="btn btn-sm btn-success">Registrar</a>-->
									<input class="btn btn-sm btn-success float-rigth" value="REGISTRAR" name="guardar" type="button" id="btnSolicitudReintegro" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" />
								</div>
								
							</div>
						</div>

						<div style="clear:both;padding-top:15px"></div>
					
						<div class="card">
						
						<nav>
							<div class="nav nav-pills" id="nav-tab" role="tablist">
								<a
									class="nav-link active"
									id="proyectista_propietario-tab"
									data-toggle="pill"
									href="#proyectista_propietario"
									role="tab"
									aria-controls="proyectista_propietario"
									aria-selected="true">Proyectistas y Propietario</a>
								
								<a
									class="nav-link"
									id="informacion_proyecto-tab"
									data-toggle="pill"
									href="#informacion_proyecto"
									role="tab"
									aria-controls="informacion_proyecto"
									aria-selected="false"
									>Informaci&oacute;n del proyecto</a>
								
								<a
									class="nav-link"
									id="datos_comprobante-tab"
									data-toggle="pill"
									href="#datos_comprobante"
									role="tab"
									aria-controls="datos_comprobante"
									aria-selected="false"
									>Datos del Comprobante</a>
								
							</div>
						</nav>
						<div class="tab-content" id="my-profile-tabsContent">
							<div class="tab-pane fade pt-3 show active" id="proyectista_propietario" role="tabpanel" aria-labelledby="proyectista_propietario-tab">
								
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Proyectistas
														</strong>
														
													</div>
												</div>
											</div>

											<!--<div class="card-body" style="margin-top:15px;margin-bottom:15px">-->
											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoProyectista" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblProyectista" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>N° CAP</th>
																	<th>Nombres</th>
																	<th>Celular</th>
																	<th>Email</th>
																	<!--<th>Firma</th> agregar despues
																	<th>Opciones</th>-->
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php foreach($proyectista_solicitud as $row){?>
																<tr>
																	<th><?php echo $row->numero_cap?></th>
																	<th><?php echo $row->agremiado?></th>
																	<th><?php echo $row->celular1?></th>
																	<th><?php echo $row->email1?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<!--<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>-->
																	</div>
																	</th>
																</tr>											
																<?php }?>
															</tbody>							
															</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>		
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Propietario
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoPropietario" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblPropietario" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Persona</th>
																	<th>N&uacute;mero Documento</th>
																	<th>Nombres</th>
																	<th>celular</th>
																	<th>Email</th>
																	<!--<th>Opciones</th>-->
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php foreach($propietario_solicitud as $row){?>
																<tr>
																	<th><?php echo $row->tipo_propietario?></th>
																	<th><?php echo $row->numero_documento?></th>
																	<th><?php echo $row->nombres?></th>
																	<th><?php echo $row->numero_celular?></th>
																	<th><?php echo $row->correo?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<!--<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalIdioma(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarIdioma(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>-->
																	</div>
																	</th>
																</tr>					
																<?php }?>
															</tbody>							
															</table>
															
															</div>
														
														</div>
													
													</div>
													
												</div>
													
											</div>
											
											
										</div>
										
									</div>
							
								</div>
							</div>

							<div class="tab-pane fade pt-3" id="informacion_proyecto" role="tabpanel" aria-labelledby="informacion_proyecto-tab">
							
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Informaci&oacute;n del Proyecto
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoinfoProyecto" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblInfoProyecto" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Tramite</th>
																	<th>Tipo de Habilitacion Urbana</th>
																	<!--<th>Etapas</th>-->
																	<th>&Aacute;rea Bruta del Terreno Declarado (m2)</th>
																	<th>Formato de Registro</th>
																	<th>Plano de Ubicaci&oacute;n</th>
																	<th>FUHU</th>
																	<!--<th>Opciones</th>-->
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php foreach($info_uso_solicitud as $row){?>
																<tr>
																	<th><?php echo $row->tipo_tramite?></th>
																	<th><?php echo $row->tipo_uso?></th>
																	<th><?php echo $row->area_techada?></th>
																	<!--
																	<th><button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerFormato(<?php //echo $row->id?>)"><i class="fa fa-edit" style="font-size:9px!important"></i>Formato</button></th>
																	<th><button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerPlano(<?php //echo $row->id?>)"><i class="fa fa-edit" style="font-size:9px!important"></i>Plano</button></th>
																	<th><button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerFUHU(<?php //echo $row->id?>)"><i class="fa fa-edit" style="font-size:9px!important"></i>FUHU</button></th>
																	-->
																	
																	<td class="text-left" style="vertical-align:middle">
																		<a href="/img/derecho_revision/<?php echo $row->ruta_archivo1?>" target="_blank" class="btn btn-sm btn-warning">Ver Imagen</a>
																	</td>
																	<td class="text-left" style="vertical-align:middle">
																		<a href="/img/derecho_revision/<?php echo $row->ruta_archivo2?>" target="_blank" class="btn btn-sm btn-warning">Ver Imagen</a>
																	</td>
																	<td class="text-left" style="vertical-align:middle">
																		<a href="/img/derecho_revision/<?php echo $row->ruta_archivo3?>" target="_blank" class="btn btn-sm btn-warning">Ver Imagen</a>
																	</td>
																	
																	<!--<th><?php //echo $row->fecha_egresado?></th>
																	<th><?php //echo $row->fecha_graduado?></th>
																	<th><?php //echo $row->libro?></th>
																	<th><?php //echo $row->folio?></th>-->
																	<th>
																	<!--<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>-->
																	</div>
																	</th>
																</tr>													
																<?php }?>
															</tbody>							
															</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>		
									</div>
								</div>
							</div>
							<div class="tab-pane fade pt-3" id="datos_comprobante" role="tabpanel" aria-labelledby="datos_comprobante-tab">
							
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Datos del Comprobante
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoComprobante" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblComprobante" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Persona</th>
																	<th>N&uacute;mero Documento</th>
																	<th>Nombre/Razon Social</th>
																	<th>Direcci&oacute;n</th>
																	<th>Departamento</th>
																	<th>Provincia</th>
																	<th>Distrito</th>
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php //foreach($agremiado_estudio as $row){?>
																<!--<tr>
																	<th><?php //echo $row->universidad?></th>
																	<th><?php //echo $row->especialidad?></th>
																	<th><?php //echo $row->tesis?></th>
																	<th><?php //echo $row->fecha_egresado?></th>
																	<th><?php //echo $row->fecha_graduado?></th>
																	<th><?php //echo $row->libro?></th>
																	<th><?php //echo $row->folio?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->													
																<?php //}?>
															</tbody>							
															</table>
															</div>
														</div>
													</div>
												</div>
											</div>
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

<script src="{{ asset('js/derecho_revision/lista.js') }}"></script>

@endpush
