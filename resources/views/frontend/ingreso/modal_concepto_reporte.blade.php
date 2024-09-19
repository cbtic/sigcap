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
		min-width: 30%;
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

		$("#concepto_reporte").select2({ width: '100%' });

	});

	function reporteDeudaTotal(){

		var id_concepto = $('#concepto_reporte').val();
		var numero_cap = $('#numero_cap').val();

		if(id_concepto==''){id_concepto=0}

		var href = '/ingreso/reporte_deudas_total_pdf/'+numero_cap+'/'+id_concepto;
		window.open(href, '_blank');

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
										Seleccione un concepto
									</strong>
								</div>

								<form class="form-horizontal" method="post" action="" id="frmConceptoReporte" autocomplete="off">

									<div class="card-body" style="padding:5px!important;">

										<div class="row">

											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:10px">

												<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
												<input type="hidden" name="numero_cap" id="numero_cap" value="<?php echo $numero_cap ?>">

												<div class="row" style="padding-left:10px">
													<div class="col-lg-12">
														<div class="form-group">
															<label class="control-label form-control-sm">Concepto</label>
															<select name="concepto_reporte" id="concepto_reporte" class="form-control form-control-sm">
																<option value="">-- Selecionar Concepto --</option>
																<?php
																foreach ($concepto as $row) {
																	
																?>
																<option value="<?php echo $row->id?>"><?php echo $row->denominacion?></option>
																<?php
																}
																?>
															</select>
														</div>
													</div>
												</div>
												<div style="margin-top:15px" class="form-group">
													<div class="col-sm-12 controls">
														<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
														<a href="javascript:void(0)" onClick="reporteDeudaTotal()" class="btn btn-sm btn-success">Reporte</a>
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