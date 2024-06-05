<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Sistema SIGCAP</title>

<style>
	/*
.datepicker {
  z-index: 1600 !important; 
}
*/
	/*.datepicker{ z-index:99999 !important; }*/

	.datepicker,
	.table-condensed {
		width: 250px;
		height: 250px;
	}


	.modal-dialog {
		width: 100%;
		max-width: 60% !important
	}

	#tablemodal {
		border-spacing: 0;
		display: flex;
		/*Se ajuste dinamicamente al tamano del dispositivo**/
		max-height: 80vh;
		/*El alto que necesitemos**/
		overflow-y: auto;
		/**El scroll verticalmente cuando sea necesario*/
		overflow-x: hidden;
		/*Sin scroll horizontal*/
		table-layout: fixed;
		/**Forzamos a que las filas tenga el mismo ancho**/
		width: 98vw;
		/*El ancho que necesitemos*/
		border: 1px solid #c4c0c9;
	}

	#tablemodal thead {
		background-color: #e2e3e5;
		position: fixed !important;
	}


	#tablemodal th {
		border-bottom: 1px solid #c4c0c9;
		border-right: 1px solid #c4c0c9;
	}

	#tablemodal th {
		font-weight: normal;
		margin: 0;
		max-width: 9.5vw;
		min-width: 9.5vw;
		word-wrap: break-word;
		font-size: 10px;
		font-weight: bold;
		height: 3.5vh !important;
		line-height: 12px;
		vertical-align: middle;
		/*height:20px;*/
		padding: 4px;
		border-right: 1px solid #c4c0c9;
	}

	#tablemodal td {
		font-weight: normal;
		margin: 0;
		max-width: 9.5vw;
		min-width: 9.5vw;
		word-wrap: break-word;
		font-size: 11px;
		height: 3.5vh !important;
		padding: 4px;
		border-right: 1px solid #c4c0c9;
	}

	#tablemodal tbody tr:hover td,
	#tablemodal tbody tr:hover th {
		/*background-color: red!important;*/
		font-weight: bold;
		/*mix-blend-mode: difference;*/

	}

</style>

<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>-->
<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->


<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->


<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->

<!--
<script src="resources/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<link rel="stylesheet" href="resources/plugins/timepicker/bootstrap-timepicker.min.css">
-->

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css">
-->

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js" integrity="sha512-r/mHP22LKVhxWFlvCpzqMUT4dWScZc6WRhBMVUQh+SdofvvM1BS1Hdcy94XVOod7QqQMRjLQn5w/AQOfXTPvVA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.css" integrity="sha512-HWqapTcU+yOMgBe4kFnMcJGbvFPbgk39bm0ExFn0ks6/n97BBHzhDuzVkvMVVHTJSK5mtrXGX4oVwoQsNcsYvg==" crossorigin="anonymous" />
-->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>-->
<script type="text/javascript">
	/*
jQuery(function($){
$.mask.definitions['H'] = "[0-1]";
$.mask.definitions['h'] = "[0-9]";
$.mask.definitions['M'] = "[0-5]";
$.mask.definitions['m'] = "[0-9]";
$.mask.definitions['P'] = "[AaPp]";
$.mask.definitions['p'] = "[Mm]";
});
*/
	$(document).ready(function() {
		$("#nombre_proyecto").select2({ width: '100%' });
		//$('#hora_solicitud').focus();
		//$('#hora_solicitud').mask('00:00');
		//$("#id_empresa").select2({ width: '100%' });
	});
</script>

<script type="text/javascript">
	$('#openOverlayOpc').on('shown.bs.modal', function() {
		$('#fecha_solicitud').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			//container: '#openOverlayOpc modal-body'
			container: '#openOverlayOpc modal-body'
		});
		/*
	 $('#hora_solicitud').timepicker({
		showInputs: false,
		container: '#openOverlayOpc modal-body'
	});
	*/

	});

	$(document).ready(function() {

		/*if($('#id_tipo').val() =="0"){
			$('#nombre_proyecto_').hide();
			$('#tipo_tramite_').hide();
		}*/
		
		
		obtenerTipoCertificado();

	});

	function validacion() {

		var msg = "";
		var cobservaciones = $("#frmComentar #cobservaciones").val();

		if (cobservaciones == "") {
			msg += "Debe ingresar una Observacion <br>";
		}

		if (msg != "") {
			bootbox.alert(msg);
			return false;
		}
	}

	function obtenerTipoCertificado(){
	
	var id_tipo = $("#id_tipo").val();

	$('#nombre_proyecto_').hide();
	$('#tipo_tramite_').hide();
	$('#tipo_tramite_certificado3_').hide();
	$('#n_pisos_').hide();
	$('#sotanos_').hide();
	$('#semisotanos_').hide();
	$('#piso_nivel_').hide();
	$('#total_area_techada_').hide();
	
	if (id_tipo == "0")//SELECCIONAR
	{
		$('#nombre_proyecto_').hide();
		$('#tipo_tramite_').hide();
		$('#tipo_tramite_certificado3_').hide();
		$('#n_pisos_').hide();
		$('#sotanos_').hide();
		$('#semisotanos_').hide();
		$('#piso_nivel_').hide();
		$('#otro_piso_nivel_').hide();
		$('#total_area_techada_').hide();
	}else if (id_tipo == "1")//CERTIFICADO TIPO 1
	{
		$('#nombre_proyecto_').show();
		$('#tipo_tramite_').hide();
		//$('#nombre_proyecto_').show();
		$('#tipo_tramite').val('0');
		$('#tipo_tramite_certificado3_').hide();
		$('#n_pisos_').show();
		$('#sotanos_').show();
		$('#semisotanos_').show();
		$('#piso_nivel_').show();
		$('#otro_piso_nivel_').show();
		$('#total_area_techada_').show();

	}else if (id_tipo == "2") //CERTIFICADO TIPO 2
	{
		$('#nombre_proyecto_').show();
		$('#tipo_tramite_').hide();
		//$('#nombre_proyecto_').show();
		$('#tipo_tramite').val('0');
		$('#tipo_tramite_certificado3_').hide();
		$('#n_pisos_').hide();
		$('#sotanos_').hide();
		$('#semisotanos_').hide();
		$('#piso_nivel_').hide();
		$('#otro_piso_nivel_').hide();
		$('#total_area_techada_').hide();
	}else if (id_tipo == "3") //CERTIFICADO TIPO 3
	{
		$('#nombre_proyecto_').show();
		$('#tipo_tramite_').hide();
		//$('#nombre_proyecto_').show();
		$('#tipo_tramite').val('0');
		$('#tipo_tramite_certificado3_').show();
		$('#n_pisos_').hide();
		$('#sotanos_').hide();
		$('#semisotanos_').hide();
		$('#piso_nivel_').hide();
		$('#otro_piso_nivel_').hide();
		$('#total_area_techada_').hide();
	}else if (id_tipo == "4") { //CERTIFICADO TIPO 4
		$('#nombre_proyecto_').hide(); 
		$('#tipo_tramite_').show();
		$('#vigencia_group').show();
		$('#nombre_proyecto').val('0');
		$('#tipo_tramite_certificado3_').hide();
		$('#n_pisos_').hide();
		$('#sotanos_').hide();
		$('#semisotanos_').hide();
		$('#piso_nivel_').hide();
		$('#otro_piso_nivel_').hide();
		$('#total_area_techada_').hide();
		//$('#tipo_tramite_').val('');
	}else if (id_tipo == "5") { //CONSTANCIA
		$('#nombre_proyecto_').hide(); 
		$('#tipo_tramite_').hide();
		$('#vigencia_group').hide();
		$('#nombre_proyecto').val('0');
		$('#tipo_tramite').val('');
		$('#tipo_tramite_certificado3_').hide();
		$('#n_pisos_').hide();
		$('#sotanos_').hide();
		$('#semisotanos_').hide();
		$('#piso_nivel_').hide();
		$('#otro_piso_nivel_').hide();
		$('#total_area_techada_').hide();
	}else if (id_tipo == "6"){ //RECORD DE PROYECTOS
		$('#nombre_proyecto_').hide(); 
		$('#tipo_tramite_').hide();
		$('#nombre_proyecto').val('0');
		$('#tipo_tramite').val('0');
		$('#vigencia_group').hide();
		$('#tipo_tramite_certificado3_').hide();
		$('#n_pisos_').hide();
		$('#sotanos_').hide();
		$('#semisotanos_').hide();
		$('#piso_nivel_').hide();
		$('#otro_piso_nivel_').hide();
		$('#total_area_techada_').hide();
	}else{ //seleccionar
		$('#nombre_proyecto_').hide(); 
		$('#tipo_tramite_').hide();
		$('#nombre_proyecto').val('0');
		$('#tipo_tramite').val('0');
		$('#tipo_tramite_certificado3_').hide();
		$('#n_pisos_').hide();
		$('#sotanos_').hide();
		$('#semisotanos_').hide();
		$('#piso_nivel_').hide();
		$('#otro_piso_nivel_').hide();
		$('#total_area_techada_').hide();
	}
}


	function fn_save() {

		var _token = $('#_token').val();
		var id = $('#id').val();
		var id_regional = 5;
		var idagremiado = $('#idagremiado_').val();
		var fecha_sol = $('#fecha_r_').val();
		var fecha_emi = $('#fecha_e_').val();
		var validez = $('#vigencia_').val();
		var ev = "";
		var codigo = $('#codigo_').val();
		var observaciones = $('#observacion_').val();
		var estado = 1;
		var tipo = $('#id_tipo').val();
		var nombre_proyecto = $('#nombre_proyecto').val();
		var id_proyecto = $('#id_proyecto').val();
		var tipo_tramite = $('#tipo_tramite').val();
		var tipo_tramite_tipo3 = $('#tipo_tramite_certificado3').val();
		var n_pisos = $('#n_pisos').val();
		var sotanos_m2 = $('#sotanos').val();
		var semisotano_m2 = $('#semisotanos').val();
		var piso_nivel_m2 = $('#piso_nivel').val();
		var otro_piso_nivel_m2 = $('#otro_piso_nivel').val();
		var total_area_techada_m2 = $('#total_area_techada').val();

		$.ajax({
			url: "/certificado/send_certificado",
			type: "POST",
			data: {
				_token: _token,
				id: id,
				id_regional: id_regional,
				observaciones: observaciones,
				estado: estado,
				observaciones: observaciones,
				codigo: codigo,
				ev: ev,
				fecha_emi: fecha_emi,
				validez: validez,
				fecha_sol: fecha_sol,
				tipo: tipo,
				tipo_tramite:tipo_tramite,
				id_proyecto:id_proyecto,
				nombre_proyecto:nombre_proyecto,
				idagremiado: idagremiado,
				tipo_tramite_tipo3:tipo_tramite_tipo3,
				n_pisos:n_pisos,
				sotanos_m2:sotanos_m2,
				semisotano_m2:semisotano_m2,
				piso_nivel_m2:piso_nivel_m2,
				otro_piso_nivel_m2:otro_piso_nivel_m2,
				total_area_techada_m2:total_area_techada_m2
			},
			//dataType: 'json',
			success: function(result) {
					Swal.fire("Se gener&oacute; el certificado correctamente. Puede imprimirlo en el bot&oacute;n Ver Certificado")
					$('#openOverlayOpc').modal('hide');
					//window.location.reload();
					datatablenew();
				//});

			}
		});
	}
	
	function obtenerNombreProyecto() {

	var ncap = $('#cap_').val();

	$.ajax({
		url: '/proyecto/obtener_proyecto/' + ncap,
		dataType: "json",
		success: function(result) {

			//print_r(result).exit();
			//alert(result);
			console.log(result);
			var option = "<option value='0'>--Seleccionar--</option>";
			$("#nombre_proyecto").html("");
			$("#id_proyecto").html("");
			var selected = "";
			$(result).each(function (ii, oo) {
				selected = "";
				if(id == oo.id)selected = "selected='selected'";
				option += "<option value='"+oo.id+"' "+selected+" >"+oo.nombre+"</option>";
			});
			$("#nombre_proyecto").html(option);
			$("#id_proyecto").html(option);
		}
	});
	}

	function obtenerAgremiado() {

		var ncap = $('#cap_').val();

		$.ajax({
			url: '/afiliacion_seguro/obtener_agremiado/' + ncap,
			dataType: "json",
			success: function(result) {
				//alert(result);
				console.log(result);

					$('#idagremiado_').val('');
					$('#nombre_').val('');
					$('#situacion_').val('');
					$('#email_').val('');
				//alert(result.situacion).exit();
				if(result.situacion=='HABILITADO'){
					$('#idagremiado_').val(result.id);
					$('#nombre_').val(result.nombre_completo);
					$('#situacion_').val(result.situacion);
					$('#email_').val(result.email);
					obtenerNombreProyecto();
				}else if (result.situacion=='FALLECIDO'){
					bootbox.alert("El Agremiado est&aacute; FALLECIDO");
				}else if (result.situacion=='REGIONAL'){
					bootbox.alert("El Agremiado pertenece a otra REGIONAL");
				}else if (result.situacion=='INHABILITADO'){
					bootbox.alert("El Agremiado est&aacute; INHABILITADO");
				}else if (result.situacion=='PROVINCIA'){
					bootbox.alert("El Agremiado est&aacute; en otra PROVINCIA");
				}else if (result.situacion=='EXTRANJERO'){
					bootbox.alert("El Agremiado est&aacute; en el EXTRANJERO");
				}
				
			}
		});
	}

	function valida_pago() {
		var idagremiado = $('#idagremiado_').val();
		var serie = $('#serie_').val();
		var numero = $('#numero_').val();
		var concepto = 1;

		$.ajax({
			url: '/certificado/valida_pago/' + idagremiado + "/" + serie + "/" + numero + "/" + concepto,
			dataType: "json",
			success: function(result) {
				//alert(result);
				console.log(result);

				$('#fecha_e_').val(result.fecha_e);
				$('#vigencia_').val(result.vigencia);
				$('#codigo_').val(result.codigo);

			}

		});

	}
</script>


<body class="hold-transition skin-blue sidebar-mini">

	<div>

		<div class="justify-content-center">

			<div class="card">

				<div class="card-header" style="padding:5px!important;padding-left:20px!important">
					Edici&oacute;n de Certificados
				</div>


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id ?>">


					<?php
					/*
						$readonly = $id > 0 ? "readonly='readonly'" : '';
						$readonly_ = $id > 0 ? '' : "readonly='readonly'";
						*/
					?>

					<div class="card-body" style="margin-top:1px;margin-bottom:1px">
						<div class="row">

							<div class="col-lg-2">
								<div class="form-group">
									<label class="form-control-sm">Nº CAP</label>
									<input type="text" name="cap_" id="cap_" value="<?php echo $cap_numero ?>" placeholder="" class="form-control form-control-sm">
								</div>
							</div>
							<div class="col-lg-2" style="padding-top:12px;padding-left:0px;padding-right:0px">
								<br>
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#vehiculoModal" onClick="obtenerAgremiado('<?php echo $id ?>')">
									Buscar
								</button>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label">Apellidos y Nombres</label>
									<input id="nombre_" name="nombre_" class="form-control form-control-sm" value="<?php echo $desc_cliente ?>" type="text" readonly>
									<input id="idagremiado_" name="idagremiado_" class="form-control form-control-sm" value="<?php echo $certificado->id_agremiado ?>" type="hidden" readonly>
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label">Situaci&oacute;n</label>
									<input id="situacion_" name="situacion_" class="form-control form-control-sm" value="<?php echo $situacion ?>" type="text" readonly>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Correo electr&oacute;nico</label>
									<input id="email_" readonly="readonly" name="email_" class="form-control form-control-sm" value="<?php echo $email1 ?>" type="text">
								</div>
							</div>

							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Fecha Registro</label>
									<input id="fecha_r_" name="fecha_r_" class="form-control form-control-sm" value="<?php if($certificado->fecha_solicitud!=""){echo date("Y-m-d",strtotime($certificado->fecha_solicitud));}else echo date('Y-m-d');?>" type="date" <?php echo $certificado->fecha_solicitud =! '' ? 'disabled' : ''; ?>>
								</div>
							</div>

							<div class="col-lg-4">
								<div class="form-group">
									<label class="control-label">Tipo de Certificado</label>
									<select name="id_tipo" id="id_tipo" class="form-control form-control-sm" onChange="obtenerTipoCertificado()" <?php echo ($certificado->id_tipo != '') ? 'disabled' : ''; ?>>
										<option value="0">--Selecionar--</option>
										<?php
										foreach ($tipo_certificado as $row) { ?>
											<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $certificado->id_tipo) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-lg-12">
								<div class="form-group" id="nombre_proyecto_">
									<label class="control-label">Nombre del Proyecto</label>
									<select name="nombre_proyecto" id="nombre_proyecto" class="form-control form-control-sm" onChange="">
									<select name="id_proyecto" id="id_proyecto" class="form-control form-control-sm" style="display: none;" onChange="">
										<!--<option value="">--Selecionar--</option>-->
									</select>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-lg-2">
								<div class="form-group" id="n_pisos_">
									<label class="control-label">N° de pisos o niveles</label>
									<input id="n_pisos" name="n_pisos" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="sotanos_">
									<label class="control-label">S&oacute;tano(s)(m2)</label>
									<input id="sotanos" name="sotanos" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="semisotanos_">
									<label class="control-label">Semis&oacute;tano(m2)</label>
									<input id="semisotanos" name="semisotanos" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="piso_nivel_">
									<label class="control-label">1er. Piso o Nivel(m2)</label>
									<input id="piso_nivel" name="piso_nivel" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="otro_piso_nivel_">
									<label class="control-label">Otros Pisos o Nivel(m2)</label>
									<input id="otro_piso_nivel" name="otro_piso_nivel" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="total_area_techada_">
									<label class="control-label">Total &Aacute;rea Techada(m2)</label>
									<input id="total_area_techada" name="total_area_techada" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
						</div>

						<!--<div class="row">

							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">Comprobante</label>
									<div class="row">
										<div class="col-lg-4">
											<div class="form-group">
												<input id="serie_" name="serie_" class="form-control form-control-sm" value="" type="text">
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group">
												<input id="numero_" name="numero_" class="form-control form-control-sm" value="" type="text">
											</div>
										</div>

										<div class="col-lg-2" style="padding-top:0px;padding-left:0px;padding-right:0px">

											<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#vehiculoModal" onClick="valida_pago()">
												Validar pago
											</button>
										</div>



									</div>

								</div>
							</div>

						</div>-->

						<div class="row">
							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label">Fecha Emision</label>
									<input id="fecha_e_" name="fecha_e_" class="form-control form-control-sm" value="<?php if($certificado->fecha_emision!=""){echo date("Y-m-d",strtotime($certificado->fecha_emision));}else echo date('Y-m-d'); ?>" type="date" readonly='readonly'>
								</div>
							</div>
							
							<div class="form-group" id="tipo_tramite_">
								<div class="col-lg-12">
									<label class="control-label">Tipo de Tramite</label>
									<select name="tipo_tramite" id="tipo_tramite" class="form-control form-control-sm" onChange="obtenerTipoCertificado()">
										<option value="0">--Selecionar--</option>
										<?php
										foreach ($tipo_tramite as $row) { ?>
											<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $certificado->id_tipo_tramite) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group" id="tipo_tramite_certificado3_">
								<div class="col-lg-12">
									<label class="control-label">Tipo de Tramite</label>
									<select name="tipo_tramite_certificado3" id="tipo_tramite_certificado3" class="form-control form-control-sm" onChange="obtenerTipoCertificado">
										<option value="0">--Selecionar--</option>
										<?php
										foreach ($tipo_tramite_tipo3 as $row) { ?>
											<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $certificado->id_tipo_tramite) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group" id="vigencia_group">
								<div class="col-lg-12">
									<label class="control-label">D&iacute;as Vigencia</label>
									<select name="vigencia_" id="vigencia_" class="form-control form-control-sm">
										<?php
										$valorSeleccionado = isset($certificado->dias_validez) ? $certificado->dias_validez : '30';
										?>
									<option value="" <?php echo ($valorSeleccionado == '') ? 'selected="selected"' : ''; ?>>--Dias Vigencia--</option>
									<option value="30" <?php echo ($valorSeleccionado == '30') ? 'selected="selected"' : ''; ?>>30 D&iacute;as</option>
									<option value="60" <?php echo ($valorSeleccionado == '60') ? 'selected="selected"' : ''; ?>>60 D&iacute;as</option>
									<option value="90" <?php echo ($valorSeleccionado == '90') ? 'selected="selected"' : ''; ?>>90 D&iacute;as</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<label class="control-label">Codigo</label>
									<input id="codigo_" name="codigo_" class="form-control form-control-sm" value="<?php echo $certificado->codigo ?>" type="text" readonly="readonly">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">Observaciones</label>
									<input id="observacion_" name="observacion_" class="form-control form-control-sm" value="<?php echo $certificado->observaciones ?>" type="textarea">
								</div>
							</div>
						</div>
						<div class="row">

							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
										<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>

									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
	<!-- /.box -->


	</div>
	<!--/.col (left) -->


	</div>
	<!-- /.row -->
	</section>
	<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<script type="text/javascript">
		$(document).ready(function() {

			$('#ruc_').blur(function() {
				var id = $('#id').val();
				if (id == 0) {
					validaRuc(this.value);
				}
				//validaRuc(this.value);
			});




		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			//$('#numero_placa').focus();
			//$('#numero_placa').mask('AAA-000');
			//$('#vehiculo_numero_placa').mask('AAA-000');


		});
	</script>