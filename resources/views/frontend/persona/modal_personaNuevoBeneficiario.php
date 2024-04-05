<title>Sistema </title>

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
		max-width: 25% !important
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


	.btn-file {
		position: relative;
		overflow: hidden;
	}

	.btn-file input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		min-width: 100%;
		min-height: 100%;
		font-size: 100px;
		text-align: right;
		filter: alpha(opacity=0);
		opacity: 0;
		outline: none;
		background: white;
		cursor: inherit;
		display: block;
	}
</style>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />


<script type="text/javascript">
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


	//$(document).ready(function() {
		
		var id_tipo_documento = "<?php echo $id_tipo_documento?>";
		//alert(id_tipo_documento);
		if(id_tipo_documento=="78")
		{
			//alert("ok");
			validaDni();

		}
		else{

		}


		/*
		$('#numero_documento').blur(function() {

			//alert(this.value);
			var id = $('#id').val();
			if (id == 0) {
				validaDni(this.value);
			}
		});
		*/


	//});

	function validaDni() {

		var dni = $('#frmPersona2 #numero_documento').val();

		var settings = {
			"url": "https://apiperu.dev/api/dni/" + dni,
			"method": "GET",
			"timeout": 0,
			"headers": {
				"Authorization": "Bearer 20b6666ddda099db4204cf53854f8ca04d950a4eead89029e77999b0726181cb"
			},
		};

		$.ajax(settings).done(function(response) {
			console.log(response);

			if (response.success == true) {

				var data = response.data;

				$('#apellido_paterno').val('')
				$('#apellido_materno').val('')
				$('#nombres').val('')
				//$('#codigo_').val('')
				//$('#ocupacion_').val('')
				//$('#telefono_').val('')
				//$('#email_').val('')

				$('#apellido_paterno').val(data.apellido_paterno);
				$('#apellido_materno').val(data.apellido_materno);
				$('#nombres').val(data.nombres);

				//alert(data.nombre_o_razon_social);

			} else {
				bootbox.alert("DNI Invalido,... revise el DNI digitado ¡");
				return false;
			}

		});
	}
	
	function guardarBeneficiario() {

		var _token = $('#_token').val();
		var id = $('#frmPersona2 #id').val();
		var tipo_documento = $('#frmPersona2 #tipo_documento').val();
		var numero_documento = $('#frmPersona2 #numero_documento').val();
		var ruc = $('#numero_documento').val();
		var apellido_paterno = $('#frmPersona2 #apellido_paterno').val();
		var apellido_materno = $('#frmPersona2 #apellido_materno').val();
		var nombres = $('#frmPersona2 #nombres').val();
		var celular = $('#frmPersona2 #celular').val();
		var correo = $('#frmPersona2 #correo').val();
		var fecha_nacimiento = $('#frmPersona2 #fecha_nacimiento').val();
		var sexo = $('#frmPersona2 #sexo').val();
		
		/*
		var codigo = $('#codigo_').val();
		var ocupacion = $('#ocupacion_').val();
		var telefono = $('#telefono_').val();
		var ruc = $('#ruc_').val();
		var email = $('#email_').val();
		var observacion = $('#observacion_').val();
		var img_foto = $('#img_foto').val();
		var flag_negativo = 0;

		if ($("#flag_negativo_").is(':checked')) flag_negativo = 1;
*/
		$.ajax({
			url: "/persona/send_persona_newBeneficiario",
			type: "POST",
			data: {
				_token: _token,
				id: id,
				tipo_documento: tipo_documento,
				numero_documento: numero_documento,
				apellido_paterno: apellido_paterno,
				apellido_materno: apellido_materno,
				nombres: nombres,
				celular:celular,
				correo:correo,
				fecha_nacimiento:fecha_nacimiento,
				sexo:sexo,
				ruc:ruc
			},
			//dataType: 'json',
			success: function(result) {
				//alert("guardado..");
				/*
				if (result.sw == false) {
					bootbox.alert(result.msg);
				}
				*/

				$('#openOverlayOpc').modal('hide');
				//window.location.reload();


				//datatablenew();
			}
		});
	}
</script>


<body class="hold-transition skin-blue sidebar-mini">

	<div>

		<div class="justify-content-center">

			<div class="card">

				<div class="card-header" style="padding:5px!important;padding-left:20px!important">
					Ingrese los datos del Nueva Persona
				</div>

				<div class="card-body">

					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">

							<form method="post" id="frmPersona2" action="#" enctype="multipart/form-data">
								<!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
								<meta name="_token" content="{{ csrf_token() }}">

								<input type="hidden" name="id" id="id" value="0">

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">

											<select name="tipo_documento" id="tipo_documento" class="form-control form-control-sm" onChange="validaTipoDocumento();" readonly>
												<?php
												foreach ($tipo_documento as $row) { ?>
													<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == $id_tipo_documento) echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
												<?php
												}
												?>
											</select>

										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:10px;margin-bottom:0px">
											<input id="numero_documento" name="numero_documento" class="form-control form-control-sm" placeholder="Número Documento" onBlur="validaDni()" value="<?php echo $numero_documento ?>" type="text" readonly>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:10px;margin-bottom:0px">
											<input id="apellido_paterno" name="apellido_paterno" class="form-control form-control-sm" placeholder="Apellido Paterno" value="" type="text" readonly>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:10px;margin-bottom:0px">
											<input id="apellido_materno" name="apellido_materno" class="form-control form-control-sm" placeholder="Apellido Materno" value="" type="text" readonly>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:10px;margin-bottom:0px">
											<input id="nombres" name="nombres" class="form-control form-control-sm" placeholder="Nombres" value="" type="text" readonly>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:10px;margin-bottom:0px">
											<input id="celular" name="celular" class="form-control form-control-sm" placeholder="Celular" value="" type="text" >
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:10px;margin-bottom:0px">
											<input id="correo" name="correo" class="form-control form-control-sm" placeholder="Correo" value="" type="text" >
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:10px;margin-bottom:0px">
											<input placeholder="fecha_nacimiento" type="date" id="fecha_nacimiento" class="form-control form-control-sm" placeholder="Fecha Nacimiento" value="" type="text">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:10px;margin-bottom:0px">										
											<select name="sexo" id="sexo" class="form-control form-control-sm" onChange="">
												<option value="">--Selecionar Género--</option>
												<?php
												foreach ($sexo as $row) { ?>
													<option value="<?php echo $row->codigo ?>"> <?php echo $row->denominacion ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>



									<div style="margin-top:10px" class="form-group">
										<div class="col-sm-12 controls">
											<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions" style="float:right">
												<a href="javascript:void(0)" onClick="guardarBeneficiario()" class="btn btn-sm btn-success">Guardar</a>
											</div>
										</div>
									</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript">

		function validaTipoDocumento() {
			var tipo_documento = $("#tipo_documento").val();

			$('#numero_documento').val("");
			$('#apellido_paterno').val("");
			$('#apellido_materno').val("");
			$('#nombres').val("");
			/*
		$('#codigo').val("");
		$('#ocupacion').val("");
		$('#telefono').val("");
		$('#email').val("");
*/

			if (tipo_documento == "DNI") {
				$('#apellido_paterno').attr('readonly', true);
				$('#apellido_materno').attr('readonly', true);
				$('#nombres').attr('readonly', true);
			} else {
				$('#apellido_paterno').attr('readonly', false);
				$('#apellido_materno').attr('readonly', false);
				$('#nombres').attr('readonly', false);
			}

		}
	</script>