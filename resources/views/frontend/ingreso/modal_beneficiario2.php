<title>Sistema de CAP - Lima</title>

<style>
	/*
.table-fixed thead,
.table-fixed tfoot{
  width: 97%;
}

.table-fixed tbody {
  height: 230px;
  overflow-y: auto;
  width: 100%;
}

.table-fixed thead,
.table-fixed tbody,
.table-fixed tfoot,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
  display: block;
}

.table-fixed tbody td,
.table-fixed thead > tr> th,
.table-fixed tfoot > tr> td{
  float: left;
  border-bottom-width: 0;
}
*/
	/*****************/
	.modal-dialog {
		min-width: 70%;
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

	#myInput1 {
		background-image: url('/css/searchicon.png');
		background-position: 10px 10px;
		background-repeat: no-repeat;
		width: 100%;
		font-size: 16px;
		padding: 12px 20px 12px 40px;
		border: 1px solid #ddd;
		margin-bottom: 12px;
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

	/*
tr:nth-child(2n) {
    background: none repeat scroll 0 0 #edebeb;
}  
*/

	#tablemodalm {
		/*
	width: 30em;
	overflow-x: auto;
	white-space: nowrap;
	*/

		/*background-color: #fed9ff; 
      width: 600px; 
      height: 150px; 
      overflow-x: hidden;
      overflow-y: auto; 
      text-align: center; 
      padding: 20px;*/
	}

	/*
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
}
*/
	fieldset.scheduler-border {
		border: solid 2px #c6c8ca !important;
		padding: 0 10px 10px 10px;
		border-bottom: none;
		width: 100%;
		color: #6c757d;
		font-weight: bold;
		margin: 15px 0px 10px 0px
	}

	legend.scheduler-border {
		width: auto !important;
		border: none;
		font-size: 14px;
	}

	/*********************************************************/
	.switch {
		position: relative;
		display: inline-block;
		width: 42px;
		height: 24px;
	}

	/* Hide default HTML checkbox */
	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	/* The slider */
	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #337ab7;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 18px;
		width: 18px;
		left: 0px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked+.slider {
		background-color: #4cae4c;
	}

	input:focus+.slider {
		box-shadow: 0 0 1px #4cae4c;
	}

	input:checked+.slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}

	.no {
		padding-right: 3px;
		padding-left: 0px;
		display: block;
		width: 20px;
		float: left;
		font-size: 11px;
		text-align: right;
		padding-top: 5px
	}

	.si {
		padding-right: 0px;
		padding-left: 3px;
		display: block;
		width: 20px;
		float: left;
		font-size: 11px;
		text-align: left;
		padding-top: 5px
	}
</style>

<script type="text/javascript">
	$(document).ready(function() {

	});

	function cargar_calificacion() {

		var id_ingreso_vehiculo = $('#id_ingreso_vehiculo').val();
		var id = $('#id').val();
		var opc = $('#opc').val();
		var flag_agrupar = 0;
		if ($('#flag_agrupar_').is(":checked")) flag_agrupar = 1;

		$("#divCalificacion").html("");
		$.ajax({
			url: "/supervision/cargar_calificacion/" + id + "/" + id_ingreso_vehiculo + "/" + flag_agrupar + "/" + opc,
			type: "GET",
			success: function(result) {
				$("#divCalificacion").html(result);
			}
		});
	}

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

	function guardarCita__() {
		alert("fdssf");
	}

	function guardarCita(id_medico, fecha_cita) {

		var msg = "";
		var id_ipress = $('#id_ipress').val();
		var id_consultorio = $('#id_consultorio').val();
		var fecha_atencion = $('#fecha_atencion').val();
		var dni_beneficiario = $("#dni_beneficiario").val();
		//alert(id_ipress);
		if (dni_beneficiario == "") msg += "Debe ingresar el numero de documento <br>";
		if (id_ipress == "") {
			msg += "Debe ingresar una Ipress<br>";
		}
		if (id_consultorio == "") {
			msg += "Debe ingresar un Consultorio<br>";
		}
		if (fecha_atencion == "") {
			msg += "Debe ingresar una fecha de atencion<br>";
		}

		if (msg != "") {
			bootbox.alert(msg);
			return false;
		} else {
			fn_save_cita(id_medico, fecha_cita);
		}
	}

	function fn_save_cita(id_medico, fecha_cita) {
		/*
	var tipodoc_beneficiario = $('#tipodoc_beneficiario').val();
	var nrodocafiliado = $('#nrodocafiliado').val();
	var nrodocafiliado = $('#nrodocafiliado').val();
    var id_ipress = $('#id_ipress').val();
    var id_consultorio = $('#id_consultorio').val();
	*/
		var fecha_atencion_original = $('#fecha_atencion').val();

		$.ajax({
			url: "registrar_cita",
			type: "POST",
			//data:{id_medico:id_medico,id_ipress:id_ipress,id_consultorio:id_consultorio,fecha_atencion:fecha_cita},
			data: $("#frmCita").serialize() + "&id_medico=" + id_medico + "&fecha_cita=" + fecha_cita,
			success: function(result) {
				$('#openOverlayOpc').modal('hide');
				//parent.$('#idMaestroPersona').val(result);
				//parent.obtenerinformacionpersona();

				/*
				var date = new Date();
				var d = date.getDate();
				var m = date.getMonth();
				var y = date.getFullYear();
				fullCalendar();
				*/
				//$('#calendar').fullCalendar({ events: "cronograma_cita",    });
				$('#calendar').fullCalendar("refetchEvents");
				modalDelegar(fecha_atencion_original);

			}
		});
	}


	function validarLiquidacion() {

		var msg = "";
		var sw = true;

		var saldo_liquidado = $('#saldo_liquidado').val();
		var estado = $('#estado').val();

		if (saldo_liquidado == "") msg += "Debe ingresar un saldo liquidado <br>";
		if (estado == "") msg += "Debe ingresar una observacion <br>";

		if (msg != "") {
			bootbox.alert(msg);
			//return false;
		} else {
			//submitFrm();
			document.frmLiquidacion.submit();
		}
		return false;
	}
</script>

<script>
	function myFunction() {
		var input, filter, table, tr, td, i, txtValue;
		input = document.getElementById("myInput");
		filter = input.value.toUpperCase();
		table = document.getElementById("tblConceptos");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[0];
			if (td) {
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
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

				<div class="card-body" style="padding:5px!important;">

					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

							<div class="card">
								<div class="card-header">
									<strong>
										Otros Pagos
									</strong>
								</div>

								<form class="form-horizontal" method="post" action="" id="frmOtroPago" autocomplete="off">

									<div class="card-body" style="padding:5px!important;">

										<div class="row">

											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

												<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">


												<input type="hidden" name="id_persona" id="id_persona" value="<?php echo $id_persona ?>">
												<input type="hidden" name="id_agremiado" id="id_agremiado" value="<?php echo $id_agremiado ?>">
												<input type="hidden" name="periodo" id="periodo" value="<?php echo $periodo ?>">
												<input type="hidden" name="tipo_documento" id="tipo_documento" value="<?php echo $tipo_documento ?>">

												<div class="row" style="padding-left:10px">
													<!--
													<div class="col-lg-12">
														<div class="form-group">
															<label class="control-label form-control-sm">N° Doc. / Nombre</label>
															<input id="nombres_o" name="nombres_o" on class="form-control form-control-sm" value="" type="text" readonly>
														</div>
													</div>
-->
													<div class="card-body">
														<div class="row">

															<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
																<div class="form-group">
																	<input type="text" name="myInput" id="myInput" onkeyup="myFunction()" placeholder="Buscar..." class="form-control form-control-sm">
																</div>
															</div>.
<!--
															<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12" style="padding-top:0px;padding-left:0px;padding-right:0px">

																<button type="button" id="btnBuscar" name="btnBuscar" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#vehiculoModal" onclick="generarConceptoNuevo(cuentaproductos)">
																	<i class="fa fa-search-plus"></i> Buscar
																</button>
															</div>
-->
														</div>

														<div class="table-responsive overflow-auto" style="max-height: 500px">
															<table id="tblConceptos" class="table table-hover table-sm">
																<thead>
																	<tr style="font-size:13px">
																		<th style="text-align: center; padding-bottom:0px;padding-right:5px;margin-bottom: 0px; vertical-align: middle">
																		</th>
																		<th>Código</th>
																		<th>Denominación</th>
																		<th>Moneda</th>
																		<th>Importe</th>
																	</tr>
																</thead>
																<tbody style="font-size:13px">
																	<?php
																	$total = 0;
																	$descuento = 0;
																	$valor_venta_bruto = 0;
																	$valor_venta = 0;
																	$igv = 0;

																	foreach ($conceptos as $key => $row) :
																		$monto = $row->importe;
																		$stotal = str_replace(",", "", number_format($monto / 1.18, 1));
																		$igv_   = str_replace(",", "", number_format($stotal * 0.18, 1));
																	?>
																		<tr style="font-size:13px">
																			<td class="text-center">
																				<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																					<input type="checkbox" class="mov_" name="concepto_detalles[<?php echo $key ?>][id]" value="<?php echo $row->id ?>" onchange="calcular_total_(this)" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][id]" value="<?php echo $row->id ?>" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][codigo]" value="<?php echo $row->codigo ?>" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][denominacion]" value="<?php echo $row->denominacion ?>" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][importe]" value="<?php echo $row->importe ?>" />

																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][pu]" value="<?php echo $row->importe ?>" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][igv]" value="<?php echo $igv_ ?>" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][pv]" value="<?php echo $stotal ?>" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][total]" value="<?php echo $row->importe ?>" />

																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][moneda]" value="<?php echo $row->moneda ?>" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][id_moneda]" value="<?php echo $row->id_moneda ?>" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][cantidad]" value="1" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][descuento]" value="" />
																					<input type="hidden" name="concepto_detalle[<?php echo $key ?>][centro_costo]" value="centro_costo" />

																				</div>
																			</td>

																			<td class="text-left"><?php echo $row->codigo ?></td>
																			<td class="text-left"><?php echo $row->denominacion ?></td>
																			<td class="text-left"><?php echo $row->moneda ?></td>
																			<td class="text-right val_total_">
																				<span class="val_total"><?php echo $row->importe ?></span>
																			</td>


																		</tr>
																	<?php
																	//$total += $row->importe;	
																	endforeach;
																	?>

																	<tr>
																		<th colspan="4" style="text-align:right;padding-right:55px!important;padding-bottom:0px;margin-bottom:0px"> Total</th>
																		<td style="padding-bottom:0px;margin-bottom:0px">
																			<input type="text" readonly name="total_concepto_" id="total_concepto_" value="" class="form-control form-control-sm text-right" />
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>

												</div>
												<div style="margin-top:15px" class="form-group">
													<div class="col-sm-12 controls">
														<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
															<a href="javascript:void(0)" onClick="guardar_concepto_valorizacion()" class="btn btn-sm btn-success">Guardar</a>
														</div>

													</div>
												</div>
											</div>
										</div>
									</div>
								</form>

							</div>

						</div>


					</div>
				</div>
			</div>

			</section>

		</div>