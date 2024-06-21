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
	max-width:60%!important
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

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>-->
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
	$('#fecha_comprobante').datepicker({
	   format: "dd-mm-yyyy",
	   autoclose: true,
	});
	$('#fecha_vencimiento').datepicker({
	   format: "dd-mm-yyyy",
	   autoclose: true,
	});
	$('#fecha_operacion').datepicker({
	   format: "dd-mm-yyyy",
	   autoclose: true,
	});

	$('#chk_activar_numero_operacion').change(function(){
        if($(this).is(':checked')){
            $('#numero_operacion').prop('readonly', false);
			$('#fecha_operacion').prop('readonly', false);
        } else {
            $('#numero_operacion').prop('readonly', true);
			$('#fecha_operacion').prop('readonly', true);
        }
    });

	validaAbonado();
});
</script>

<script type="text/javascript">




function validaAbonado(){
	var abonado = $('#abonado').val();

	if (abonado=="0"){
		$('#numero_operacion').prop('readonly', true);
		$('#fecha_operacion').prop('readonly', true);
		$('#numero_operacion').val("");
		$('#fecha_operacion').val("");

	} else if(abonado=="1"){
		$('#numero_operacion').prop('readonly', false);
		$('#fecha_operacion').prop('readonly', false);
	}


}

function valida(){
	var mensaje= "0";

	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_regional = $('#id_regional').val();
	var nombre = $('#denominacion_').val();
	var descripcion =$('#descripcion_').val();	
	var concepto =$('#concepto').val();	
	

	if (nombre==""){
	   mensaje= "Falta ingresar la denominacion del Seguro";

	}

	if (mensaje=="0")[
		fn_save()		
		]
	else {
		Swal.fire(mensaje);
	}

}

function save_recibo_honorario(){

var msg = "";
var _token = $('#_token').val();

var id = $('#id').val();
var tipo_comprobante = $('#tipo_comprobante').val();
var numero_comprobante = $('#numero_comprobante').val();
var fecha_comprobante = $('#fecha_comprobante').val();
var fecha_vencimiento = $('#fecha_vencimiento').val();
var numero_operacion = $('#numero_operacion').val();
var cancelado = $('#chk_activar_numero_operacion').prop('checked') ? 1 : 0;
$('#cancelado').val(cancelado);

if(numero_comprobante == "")msg += "Debe ingresar el numero de comprobante <br>";
if(fecha_comprobante == "")msg += "Debe ingresar la fecha de comprobante del comprobante <br>";
if(fecha_vencimiento == "")msg += "Debe ingresar la fecha de vencimiento del comprobante <br>";

if (msg != "") {
	bootbox.alert(msg);
	return false;
}

var selTipo = '';
$('#selTipo').val(selTipo);

if(cancelado==1){

  const swalWithBootstrapButtons = Swal.mixin({
	customClass: {
	  confirmButton: "btn btn-success",
	  cancelButton: "btn btn-warning"
	},
	buttonsStyling: false
  });
  swalWithBootstrapButtons.fire({
	title: 'Cancelación',
	text: "Seleccionar el tipo de cancelación!",
	icon: "warning",
	showCancelButton: true,
	confirmButtonText: "Solo Selccionado!",
	cancelButtonText: "Todo el Grupo!",
	reverseButtons: true
  }).then((result) => {
	if (result.isConfirmed) {
		selTipo = 'S';
		$('#selTipo').val(selTipo);
		send_recibo_honorario();

	} else if 
		(result.dismiss === Swal.DismissReason.cancel) 
		  
		{
			selTipo = 'T';
			$('#selTipo').val(selTipo);

			send_recibo_honorario();
		}
  });

}else{
	send_recibo_honorario();
}
//datatablenew();	
//limpiar();	

}


function send_recibo_honorario(){
    
	var _token = $('#_token').val();

	var id = $('#id').val();
	var tipo_comprobante = $('#tipo_comprobante').val();
	var numero_comprobante = $('#numero_comprobante').val();
	var fecha_comprobante = $('#fecha_comprobante').val();
	var fecha_vencimiento = $('#fecha_vencimiento').val();	
	var cancelado = $('#chk_activar_numero_operacion').prop('checked') ? 1 : 0;
	var numero_operacion = $('#numero_operacion').val();
	var fecha_operacion = $('#fecha_operacion').val();
	var selTipo = $('#selTipo').val();

	var periodo = $('#periodo').val();
	var mes = $('#mes_').val();
	var id_periodo_comision = $('#id_periodo_comision').val();
	var id_grupo = $('#id_grupo').val();

	//alert(periodo); exit();
	

    $.ajax({
			url:"/planillaDelegado/send_recibo_honorario",
            type: "POST",
            data : {_token:_token,id:id,tipo_comprobante:tipo_comprobante,numero_comprobante:numero_comprobante,fecha_comprobante:fecha_comprobante,fecha_vencimiento:fecha_vencimiento,cancelado:cancelado,numero_operacion:numero_operacion,fecha_operacion:fecha_operacion,selTipo:selTipo,periodo:periodo,mes:mes,id_periodo_comision:id_periodo_comision,id_grupo:id_grupo},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				//window.location.reload();
				datatablenew();
								
            }
    });

}



</script>


<body class="hold-transition skin-blue sidebar-mini">

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
			
			<div class="card-header" style="padding:5px!important;padding-left:20px!important">
				Edici&oacute;n Recibo Honorarios Delegado
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				<input type="hidden" name="selTipo" id="selTipo" value="">

				<input type="hidden" name="periodo" id="periodo" value="<?php echo $datosRecibo[0]->periodo?>">
				<input type="hidden" name="mes_" id="mes_" value="<?php echo $datosRecibo[0]->mes?>">
				<input type="hidden" name="id_periodo_comision" id="id_periodo_comision" value="<?php echo $datosRecibo[0]->id_periodo_comision?>">
				<input type="hidden" name="id_grupo" id="id_grupo" value="<?php echo $datosRecibo[0]->id_grupo?>">
												
				<div class="row">
					
					<?php 
						$readonly=$id>0?"readonly='readonly'":'';
						$readonly_=$id>0?'':"readonly='readonly'";							
					?>
											
					<div class="col-lg-4">
						<div class="form-group">
							<label class="control-label form-control-sm">N&deg; CAP</label>							
							<input type="text" name="numero_cap" id="numero_cap" value="<?php echo $datosRecibo[0]->numero_cap?>" class="form-control form-control-sm" readonly="readonly">
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label class="control-label form-control-sm">Apellidos y Nombres</label>
							<input type="text" name="nombres" id="nombres" value="<?php echo $datosRecibo[0]->agremiado?>" class="form-control form-control-sm" readonly="readonly">
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label class="control-label form-control-sm">Tipo Comprobante</label>
							<input type="text" name="tipo" id="tipo" value="Recibo por Honorarios"  class="form-control form-control-sm" readonly="readonly">
							<input type="hidden" name="tipo_comprobante" id="tipo_comprobante" value="<?php echo $datosRecibo[0]->tipo_comprobante?>">
						</div>
					</div>						
					
				</div>

				<div class="row">											
					<div class="col-lg-4">
						<div class="form-group">
							<label class="control-label form-control-sm">N&uacute;mero Comprobante</label>
							<input type="text" name="numero_comprobante" id="numero_comprobante" value="<?php echo $datosRecibo[0]->numero_comprobante?>" class="form-control form-control-sm">
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label class="control-label form-control-sm">Fecha Comprobante</label>
							<input id="fecha_comprobante" name="fecha_comprobante" class="form-control form-control-sm"  value="<?php echo $datosRecibo[0]->fecha_comprobante?>" type="text"  >							
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label class="control-label form-control-sm">Fecha Vencimiento</label>
							<input type="text" id="fecha_vencimiento" name="fecha_vencimiento"  value="<?php echo $datosRecibo[0]->fecha_vencimiento?>" class="form-control form-control-sm"  >
						</div>
					</div>
									
				</div>
				
				<div class="row">
					
					<div class="col-lg-4">
						<div class="form-group">
							<input type="hidden" name="abonado" id="abonado" value="<?php echo $datosRecibo[0]->cancelado?>">
							<input id="chk_activar_numero_operacion"   type="checkbox"  <?php if($datosRecibo[0]->cancelado=="1") echo "checked='checked'"?> style="margin-left:0px;width:18px;height:18px;margin-top:6px">							
							<label class="control-label form-control-sm">Recibo Abonado</label>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label class="control-label form-control-sm">N&uacute;mero Operaci&oacute;n</label>
							<input type="text" name="numero_operacion" id="numero_operacion" value="<?php echo $datosRecibo[0]->numero_operacion?>" class="form-control form-control-sm" readonly="readonly">
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label class="control-label form-control-sm">Fecha Operación</label>
							<input type="text" id="fecha_operacion" name="fecha_operacion"  value="<?php echo $datosRecibo[0]->fecha_operacion?>"  class="form-control form-control-sm" readonly="readonly">
						</div>
					</div>
									
				</div>
				
				<div style="margin-top:10px" class="form-group">
					<div class="col-sm-12 controls">
						<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
							<a href="javascript:void(0)" onClick="save_recibo_honorario()" class="btn btn-sm btn-success">Guardar</a>
							
						</div>
											
					</div>
				</div> 
					
            </div>
			                
        </div>
          <!-- /.box -->
          

        </div>

     
    </div>
        </section>
       
    </div>
    
    
<script type="text/javascript">
$(document).ready(function () {

	$('#ruc_').blur(function () {
		var id = $('#id').val();
			if(id==0) {
				validaRuc(this.value);
			}
		//validaRuc(this.value);
	});
	
	
	
	
});


</script>

<script type="text/javascript">
$(document).ready(function() {
	//$('#numero_placa').focus();
	//$('#numero_placa').mask('AAA-000');
	//$('#vehiculo_numero_placa').mask('AAA-000');
	
	
});




</script>

