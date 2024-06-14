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

function formatoMoneda_(num) {
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
    $('#minimo').val(formatoMoneda_(total_minimo));
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
    $('#total').val(formatoMoneda_(total));
    
    if(total<total_minimo){
        var total_ = total_minimo;
        var valor_minimo_edificaciones= <?php echo $parametro[0]->valor_minimo_edificaciones?>;
        var uit_minimo= <?php echo $parametro[0]->valor_uit?>;
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
					<input type="hidden" name="id_solicitud_reintegro" id="id_solicitud_reintegro" value="0">
					<input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $id?>">
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
								<input id="nombre_proyecto" name="nombre_proyecto" on class="form-control form-control-sm"  value="<?php echo $proyecto2->nombre?>" type="text" readonly='readonly'>
							</div>

							<div class="col-lg-1">
								<label class="control-label form-control-sm">Tipo</label>
								<select name="tipo_direccion" id="tipo_direccion" class="form-control form-control-sm" onChange="" disabled='disabled'>
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto2->id_tipo_direccion)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						
							<div class="col-lg-5">
								<label class="control-label form-control-sm">Direccion</label>
								<input id="direccion_proyecto" name="direccion_proyecto" on class="form-control form-control-sm"  value="<?php echo $proyecto2->direccion?>" type="text" readonly='readonly'>
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
							<div class="col-lg-1" hidden>
								<label class="control-label form-control-sm">Tipo Proyectista</label>
								<select name="tipo_proyectista" id="tipo_proyectista" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_proyectista as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyectista->id_tipo_profesional)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
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

							<div class="col-lg-1">
								<div class="form-group" id="direccion_agremiado_">
									<label class="control-label form-control-sm">T&eacute;lefono</label>
									<input id="direccion_agremiado" name="direccion_agremiado" on class="form-control form-control-sm"  value="<?php echo $datos_agremiado->celular1?>" type="text" readonly='readonly'>
								</div>
								<div class="form-group" id="direccion_persona_">
									<label class="control-label form-control-sm">Direcci&oacute;n</label>
									<input id="direccion_persona" name="direccion_persona" on class="form-control form-control-sm"  value="<?php echo $datos_persona->direccion?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-3">
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
						
						<?php if(count($proyectista_solicitud)>1){?>
						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Proyectista Asociados
						</div>
						
						<?php } ?>
						
						<?php 
							foreach($proyectista_solicitud as $row){
							if($row->numero_cap!=$datos_agremiado->numero_cap){
						?>
							
						<div class="row" style="padding-left:10px">
							<div class="col-lg-1" hidden>
								<label class="control-label form-control-sm">Tipo Proyectista</label>
								<select name="tipo_proyectista_row" id="tipo_proyectista_row" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_proyectista as $row_) {?>
									<option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_tipo_profesional)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-lg-3" >
								<div class="form-group "id="agremiado_">
									<label class="control-label form-control-sm">Nombre</label>
									<input id="agremiado_row" name="agremiado_row" on class="form-control form-control-sm"  value="<?php echo $row->agremiado?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="numero_cap_">
									<label class="control-label form-control-sm">N° CAP</label>
									<input id="numero_cap_row" name="numero_cap_row" on class="form-control form-control-sm"  value="<?php echo $row->numero_cap?>" type="text" onchange="obtenerProyectista()"readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group" id="situacion_">
									<label class="control-label form-control-sm">Situaci&oacute;n</label>
									<input id="situacion_row" name="situacion_row" on class="form-control form-control-sm"  value="<?php echo $row->situacion?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-1">
								<div class="form-group" id="direccion_agremiado_">
									<label class="control-label form-control-sm">T&eacute;lefono</label>
									<input id="direccion_agremiado_row" name="direccion_agremiado_row" on class="form-control form-control-sm"  value="<?php echo $row->celular1?>" type="text" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group" id="n_regional_">
									<label class="control-label form-control-sm">Email</label>
									<input id="n_regional_row" name="n_regional_row" on class="form-control form-control-sm"  value="<?php echo $row->email1?>" type="text" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="act_gremial_">
									<label class="control-label form-control-sm">Actividad Gremial</label>
									<input id="act_gremial_row" name="act_gremial_row" on class="form-control form-control-sm"  value="<?php echo $row->actividad?>" type="text" readonly='readonly'>
								</div>
							</div>
						</div>
						
						
						<?php 
								}
							} 
						?>
						
						
						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Propietario/Administrado
						</div>	
						<div class="row" style="padding-left:10px">
							<div class="col-lg-1">
								<label class="control-label form-control-sm">Tipo Documento</label>
								<select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" onchange="obtenerPropietario_()" disabled='disabled'>
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_documento as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$propietario_solicitud[0]->id_tipo_propietario)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>

							<div class="col-lg-1">
								<div class="form-group" id="dni_propietario_">
								<label class="control-label form-control-sm">DNI</label>
								<input id="dni_propietario" name="dni_propietario" on class="form-control form-control-sm" value="<?php echo isset($propietario_solicitud) && $propietario_solicitud[0]->id_tipo_propietario=='78' ? $propietario_solicitud[0]->numero_documento : '';?>" type="text" onchange="obtenerDatosDni()" readonly='readonly'>
								</div>
								<div class="form-group" id="ruc_propietario_">
									<label class="control-label form-control-sm">RUC</label>
									<input id="ruc_propietario" name="ruc_propietario" on class="form-control form-control-sm"  value="<?php if($propietario_solicitud[0]->id_tipo_propietario=='79') echo $propietario_solicitud[0]->numero_documento;?>" type="text" onchange="obtenerDatosRuc()">
								</div>
							</div>

							<div class="col-lg-3" >
							<div class="form-group" id="nombre_propietario_">
								<label class="control-label form-control-sm">Nombre</label>
								<input id="nombre_propietario" name="nombre_propietario" on class="form-control form-control-sm"  value="<?php echo $propietario_solicitud[0]->propietario?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="razon_social_propietario_">
									<label class="control-label form-control-sm">Raz&oacute;n Social</label>
									<input id="razon_social_propietario" name="razon_social_propietario" on class="form-control form-control-sm"  value="<?php echo $propietario_solicitud[0]->propietario?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>
							<div class="col-lg-3" >
								<div class="form-group" id="direccion_dni_">
									<label class="control-label form-control-sm">Direcci&oacute;n</label>
									<input id="direccion_dni" name="direccion_dni" on class="form-control form-control-sm"  value="<?php echo $propietario_solicitud[0]->direccion?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="direccion_ruc_">
									<label class="control-label form-control-sm">Direcci&oacute;n</label>
									<input id="direccion_ruc" name="direccion_ruc" on class="form-control form-control-sm"  value="<?php echo $propietario_solicitud[0]->direccion?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>
							
							<div class="col-lg-1" >
								<div class="form-group" id="celular_dni_">
									<label class="control-label form-control-sm">Celular</label>
									<input id="celular_dni" name="celular_dni" on class="form-control form-control-sm"  value="<?php echo $propietario_solicitud[0]->numero_celular?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="telefono_ruc_">
									<label class="control-label form-control-sm">Tel&eacute;fono</label>
									<input id="telefono_ruc" name="telefono_ruc" on class="form-control form-control-sm"  value="<?php echo $propietario_solicitud[0]->numero_celular?>" type="text" onchange="" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-2" >
								<div class="form-group" id="email_dni_">
									<label class="control-label form-control-sm">Email</label>
									<input id="email_dni" name="email_dni" on class="form-control form-control-sm"  value="<?php echo $propietario_solicitud[0]->correo?>" type="text" onchange="" readonly='readonly'>
								</div>
								<div class="form-group" id="email_ruc_">
									<label class="control-label form-control-sm">Email</label>
									<input id="email_ruc" name="email_ruc" on class="form-control form-control-sm"  value="<?php echo $propietario_solicitud[0]->correo?>" type="text" onchange="" readonly='readonly'>
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
						
						<?php 
							foreach($datos_usoEdificaciones as $row){
							$sub_tipo_uso = App\Models\TablaMaestra::getMaestroByTipoAndSubTipo(111,$row->id_tipo_uso);
						?>
							
							<div class="row">
							<div class="col-lg-8" style=";padding-right:15px">
								<div class="row" style="padding-left:10px">
									<div class="col-lg-12" id="uso-container">
										<div class="row uso-row">
											<div class="col-lg-5" style=";padding-right:15px">
											<label class="control-label form-control-sm">Tipo de Uso</label>
											<select name="tipo_uso[]" id="tipo_uso" class="form-control form-control-sm" onChange="obtenerSubTipoUso(this)">
												<option value="">--Seleccionar--</option>
												<?php
												foreach ($tipo_uso as $row_) {?>
												<option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_tipo_uso)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="col-lg-4" style=";padding-right:15px">
											<label class="control-label form-control-sm">Sub-Tipo de Uso</label>
											<select name="sub_tipo_uso[]" id="sub_tipo_uso" class="form-control form-control-sm" onChange="">
												<option value="">--Seleccionar--</option>
												<?php
												foreach ($sub_tipo_uso as $row_) {?>
												<option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_sub_tipo_uso)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="col-lg-2">
											<label class="control-label form-control-sm">&Aacute;rea Techada</label>
											<input id="area_techada" name="area_techada[]" on class="form-control form-control-sm"  value="<?php echo number_format($row->area_techada, 2, '.', ',');?>" type="text" onchange="">
										</div>
										<div style="margin-top:37px" class="form-group">
											<div class="col-sm-12 controls">
												<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
													<a href="javascript:void(0)" onClick="AddFilaUso()" class="btn btn-sm btn-success">Agregar</a>
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>

						
						
						<?php 
								//}
							} 
						?>

						<div style="padding: 10px 0px 15px 10px; font-weight: bold">
							Presupuesto
						</div>
						
						
						<div class="row">
							<div class="col-lg-8" style=";padding-right:15px">
								
								<?php 
									foreach($datos_presupuesto as $row){	
								?>
								
								<div class="row" style="padding-left:10px">
									<div class="col-lg-12" id="presupuesto-container">
										<div class="row presupuesto-row">
											<div class="col-lg-5" style=";padding-right:15px">
												<label class="control-label form-control-sm">Tipo de Obra</label>
												<select name="tipo_obra[]" id="tipo_obra" class="form-control form-control-sm" onChange="">
													<option value="">--Selecionar--</option>
													<?php
													foreach ($tipo_obra as $row_) {?>
													<option value="<?php echo $row_->codigo?>" <?php if($row_->codigo==$row->id_tipo_obra)echo "selected='selected'"?>><?php echo $row_->denominacion?></option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-2">
												<label class="control-label form-control-sm">&Aacute;rea Techada m2</label>
												<input id="area_techada_presupuesto" name="area_techada_presupuesto[]" on class="form-control form-control-sm"  value="<?php echo number_format($row->area_techada, 2, '.', ',');?>" type="text">
											</div>
											<div class="col-lg-2">
												<label class="control-label form-control-sm">Valor Unitario S/</label>
												<input id="valor_unitario" name="valor_unitario[]" on class="form-control form-control-sm"  value="<?php echo number_format($row->valor_unitario, 2, '.', ',');?>" type="text">
											</div>
											<div class="col-lg-2">
												<label class="control-label form-control-sm">Presupuesto</label>
												<input id="presupuesto" name="presupuesto[]" on class="form-control form-control-sm"  value="<?php echo number_format($row->total_presupuesto, 2, '.', ',');?>" type="text" readonly='readonly'>
											</div>
											<div style="margin-top:37px" class="form-group">
												<div class="col-sm-12 controls">
													<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
														<a href="javascript:void(0)" onClick="AddFilaPresupuesto()" class="btn btn-sm btn-success">Agregar</a>
														<!--<button type="button" id="btnAgregar" class="btn btn-sm btn-success" onclick="AddFila()">Agregar</button>-->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<?php 
									} 
								?>		
								
								<div class="row" style="padding-left:10px;padding-top:10px; display:flex; justify-content:flex-end">
									<div class="col-lg-3">
										<label class="control-label form-control-sm">Valor Total de Obra S/</label>
										<input id="valor_total_obra" name="valor_total_obra" on class="form-control form-control-sm"  value="<?php echo number_format($derechoRevision_->valor_obra, 2, '.', ',');?>" type="text" readonyl="readonly">
									</div>
								</div>
							</div>
							<div class="col-lg-2" style=";padding-right:15px; border-left:2px solid #ccc;">
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm">&Aacute;rea Techada Total</label>
										<input id="area_techada_total" name="area_techada_total" on class="form-control form-control-sm"  value="<?php echo number_format($derechoRevision_->area_total, 2, '.', ',');?>" type="text" readonly='readonly'>
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm">Azotea</label>
										<input id="azotea" name="azotea" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->azotea?>" type="text">
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm">N° de Pisos</label>
										<input id="n_pisos" name="n_pisos" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->numero_piso?>" type="text">
									</div>
								</div>
							</div>

							<div class="col-lg-2" style=";padding-right:15px">
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm">N° S&oacute;tanos</label>
										<input id="n_sotanos" name="n_sotanos" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->numero_sotano?>" type="text">
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm">Semis&oacute;tano</label>
										<input id="semisotano" name="semisotano" on class="form-control form-control-sm"  value="<?php echo $derechoRevision_->semisotano?>" type="text">
									</div>
								</div>
								<div class="row" style="padding-left:10px;padding-top:10px">
									<div class="col-lg-8">
										<label class="control-label form-control-sm">Fecha Registro</label>
										<input id="fecha_registro" name="fecha_registro" on class="form-control form-control-sm"  value="<?php echo date('Y-m-d', strtotime($derechoRevision_->fecha_registro)); ?>" type="text" readonly='readonly'>
									</div>
								</div>
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
						<div class="row justify-content-center" style="padding-left:10px;padding-top:15px">
							<div class="col-lg-4" style="padding:10px; border:1px solid #ccc;">
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
							<div class="col-lg-4" style="padding:10px; border:1px solid #ccc;">
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
						
						<div style="margin-top:15px" class="form-group">
							<div class="col-sm-12 controls">
								<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
									<!--<a href="javascript:void(0)" onClick="btnSolicitudDerechoRevision()" class="btn btn-sm btn-success">Registrar</a>-->
									<input class="btn btn-sm btn-success float-rigth" value="REGISTRAR" name="guardar" type="button" id="btnSolicitudReintegro" style="padding-left:25px;padding-right:25px;margin-left:10px;margin-top:15px" />
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

<script src="{{ asset('js/derecho_revision/listaReintegro.js') }}"></script>

@endpush
