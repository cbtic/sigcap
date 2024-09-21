<title>Sistema </title>

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
		let date = new Date()
		let day = date.getDate()
		let month = date.getMonth() + 1
		let year = date.getFullYear()

		if (month < 10) {
			$('#txtFechaIni').val(`${day}-0${month}-${year}`);
			//console.log('${day}-0${month}-${year}')
		} else {
			//console.log('${day}-${month}-${year}')
			$('#txtFechaIni').val(`${day}-${month}-${year}`);
		}
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

	function pad(str, max) {
		str = str.toString();
		return str.length < max ? pad("0" + str, max) : str;
	}

	function reformatDateString(s) {
		var b = s.split(/\D/);
		return b.reverse().join('/');
	}

	function sumarDias(fecha, dias) {
		fecha.setDate(fecha.getDate() + dias);
		return fecha;
	}

	function FormatFecha(fecha) {
		//let date = new Date()
		let date = new Date(fecha)
		let day = date.getDate()
		let month = date.getMonth() + 1
		let year = date.getFullYear()

		let fechaFormat
		if (month < 10) {
			fechaFormat = `${day}-0${month}-${year}`
		} else {
			fechaFormat = `${day}-${month}-${year}`
		}
		return fechaFormat;
	}

	var cuentaproductos = 0;

	function generarConceptoNuevo() {
		
		var cantidad = $("#tblConceptos tr").length;
		//alert(cantidad);
		//if (cantidad > 1) $("#tblConceptos tr").remove();
		//if (cantidad > 1) $("#tblConceptos").querySelector("tbody").innerHTML="";
		//if (cantidad > 1) document.getElementById("tblConceptos").querySelector("tbody").innerHTML="";
		//this.getElementById("tblConceptos").querySelector("tbody").innerHTML="";
		//alert(cantidad);

		var n = 0;
		var nroCuotas = $('#cboCuotas').val();
		//$("#tblConceptos tr").remove(); 

		var total_frac = $('#txtTotalFrac').val();
		var porcentaje = $('#txtPorcentaje').val();
		var cuota_uno = 0;
		var fecha_cuota = $('#txtFechaIni').val();

		n++;
		cuota_uno = parseFloat((total_frac * porcentaje) / 100).toFixed(1);
		//fecha_cuota = reformatDateString($('#txtFechaIni').val());

		var d = new Date();
		//alert(FormatFecha(sumarDias(d, -5)));


		$('#tblConceptos tbody').html("");
		$("#divGuardar").hide();

		/*
		$('#tblConceptos tbody tr').after('<tr id="fila' + pad(n, 2) + '"> <td width="5%">' + n + '</td> <td td width="10%"> ' + fecha_cuota + ' </td> <td width="55%">' + $("#denominacion").val() + '- Fraccionado ' + n + '</td> <td width="10%">SOLES</td> <td width="20%">' + cuota_uno + '</td></tr>');

		$('#tblConceptos tbody tr').after('<td> <input type="hidden" name="fraccionamiento[' + n + '][fecha_cuota]" value="' + fecha_cuota + '"> </td>');
		$('#tblConceptos tbody tr').after('<td> <input type="hidden" name="fraccionamiento[' + n + '][denominacion]" value="' + $("#denominacion").val() + '- Fraccionado ' + n + '"> </td>');
		$('#tblConceptos tbody tr').after('<td> <input type="hidden" name="fraccionamiento[' + n + '][total_frac]" value="' + cuota_uno + '"> </td>');
		*/
		var total_frac_dif = total_frac - cuota_uno;

		//alert(total_frac_dif);

		total_frac = parseFloat((total_frac_dif) / (nroCuotas - 1)).toFixed(1);

		var total_coutas = 0;
		
		for (let i = 0; i < nroCuotas - 1; i++) {

			total_coutas+= Number(total_frac);
			
			/*
			n++;
			fecha_cuota = FormatFecha(sumarDias(d, 30))
			$('#tblConceptos tr:last').after('<tr id="fila' + pad(n, 2) + '"> <td width="5%">' + n + '</td> <td width="10%">' + fecha_cuota + '</td>  <td width="55%">' + $("#denominacion").val() + '- Fraccionado ' + n + '</td> <td width="10%">SOLES</td> <td width="20%">' + total_frac + '</td></tr>');

			$('#tblConceptos tr:last').after('<td> <input type="hidden" name="fraccionamiento[' + n + '][fecha_cuota]" value="' + fecha_cuota + '"> </td>');
			$('#tblConceptos tr:last').after('<td> <input type="hidden" name="fraccionamiento[' + n + '][denominacion]" value="' + $("#denominacion").val() + '- Fraccionado ' + n + '"> </td>');
			$('#tblConceptos tr:last').after('<td> <input type="hidden" name="fraccionamiento[' + n + '][total_frac]" value="' + total_frac + '"> </td>');
			*/
		}

		//alert(total_coutas.toFixed(1));
		total_coutas=total_coutas.toFixed(1);

		var total_diferencia = total_frac_dif - total_coutas;
		
		
		var newRow = "";
		for (let i = 0; i < nroCuotas; i++) {
			newRow = "";
			if(i == 0){
				newRow+='<tr>';
				newRow+='<td width="5%">' + n + '</td> <td td width="10%"> ' + fecha_cuota + ' </td> <td width="55%">' + $("#denominacion").val() + '- Fraccionado ' + n + '</td> <td width="10%">SOLES</td> <td width="20%">' + cuota_uno + '</td></tr>';
				newRow+='<td> <input type="hidden" name="fraccionamiento[' + n + '][fecha_cuota]" value="' + fecha_cuota + '"> </td>';
				newRow+='<td> <input type="hidden" name="fraccionamiento[' + n + '][denominacion]" value="' + $("#denominacion").val() + '- Fraccionado ' + n + '"> </td>';
				newRow+='<td> <input type="hidden" name="fraccionamiento[' + n + '][total_frac]" value="' + cuota_uno + '"> </td>';
				newRow+='</tr>';
			}else{

				if (i==(nroCuotas-1)){
					total_frac = Number(total_frac) + Number(total_diferencia);
					total_frac = total_frac.toFixed(1);
				}
				
				fecha_cuota = FormatFecha(sumarDias(d, 30));

				fecha_cuota= ultimoDiaDelMesDeFecha(fecha_cuota);



				newRow+='<tr>';
				newRow+='<tr id="fila' + pad(n, 2) + '"> <td width="5%">' + n + '</td> <td width="10%">' + fecha_cuota + '</td>  <td width="55%">' + $("#denominacion").val() + '- Fraccionado ' + n + '</td> <td width="10%">SOLES</td> <td width="20%">' + total_frac + '</td></tr>';
				newRow+='<td> <input type="hidden" name="fraccionamiento[' + n + '][fecha_cuota]" value="' + fecha_cuota + '"> </td>';
				newRow+='<td> <input type="hidden" name="fraccionamiento[' + n + '][denominacion]" value="' + $("#denominacion").val() + '- Fraccionado ' + n + '"> </td>';
				newRow+='<td> <input type="hidden" name="fraccionamiento[' + n + '][total_frac]" value="' + total_frac + '"> </td>';
				newRow+='</tr>';
			}
			n++;
			//alert(newRow);
			$('#tblConceptos tbody').append(newRow);
			$("#divGuardar").show();
		}

		function ultimoDiaDelMesDeFecha(fecha) {
			// Separar la fecha en día, mes y año
			let [dia, mes, año] = fecha.split('-').map(Number);

			// Obtener el último día del mes
			let ultimoDia = new Date(año, mes, 0).getDate();

			// Formatear el resultado en d/m/Y
			return `${ultimoDia}-${mes}-${año}`;
		}

		
		//$('#btnFraciona').attr("disabled",true);

		//$('#cboCuotas').attr("disabled",true);
		//$('#txtPorcentaje').attr("disabled",true);
		//$('#txtFechaIni').attr("disabled",true);


		//cuentaproductos = cuentaproductos + 1;
		//alert(cuentaproductos);
		//$('#tblConceptos tr:last').after('<tr id="fila' + pad(cuentaproductos, 2) + '"><td class="text-right">#</td></tr>');

		
		


	}

	function eliminaFila(fila) {
		if (fila > 1) {
			cuentaproductos = cuentaproductos - 1;
			$('#fila' + pad(fila, 2)).remove();
		} else {
			$('#producto01').val("");
			$('#producto01').attr("readonly", false);
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
										Fraccionar Deuda
									</strong>
								</div>

								<form class="form-horizontal" method="post" action="" id="frmFracionaDeuda" autocomplete="off">

									<div class="card-body" style="padding:5px!important;">

										<div class="row">

											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

												<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
												<input type="hidden" name="id_persona" id="id_persona" value="<?php echo $id_persona ?>">
												<input type="hidden" name="id_agremiado" id="id_agremiado" value="<?php echo $id_agremiado ?>">
												<input type="hidden" name="total_fraccionar" id="total_fraccionar" value="<?php echo $total_fraccionar ?>">


												<input type="hidden" name="id_concepto" id="id_concepto" value="<?php echo $concepto["id"] ?>">
												<input type="hidden" name="denominacion" id="denominacion" value="<?php echo $concepto["denominacion"] ?>">
												<input type="hidden" name="id_moneda" id="id_moneda" value="<?php echo $concepto["id_moneda"] ?>">

												<?php
												
												foreach ($comprobanted as $key => $row) :	
													//print_r($row);
												?>
													
													<input type="hidden" name="valorizacion[<?php echo $key ?>][id]" value="<?php echo $row['id'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][fecha]" value="<?php echo $row['fecha'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][denominacion]" value="<?php echo $row['denominacion'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][monto]" value="<?php echo $row['monto'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][pu]" value="<?php echo $row['pu'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][igv]" value="<?php echo $row['igv'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][pv]" value="<?php echo $row['pv'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][total]" value="<?php echo $row['total']  ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][moneda]" value="<?php echo $row['moneda']  ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][id_moneda]" value="<?php echo $row['id_moneda']  ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][abreviatura]" value="<?php echo $row['abreviatura']  ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][cantidad]" value="<?php echo $row['cantidad']  ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][descuento]" value="<?php echo $row['descuento']  ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][cod_contable]" value="<?php echo $row['cod_contable']  ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][descripcion]" value="<?php echo $row['descripcion'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][vencio]" value="<?php echo $row['vencio'] ?>" />
													<input type="hidden" name="valorizacion[<?php echo $key ?>][id_concepto]" value="<?php echo $row['id_concepto'] ?>" />
													
													

												<?php
												endforeach;
												?>

												<div class="row" style="padding-left:10px">
													<div class="card-body">
														<div class="row">
															<div class="col-lg-2">
																<div class="form-group form-group-sm">
																	<label class="form-control-sm">Nro Cuotas</label>
																	<!--<select name="cboCuotas" id="cboCuotas" class="form-control form-control-sm" onchange="cargarValorizacion()">-->
																<!--		
																	<select name="cboCuotas" id="cboCuotas" class="form-control form-control-sm">
																		<option value="3" selected>03 meses</option>
																		<option value="6">06 meses</option>
																		<option value="9">09 meses</option>
																		<option value="12">12 meses</option>
																		<option value="24">24 meses</option>
																		<option value="36">36 meses</option>
																	</select>
											-->
																	<select id="cboCuotas" name="cboCuotas" class="form-control form-control-sm">
																		<option value="">Seleccione una opción</option>
																		<?php
																		// Generar las opciones de 2 a 99 con PHP
																		for ($i = 2; $i <= 99; $i++) {
																			// Por ejemplo, si quieres que la cuota 12 esté seleccionada por defecto:
																			if ($i == 12) {
																				echo "<option value='$i' selected>$i cuotas</option>";
																			} else {
																				echo "<option value='$i'>$i cuotas</option>";
																			}
																		}
																		?>
																	</select>

																</div>
															</div>
															<div class="col-lg-2">
																<div class="form-group form-group-sm">
																	<label class="form-control-sm">Total Fraccionar</label>
																	<input type="text" readonly name="txtTotalFrac" id="txtTotalFrac" value="<?php echo $total_fraccionar //$valorizacion[0]->monto?>" class="form-control form-control-sm">																	
																</div>
															</div>

															

															<div class="col-lg-2">
																<div class="form-group">
																	<label class="form-control-sm">Porcentaje 1° Couta</label>
																	<input type="text" name="txtPorcentaje" id="txtPorcentaje" value="20" placeholder="" class="form-control form-control-sm">
																</div>
															</div>

															<div class="col-lg-2">
																<div class="form-group">
																	<label class="form-control-sm">Fecha Inicio</label>
																	<input type="text" name="txtFechaIni" id="txtFechaIni" value="" placeholder="" class="form-control form-control-sm">
																</div>
															</div>

															<div class="col-lg-2" style="padding-top:12px;padding-left:0px;padding-right:0px">
																<br>
																<button type="button" id="btnFraciona" name="btnFraciona" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#vehiculoModal" onclick="generarConceptoNuevo(cuentaproductos)">
																	<i class="fas fa-plus-circle"></i> Fraccionar
																</button>
															</div>

														</div>

														<?php $seleccionar_todos = "style='display:block'"; ?>
														<div class="table-responsive overflow-auto" style="max-height: 500px">
															<table id="tblConceptos" class="table table-hover table-sm">
																<thead>
																	<tr style="font-size:13px">
																		<th>Id</th>
																		<th>Fecha</th>
																		<th>Denominación</th>
																		<th>Moneda</th>
																		<th>Importe</th>
																	</tr>
																	

																</thead>
																<tbody style="font-size:13px">

																</tbody>
															</table>
														</div>
													</div>

												</div>
												<div style="margin-top:15px" class="form-group">
													<div id ="divGuardar" class="col-sm-12 controls" style="display:none">
														<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
															<a href="javascript:void(0)" onClick="guardar_fracciona_deuda()" class="btn btn-sm btn-success">Guardar</a>
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

		@push('after-scripts')

		<script src="{{ asset('js/ingreso.js') }}"></script>

		@endpush