<title>Sistema de CAP - Lima</title>

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
		max-width: 92% !important
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

	#tablemodalm {}
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
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
		//$('#hora_solicitud').focus();
		$('#hora_solicitud').mask('00:00');
		//$("#id_empresa").select2({ width: '100%' });
	});
</script>

<script type="text/javascript">
	$('#openOverlayOpc').on('shown.bs.modal', function() {
		$('#fecha_solicitudxx').datepicker({
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



	});

	function validacion() {

		var msg = "";
		var cobservaciones = $("#frmComentar #estado_").val();

		if (cobservaciones == "") {
			msg += "Debe ingresar una Observacion <br>";
		}

		if (msg != "") {
			bootbox.alert(msg);
			return false;
		}
	}




	function fn_save() {
		var msg = "";
		var _token = $('#_token').val();
		var id = $('#id_per_det').val();
		var id_persona = $('#id').val();


		var direccion = $('#direccion_').val();
		var ubigeo = $('#ubigeodireccionprincipal').val();
		//alert(ubigeo); exit();
		var telefono = $('#telefono_').val();
		var email = $('#email_').val();
		var fecha_ingreso = $('#fecha_ingreso_').val();
		var id_condicion_laboral = $('#id_condicion_laboral_').val();
		var id_tipo_planilla = $('#id_tipo_planilla_').val();
		var id_profesion = $('#id_profesion_').val();
		var id_banco_sueldo = $('#id_banco_sueldo_').val();
		var num_cuenta_sueldo = $('#num_cuenta_sueldo_').val();
		var cci_sueldo = $('#cci_sueldo_').val();
		var id_regimen_pensionario = $('#id_regimen_pensionario_').val();
		var id_afp = $('#id_afp_').val();
		var fecha_afiliacion_afp = $('#fecha_afiliacion_afp_').val();
		var id_tipo_comision_afp = $('#id_tipo_comision_afp_').val();
		var cuspp = $('#cuspp_').val();
		var fecha_cese = $('#fecha_cese_').val();
		var fecha_termino_contrato = $('#fecha_termino_contrato_').val();
		var num_contrato = $('#num_contrato_').val();
		var id_cargo = $('#id_cargo_').val();
		var id_nivel = $('#id_nivel_').val();
		var id_banco_cts = $('#id_banco_cts_').val();
		var num_cuenta_cts = $('#num_cuenta_cts_').val();
		var id_moneda_cts = $('#id_moneda_cts_').val();
		var estado = $('#estado_').val();
		var id_ubicacion = $('#id_ubicacion_').val();

		var tipo_documento = $('#tipo_documento_').val();
		var numero_documento = $('#numero_documento_').val();
		var fecha_nacimiento = $('#fecha_nacimiento_').val();
		var sexo = $('#sexo_').val();

		var id_area_trabajo = $('#id_area_trabajo_').val();
		var id_unidad_trabajo = $('#id_unidad_trabajo_').val();

		if (tipo_documento == "0") msg += "Debe ingresar el Tipo de Documento <br>";
		if (numero_documento == "") {
			msg += "Debe ingresar el Número de Documento <br>";
		}
		if (fecha_nacimiento == "") {
			msg += "Debe ingresar Fecha de Nacimiento <br>";
		}
		if (sexo == "0") {
			msg += "Debe ingresar el Genero del personal <br>";
		}
		if (id_ubicacion == "0") {
			msg += "Debe ingresar la Empresa Asociada al Personal <br>";
		}
		if (id_regimen_pensionario == "0") {
			msg += "Debe ingresar el Régimen Pensionario<br>";
		}
		if (id_condicion_laboral == "0") {
			msg += "Debe ingresar la Condición Laboral <br>";
		}
		if (id_area_trabajo == "") {
			msg += "Debe ingresar el Area de Trabajo <br>";
		}
		if (id_unidad_trabajo == "") {
			msg += "Debe ingresar la Unidad de Trabajo <br>";
		}

		var edad = calcularEdad(fecha_nacimiento);
		if (edad < 18) {
			msg += "El personal es Menor de Edad: " + edad + "<br>";
		}



		if (estado == "0") {
			msg += "Debe ingresar el Estado Laboral <br>";
		}

		if (msg != "") {
			bootbox.alert(msg);
			return false;
		} else {
			$.ajax({
				url: "/persona/send_personad",
				type: "POST",
				data: {
					_token: _token,
					id: id,
					id_persona: id_persona,
					direccion: direccion,
					ubigeo: ubigeo,
					telefono: telefono,
					email: email,
					fecha_ingreso: fecha_ingreso,
					id_condicion_laboral: id_condicion_laboral,
					id_tipo_planilla: id_tipo_planilla,
					id_profesion: id_profesion,
					id_banco_sueldo: id_banco_sueldo,
					num_cuenta_sueldo: num_cuenta_sueldo,
					cci_sueldo: cci_sueldo,
					id_regimen_pensionario: id_regimen_pensionario,
					id_afp: id_afp,
					fecha_afiliacion_afp: fecha_afiliacion_afp,
					id_tipo_comision_afp: id_tipo_comision_afp,
					cuspp: cuspp,
					fecha_cese: fecha_cese,
					fecha_termino_contrato: fecha_termino_contrato,
					num_contrato: num_contrato,
					id_cargo: id_cargo,
					id_nivel: id_nivel,
					id_banco_cts: id_banco_cts,
					num_cuenta_cts: num_cuenta_cts,
					id_moneda_cts: id_moneda_cts,
					estado: estado,
					id_ubicacion: id_ubicacion,
					fecha_nacimiento: fecha_nacimiento,
					sexo: sexo,
					id_area_trabajo: id_area_trabajo,
					id_unidad_trabajo: id_unidad_trabajo
				},
				success: function(result) {
					$('#openOverlayOpc').modal('hide');
					datatablenew();
				}
			});
		}
	}

	function fn_liberar(id) {

		//var id_estacionamiento = $('#id_estacionamiento').val();
		var _token = $('#_token').val();

		$.ajax({
			url: "/estacionamiento/liberar_asignacion_estacionamiento_vehiculo",
			type: "POST",
			data: {
				_token: _token,
				id: id
			},
			success: function(result) {
				$('#openOverlayOpc').modal('hide');
				cargarAsignarEstacionamiento();
			}
		});
	}
</script>


<body class="hold-transition skin-blue sidebar-mini">

	<div>
		<!--
        <section class="content-header">
          <h1>
            <small style="font-size: 20px">Programados del Medicos del dia <?php //echo $fecha_atencion
																			?></small>
          </h1>
        </section>
		-->
		<div class="justify-content-center">

			<div class="card">

				<div class="card-header" style="padding:5px!important;padding-left:20px!important">
					Asignacion de Cuentas
				</div>

				<div class="card-body">
					<div id="general" class="tab-pane fade in active" style="opacity:100">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="id" id="id" value="<?php echo $id ?>">

						<div class="row">

							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">

									<label class="control-label">Cuenta</label>
									<select name="cuenta" id="cuenta" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($plan_contable as $row) { ?>
											<option value="<?php echo $row->id ?>" <?php if ($row->id == $asignacion->id_plan_contable) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php } ?>
										@error('cuenta') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group form-group-sm">
									<label class="form-control-sm">Denominación</label>
									<input type="text" name="denominacion" id="denominacion" value="<?php echo $asignacion->denominacion ?>" class="form-control form-control-sm">
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">

									<label class="control-label">Tipo</label>
									<select name="tipo_cuenta" id="tipo_cuenta" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($tipo_cuenta as $row) { ?>
											<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $asignacion->id_tipo_cuenta) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php } ?>
										@error('tipo_cuenta') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">

									<label class="control-label">Centro Costos</label>
									<select name="centro_costo" id="centro_costo" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($centro_costo as $row) { ?>
											<option value="<?php echo $row->id ?>" <?php if ($row->id == $asignacion->id_centro_costo) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php } ?>
										@error('centro_costo') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">

									<label class="control-label">Partida Presupuestal</label>
									<select name="partida_presupuestal" id="partida_presupuestal" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($partida_presupuestal as $row) { ?>
											<option value="<?php echo $row->id ?>" <?php if ($row->id == $asignacion->id_partida_presupuestal) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php } ?>
										@error('partida_presupuestal') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group form-group-sm">
									<label class="form-control-sm">Origen</label>
									<input type="text" name="origen" id="origen" value="<?php echo $asignacion->id_origen ?>" class="form-control form-control-sm">
								</div>
							</div>

						</div>

						<div class="row">


							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Estado</label>
									<select name="estado" id="estado" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<option value="A" <?php if ($asignacion->estado == "A") echo "selected='selected'" ?>><?php echo "ACTIVO" ?></option>
										<option value="C" <?php if ($asignacion->estado == "C") echo "selected='selected'" ?>><?php echo "CESADO" ?></option>
									</select>
									@error('estado') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
						</div>

						<div style="margin-top:10px;float:right" class="form-group">
							<div class="col-sm-12 controls">
								<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
									<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
								</div>

							</div>
						</div>
					</div>


					<!-- /.box -->
				</div>
				<!--/.col (left) -->
			</div>
			<!-- /.row -->
			<!-- </section> -->
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
	</div>



	<script type="text/javascript">
		$(document).ready(function() {



		});
	</script>