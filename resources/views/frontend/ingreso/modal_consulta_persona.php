<title>Sistema de CAP - Lima</title>

<style>

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

		$('#btnBuscar').click(function () {
			fn_ListarBusqueda();
		});

		$('#agremiado').keypress(function(e){
			if(e.which == 13) {
				fn_ListarBusqueda();
			}
		});

		$('#sexo').keypress(function(e){
			if(e.which == 13) {
				fn_ListarBusqueda();
			}
		});

		$('#numero_documento').keypress(function(e){
			if(e.which == 13) {
				fn_ListarBusqueda();
			}
		});

		$('#estado').keypress(function(e){
			if(e.which == 13) {
				fn_ListarBusqueda();
				return false;
			}
		});


	});



</script>

<script>


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
										Consulta de Personas
									</strong>
								</div>

								<form class="form-horizontal" method="post" action="" id="frmOtroPago" autocomplete="off">

									<div class="card-body" style="padding:5px!important;">

										<div class="row">

											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">

												<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">


												<input type="hidden" name="id_persona" id="id_persona" value="<?//php echo $id_persona ?>">


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

														<div class="col-lg-2">
															<div class="form-group">

																<select name="tipo_documento_m" id="tipo_documento_m" class="form-control form-control-sm" onchange="" >
																	<option value="">-Tipo Documento-</option>
																	<?php
																	foreach ($tipo_documento as $row) { ?>
																		<option value="<?php echo $row->codigo ?>"> <?php echo $row->denominacion ?></option>
																	<?php
																	}
																	?>
																</select>

															</div>
														</div>


														<div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
															<input class="form-control form-control-sm" id="numero_documento_m" name="numero_documento_m" placeholder="Numero Documento">
														</div>

														<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
															<input class="form-control form-control-sm" id="agremiado_m" name="agremiado_m" placeholder="Nombres">
														</div>

														<div class="col-lg-1">
															<div class="form-group">
																<select name="sexo_m" id="sexo_m" class="form-control form-control-sm">
																	<option value=""selected="selected">-Sexo-</option>
																	<option value="M">Masculino</option>
																	<option value="F">Femenino</option>
																</select>

															</div>
														</div>
														
														<div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
															<select name="estado_m" id="estado_m" class="form-control form-control-sm">
																<option value="">Todos</option>
																<option value="1" selected="selected">Activo</option>
																<option value="0">Eliminado</option>
															</select>
														</div>
														<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="padding-right:0px">
															<input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
														</div>


														</div>

														<div class="table-responsive overflow-auto" style="max-height: 500px">
															<table id="tblPersonas" class="table table-hover table-sm">
																<thead>
																<tr style="font-size:13px">
																	<th>Tipo Doc.</th>
																	<th>N&uacute;mero Doc.</th>
																	<th>N&uacute;mero CAP</th>
																	<th>Nombre</th>																																	
																	<th>Sexo</th>																	
																	<th>Estado</th>
																	<th>Acciones</th>
																</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
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