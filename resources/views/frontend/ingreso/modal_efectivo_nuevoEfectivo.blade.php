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
		container: '#openOverlayOpc modal-body',
		language:'es'
	});
});

$(document).ready(function() {
	 
	if($('#id').val() > 0){

		document.addEventListener("DOMContentLoaded", function() {
			<?php foreach ($tipo_monedas as $row): ?>
				calculartotal('<?php echo $row->abreviatura; ?>', '<?php echo $row->codigo; ?>');
			<?php endforeach; ?>
		});

	}
	
});

function validaCaja(){

	var id = $('#fecha').val();

	if(id > 0){

		fn_save_efectivo();

	}else{

		var caja = $('#caja').val();
		var fecha = $('#fecha').val();
		var moneda = $('#moneda').val();
		var id_efectivo = $('#id').val();
		$.ajax({
			url: "/ingreso/validarCaja/"+caja+"/"+fecha+"/"+moneda+"/"+id_efectivo,
			type: "get",
			dataType: "json",
			success: function (result) {
				
				var cantidad_ingresos = result[0].cantidad;

				if(cantidad_ingresos>0){
					bootbox.alert("Ya se hizo un registro de Efectivo de esta caja");
				}else{
					fn_save_efectivo();
				}
			}
		});
	}
}

function fn_save_efectivo(){
	
	//var id = $('#id').val();

    $.ajax({
			url: "/ingreso/send_efectivo_nuevoEfectivo",
            type: "POST",
            data : $("#frmEfectivo").serialize(),
            success: function (result) {
				
				//alert(result);

				//$('#openOverlayOpc').modal('hide');
				//window.location.reload();
				datatablenew();
				bootbox.alert("Guardado exitosamente");
				if (result.id>0) {
					modalEfectivo(result.id);
				}	
				//limpiar();
				
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
	//$('#importe_soles').val("0");
	//$('#importe_dolares').val("0");
	//$('#moneda').val(1);
	$('#total_').text("0");

}

function calculartotal(valor, index) {
	
    //if (codigo) {
		/*
        let cantidad = parseFloat($(`#${codigo}`).val()) || 0;
        let total = valor * cantidad;
        $(`#${codigo}_`).val(total.toFixed(2));
        calcularTotalGeneral();
		*/
		let cantidad = parseFloat($(`#cantidad_`+index).val()) || 0;
        let total = valor * cantidad;
        $(`#total_`+index).val(total.toFixed(2));
        calcularTotalGeneral();
    //}
}

function calcularTotalGeneral() {
    
	let totalGeneral = 0;
	//var moneda = 0;
	/*
    tipo_monedas.forEach(codigo => {
        totalGeneral += parseFloat($(`#${codigo}_`).val()) || 0;
    });
	*/
	$('input[name="total[]"]').each(function () {
        totalGeneral += parseFloat($(this).val()) || 0;
    });
	console.log(totalGeneral);

	$('#total_').text(totalGeneral.toFixed(2));

	moneda = $('#moneda').val();
	//alert(moneda);
	if(moneda==1){
		$('#importe_soles').val(totalGeneral.toFixed(2));
	}else{
		$('#importe_dolares').val(totalGeneral.toFixed(2));
	}
	
}

var id = "<?php echo $id?>";
//if(id==0)
cargarEfectivoDetalleMoneda(id,1);

function cargar_moneda(){
	
	var moneda = $("#moneda").val();
	var id = $("#id").val();
	cargarEfectivoDetalleMoneda(id,moneda);

}

function cargarEfectivoDetalleMoneda(id,id_moneda){

	$.ajax({
			url: "/ingreso/modal_efectivo_detalle/"+id+"/"+id_moneda,
			type: "GET",
			success: function (result) {  
					$("#efectivoDetalle").html(result);
					//$('[data-toggle="tooltip"]').tooltip();
							
			}
	});

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
			
            <div class="card-body" style="max-height: 850px; overflow-y: auto;">
			<form method="post" action="#" id="frmEfectivo" name="frmEfectivo" enctype="multipart/form-data">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:0px;padding-bottom:0px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-3">
							Caja
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<select name="caja" id="caja" class="form-control form-control-sm" onChange="" <?php if($id>0){ ?> disabled <?php }?>>
									<option value="">--Selecionar--</option>
									<?php
									foreach ($caja as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$efectivo->id_caja)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
								<?php if ($id > 0) { ?>
									<input type="hidden" name="caja" value="<?php echo $efectivo->id_caja; ?>">
								<?php } ?>
							</div>
						</div>
						<div class="col-lg-3">
							Fecha
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input id="fecha" name="fecha" on class="form-control form-control-sm"  value="<?php echo ($id > 0) ? date('d-m-Y', strtotime($efectivo->fecha)) : date('Y-m-d'); ?>" type="text" paceholder="Fecha">
							</div>
						</div>
						<div class="col-lg-3">
							Importe Soles
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input id="importe_soles" name="importe_soles" on class="form-control form-control-sm"  value="<?php echo $id>0 ? $efectivo->importe_soles : '0' ?>" type="text" >
							</div>
						</div>
						<div class="col-lg-3">
							Importe Dolares
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input id="importe_dolares" name="importe_dolares" on class="form-control form-control-sm"  value="<?php echo $id>0 ? $efectivo->importe_dolares : '0' ?>" type="text" >
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:15px; padding-right:15px">
						<div class="col-lg-3">
							Moneda
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<select name="moneda" id="moneda" class="form-control form-control-sm" onchange="limpiar();cargar_moneda();">
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

					<div id="efectivoDetalle">
					<!--
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
					<?php //foreach($tipo_monedas as $index => $row){?>
						<div class="row" style="padding-left:15px; padding-right:15px">
							<div class="col-lg-4">
								<?php //echo $row->denominacion?>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
								<?php 
								/*$cantidad = '0';
								if ($id > 0) {
									foreach ($efectivo_detalle as $detalle) {
										if ($detalle->id_tipo_efectivo == $row->codigo) {
											$cantidad = $detalle->cantidad;
											break;
										}
									}
								}*/
								?>
								<input id="<?php //echo $row->codigo ?>" name="<?php //echo $row->codigo ?>" class="form-control form-control-sm" value="<?php //echo $cantidad; ?>" type="text" oninput="calculartotal(<?php //echo $row->abreviatura; ?>, <?php //echo $row->codigo; ?>)">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input id="<?php //echo $row->codigo?>_" name="<?php //echo $row->codigo?>_" on class="form-control form-control-sm"  value="0" type="text" >
								</div>
							</div>
						</div>
						<?php //if ($id > 0): ?>
							<script>
								calculartotal('<?php //echo $row->abreviatura; ?>', '<?php //echo $row->codigo; ?>');
							</script>
						<?php //endif; ?>
					<?php 
					//}
					?>

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
					-->

					</div>

					<div style="margin-top:0px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="validaCaja()" class="btn btn-sm btn-success">Guardar</a>
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
	
	
});

</script>

<script type="text/javascript">
$(document).ready(function() {
		
});

</script>

