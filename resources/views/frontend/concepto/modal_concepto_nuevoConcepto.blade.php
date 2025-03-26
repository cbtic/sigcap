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
  height:250px;
}


.modal-dialog {
	width: 100%;
	max-width:40%!important
  }

#tablemodal{
    border-spacing: 0;
    display: flex;/*Se ajuste dinamicamente al tamano del dispositivo**/
    max-height: 80vh; /*El alto que necesitemos**/
    overflow-y: auto; /**El scroll verticalmente cuando sea necesario*/
    overflow-x: hidden;/*Sin scroll horizontal*/
    table-layout: fixed;/**Forzamos a que las filas tenga el mismo ancho**/
    width: 98vw; /*El ancho que necesitemos*/
    border:1px solid #c4c0c9;
}

#tablemodal thead{
    background-color: #e2e3e5;
    position: fixed !important;
}


#tablemodal th{
    border-bottom: 1px solid #c4c0c9;
    border-right: 1px solid #c4c0c9;
}

#tablemodal th{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 10px;
	font-weight:bold;
    height: 3.5vh !important;
	line-height:12px;
	vertical-align:middle;
	/*height:20px;*/
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal td{
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

#tablemodal tbody tr:hover td, #tablemodal tbody tr:hover th {
  /*background-color: red!important;*/
  font-weight:bold;
  /*mix-blend-mode: difference;*/
  
}

#tablemodalm{
	
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

input:checked + .slider {
  background-color: #4cae4c;
}

input:focus + .slider {
  box-shadow: 0 0 1px #4cae4c;
}

input:checked + .slider:before {
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

.no {padding-right:3px;padding-left:0px;display:block;width:100px;float:left;font-size:14px;text-align:right;padding-top:5px}
.si {padding-right:0px;padding-left:3px;display:block;width:100px;float:left;font-size:14px;text-align:left;padding-top:5px}

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


$(document).ready(function() {

	$("#partida_presupuestal").select2({ width: '100%' });
	$("#id_tipo_afectacion").select2({ width: '100%' });
	$("#id_centro_costo").select2({ width: '100%' });
	$("#id_tipo_concepto").select2({ width: '100%' });
	$("#cuenta_contable_debe").select2({ width: '100%' });
	$("#cuenta_contable_al_haber1").select2({ width: '100%' });
	$("#cuenta_contable_al_haber2").select2({ width: '100%' });
});

function valida(){
	
	var msg = "0";

	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_regional = $('#id_regional').val();
	var id_tipo_concepto = $('#id_tipo_concepto').val();
	var denominacion = $('#denominacion').val();
	var importe = $('#importe').val();
	var id_moneda = $('#id_moneda').val();
	var periodo = $('#periodo').val();
	var partida_presupuestal = $('#partida_presupuestal').val();
	var id_tipo_afectacion = $('#id_tipo_afectacion').val();
	var centro_costo = $('#id_centro_costo').val();
	var genera_pago = $('#genera_pago').val();

	if (id_regional==""){
		msg= "Falta seleccionar la Regional";
	}else if (id_tipo_concepto==""){
		msg= "Falta seleccionar el Tipo de Concepto";
	}else if (denominacion==""){
		msg= "Falta ingresar la Denominaci&oacute;n";
	}else if (importe==""){
		msg= "Falta ingresar el Importe";
	}else if (id_moneda==""){
		msg= "Falta seleccionar la Moneda";
	}else if (periodo==""){
		msg= "Falta ingresar el Periodo";
	}else if (partida_presupuestal==""){
		msg= "Falta ingresar la Partida Presupuestal";
	}else if (id_tipo_afectacion==""){
		msg= "Falta seleccionar el Tipo de Afectaci&oacute;n";
	}else if (centro_costo==""){
		msg= "Falta ingresar el Centro de Costos";
	}else if (genera_pago==""){
		msg= "Falta ingresar Genera Pago";
	}

	if(genera_pago==1 && importe == "0" ){
		msg= "El importe no puede ser 0 cuando el concepto genera pago";
	}

	if (msg=="0"){
		fn_save_concepto()		
	}
	else {
		Swal.fire(msg);
	}

}

function fn_save_concepto(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	//var codigo = $('#codigo').val();
	var id_regional = $('#id_regional').val();
	var id_tipo_concepto = $('#id_tipo_concepto').val();
	var denominacion = $('#denominacion').val();
	var importe = $('#importe').val();
	var id_moneda = $('#id_moneda').val();
	var periodo = $('#periodo').val();
	var cuenta_contable_debe = $('#cuenta_contable_debe').val();
	var cuenta_contable_al_haber1 = $('#cuenta_contable_al_haber1').val();
	var cuenta_contable_al_haber2 = $('#cuenta_contable_al_haber2').val();
	var partida_presupuestal = $('#partida_presupuestal').val();
	var id_tipo_afectacion = $('#id_tipo_afectacion').val();
	var centro_costo = $('#id_centro_costo').val();
	var genera_pago = $('#genera_pago').val();
	
	
    $.ajax({
			url: "/concepto/send_concepto_nuevoConcepto",
            type: "POST",
            data : {_token:_token,id:id,id_regional:id_regional,id_tipo_concepto:id_tipo_concepto,denominacion:denominacion,importe:importe,id_moneda:id_moneda,periodo:periodo,cuenta_contable_debe:cuenta_contable_debe,cuenta_contable_al_haber1:cuenta_contable_al_haber1,cuenta_contable_al_haber2:cuenta_contable_al_haber2,partida_presupuestal:partida_presupuestal,id_tipo_afectacion:id_tipo_afectacion,centro_costo:centro_costo,genera_pago:genera_pago},
            success: function (result) {
				
				$('#openOverlayOpc').modal('hide');
				window.location.reload();
				datatablenew();
				
            }
    });
}

</script>


<body class="hold-transition skin-blue sidebar-mini">
	<div class="panel-heading close-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div>
		<div class="justify-content-center">		
			<div class="card">
				<div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
					Registro de Concepto
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
					
							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" id="id" value="<?php echo $id?>">
							<div class="row" style="padding-left:10px">
								<div class="col-lg-3">
									<div class="form-group">
										<label class="control-label form-control-sm">C&oacute;digo</label>
										<input id="codigo" name="codigo" class="form-control form-control-sm"  value="<?php echo $concepto->codigo?>" type="text" readonly="readonly" >						
									</div>
								</div>
								<div class="col-lg-5">
									<div class="form-group">
										<label class="control-label form-control-sm">Regional</label>
										<select name="id_regional" id="id_regional" class="form-control form-control-sm" onChange="">
											<option value="">--Selecionar--</option>
												<?php
												foreach ($region as $row) {?>
													<option value="<?php echo $row->id?>" <?php if($row->id=='5')echo "selected='selected'"?>><?php echo $row->denominacion?></option>
												<?php
												}
												?>
										</select>
									</div>
								</div>
								<div class="col-lg-10">
									<div class="form-group">
										<label class="control-label form-control-sm">Tipo Concepto</label>
										<select name="id_tipo_concepto" id="id_tipo_concepto" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
											<?php
												foreach ($tipoConcepto as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id==$concepto->id_tipo_concepto)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
											<?php 
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-10">
									<div class="form-group">
										<label class="control-label form-control-sm">Denominaci&oacute;n</label>
										<input id="denominacion" name="denominacion" class="form-control form-control-sm"  value="<?php echo $concepto->denominacion?>" type="text" >													
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label class="control-label form-control-sm">Importe</label>
										<input id="importe" name="importe" class="form-control form-control-sm"  value="<?php echo $concepto->importe?>" type="text" >
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label class="control-label form-control-sm">Moneda</label>
										<select name="id_moneda" id="id_moneda" class="form-control form-control-sm" onChange="">
											<option value="">--Selecionar--</option>
											<?php
											foreach ($moneda as $row) {?>
											<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$concepto->id_moneda)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label class="control-label form-control-sm">Periodo</label>
										<input id="periodo" name="periodo" class="form-control form-control-sm"  value="<?php echo $concepto->periodo?>" type="text" >
									</div>
								</div>
								
								<div class="col-lg-5">
									<div class="form-group">
										<label class="control-label form-control-sm">Cuenta Contable Debe</label>
										<select name="cuenta_contable_debe" id="cuenta_contable_debe" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
											<?php
												foreach ($concepto_cuenta_debe as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id==$concepto->cuenta_contable_debe)echo "selected='selected'"?>><?php echo $row->cuenta?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								<div class="col-lg-5">
									<div class="form-group">
										<label class="control-label form-control-sm">Cuenta Contable al Haber1</label>
										<select name="cuenta_contable_al_haber1" id="cuenta_contable_al_haber1" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
											<?php
												foreach ($concepto_cuenta_haber1 as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id==$concepto->cuenta_contable_al_haber1)echo "selected='selected'"?>><?php echo $row->cuenta?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								<div class="col-lg-5">
									<div class="form-group">
										<label class="control-label form-control-sm">Cuenta Contable al Haber2</label>
										<select name="cuenta_contable_al_haber2" id="cuenta_contable_al_haber2" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
											<?php
												foreach ($concepto_cuenta_haber2 as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id==$concepto->cuenta_contable_al_haber2)echo "selected='selected'"?>><?php echo $row->cuenta?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-5">
									<div class="form-group">
										<label class="control-label form-control-sm">Partida Presupuestal</label>
										<select name="partida_presupuestal" id="partida_presupuestal" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
											<?php
												foreach ($partidaPresupuestal as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id==$concepto->partida_presupuestal)echo "selected='selected'"?>><?php echo $row->codigo?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-5">
									<div class="form-group">
										<label class="control-label form-control-sm">Tipo Afectaci&oacute;n</label>
										<select name="id_tipo_afectacion" id="id_tipo_afectacion" class="form-control form-control-sm" onChange="">
											<option value="">--Selecionar--</option>
											<?php
												foreach ($id_tipo_afectacion as $row) {?>
												<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$concepto->id_tipo_afectacion)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-5">
									<div class="form-group">
										<label class="control-label form-control-sm">Centro de Costos</label>
										<select name="id_centro_costo" id="id_centro_costo" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
											<?php
												foreach ($centroCosto as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id==$concepto->centro_costo)echo "selected='selected'"?>><?php echo $row->codigo?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-2 col-sm-12 col-xs-12">
									<label class="control-label form-control-sm">Genera Pago</label>
									<select name="genera_pago" id="genera_pago" class="form-control form-control-sm">
										<option value="" <?php if(''==$concepto->genera_pago)echo "selected='selected'"?>>--Selecciona Genera Pago--</option>
										<option value="1" <?php if('1'==$concepto->genera_pago)echo "selected='selected'"?>>Si</option>
										<option value="0" <?php if('0'==$concepto->genera_pago)echo "selected='selected'"?>>No</option>
									</select>
								</div>
						
					</div>
					
					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="valida()" class="btn btn-sm btn-success">Guardar</a>
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



</script>

