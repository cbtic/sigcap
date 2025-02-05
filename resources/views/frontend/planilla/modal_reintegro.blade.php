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
	$("#concepto").select2({ width: '100%' });
	$("#id_agremiado").select2({ width: '100%' });
	$("#id_comision").select2({ width: '100%' });
	datatableReintegroDetalle();
	obtenerAnioReintegro();
	activarPorcentaje();
	//$('#hora_solicitud').focus();
	//$('#hora_solicitud').mask('00:00');
	//$("#id_empresa").select2({ width: '100%' });
});
</script>


<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitud').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		//container: '#openOverlayOpc modal-body'
		container: '#openOverlayOpc modal-body'
     });
	 /*
	 $('#hora_solicitud').timepicker({
		showInputs: false,
		container: '#openOverlayOpc modal-body'
	});
	*/
	 
});


var id = "<?php echo $id?>";

if(id==0){
	var id_periodo = $("#id_periodo").val();
	obtenerComisiones();
	//obtenerDelegadoPerido_(id_periodo);
}

if(id>0){
	var id_periodo = "<?php echo $delegadoReintegro->id_periodo?>";
	var id_agremiado = "<?php echo (isset($comisionDelegado->id_agremiado))?$comisionDelegado->id_agremiado:0?>";
	var id_comision = "<?php echo $delegadoReintegro->id_comision?>";
	obtenerDelegadoPeridoEdit(id_periodo,id_agremiado);
	obtenerComisionDelegadoPeridoEdit(id_periodo,id_agremiado,id_comision);
}

//obtenerDelegadoPeridoEdit

$(document).ready(function() {
	 
	 

});

function validacion(){
    
    var msg = "";
    var cobservaciones=$("#frmComentar #cobservaciones").val();
    
    if(cobservaciones==""){msg+="Debe ingresar una Observacion <br>";}
    
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
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

function fn_save(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_regional = $('#id_regional').val();
	var id_periodo = $('#id_periodo').val();
	var id_mes = $('#mes').val();
	var id_mes_ejecuta_reintegro = $('#id_mes_ejecuta_reintegro').val();
	var id_comision = $('#id_comision').val();
	var id_delegado = $('#id_comision option:selected').attr("id_delegado");
	var importe = $('#importe').val();
	var cantidad = $('#cantidad').val();
	var id_tipo_reintegro = $('#id_tipo_reintegro').val();
	var observacion = $('#observacion').val();
	var porcentaje = $('#porcentaje').val();
	var anio = $('#anio').val();
	
    $.ajax({
			url: "/planilla/send_reintegro",
            type: "POST",
            data : {_token:_token,id:id,id_regional:id_regional,id_periodo:id_periodo,id_mes:id_mes,
				id_mes_ejecuta_reintegro:id_mes_ejecuta_reintegro,id_comision:id_comision,
				id_delegado:id_delegado,importe:importe,cantidad:cantidad,id_tipo_reintegro:id_tipo_reintegro,
				observacion:observacion,porcentaje:porcentaje,anio:anio},
            success: function (result) {
				//$('#openOverlayOpc').modal('hide');
				//window.location.reload();
				//datatablenew();
				if($('#id').val()>0){
					datatableReintegroDetalle();
				}else{
					//$('#openOverlayOpc').modal('hide');
					//window.location.reload();
					modalSeguro(result);
				}
				datatablenew();
								
            }
    });

}

function obtener_monto(){

	//var _id = $("#id").val();	
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	$('#monto').val("");
	
	var id_tipo_reintegro = $("#id_tipo_reintegro").val();
	var id_comision = $("#id_comision").val();
	var id_periodo = $('#id_periodo').val();
	var anio = $('#anio').val();
	var mes = $('#mes').val();
	var porcentaje = $('#porcentaje').val();

	$.ajax({
		url: '/planilla/obtener_monto/' + id_tipo_reintegro + '/' + id_comision + '/' + id_periodo + '/' + anio + '/' + mes + '/' + porcentaje,
		dataType: "json",
		success: function(result){
			console.log(result);
			$('#monto').val(Number(result).toFixed(2));

			calcular_importe();

		},
		error: function(data) {
		}
		
	});

}

function datatableReintegroDetalle(){
	
	var id_agremiado =  $('#id').val();
	
    $("#tblReintegroDetalle tbody").html("");
	$.ajax({
			url: "/planilla/obtener_datos_reintegro_detalle/"+id_agremiado,
			type: "GET",
			success: function (result) {  
					$("#tblReintegroDetalle tbody").html(result);
			}
	});
}

function calcular_importe(){

	var monto = $('#monto').val();
	var cantidad = $('#cantidad').val();
	var importe = cantidad * monto;
	$('#importe').val(importe);
	
}

function obtenerAnioReintegro(){

	var periodo = $('#id_periodo').val();

	$.ajax({
		url: "/planilla/obtener_anio_reintegro/"+periodo,
		dataType: "json",
		success: function (result) {  

			var option = "";
			$('#anio').html("");
			result.forEach(function (anio) {
				option += "<option value='"+anio+"'>"+anio+"</option>";
			});
			$('#anio').html(option);

		}
	});

}

function obtenerComisiones(){

	var periodo = $('#id_periodo').val();

	$.ajax({
		url: "/planilla/obtener_comisiones/"+periodo,
		dataType: "json",
		success: function (result) {  

			var option = "";
			$('#id_comision').html("");
			result.forEach(function (comision) {
				option += "<option value='"+comision.id+"'>"+comision.denominacion+" - "+comision.comision+"</option>";
			});
			$('#id_comision').html(option);

		}
	});

}

function activarPorcentaje(){
	var tipo_reintegro = $('#id_tipo_reintegro').val();

	if(tipo_reintegro!=437){
		$('#porcentajeCoordinador').hide();
	}else{
		$('#porcentajeCoordinador').show();
	}
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
				Registro Reintegro
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:10px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					
					<div class="row">
						
						<?php 
							$readonly=$id>0?"readonly='readonly'":'';
							$readonly_=$id>0?'':"readonly='readonly'";
						?>
						
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label form-control-sm">Regional</label>
								<select name="id_regional" readonly id="id_regional" class="form-control form-control-sm" onChange="" disabled>
									<option value="">--Selecionar--</option>
									<?php
									foreach ($region as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==$id_regional)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label form-control-sm">Periodo</label>
								<input type="hidden" name="id_periodo_" id="id_periodo_" value="" />
								<select name="id_periodo" id="id_periodo" class="form-control form-control-sm" onChange="obtenerDelegadoPerido()" disabled='disabled'>
									<?php
									foreach ($periodo as $row) {?>
									<option value="<?php echo $row->id?>" 
										<?php if($id>0 && $row->id==$delegadoReintegro->id_periodo)echo "selected='selected'"?>
										<?php if($id==0 && $row->id==$periodo_ultimo->id)echo "selected='selected'"?>
										><?php echo $row->descripcion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Año a Reintegrar</label>
								<select name="anio" id="anio" class="form-control form-control-sm" onChange="obtener_monto()">
								</select>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Mes a Reintegrar</label>
								<select name="mes" id="mes" class="form-control form-control-sm">
								<?php
									foreach ($mes as $key=>$row) {?>
									<option value="<?php echo $key?>" <?php if($key==$delegadoReintegro->id_mes)echo "selected='selected'"?>><?php echo $row?></option>
								<?php 
									}
								?>
							</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Delegado</label>
								<select name="id_agremiado" id="id_agremiado" class="form-control form-control-sm" onChange="" <?php if($id>0) {?><?php } ?>>
								<option value="">--Selecionar--</option>
									<?php
										foreach ($agremiados as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==$delegadoReintegro->id_delegado)echo "selected='selected'"?>><?php echo $row->numero_cap." - ".$row->apellido_paterno." ".$row->apellido_materno." ".$row->nombres?></option>
									<?php 
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="control-label form-control-sm">Comisi&oacute;n</label>
								<select name="id_comision" id="id_comision" class="form-control form-control-sm" onChange="" <?php if($id>0) {?><?php } ?>>
								<!--<option value="">--Selecionar--</option>
									<?php
										//foreach ($comisiones as $row) {?>
									<option value="<?php //echo $row->id?>" <?php //if($row->id==$delegadoReintegro->id_comision)echo "selected='selected'"?>><?php //echo $row->denominacion." - ".$row->comision?></option>
									<?php 
										//}
									?>
								--></select>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
							<label class="control-label form-control-sm">Tipo Reintegro</label>
							<select name="id_tipo_reintegro" id="id_tipo_reintegro" class="form-control form-control-sm" onChange="obtener_monto();activarPorcentaje()">
								<option value="">--Selecionar--</option>
                                <?php
                                foreach ($tipo_reintegro as $row) {
                                ?>
                                <option value="<?php echo $row->codigo?>" <?php if($row->codigo==$delegadoReintegro->id_tipo_reintegro)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
                                <?php
                                }
                                ?>
							</select>
						</div>
						
						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label form-control-sm">Mes Ejecuta Reintegro</label>
								<select name="id_mes_ejecuta_reintegro" id="id_mes_ejecuta_reintegro" class="form-control form-control-sm" onChange="obtener_monto()" <?php if($id>0) {?>disabled<?php } ?>>
								<?php
									foreach ($mes as $key=>$row) {?>
									<option value="<?php echo $key?>" <?php if($key==$delegadoReintegro->id_mes_ejecuta_reintegro)echo "selected='selected'"?>><?php echo $row?></option>
								<?php 
									}
								?>
							</select>
							<input type="hidden" name="monto" id="monto" value="0" />
							</div>
						</div>
						
						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Cantidad</label>
								<input id="cantidad" name="cantidad" class="form-control form-control-sm" value="<?php //echo $delegadoReintegro->cantidad?>" type="text" onKeyUp="calcular_importe()"/>
							</div>
						</div>
						<div class="col-lg-1" id="porcentajeCoordinador">
							<div class="form-group">
								<label class="control-label form-control-sm">Porcentaje %</label>
								<input id="porcentaje" name="porcentaje" class="form-control form-control-sm" value="<?php echo !empty($delegadoReintegro->porcentaje) ? $delegadoReintegro->porcentaje : 10; ?>" type="text" onKeyUp="obtener_monto()" />
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Importe</label>
								<input id="importe" name="importe" class="form-control form-control-sm" value="<?php //echo $delegadoReintegro->importe?>" type="text" readonly="readonly"/>
							</div>
						</div>
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label form-control-sm">Observaciones</label>
								<textarea id="observacion" name="observacion" class="form-control form-control-sm"><?php //echo $delegadoReintegro->observacion?></textarea>
							</div>
						</div>
					</div>
			</form>
					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="valida()" class="btn btn-sm btn-success" style="margin-right: 15px;">Guardar</a>
								<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide');window.location.reload();" class="btn btn-md btn-warning">Cerrar</a>
								
							</div>
												
						</div>
					</div> 
					
              </div>
			  <div class="card-body">	

					<div class="table-responsive">
						<table id="tblReintegroDetalle" class="table table-hover table-sm">
							<thead>
							<tr style="font-size:13px">
								<th>Agremiado</th>
								<th>Tipo Reintegro</th>
								<th>Mes a Reintegrar</th>
								<th>Mes Ejecuta Reintegro</th>
								<th>Cantidad</th>
								<th>Importe</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
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

