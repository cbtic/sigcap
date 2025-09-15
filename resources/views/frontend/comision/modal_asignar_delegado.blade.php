<title>Sistema de CAP - Lima</title>

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
	$("#id_regional").select2({ width: '100%' });
	$("#id_comision").select2({ width: '100%' });
	$("#id_concurso_inscripcion").select2({ width: '100%' });
	$("#id_concurso_inscripcion2").select2({ width: '100%' });
	$("#id_profesion_otro").select2({ width: '100%' });
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

function guardarCita__(){
	alert("fdssf");
}

function guardarCita(id_medico,fecha_cita){
    
    var msg = "";
    var id_ipress = $('#id_ipress').val();
    var id_consultorio = $('#id_consultorio').val();
    var fecha_atencion = $('#fecha_atencion').val();
    var dni_beneficiario = $("#dni_beneficiario").val();
	//alert(id_ipress);
	if(dni_beneficiario == "")msg += "Debe ingresar el numero de documento <br>";
    if(id_ipress==""){msg+="Debe ingresar una Ipress<br>";}
    if(id_consultorio==""){msg+="Debe ingresar un Consultorio<br>";}
    if(fecha_atencion==""){msg+="Debe ingresar una fecha de atencion<br>";}
   
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
        fn_save_cita(id_medico,fecha_cita);
    }
}

function habilitar(obj){

	if($(obj).is(":checked")){
		$('input[name=coordinador]').prop("checked",false);
		$(obj).prop("checked",true);
	}

}

function fn_save(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_comision = $('#id_comision').val();
	var id_regional = $('#id_regional').val();
	var id_concurso_inscripcion = $('#id_concurso_inscripcion').val();
	var id_concurso_inscripcion2 = $('#id_concurso_inscripcion2').val();
	var coordinador = $('input[name=coordinador]:checked').val();
	var id_comision_delegado_1 = $('#id_comision_delegado_1').val();
	var id_comision_delegado_2 = $('#id_comision_delegado_2').val();
	
	//alert(coordinador);return false;
	
    $.ajax({
			url: "/comision/send_delegado",
            type: "POST",
            data : {_token:_token,id:id,id_comision:id_comision,id_regional:id_regional,id_concurso_inscripcion:id_concurso_inscripcion,id_concurso_inscripcion2:id_concurso_inscripcion2,coordinador:coordinador,id_comision_delegado_1:id_comision_delegado_1,id_comision_delegado_2:id_comision_delegado_2},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				datatablenew();
				//obtenerInversionista(0);
				//obtenerDetalleInversionista(0);
				//window.location.reload();
				
            }
    });
}

function fn_liberar(id){
    
	//var id_estacionamiento = $('#id_estacionamiento').val();
	var _token = $('#_token').val();
	
    $.ajax({
			url: "/estacionamiento/liberar_asignacion_estacionamiento_vehiculo",
            type: "POST",
            data : {_token:_token,id:id},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				cargarAsignarEstacionamiento();
            }
    });
}


function validarLiquidacion() {
	
	var msg = "";
	var sw = true;
	
	var saldo_liquidado = $('#saldo_liquidado').val();
	var estado = $('#estado').val();
	
	if(saldo_liquidado == "")msg += "Debe ingresar un saldo liquidado <br>";
	if(estado == "")msg += "Debe ingresar una observacion <br>";
	
	if(msg!=""){
		bootbox.alert(msg);
		//return false;
	} else {
		//submitFrm();
		document.frmLiquidacion.submit();
	}
	return false;
}


function obtenerVehiculo(id,obj){
	
	//$("#tblPlan tbody text-white").attr('class','bg-primary text-white');
	if(obj!=undefined){
		$("#tblSinReservaEstacionamiento tbody tr").each(function (ii, oo) {
			var clase = $(this).attr("clase");
			$(this).attr('class',clase);
		});
		
		$(obj).attr('class','bg-success text-white');
	}
	//$('#tblPlanDetalle tbody').html("");
	$('#id_empresa').val(id);
	var id_estacionamiento = $('#id_estacionamiento').val();
	$.ajax({
		url: '/estacionamiento/obtener_vehiculo/'+id+'/'+id_estacionamiento,
		dataType: "json",
		success: function(result){
			
			var newRow = "";
			$('#tblPlanDetalle').dataTable().fnDestroy(); //la destruimos
			$('#tblPlanDetalle tbody').html("");
			$(result).each(function (ii, oo) {
				newRow += "<tr class='normal'><td>"+oo.placa+"</td>";
				newRow += '<td class="text-left" style="padding:0px!important;margin:0px!important">';
				newRow += '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
				newRow += '<a href="javascript:void(0)" onClick=fn_save("'+oo.id_vehiculo+'") class="btn btn-sm btn-normal">';
				newRow += '<i class="fa fa-2x fa-check" style="color:green"></i></a></a></div></td></tr>';
			});
			$('#tblPlanDetalle tbody').html(newRow);
			
			$('#tblPlanDetalle').DataTable({
				//"sPaginationType": "full_numbers",
				"paging":false,
				"dom": '<"top">rt<"bottom"flpi><"clear">',
				"language": {"url": "/js/Spanish.json"},
			});
			
			$("#system-search2").keyup(function() {
				var dataTable = $('#tblPlanDetalle').dataTable();
			   dataTable.fnFilter(this.value);
			});
			
		}
		
	});
	
}

function cargar_tipo_proveedor(){
	
	var tipo_proveedor = 0;
	if($('#tipo_proveedor_').is(":checked"))tipo_proveedor = 1;
	
	$("#divPersona").hide();
	$("#divEmpresa").hide();
	
	$("#empresa_").val("");
	$("#persona_").val("");
	
	$("#id_empresa").val("");
	$("#id_persona").val("");
	
	if(tipo_proveedor==0)$("#divPersona").show();
	if(tipo_proveedor==1)$("#divEmpresa").show();
	
}

/*
$('#fecha_solicitud').datepicker({
	autoclose: true,
	dateFormat: 'dd-mm-yy',
	changeMonth: true,
	changeYear: true,
	container: '#openOverlayOpc modal-body'
});
*/
/*
$('#fecha_solicitud').datepicker({
	format: "dd/mm/yyyy",
	startDate: "01-01-2015",
	endDate: "01-01-2020",
	todayBtn: "linked",
	autoclose: true,
	todayHighlight: true,
	container: '#openOverlayOpc modal-body'
});
*/

/*				
format: "dd/mm/yyyy",
startDate: "01-01-2015",
endDate: "01-01-2020",
todayBtn: "linked",
autoclose: true,
todayHighlight: true,
container: '#myModal modal-body'
*/	
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
				Registro Delegado
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					<?php
					
					$display_empresa="display:none";
					$display_persona="display:block";
					?>
					
					<div class="row" style="padding-left:10px">
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Regional</label>
								<select name="id_regional" id="id_regional" class="form-control form-control-sm" <?php if($id>0){echo 'disabled="disabled"';}?> onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($region as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==5)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
					
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Periodo</label>
								<?php if($id>0){?>
								<input type="text" id="periodo" name="periodo" class="form-control form-control-sm" value="<?php echo $periodo_->descripcion?>" readonly="readonly">
								<?php }else{?>
									<?php 
									if($periodo_activo){
									?>
									<select name="id_periodo" id="id_periodo" class="form-control form-control-sm" onChange="obtenerComisionPeridoTipoComision();obtenerConcursoInscripcionPeridoTipoComision()" disabled="disabled">
										<!--<option value="">--Seleccionar--</option>-->
										<?php
										foreach ($periodo as $row) {?>
										<option value="<?php echo $row->id?>" <?php if($row->id==$periodo_activo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
										<?php 
										}
										?>
									</select>
									<?php
									}else{
									?>
									<select name="id_periodo" id="id_periodo" class="form-control form-control-sm" onChange="obtenerComisionPeridoTipoComision();obtenerConcursoInscripcionPeridoTipoComision()">
										<!--<option value="">--Seleccionar--</option>-->
										<?php
										foreach ($periodo as $row) {?>
										<option value="<?php echo $row->id?>" <?php if($row->id==$periodo_ultimo->id)echo "selected='selected'"?>><?php echo $row->descripcion?></option>
										<?php 
										}
										?>
									</select>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Tipo Comisi&oacute;n</label>
								<?php if($id>0){?>
								<input type="text" id="tipo_comision" name="tipo_comision" class="form-control form-control-sm" value="<?php echo $tipo_comision_->denominacion?>" readonly="readonly">
								<?php }else{?>
								<select name="id_tipo_comision" id="id_tipo_comision" class="form-control form-control-sm" onChange="obtenerComisionPeridoTipoComision();obtenerConcursoInscripcionPeridoTipoComision()">
									<option value="">--Seleccionar--</option>
									<?php
									foreach ($tipo_comision as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php //if($row->id==$comision->id_periodo_comisiones)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
								<?php } ?>
							</div>
						</div>
					
					</div>
					
					<div class="row" style="padding-left:10px">
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label form-control-sm">Comision</label>
								<?php if($id>0){?>
								<select name="id_comision" id="id_comision" class="form-control form-control-sm" disabled="disabled" >
									<option value="">--Seleccionar--</option>
									<?php
									foreach ($comision as $row) {?>
									<option value="<?php echo $row->id?>" <?php if($row->id==$id)echo "selected='selected'"?>><?php echo $row->comision." ".$row->denominacion?></option>
									<?php 
									}
									?>
								</select>
								<?php }else{?>
								<select name="id_comision" id="id_comision" class="form-control form-control-sm" onChange="">
									<option value="">--Seleccionar--</option>
									<?php
									//foreach ($comision as $row) {?>
									<!--<option value="<?php //echo $row->id?>"><?php //echo $row->comision." ".$row->denominacion?></option>-->
									<?php 
									//}
									?>
								</select>
								<?php } ?>
							</div>
						</div>
						
					</div>
					
					
					<div class="row" style="padding-left:10px">
						<div class="col-lg-8">
							<div class="form-group">
								<label class="control-label form-control-sm">Delegado Titular 1</label>
								
								<input type="hidden" name="id_comision_delegado_1" id="id_comision_delegado_1" value="<?php if(isset($comisionDelegado[0]->id))echo $comisionDelegado[0]->id?>" />
								
								<select name="id_concurso_inscripcion" id="id_concurso_inscripcion" class="form-control form-control-sm" onChange="">
									<option value="">--Seleccionar--</option>
									<?php
									foreach ($concurso_inscripcion as $row) {?>
									<option value="<?php echo $row->id?>" <?php if(isset($comisionDelegado[0]->id_agremiado) && $row->id_agremiado==$comisionDelegado[0]->id_agremiado)echo "selected='selected'"?>><?php echo $row->numero_cap." - ".$row->apellido_paterno." ".$row->apellido_materno." ".$row->nombres." - ".$row->puesto?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-4" id="divCoordinador1" style=" <?php if(isset($tipo_comision_->codigo) && $tipo_comision_->codigo==2)echo "display:none";?> ">
							<div class="form-group">
								<label class="control-label form-control-sm">Coordinador</label>
								<br>
								<input type="checkbox" style="margin-left:30px;width:18px;height:18px;margin-top:6px" name="coordinador" value="1" <?php if(isset($comisionDelegado[0]->coordinador) && $comisionDelegado[0]->coordinador==1)echo "checked='checked'"?> onChange="habilitar(this)" />
							</div>
						</div>
						
					</div>
					
					<?php //echo $tipo_comision_->codigo."cccc"?>
					
					<div class="row" id="divDelegado2" style="padding-left:10px;<?php if(isset($tipo_comision_->codigo) && $tipo_comision_->codigo==2)echo "display:none";?>"  >
						
						<div class="col-lg-8">
							<div class="form-group">
								<label class="control-label form-control-sm">Delegado Titular 2</label>
								<input type="hidden" name="id_comision_delegado_2" id="id_comision_delegado_2" value="<?php if(isset($comisionDelegado[1]->id))echo $comisionDelegado[1]->id?>" />
								<select name="id_concurso_inscripcion2" id="id_concurso_inscripcion2" class="form-control form-control-sm" onChange="">
									<option value="">--Seleccionar--</option>
									<?php
									foreach ($concurso_inscripcion as $row) {?>
									<option value="<?php echo $row->id?>" <?php if(isset($comisionDelegado[1]->id_agremiado) && $row->id_agremiado==$comisionDelegado[1]->id_agremiado)echo "selected='selected'"?>><?php echo $row->numero_cap." - ".$row->apellido_paterno." ".$row->apellido_materno." ".$row->nombres." - ".$row->puesto?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Coordinador</label>
								<br>
								<input type="checkbox" style="margin-left:30px;width:18px;height:18px;margin-top:6px" name="coordinador" value="2" <?php if(isset($comisionDelegado[1]->coordinador) && $comisionDelegado[1]->coordinador==1)echo "checked='checked'"?> onChange="habilitar(this)" />
							</div>
						</div>
						
					</div>
					
					
					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
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

