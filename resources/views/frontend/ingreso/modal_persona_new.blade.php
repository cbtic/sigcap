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
		max-width: 50% !important
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


	$(document).ready(function() {
		$(".upload").on('click', function() {
			var formData = new FormData();
			var files = $('#image')[0].files[0];
			formData.append('file', files);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "/persona/upload",
				type: 'post',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response) {
					if (response != 0) {
						$("#img_ruta").attr("src", "/img/frontend/tmp/" + response);
						$("#img_foto").val(response);
					} else {
						alert('Formato de imagen incorrecto.');
					}
				}
			});
			return false;
		});

		$(".delete").on('click', function() {
			$("#img_ruta").attr("src", "/dist/img/profile-icon.png");
			$("#img_foto").val("");
		});

	});

	function fn_save() {

		var _token = $('#_token').val();
		var id = $('#id').val();
		var tipo_documento = $('#tipo_documento_').val();
		var numero_documento = $('#numero_documento_').val();
		var apellido_paterno = $('#apellido_paterno_').val();
		var apellido_materno = $('#apellido_materno_').val();
		var nombres = $('#nombres_').val();
		var codigo = $('#codigo_').val();
		var ocupacion = $('#ocupacion_').val();
		var telefono = $('#telefono_').val();
		var ruc = $('#ruc_').val();
		var email = $('#email_').val();
		var observacion = $('#observacion_').val();
		var img_foto = $('#img_foto').val();
		var flag_negativo = 0;

		if ($("#flag_negativo_").is(':checked')) flag_negativo = 1;

		$.ajax({
			url: "/persona/send_persona",
			type: "POST",
			data: {
				_token: _token,
				id: id,
				tipo_documento: tipo_documento,
				numero_documento: numero_documento,
				apellido_paterno: apellido_paterno,
				apellido_materno: apellido_materno,
				nombres: nombres,
				codigo: codigo,
				ocupacion: ocupacion,
				telefono: telefono,
				email: email,
				ruc: ruc,
				flag_negativo: flag_negativo,
				observacion: observacion,
				img_foto: img_foto
			},
			dataType: 'json',
			success: function(result) {
				if (result.sw == false) {
					bootbox.alert(result.msg);
				}

				$('#openOverlayOpc').modal('hide');
				datatablenew();
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

							<form method="post" action="#" enctype="multipart/form-data">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="id" id="id" value="<?php echo $id ?>">

								<div class="row">
									<?php
									$readonly = $id > 0 ? "readonly='readonly'" : '';
									$disabled = $id > 0 ? "disabled='disabled'" : '';
									?>

									<div class="col-lg-7">
										<div class="col-lg-12">
											<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
												<label class="form-control-sm">Tipo Documento</label>

												<select name="tipo_documento_" id="tipo_documento_" class="form-control form-control-sm" onchange="">
													<?php
													foreach ($tipo_documento as $row) { ?>
														<option value="<?php echo $row->codigo ?>" <?php if ($row->codigo == "85") echo "selected='selected'" ?>><?php echo $row->denominacion ?></option>
													<?php
													}
													?>
												</select>

											</div>
										</div>

										<div class="col-lg-12">
											<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
												<label class="control-label">N. Documento</label>												
												<input id="numero_documento_" name="numero_documento_" class="form-control form-control-sm" value="" type="text" <?php echo $readonly ?>>
											</div>
										</div>

									</div>

								</div>

								<div style="padding-left:15px">
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
												<label class="control-label">Apellido Paterno</label>
												<input id="apellido_paterno_" name="apellido_paterno_" class="form-control form-control-sm" value="" type="text" readonly>
											</div>
										</div>

									</div>

									<div class="row">

										<div class="col-lg-12">
											<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
												<label class="control-label">Apellido Materno</label>
												<input id="apellido_materno_" name="apellido_materno_" class="form-control form-control-sm" value="" type="text" readonly>
											</div>
										</div>

									</div>

									<div class="row">

										<div class="col-lg-12">
											<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
												<label class="control-label">Nombres</label>
												<input id="nombres_" name="nombres_" class="form-control form-control-sm" value="" type="text" readonly>
											</div>
										</div>

									</div>


									<div style="margin-top:10px" class="form-group">
										<div class="col-sm-12 controls">
											<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions" style="float:right">
												<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
											</div>

										</div>
									</div>

								</div>

						</div>
					</div>
				</div>

			</div>

			</section>

		</div>


		<script type="text/javascript">
			function validaDni(dni) {
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

						$('#apellido_paterno_').val('')
						$('#apellido_materno_').val('')
						$('#nombres_').val('')
						$('#codigo_').val('')
						$('#ocupacion_').val('')
						$('#telefono_').val('')
						$('#email_').val('')

						$('#apellido_paterno_').val(data.apellido_paterno);
						$('#apellido_materno_').val(data.apellido_materno);
						$('#nombres_').val(data.nombres);

						//alert(data.nombre_o_razon_social);

					} else {
						bootbox.alert("DNI Invalido,... revise el DNI digitado ¡");
						return false;
					}

				});
			}

			function validaTipoDocumento() {
				var tipo_documento = $("#tipo_documento_").val();

				$('#numero_documento_').val("");
				$('#apellido_paterno_').val("");
				$('#apellido_materno_').val("");
				$('#nombres_').val("");
				$('#codigo_').val("");
				$('#ocupacion_').val("");
				$('#telefono_').val("");
				$('#email_').val("");


				if (tipo_documento == "DNI") {
					$('#apellido_paterno_').attr('readonly', true);
					$('#apellido_materno_').attr('readonly', true);
					$('#nombres_').attr('readonly', true);
				} else {
					$('#apellido_paterno_').attr('readonly', false);
					$('#apellido_materno_').attr('readonly', false);
					$('#nombres_').attr('readonly', false);
				}

			}
		</script>