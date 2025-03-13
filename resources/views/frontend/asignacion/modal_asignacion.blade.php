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
		max-width: 40% !important
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

		$("#cuenta").select2({ 
			width: '100%',
			matcher: function(params, data) {

            if ($.trim(params.term) === '') {
                return data;
            }

            var text = data.text || '';

            var parts = text.split('-');
            var cuenta = parts[0] ? parts[0].trim() : '';

            if (cuenta.toUpperCase().startsWith(params.term.toUpperCase())) {
                return data;
            }

            return null;
        } 
		});
		$("#centro_costo").select2({ width: '100%' });
		$("#partida_presupuestal").select2({ width: '100%' });
		$("#medio_pago").select2({ width: '100%' });
		$("#codigo_financiero").select2({ width: '100%' });
		$("#origen").select2({ width: '100%' });

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

		var id = $('#id').val();

		var cuenta = $('#cuenta').val();

		//alert(cuenta);exit();

		var denominacion = $('#denominacion').val();
		var tipo_cuenta = $('#tipo_cuenta').val();
		var centro_costo = $('#centro_costo').val();
		var partida_presupuestal = $('#partida_presupuestal').val();
		var codigo_financiero = $('#codigo_financiero').val();
		var medio_pago = $('#medio_pago').val();
		var origen = $('#origen').val();
		var tipo_planilla = $('#tipo_planilla').val();
/*

		if (estado == "0") {
			msg += "Debe ingresar el Estado Laboral <br>";
		}
		*/

		if (msg != "") {
			bootbox.alert(msg);
			return false;
		} else {
			$.ajax({
				url: "/asignacion/send_asignacion",
				type: "POST",
				data: {
					_token: _token,
					id: id,
					cuenta: cuenta,
					denominacion: denominacion,
					tipo_cuenta: tipo_cuenta,
					centro_costo: centro_costo,
					partida_presupuestal: partida_presupuestal,
					codigo_financiero: codigo_financiero,
					medio_pago: medio_pago,
					origen: origen,
					tipo_planilla:tipo_planilla
				},
				success: function(result) {
					$('#openOverlayOpc').modal('hide');
					datatablenew();
				}
			});
		}
	}

	function generarDenominacion(){

		var cuenta = $('#cuenta option:selected').text();
		var cuenta_partes = cuenta.split('-');

		var cuenta_denominacion = cuenta_partes.length > 1 ? cuenta_partes.slice(1).join('-').trim():'';

		//alert(cuenta_denominacion);

		$('#denominacion').val(cuenta_denominacion);
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

							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="form-control-sm">Tipo Planilla</label>
									<select name="tipo_planilla" id="tipo_planilla" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($tipo_planilla as $row) { ?>
											<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $asignacion->id_tipo_planilla) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php } ?>
										@error('tipo_planilla') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="form-control-sm">Cuenta</label>
									<select name="cuenta" id="cuenta" class="form-control form-control-sm" onchange="generarDenominacion();">
										<option value="0">Seleccionar</option>
										<?php foreach ($plan_contable as $row) { ?>
											<option value="<?php echo $row->id ?>" <?php if ($row->id == $asignacion->id_plan_contable) echo "selected='selected'" ?>><?php echo $row->cuenta."-".$row->denominacion ?></option>
										<?php } ?>
										@error('cuenta') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="form-control-sm">Denominación</label>
									<input type="text" name="denominacion" id="denominacion" value="<?php echo $asignacion->denominacion ?>" class="form-control form-control-sm">
								</div>
							</div>
						
							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="form-control-sm">Tipo</label>
									<select name="tipo_cuenta" id="tipo_cuenta" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($tipo_cuenta as $row) { ?>
											<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $asignacion->id_tipo_cuenta) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
										<?php } ?>
										@error('tipo_cuenta') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="form-control-sm">Centro Costos</label>
									<select name="centro_costo" id="centro_costo" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($centro_costo as $row) { ?>
											<option value="<?php echo $row->id ?>" <?php if ($row->id == $asignacion->id_centro_costo) echo "selected='selected'" ?>><?php echo $row->codigo."-".$row->denominacion ?></option>
										<?php } ?>
										@error('centro_costo') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">

									<label class="form-control-sm">Partida Presupuestal</label>
									<select name="partida_presupuestal" id="partida_presupuestal" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($partida_presupuestal as $row) { ?>
											<option value="<?php echo $row->id ?>" <?php if ($row->id == $asignacion->id_partida_presupuestal) echo "selected='selected'" ?>><?php echo $row->codigo."-".$row->denominacion ?></option>
										<?php } ?>
										@error('partida_presupuestal') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="form-control-sm">Código Financiero</label>
									<select name="codigo_financiero" id="codigo_financiero" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($codigo_financiero as $row) { ?>
											<option value="<?php echo $row->id ?>" <?php if ($row->id == $asignacion->id_codigo_financiero) echo "selected='selected'" ?>><?php echo $row->codigo."-".$row->denominacion ?></option>
										<?php } ?>
										@error('codigo_financiero') <span ...>Dato requerido</span> @enderror
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">

									<label class="form-control-sm">Medio Pago</label>
									<select name="medio_pago" id="medio_pago" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($medio_pago as $row) { ?>
											<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $asignacion->id_medio_pago) echo "selected='selected'" ?>><?php echo $row->codigo."-".$row->denominacion ?></option>
										<?php } ?>
										@error('medio_pago') <span ...>Dato requerido</span> @enderror
									</select>

								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="form-control-sm">Origen</label>
									<select name="origen" id="origen" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<?php foreach ($origen as $row) { ?>
											<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $asignacion->id_origen) echo "selected='selected'" ?>><?php echo $row->codigo."-".$row->denominacion ?></option>
										<?php } ?>
										@error('codigo_financiero') <span ...>Dato requerido</span> @enderror
									</select>
								</div>
							</div>


<!--
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Estado</label>
									<select name="estado" id="estado" class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<option value="A" <//?php if ($asignacion->estado == "A") echo "selected='selected'" ?>><//?php echo "ACTIVO" ?></option>
										<option value="C" <//?php if ($asignacion->estado == "C") echo "selected='selected'" ?>><//?php echo "CESADO" ?></option>
									</select>
									@error('estado') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
										-->
						</div>

						<div style="margin-top:10px;float:right" class="form-group">
							<div class="col-sm-12 controls">
								<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
									<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success" style="margin-right: 15px;">Guardar</a>
									<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');window.location.reload();" class="btn btn-md btn-warning">Cerrar</a>
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