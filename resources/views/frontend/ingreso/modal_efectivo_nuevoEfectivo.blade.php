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
	max-width:30%!important
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
	//$('#hora_solicitud').mask('00:00');
	//$("#id_empresa").select2({ width: '100%' });

	$("#concepto").select2({ width: '100%' });

});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
	$('#fecha_egresado').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
	});
});

$('#openOverlayOpc').on('shown.bs.modal', function() {
	$('#fecha').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
	});
});

$(document).ready(function() {
	 


});


function fn_save_efectivo(){
	
    $.ajax({
			url: "/ingreso/send_efectivo_nuevoEfectivo",
            type: "POST",
            data : $("#frmEfectivo").serialize(),
            success: function (result) {
				
				//$('#openOverlayOpc').modal('hide');
				//window.location.reload();
				datatablenew();
				bootbox.alert("Guardado exitosamente");
				limpiar();
				
            }
    });
}

var tipo_monedas = <?php echo json_encode(array_column($tipo_monedas, 'codigo')); ?>;

function limpiar(){

	tipo_monedas.forEach(codigo => {
		$(`#${codigo}`).val("0");
        $(`#${codigo}_`).val("0");
    });

	//$('#caja').val("");
	$('#importe_soles').val("0");
	$('#importe_dolares').val("0");
	$('#moneda').val(1);
	$('#total_').text("0");

}

/*function calculartotal(valor, posicion){

	var valor;
	var posicion;
	var total = 0;
	
	if(posicion == 1){
		cantidad = parseFloat($('#billetes10').val()) || 0;
		total = valor * cantidad;
		$('#billetes10_').val(total.toFixed(2));
	}
	if(posicion == 2){
		cantidad = parseFloat($('#billetes20').val()) || 0;
		total = valor * cantidad;
		$('#billetes20_').val(total.toFixed(2));
	}
	if(posicion == 3){
		cantidad = parseFloat($('#billetes50').val()) || 0;
		total = valor * cantidad;
		$('#billetes50_').val(total.toFixed(2));
	}
	if(posicion == 4){
		cantidad = parseFloat($('#billetes100').val()) || 0;
		total = valor * cantidad;
		$('#billetes100_').val(total.toFixed(2));
	}
	if(posicion == 5){
		cantidad = parseFloat($('#billetes200').val()) || 0;
		total = valor * cantidad;
		$('#billetes200_').val(total.toFixed(2));
	}
	if(posicion == 6){
		cantidad = parseFloat($('#moneda001').val()) || 0;
		total = valor * cantidad;
		$('#moneda001_').val(total.toFixed(2));
	}
	if(posicion == 7){
		cantidad = parseFloat($('#moneda005').val()) || 0;
		total = valor * cantidad;
		$('#moneda005_').val(total.toFixed(2));
	}
	if(posicion == 8){
		cantidad = parseFloat($('#moneda010').val()) || 0;
		total = valor * cantidad;
		$('#moneda010_').val(total.toFixed(2));
	}
	if(posicion == 9){
		cantidad = parseFloat($('#moneda020').val()) || 0;
		total = valor * cantidad;
		$('#moneda020_').val(total.toFixed(2));
	}
	if(posicion == 10){
		cantidad = parseFloat($('#moneda050').val()) || 0;
		total = valor * cantidad;
		$('#moneda050_').val(total.toFixed(2));
	}
	if(posicion == 11){
		cantidad = parseFloat($('#moneda1').val()) || 0;
		total = valor * cantidad;
		$('#moneda1_').val(total.toFixed(2));
	}
	if(posicion == 12){
		cantidad = parseFloat($('#moneda2').val()) || 0;
		total = valor * cantidad;
		$('#moneda2_').val(total.toFixed(2));
	}
	if(posicion == 13){
		cantidad = parseFloat($('#moneda5').val()) || 0;
		total = valor * cantidad;
		$('#moneda5_').val(total.toFixed(2));
	}

}

function calcularTotalGeneral(){

	$('#total_').val();

}*/

function calculartotal(valor, codigo) {
	
    if (codigo) {
        let cantidad = parseFloat($(`#${codigo}`).val()) || 0;
        let total = valor * cantidad;
        $(`#${codigo}_`).val(total.toFixed(2));
        calcularTotalGeneral();
    }
}

function calcularTotalGeneral() {
    
	let totalGeneral = 0;
	//var moneda = 0;

    tipo_monedas.forEach(codigo => {
        totalGeneral += parseFloat($(`#${codigo}_`).val()) || 0;
    });

	$('#total_').text(totalGeneral.toFixed(2));

	moneda = $('#moneda').val();
	//alert(moneda);
	if(moneda==1){
		$('#importe_soles').val(totalGeneral.toFixed(2));
	}else{
		$('#importe_dolares').val(totalGeneral.toFixed(2));
	}
}

</script>


<body class="hold-transition skin-blue sidebar-mini">

	<div class="panel-heading close-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>

    <div>
		<!--
        <section class="content-header">
          <h1>
            <small style="font-size: 20px">Programados del Medicos del dia <?php //echo $fecha_atencion?></small>
          </h1>
        </section>
		-->
		<div class="justify-content-center">		

		<div class="card">
			
			<div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
				Registro de Efectivo
			</div>
			
            <div class="card-body">
			<form method="post" action="#" id="frmEfectivo" name="frmEfectivo" enctype="multipart/form-data">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-3">
							Caja
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<select name="caja" id="caja" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($caja as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$efectivo->id_caja)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-3">
							Fecha
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo ($id > 0) ? $efectivo->fecha : date('d-m-Y'); ?>" type="text" paceholder="Fecha">
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-3">
							Importe Soles
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input id="importe_soles" name="importe_soles" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
						<div class="col-lg-3">
							Importe Dolares
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input id="importe_dolares" name="importe_dolares" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-3">
							Moneda
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<select name="moneda" id="moneda" class="form-control form-control-sm" onchange="limpiar()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($moneda as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php echo ($row->codigo == ($efectivo->id_moneda ?? 1)) ? "selected" : ""; ?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							<b>Denominaci&oacute;n</b>
						</div>
						<div class="col-lg-4">
							<b>Cantidad</b>
						</div>
						<div class="col-lg-4">
							<b>Total</b>
						</div>
					</div>
					<?php foreach($tipo_monedas as $index => $row){?>
						<div class="row" style="padding-left:15px; padding-right:15px">
							<div class="col-lg-4">
								<?php echo $row->denominacion?>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input id="<?php echo $row->codigo?>" name="<?php echo $row->codigo?>" on class="form-control form-control-sm"  value="<?php echo ($id > 0 && isset($efectivo_detalle->id_tipo_efectivo) && $efectivo_detalle->id_tipo_efectivo == $row->codigo) ? $efectivo_detalle->cantidad : '0'; ?>" type="text" oninput="calculartotal(<?php echo $row->abreviatura; ?>, <?php echo $row->codigo; ?>)">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input id="<?php echo $row->codigo?>_" name="<?php echo $row->codigo?>_" on class="form-control form-control-sm"  value="0" type="text" >
								</div>
							</div>
						</div>
					<?php }?>
					
					<!--<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Billetes S/ 20
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="billetes20" name="billetes20" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_billetes_20 : '0'; ?>" type="text" oninput="calculartotal(20,2)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="billetes20_" name="billetes20_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Billetes S/ 50
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="billetes50" name="billetes50" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_billetes_50 : '0'; ?>" type="text" oninput="calculartotal(50,3)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="billetes50_" name="billetes50_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Billetes S/ 100
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="billetes100" name="billetes100" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_billetes_100 : '0'; ?>" type="text" oninput="calculartotal(100,4)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="billetes100_" name="billetes100_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Billetes S/ 200
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="billetes200" name="billetes200" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_billetes_200 : '0'; ?>" type="text" oninput="calculartotal(200,5)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="billetes200_" name="billetes200_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Monedas S/ 0.01
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda001" name="moneda001" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_moneda_0_01 : '0'; ?>" type="text" oninput="calculartotal(0.01,6)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda001_" name="moneda001_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Monedas S/ 0.05
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda005" name="moneda005" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_moneda_0_05 : '0'; ?>" type="text" oninput="calculartotal(0.05,7)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda005_" name="moneda005_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Monedas S/ 0.10
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda010" name="moneda010" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_moneda_0_10 : '0'; ?>" type="text" oninput="calculartotal(0.10,8)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda010_" name="moneda010_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Monedas S/ 0.20
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda020" name="moneda020" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_moneda_0_20 : '0'; ?>" type="text" oninput="calculartotal(0.20,9)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda020_" name="moneda020_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Monedas S/ 0.50
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda050" name="moneda050" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_moneda_0_50 : '0'; ?>" type="text" oninput="calculartotal(0.50,10)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda050_" name="moneda050_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Monedas S/ 1.00
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda1" name="moneda1" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_moneda_1 : '0'; ?>" type="text" oninput="calculartotal(1,11)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda1_" name="moneda1_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Monedas S/ 2.00
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda2" name="moneda2" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_moneda_2 : '0'; ?>" type="text" oninput="calculartotal(2,12)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda2_" name="moneda2_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
							Monedas S/ 5.00
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda5" name="moneda5" on class="form-control form-control-sm"  value="<?php //echo ($id > 0) ? $efectivo->cantidad_moneda_5 : '0'; ?>" type="text" oninput="calculartotal(5,13)">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input id="moneda5_" name="moneda5_" on class="form-control form-control-sm"  value="0" type="text" >
							</div>
						</div>
					</div>-->
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-4">
						</div>
						<div class="col-lg-4">
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm" id="total_">0</label>
							</div>
						</div>
					</div>
					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save_efectivo()" class="btn btn-sm btn-success">Guardar</a>
								<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');window.location.reload();" class="btn btn-md btn-warning" style="margin-left: 15px">Cerrar</a>
							</div>
												
						</div>
					</div> 
				</div>
				
				
			</div>
			<!-- /.box -->
			

			</div>
        <!--/.col (left) -->
            
     
          </div>
		  
		  </form>
          <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
<script type="text/javascript">
$(document).ready(function () {
	
	
	$('#tblReservaEstacionamiento').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search").keyup(function() {
		var dataTable = $('#tblReservaEstacionamiento').dataTable();
		dataTable.fnFilter(this.value);
	}); 
	
	$('#tblReservaEstacionamientoPreferente').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-searchp").keyup(function() {
		var dataTable = $('#tblReservaEstacionamientoPreferente').dataTable();
		dataTable.fnFilter(this.value);
	});
	
	$('#tblSinReservaEstacionamiento').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search2").keyup(function() {
		var dataTable = $('#tblSinReservaEstacionamiento').dataTable();
		dataTable.fnFilter(this.value);
	}); 
	
	
});

</script>

<script type="text/javascript">
$(document).ready(function() {
	
	$('#persona_').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});
		
	$('#persona_').focusin(function() { $('#persona_').select(); });
	/*
	$('#usuario_').autocomplete({
		appendTo: "#usuario_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/empresa/list_usuario/'+$('#usuario_').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.usuario};
					return hash;
			   }); 
			   response(resp);
			},
			error: function() {
			}
		});
		},
		select: function (event, ui) {
			$("#user_id").val(ui.item.key);
		},
			minLength: 2,
			delay: 100
	  });
	*/
	
	$('#empresa_').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});
		
	$('#empresa_').focusin(function() { $('#empresa_').select(); });
	
	$('#empresa_').autocomplete({
		appendTo: "#empresa_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/empresa/list_empresa/'+$('#empresa_').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.razon_social, ruc: obj.ruc};
					return hash;
			   }); 
			   response(resp);
			},
			error: function() {
			}
		});
		},
		select: function (event, ui) {
			$("#id_empresa").val(ui.item.key);
		},
			minLength: 1,
			delay: 100
	  });
	  
	  $('#persona_').autocomplete({
		appendTo: "#persona_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/persona/list_persona/'+$('#persona_').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.persona};
					return hash;
			   }); 
			   response(resp);
			},
			error: function() {
			}
		});
		},
		select: function (event, ui) {
			$("#id_persona").val(ui.item.key);
		},
			minLength: 1,
			delay: 100
	  });
	  
	
});

</script>

