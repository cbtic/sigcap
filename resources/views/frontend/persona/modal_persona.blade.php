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
	max-width:92%!important
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
	$('#hora_solicitud').mask('00:00');
	//$("#id_empresa").select2({ width: '100%' });
});
</script>

<script type="text/javascript">

$('#openOverlayOpc').on('shown.bs.modal', function() {
     $('#fecha_solicitudxx').datepicker({
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
    var cobservaciones=$("#frmComentar #estado_").val();
    
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

function fn_save(){  
	var msg = "";
	var _token = $('#_token').val();
	var id = $('#id_per_det').val();
	var id_persona = $('#id').val();

	
	var direccion = $('#direccion_').val();
	var ubigeo = $('#ubigeodireccionprincipal').val();
	//alert(ubigeo); exit();
	var telefono = $('#telefono_').val();
	var email = $('#email_').val();
	var fecha_ingreso = $('#fecha_ingreso_').val();
	var id_condicion_laboral = $('#id_condicion_laboral_').val();
	var id_tipo_planilla = $('#id_tipo_planilla_').val();
	var id_profesion = $('#id_profesion_').val();
	var id_banco_sueldo = $('#id_banco_sueldo_').val();
	var num_cuenta_sueldo = $('#num_cuenta_sueldo_').val();
	var cci_sueldo = $('#cci_sueldo_').val();
	var id_regimen_pensionario = $('#id_regimen_pensionario_').val();
	var id_afp = $('#id_afp_').val();
	var fecha_afiliacion_afp = $('#fecha_afiliacion_afp_').val();
	var id_tipo_comision_afp = $('#id_tipo_comision_afp_').val();
	var cuspp = $('#cuspp_').val();
	var fecha_cese = $('#fecha_cese_').val();
	var fecha_termino_contrato = $('#fecha_termino_contrato_').val();
	var num_contrato = $('#num_contrato_').val();
	var id_cargo = $('#id_cargo_').val();
	var id_nivel = $('#id_nivel_').val();
	var id_banco_cts = $('#id_banco_cts_').val();
	var num_cuenta_cts = $('#num_cuenta_cts_').val();
	var id_moneda_cts = $('#id_moneda_cts_').val();
	var estado = $('#estado_').val();
	var id_ubicacion = $('#id_ubicacion_').val();
	
	var tipo_documento = $('#tipo_documento_').val();
	var numero_documento = $('#numero_documento_').val();
	var fecha_nacimiento = $('#fecha_nacimiento_').val();
	var sexo = $('#sexo_').val();

	var id_area_trabajo = $('#id_area_trabajo_').val();
	var id_unidad_trabajo = $('#id_unidad_trabajo_').val();

	if(tipo_documento == "0")msg += "Debe ingresar el Tipo de Documento <br>";
	if(numero_documento == ""){msg += "Debe ingresar el Número de Documento <br>";}
	if(fecha_nacimiento == ""){msg += "Debe ingresar Fecha de Nacimiento <br>";}
	if(sexo == "0"){msg+="Debe ingresar el Genero del personal <br>";} 
	if(id_ubicacion == "0"){msg+="Debe ingresar la Empresa Asociada al Personal <br>";} 
	if(id_regimen_pensionario == "0"){msg+="Debe ingresar el Régimen Pensionario<br>";} 
	if(id_condicion_laboral == "0"){msg+="Debe ingresar la Condición Laboral <br>";}
	if(id_area_trabajo == ""){msg+="Debe ingresar el Area de Trabajo <br>";}
	if(id_unidad_trabajo == ""){msg+="Debe ingresar la Unidad de Trabajo <br>";}

	var edad = calcularEdad(fecha_nacimiento);
	if(edad < 18){msg+="El personal es Menor de Edad: "+edad+"<br>";}

	

	if(estado == "0"){msg+="Debe ingresar el Estado Laboral <br>";}

	if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
		$.ajax({
				url: "/persona/send_personad",
				type: "POST",
				data : {_token:_token,id:id,id_persona:id_persona,direccion:direccion,ubigeo:ubigeo,telefono:telefono,email:email,
						fecha_ingreso:fecha_ingreso,id_condicion_laboral:id_condicion_laboral,id_tipo_planilla:id_tipo_planilla,id_profesion:id_profesion,
						id_banco_sueldo:id_banco_sueldo,num_cuenta_sueldo:num_cuenta_sueldo,cci_sueldo:cci_sueldo,id_regimen_pensionario:id_regimen_pensionario,
						id_afp:id_afp,fecha_afiliacion_afp:fecha_afiliacion_afp,id_tipo_comision_afp:id_tipo_comision_afp,cuspp:cuspp,fecha_cese:fecha_cese,
						fecha_termino_contrato:fecha_termino_contrato,num_contrato:num_contrato,id_cargo:id_cargo,id_nivel:id_nivel,id_banco_cts:id_banco_cts,
						num_cuenta_cts:num_cuenta_cts,id_moneda_cts:id_moneda_cts,estado:estado,id_ubicacion:id_ubicacion,fecha_nacimiento:fecha_nacimiento,sexo:sexo,
						id_area_trabajo:id_area_trabajo,id_unidad_trabajo:id_unidad_trabajo},
				success: function (result) {
					$('#openOverlayOpc').modal('hide');
					datatablenew();
				}
		});
	}
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
				Datos Laborales
			</div>
			
            <div class="card-body">
					<div id="general" class="tab-pane fade in active" style="opacity:100">							
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="id" id="id" value="<?php echo $id?>">
						<input type="hidden" name="id_per_det" id="id_per_det" value="<?php echo $persona_detalle->id?>">
						<div class="row">
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Tipo Doc.</label>
									<select name="tipo_documento_" id="tipo_documento_" class="form-control form-control-sm" <?php if($id!=0)echo "readonly"?>>
										<option value="0">Seleccionar</option>
										<?php foreach($tipo_documento as $row){?>
										<option value="<?php echo $row->id?>" <?php if($row->id==$persona->tipo_documento)echo "selected='selected'"?> ><?php echo $row->desc_docu_did?></option>
										<?php }?>
										@error('tipo_documento_') <span ...>Dato requerido</span> @enderror
									</select>
								</div>
							</div>							
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">N. Doc.</label>
									<input id="numero_documento_" name="numero_documento_" class="form-control form-control-sm" <?php if($id!=0)echo "readonly"?>  value="<?php echo $persona->numero_documento?>" type="text" onblur="obtenerBeneficiario()">
									@error('numero_documento_') <span ...>Dato requerido</span> @enderror
								</div>								
							</div>
							<div class="col-lg-4">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Nombres</label>
									<input id="nombres_" name="nombres_" class="form-control form-control-sm" readonly value="<?php echo $persona->apellido_paterno." ".$persona->apellido_materno." ".$persona->nombres?>" type="text">
									@error('nombres_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>	
							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label">F. Nac</label>
									<input placeholder="Fecha Nacimiento" autocomplete="off" type="text" wire:model="fecha_nacimiento_" id="fecha_nacimiento_" class="form-control form-control-sm datepicker" <?php if($id!=0)echo "readonly"?> data-provide="datepicker" data-date-autoclose="true" 
										data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
										onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $persona->fecha_nacimiento?>" >
										@error('fecha_nacimiento_') <span ...>Dato requerido</span> @enderror										
								</div>
							</div>	

							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Género</label>
									<select name="sexo_" id="sexo_" class="form-control form-control-sm" <?php if($id!=0)echo "readonly"?>>
										<option value="0">Seleccionar</option>
										<option value="M" <?php if($persona->sexo == "M")echo "selected='selected'" ?> ><?php echo "MASCULINO"?></option>
										<option value="F" <?php if($persona->sexo == "F")echo "selected='selected'" ?> ><?php echo "FEMENINO"?></option>									
									</select>
									@error('sexo_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
						</div>			
						<div class="row">
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Tel&eacute;fono</label>
									<input id="telefono_" name="telefono_" class="form-control form-control-sm"  value="<?php echo $persona_detalle->telefono?>" type="text">
									@error('telefono_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>							
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Correo</label>
									<input id="email_" name="email_" class="form-control form-control-sm"  value="<?php echo $persona_detalle->email?>" type="text">
									@error('email_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Dirección</label>
									<input id="direccion_" name="direccion_" class="form-control form-control-sm"  value="<?php echo $persona_detalle->direccion?>" type="text">
									@error('direccion_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Empresa</label>
									<select name="id_ubicacion_" id="id_ubicacion_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($empresas as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_ubicacion)echo "selected='selected'"?> ><?php echo $row->razon_social?></option>
											<?php  endforeach;?>
									</select>
									@error('id_ubicacion_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>															
						</div>

						<div class="row">
							<div class="col-lg-2">
                                <div class="form-group">
									<label class="control-label">Departamento</label>
									<?php 										
										$idDepartamento = 0;
										$idProvincia = 0;
										$idDistrito = 0;

										if($persona_detalle->ubigeo!=""){
											$idDepartamento = substr($persona_detalle->ubigeo, 0, 2);
											$idProvincia = substr($persona_detalle->ubigeo, 0, 4);
											$idDistrito = $persona_detalle->ubigeo;
										}

										//print_r ("dep".$idDepartamento);
										//print_r ("pro".$idProvincia);
										//print_r ("dis".$idDistrito);

									?>
									<select class="form-control form-control-sm" id="txtIdUbiDepar" name="txtIdUbiDepar" onChange="obtenerProvincia();">
										<option value="">- Seleccione -</option>
										<?php 
										if($departamento!=""){
											foreach ($departamento as $row) {?>
												<option value="<?php echo $row->id?>" <?php if($row->id == $idDepartamento)echo "selected='selected'"?> ><?php echo $row->nombre?></option>
										<?php 
											}
										} 
										?>
									</select>
																		
                                </div><!--form-group-->
                            </div><!--col-->
							
							<div class="col-lg-2">
                                <div class="form-group">
									<label class="control-label">Provincia</label>
                                    <select class="form-control form-control-sm" id="txtIdUbiProv" name="txtIdUbiProv" onChange="obtenerDistrito()">
										<option value="">- Seleccione -</option>
										<?php 
										if($provincia!=""){
											foreach ($provincia as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id == $idProvincia)echo "selected='selected'"?> ><?php echo $row->nombre?></option>
										<?php 
											} 
										}
										?>
									</select>
                                </div><!--form-group-->
                            </div><!--col-->
							
							<div class="col-lg-2">
                                <div class="form-group">
									<label class="control-label">Distrito</label>
									<select class="form-control form-control-sm" id="ubigeodireccionprincipal" name="ubigeodireccionprincipal">
										<option value="">- Seleccione -</option>
										<?php 
										if($distrito!=""){
											foreach ($distrito as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id == $idDistrito)echo "selected='selected'"?> ><?php echo $row->nombre?></option>
										<?php 
											} 
										}
										?>
									</select>
									<input type="hidden" name="ubigeodireccionprincipalold" id="ubigeodireccionprincipalold" value="<?php echo $persona_detalle->ubigeo?>" >
                                </div><!--form-group-->
                            </div><!--col-->
							
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Cargo</label>
									<select name="id_cargo_" id="id_cargo_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($cargo as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_cargo)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_cargo_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Nivel</label>
									<select name="id_nivel_" id="id_nivel_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($nivel as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_nivel)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_nivel_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>								
						</div>

						<div class="row">
							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label">F. Ingreso</label>
									<input placeholder="Fecha Ingreso" autocomplete="off" type="text" wire:model="fecha_ingreso_" id="fecha_ingreso_" class="form-control form-control-sm datepicker" data-provide="datepicker" data-date-autoclose="true" 
										data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
										onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $persona_detalle->fecha_ingreso?>" >
											@error('fecha_ingreso_') <span ...>Dato requerido</span> @enderror										
								</div>
							</div>											
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Condición Laboral</label>
									<select name="id_condicion_laboral_" id="id_condicion_laboral_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($condLaboral as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_condicion_laboral)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_condicion_laboral_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Profesión</label>
									<select name="id_profesion_" id="id_profesion_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($profesiones as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_profesion)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_profesion_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Tipo Planilla</label>
									<select name="id_tipo_planilla_" id="id_tipo_planilla_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($tipPlanilla as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_tipo_planilla)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_tipo_planilla_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Banco Sueldo</label>
									<select name="id_banco_sueldo_" id="id_banco_sueldo_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($banco as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_banco_sueldo)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_banco_sueldo_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Cuenta Sueldo</label>
									<input id="num_cuenta_sueldo_" name="num_cuenta_sueldo_" class="form-control form-control-sm"  value="<?php echo $persona_detalle->num_cuenta_sueldo?>" type="text">
									@error('num_cuenta_sueldo_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">CCI Sueldo</label>
									<input id="cci_sueldo_" name="cci_sueldo_" class="form-control form-control-sm"  value="<?php echo $persona_detalle->cci_sueldo?>" type="text">
									@error('cci_sueldo_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>																						
						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Regimen Pensionario</label>
									<select name="id_regimen_pensionario_" id="id_regimen_pensionario_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($regPension as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_regimen_pensionario)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_regimen_pensionario_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">AFP</label>
									<select name="id_afp_" id="id_afp_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($afp as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_afp)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_afp_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label">F. Afiliación Afp</label>
									<input placeholder="Fecha Afliación Afp" autocomplete="off" type="text" wire:model="fecha_afiliacion_afp_" id="fecha_afiliacion_afp_" class="form-control form-control-sm datepicker" data-provide="datepicker" data-date-autoclose="true" 
										data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
										onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $persona_detalle->fecha_afiliacion_afp?>">
											@error('fecha_afiliacion_afp_') <span ...>Dato requerido</span> @enderror										
								</div>
							</div>							
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Comisión Afp</label>
									<select name="id_tipo_comision_afp_" id="id_tipo_comision_afp_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($comisionAfp as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_tipo_comision_afp)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_tipo_comision_afp_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">CUSPP</label>
									<input id="cuspp_" name="cuspp_" class="form-control form-control-sm"  value="<?php echo $persona_detalle->cuspp?>" type="text">
									@error('cuspp_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>																								
						</div>

						<div class="row">
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Banco CTS</label>
									<select name="id_banco_cts_" id="id_banco_cts_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($banco as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_banco_cts)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_banco_cts_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Num. Cuenta</label>
									<input id="num_cuenta_cts_" name="num_cuenta_cts_" class="form-control form-control-sm"  value="<?php echo $persona_detalle->num_cuenta_cts?>" type="text">
									@error('num_cuenta_cts_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>	
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Moneda</label>
									<select name="id_moneda_" id="id_moneda_" class="form-control form-control-sm">
											<option value="0">Seleccionar</option>
											<?php foreach($moneda as $row):?>
												<option value="<?php echo $row->id?>" <?php if($row->id==$persona_detalle->id_moneda_cts)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
											<?php  endforeach;?>
									</select>
									@error('id_moneda_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>										
						</div>
						<div class="row">
							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label">F. Cese</label>
									<input placeholder="Fecha Cese" autocomplete="off" type="text" wire:model="fecha_cese_" id="fecha_cese_" class="form-control form-control-sm datepicker" data-provide="datepicker" data-date-autoclose="true" 
										data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
										onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $persona_detalle->fecha_cese?>">
											@error('fecha_cese_') <span ...>Dato requerido</span> @enderror										
								</div>
							</div>	
							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label">Terrmino Contrato</label>
									<input placeholder="Fecha termino" autocomplete="off" type="text" wire:model="fecha_termino_contrato_" id="fecha_termino_contrato_" class="form-control form-control-sm datepicker" data-provide="datepicker" data-date-autoclose="true" 
										data-date-format="yyyy-mm-dd" data-date-today-highlight="true"                        
										onchange="this.dispatchEvent(new InputEvent('input'))" value="<?php echo $persona_detalle->fecha_termino_contrato?>">
											@error('fecha_termino_contrato_') <span ...>Dato requerido</span> @enderror										
								</div>
							</div>	
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Num. Contrato</label>
									<input id="num_contrato_" name="num_contrato_" class="form-control form-control-sm"  value="<?php echo $persona_detalle->num_contrato?>" type="text">
									@error('num_contrato_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>
							
							<div class="col-lg-2">
                                <div class="form-group">
									<label class="control-label">Area Trabajo</label>
                                    <select class="form-control form-control-sm" id="id_area_trabajo_" name="id_area_trabajo_" onChange="obtenerUnidad()">
										<option value="">- Seleccione -</option>
										<?php 
										if($area_trabajo!=""){
											foreach ($area_trabajo as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id ==  $persona_detalle->id_area_trabajo)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
										<?php 
											} 
										}
										?>
									</select>
                                </div><!--form-group-->
                            </div><!--col-->

							<div class="col-lg-2">
                                <div class="form-group">
									<label class="control-label">Unidad Trabajo</label>
                                    <select class="form-control form-control-sm" id="id_unidad_trabajo_" name="id_unidad_trabajo_">
										<option value="">- Seleccione -</option>
										<?php 
										if($unidad_trabajo!=""){
											foreach ($unidad_trabajo as $row) {?>
											<option value="<?php echo $row->id?>" <?php if($row->id ==  $persona_detalle->id_unidad_trabajo)echo "selected='selected'"?> ><?php echo $row->denominacion?></option>
										<?php 
											} 
										}
										?>
									</select>
                                </div><!--form-group-->
                            </div><!--col-->
							
											
							<div class="col-lg-2">
								<div class="form-group" style="padding-top:0px;padding-bottom:0px;margin-top:0px;margin-bottom:0px">
									<label class="control-label">Estado</label>
									<select name="estado_" id="estado_"
										class="form-control form-control-sm">
										<option value="0">Seleccionar</option>
										<option value="A" <?php if($persona->estado == "A")echo "selected='selected'" ?> ><?php echo "ACTIVO"?></option>
										<option value="C" <?php if($persona->estado == "C")echo "selected='selected'" ?> ><?php echo "CESADO"?></option>
									</select>
									@error('estado_') <span ...>Dato requerido</span> @enderror
								</div>
							</div>								
						</div>
										
						<div style="margin-top:10px;float:right" class="form-group">
							<div class="col-sm-12 controls">
								<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
									<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
								</div>
													
							</div>
						</div> 						
					</div>
				

                       <!-- /.box -->
        	</div>
        	    <!--/.col (left) -->
        </div>
          <!-- /.row -->
          <!-- </section> -->
         <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>   

<!--
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

-->

<script type="text/javascript">
$(document).ready(function() {
	
	//$('#txtIdUbiDepar').select2();
	//$('#txtIdUbiProv').select2();
	//$('#ubigeodireccionprincipal').select2();
	
	$('#telefono_').mask("900000000");

/*
	
	$("#id_especie").select2({ width: '100%' });
	
	$('#numero_placa').focus();
	$('#numero_placa').mask('AAA-000');
	$('#vehiculo_numero_placa').mask('AAA-000');
	
	$('#vehiculo_numero_placa').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});
	
	$('#vehiculo_empresa').keyup(function() {
		this.value = this.value.toLocaleUpperCase();
	});
		
	$('#vehiculo_empresa').focusin(function() { $('#vehiculo_empresa').select(); });
	
	$('#vehiculo_empresa').autocomplete({
		appendTo: "#vehiculo_empresa_busqueda",
		source: function(request, response) {
			$.ajax({
			url: '/pesaje/list/'+$('#vehiculo_empresa').val(),
			dataType: "json",
			success: function(data){
			   var resp = $.map(data,function(obj){
					var hash = {key: obj.id, value: obj.razon_social, ruc: obj.ruc};
					//if(obj.razon_social=='') { actualiza_ruc("") }
					return hash;
			   }); 
			   response(resp);
			},
			error: function() {
				//actualiza_ruc("");
			}
		});
		},
		select: function (event, ui) {
			$('#vehiculo_empresa').blur();
			$('#ruc').val(ui.item.ruc);
			//if (ui.item.value != ''){
			//actualiza_ruc(ui.item.value);
			//}
			obtener_vehiculos(ui.item.key);
			$("#id_empresa").val(ui.item.key); // save selected id to hidden input
		},
			minLength: 2,
			delay: 100
	  });
	  
	
	$('#modalVehiculoSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');
	
		$.ajax({
		  data: $('#modalVehiculoForm').serialize(),
		  url: "/vehiculo/send_ajax_asignar",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {
	
			  $('#modalVehiculoForm').trigger("reset");
			  //$('#vehiculoModal').modal('hide');
			  $('#openOverlayOpc').modal('hide');

        alert(data.msg);
        $("#nombre_empresa").val(data.vehiculo_empresa);
        $("#numero_placa").val(data.vehiculo_numero_placa);
        $("#numero_ejes").val(data.ejes);
        $("#numero_documento").val(data.ruc);
        $("#nombres_razon_social").val(data.razon_social);
        $("#empresa_direccion").val(data.direccion);

        $("#modalVehiculoSaveBtn").html("Grabar");
	
		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalVehiculoSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
	});	  
	*/
	
});



function obtenerBeneficiario(){
		
		var tipo_documento = $("#tipo_documento_").val();
		var numero_documento = $("#numero_documento_").val();
		var msg = "";

		//alert(tipo_documento);
		//alert(numero_documento);
		//exit();
		
		if (msg != "") {
			bootbox.alert(msg);
			return false;
		}

		if (tipo_documento == "0" || numero_documento == "") {
			bootbox.alert(msg);
			return false;
		}

		
		$.ajax({
			url: '/persona/buscar_persona/' + tipo_documento + '/' + numero_documento,
			dataType: "json",
			success: function(result){
				
				if(result.sw==2){
					bootbox.alert("No es colaborador de CAP - Lima, los datos han sido obtenidos de Reniec");
					//$('#telefono').attr("disabled",false);
					//$('#email').attr("disabled",false);
				}
				if(result.sw==3){
					bootbox.alert("El numero de documento no se encontro en CAP - Lima ni en Reniec");
					//$('#numero_documento').val("");
					
					/*
					$('#numero_documento').attr("disabled",false);
					$('#nombres').attr("disabled",false).attr("placeholder","Ingrese Nombres");
					
					$('#divApellidoP').show();
					$('#divApellidoM').show();
					
					$('#apellidop').attr("placeholder","Apellido Paterno");
					$('#apellidom').attr("placeholder","Apellido Materno");
					
					$('#telefono').attr("disabled",false);
					$('#email').attr("disabled",false);
					*/
					return false;
				}
				

				var persona = result.persona;
				var persona_detalle = result.persona_detalle;
				//bootbox.alert("Datos recuperados ->" + persona.apellido_materno);
				
				var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
				$('#nombres_').val(nombre);
				$('#fecha_nacimiento_').val(persona.fecha_nacimiento);
				$('#sexo_').val(persona.sexo);
				$('#id').val(persona.id);
				$('#id_per_det').val(0);
				

				$('#telefono_').val(persona_detalle.telefono);
				$('#email_').val(persona_detalle.email);

				$('#tipo_documento_').attr("disabled",true);
				$('#numero_documento_').attr("disabled",true);
			}	
		},
		{
			url: '/persona/buscar_persona/' + tipo_documento + '/' + numero_documento,
			dataType: "json",
			success: function(result){
				
				if(result.sw==2){
					bootbox.alert("No es colaborador de CAP - Lima, los datos han sido obtenidos de Reniec");
					//$('#telefono').attr("disabled",false);
					//$('#email').attr("disabled",false);
				}
				if(result.sw==3){
					bootbox.alert("El numero de documento no se encontro en CAP - Lima ni en Reniec");
					//$('#numero_documento').val("");
					
					/*
					$('#numero_documento').attr("disabled",false);
					$('#nombres').attr("disabled",false).attr("placeholder","Ingrese Nombres");
					
					$('#divApellidoP').show();
					$('#divApellidoM').show();
					
					$('#apellidop').attr("placeholder","Apellido Paterno");
					$('#apellidom').attr("placeholder","Apellido Materno");
					
					$('#telefono').attr("disabled",false);
					$('#email').attr("disabled",false);
					*/
					return false;
				}
				

				var persona = result.persona;
				var persona_detalle = result.persona_detalle;
				//bootbox.alert("Datos recuperados ->" + persona.apellido_materno);
				
				var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
				$('#nombres_').val(nombre);
				$('#fecha_nacimiento_').val(persona.fecha_nacimiento);
				$('#sexo_').val(persona.sexo);
				$('#id').val(persona.id);
				$('#id_per_det').val(0);
				

				$('#telefono_').val(persona_detalle.telefono);
				$('#email_').val(persona_detalle.email);

				$('#tipo_documento_').attr("disabled",true);
				$('#numero_documento_').attr("disabled",true);
			}	
		}
		);
		
	}

	function obtenerProvincia(){
	
	var id = $('#txtIdUbiDepar').val();
	if(id=="")return false;
	$('#txtIdUbiProv').attr("disabled",true);
	$('#ubigeodireccionprincipal').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	//alert(id); exit();

	$.ajax({
		url: '/ubigeo/obtener_provincia/'+id,		
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>Seleccionar</option>";
			$('#txtIdUbiProv').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id+"'>"+oo.nombre+"</option>";
			});
			$('#txtIdUbiProv').html(option);
			$('#txtIdUbiProv').select2();
			
			var option2 = "<option value=''>Seleccionar</option>";
			$('#ubigeodireccionprincipal').html(option2);
			
			$('#txtIdUbiProv').attr("disabled",false);
			$('#ubigeodireccionprincipal').attr("disabled",false);
			
			$('.loader').hide();
			
		}
		
	});
	
}
function obtenerDistrito(){
	
	var id = $('#txtIdUbiProv').val();
	if(id=="")return false;
	$('#ubigeodireccionprincipal').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/ubigeo/obtener_distrito/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#ubigeodireccionprincipal').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id+"'>"+oo.nombre+"</option>";
			});
			$('#ubigeodireccionprincipal').html(option);
			$('#ubigeodireccionprincipal').select2();
			
			$('#ubigeodireccionprincipal').attr("disabled",false);
			$('.loader').hide();
			
		}
		
	});
	
}
function obtenerUnidad(){
	
	var id = $('#id_area_trabajo_').val();
	if(id=="")return false;
	//$('#ubigeodireccionprincipal').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/unidad/obtener_unidad/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#id_unidad_trabajo_').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id+"'>"+oo.denominacion+"</option>";
			});
			$('#id_unidad_trabajo_').html(option);
			$('#id_unidad_trabajo_').select2();
			
			$('#id_unidad_trabajo_').attr("disabled",false);
			$('.loader').hide();
			
		}
	});	
}

function calcularEdad(fecha_nacimiento) {
    var hoy = new Date();
    var cumpleanos = new Date(fecha_nacimiento);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();
    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
    return edad;
}



</script>

