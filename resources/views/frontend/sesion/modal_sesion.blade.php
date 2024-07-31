<title>Sistema de CAP</title>

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
	max-width:70%!important
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


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<!--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
-->

<!--
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css" />
-->


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

<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
-->

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
	$("#id_concurso_inscripcion").select2({ width: '100%' });
	
	var id = "<?php echo $id?>"; 
	if(id==0){
		var id_periodo = $("#id_periodo_bus").val();
		var tipo_comision = $("#tipo_comision_bus").val();
		var id_comision = $("#id_comision_bus").val();
		
		$("#id_regional").attr("disabled",true);
		$("#id_periodo").val(id_periodo).attr("disabled",true);
		if(tipo_comision>0)$("#tipo_comision").val(tipo_comision).attr("disabled",true);
		
		$("#id_regional_").val(5);
		$("#id_periodo_").val(id_periodo);
		if(tipo_comision>0)$("#tipo_comision_").val(tipo_comision);
		
		obtenerComision();
		obtenerComisionDelegadoNuevo(id_comision);
	}else{
		var fecha_ejecucion = $("#fecha_ejecucion").val();
		var fecha_programado = $("#fecha_programado").val();
		
		if(fecha_ejecucion==""){
			$("#fecha_ejecucion").val(fecha_programado);
		}
	}
	
});

$('#btnImportarDictamenes').click(function () {
	importarDatalicenciaDictamenes();
});

function importarDatalicenciaDictamenes(){

	var fecha_ejecucion = $('#fecha_ejecucion').val();
	var id_comision = $('#id_comision').val();
	var id_sesion = $('#id').val();

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();

	$.ajax({
		url: "/sesion/importar_dataLicencia_dictamenes/"+fecha_ejecucion+"/"+id_comision+"/"+id_sesion,
		type: "GET",
		success: function(result){

			$('.loader').hide();
			
			//cargarDelegados();
			cargarDictamenNuevo(id_sesion);
			
			bootbox.alert("Se import&oacute; exitosamente los datos"); 
			
			datatablenew();
			
		}
	});
}

</script>

<script type="text/javascript">
//var mainNavigationOffset = $('.js-nav-container > ul').offset();
//var left = 0;

$('#openOverlayOpc').on('shown.bs.modal', function() {

     $('#fecha_programado').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 
	 $('#fecha_ejecucion').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
     });
	 
});

$(document).ready(function() {
	 
	$('#fecha_programado').datepicker({
	   format: "dd-mm-yyyy",
	   autoclose: true,
	});
	
	$('#fecha_ejecucion').datepicker({
	   format: "dd-mm-yyyy",
	   autoclose: true,
	});

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

function fn_save(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_comision = $('#id_comision').val();
	var id_regional = $('#id_regional').val();
	var id_tipo_sesion = $('#id_tipo_sesion').val();
	//var fecha_programado = $('#fecha_programado').val();
	//var hora_inicio = $('#hora_inicio').val();
	//var hora_fin = $('#hora_fin').val();
	//var fecha_ejecucion = $('#fecha_ejecucion').val();
	var observaciones = $('#observaciones').val();
	//var id_estado_sesion = $('#id_estado_sesion').val();
	//alert($('#frmSesion').serialize());return false;
    $.ajax({
			url: "/sesion/send_sesion",
            type: "POST",
			data : $('#frmSesion').serialize(),
            //data : {_token:_token,id:id,id_comision:id_comision,id_regional:id_regional,id_tipo_sesion:id_tipo_sesion,fecha_programado:fecha_programado,hora_inicio:hora_inicio,hora_fin:hora_fin,fecha_ejecucion:fecha_ejecucion,observaciones:observaciones,id_estado_sesion:id_estado_sesion},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				datatablenew();
				//obtenerInversionista(0);
				//obtenerDetalleInversionista(0);
				//window.location.reload();
				
            }
    });
}

function fn_save_dia(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_comision = $('#id_comision').val();
	var id_regional = $('#id_regional').val();
	var id_tipo_sesion = $('#id_tipo_sesion').val();
	var observaciones = $('#observaciones').val();
	
	$.ajax({
			url: "/sesion/update_sesion_dia_semana",
            type: "POST",
			data : $('#frmSesion').serialize(),
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				datatablenew();
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

var id = "<?php echo $id?>";
var id_periodo = "<?php echo $comision->id_periodo_comisiones?>";
var tipo_comision = "<?php echo $comision->id_tipo_comision?>";
var id_comision = "<?php echo $comisionSesion->id_comision?>";
//alert(id);

$("#id_comision").attr("disabled",false);
$("#id_tipo_sesion").attr("disabled",false);
$("#id_periodo").attr("disabled",false);
$("#id_regional").attr("disabled",false);
$("#observaciones").attr("disabled",false);
$("#tipo_comision").attr("disabled",false);

if(id>0){
	obtenerComisionEdit(id_periodo,tipo_comision,id_comision);
	$("#id_comision").attr("disabled",true);
	$("#id_tipo_sesion").attr("disabled",true);
	$("#id_periodo").attr("disabled",true);
	$("#id_regional").attr("disabled",true);
	//$("#observaciones").attr("disabled",true);
	$("#tipo_comision").attr("disabled",true);
	cargarDelegados();
	cargarDictamenNuevo(id);
}

function obtenerComisionEdit(id_periodo,tipo_comision,id_comision){
	
	$.ajax({
		url: '/sesion/obtener_comision/'+id_periodo+'/'+tipo_comision,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_comision').html("");
			var sel = "";
			$(result).each(function (ii, oo) {
				sel = "";
				if(id_comision==oo.id)sel = "selected='selected'";
				option += "<option value='"+oo.id+"' "+sel+">"+oo.denominacion+" "+oo.comision+"</option>";
			});
			$('#id_comision').html(option);
		}
		
	});
	
}

function fn_validar_dia(opc){
	
	if(opc==1){
		$("#semana1").hide();
		$("#semana2").show();
		$("#btnActualizarSemana").hide();
		$("#btnGuardarSemana").show();
		$("#btnCancelarSemana").show();
	}
	
	if(opc==2){
		$("#semana1").show();
		$("#semana2").hide();
		$("#btnActualizarSemana").show();
		$("#btnGuardarSemana").hide();
		$("#btnCancelarSemana").hide();
	}
}


function cargarDelegados(){
    
	var id=$("#id").val();
	
    $("#tblDelegado tbody").html("");
	$.ajax({
			url: "/sesion/obtener_delegados/"+id,
			type: "GET",
			success: function (result) {  
					$("#tblDelegado tbody").html(result);
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
				Registro Programacion de Sesi&oacute;n
			</div>
			
            <div class="card-body">

			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:0px">
					
					<form class="form-horizontal" method="post" action="" id="frmSesion" autocomplete="off">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					<div class="row" style="padding-left:0px">
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Regional</label>
								<input type="hidden" name="id_regional_" id="id_regional_" value="" />
								<select name="id_regional" id="id_regional" class="form-control form-control-sm" onChange="">
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
								<input type="hidden" name="id_periodo_" id="id_periodo_" value="" />
								<select name="id_periodo" id="id_periodo" class="form-control form-control-sm" onChange="obtenerComision()">
									<option value="">--Seleccionar--</option>
									<?php
									foreach ($periodo as $row) {?>
									<option value="<?php echo $row->id?>" 
										<?php if($id>0 && $row->id==$comision->id_periodo_comisiones)echo "selected='selected'"?>
										<?php if($id==0 && $row->id==$periodo_ultimo->id)echo "selected='selected'"?>
									><?php echo $row->descripcion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Tipo Comisi&oacute;n</label>
								<input type="hidden" name="tipo_comision_" id="tipo_comision_" value="" />
								<select name="tipo_comision" id="tipo_comision" class="form-control form-control-sm" onChange="obtenerComision()">
									<option value="0">--Tipo Comisi&oacute;n--</option>
										<?php
										foreach ($tipo_comision as $row) {?>
											<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$comision->id_tipo_comision)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
										}
										?>
								</select>
							</div>
						</div>
						
					</div>
					
					<div class="row" style="padding-left:5px">
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Comision</label>
								<select name="id_comision" id="id_comision" class="form-control form-control-sm" onChange="obtenerComisionDelegado()">
									<option value="">--Seleccionar--</option>
								</select>
							</div>
						</div>
						
						<div class="col-lg-4">
						
							<div class="form-group">
								
								<div class="row">
								<div class="col-lg-7">
								<label class="control-label form-control-sm">Dia Semana</label>
								
								<div id="semana1">
								<input type="text" id="dia_semana" name="dia_semana" class="form-control form-control-sm" value="<?php if($dia_semana!=null){echo $dia_semana[0]->denominacion;}?>" readonly="readonly">
								<input type="hidden" id="id_dia_semana" name="id_dia_semana" class="form-control form-control-sm" value="<?php if($dia_semana!=null){echo $dia_semana[0]->codigo;}?>">
								</div>
								<div id="semana2" style="display:none">
								<select name="dia_semana_nuevo" id="dia_semana_nuevo" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($dia_semanas as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$comision->id_dia_semana)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
								</div>
								
								</div>
								<div class="col-lg-5">
								<label class="control-label form-control-sm"></label>
								
								<a href="javascript:void(0)" id="btnActualizarSemana" style="margin-top:20px" onClick="fn_validar_dia(1)" class="btn btn-sm btn-warning">Actualizar</a>
								<a href="javascript:void(0)" style="display:none;float:left" id="btnGuardarSemana" onClick="fn_save_dia()" class="btn btn-sm btn-success">Guardar</a>
								<a href="javascript:void(0)" style="display:none;float:left" id="btnCancelarSemana" onClick="fn_validar_dia(2)" class="btn btn-sm btn-danger">Cancelar</a>
								
								</div>
								
								</div>
								
							</div>
							
							
						</div>
														
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Tipo Sesi&oacute;n</label>
								<select name="id_tipo_sesion" id="id_tipo_sesion" class="form-control form-control-sm" onChange="habilitarProgramacion()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_programacion as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$comisionSesion->id_tipo_sesion)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						
						<?php if($id==0){?>
						<div id="divFechaProgramado" class="col-lg-4" style="display:none">
							<div class="form-group">
								<label class="control-label form-control-sm">F. Programaci&oacute;n</label>
								<input id="fecha_programado" name="fecha_programado" class="form-control form-control-sm"  value="" type="text"/>
							</div>
						</div>
						<?php }?>
						
						<?php if($id>0){?>
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">F. Programaci&oacute;n</label>
								<input id="fecha_programado" name="fecha_programado" class="form-control form-control-sm"  value="<?php if($comisionSesion->fecha_programado!="")echo date("d-m-Y", strtotime($comisionSesion->fecha_programado))?>" type="text" disabled="disabled">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Ejecuci&oacute;n</label>
								<input id="fecha_ejecucion" name="fecha_ejecucion" class="form-control form-control-sm"  value="<?php if($comisionSesion->fecha_ejecucion!="")echo date("d-m-Y", strtotime($comisionSesion->fecha_ejecucion))?>" type="text">
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Hora Inicio</label>
								<input id="hora_inicio" name="hora_inicio" class="form-control form-control-sm" value="<?php echo ($comisionSesion->hora_inicio!="")?$comisionSesion->hora_inicio:"09:00"?>" type="time">
								
							</div>
						</div>
						
						<div class="col-lg-2">
							<div class="form-group">
								<label class="control-label form-control-sm">Hora Fin</label>
								<input id="hora_fin" name="hora_fin" class="form-control form-control-sm" value="<?php echo ($comisionSesion->hora_fin!="")?$comisionSesion->hora_fin:"15:00"?>" type="time">
								
							</div>
						</div>
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Estado Sesi&oacute;n</label>
								<select name="id_estado_sesion" id="id_estado_sesion" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($estado_sesion as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$comisionSesion->id_estado_sesion)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Aprobaci&oacute;n Sesi&oacute;n</label>
								<select name="id_estado_aprobacion" id="id_estado_aprobacion" class="form-control form-control-sm" onChange="habilitarAprobarPago()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($estado_sesion_aprobado as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php 
									if($comisionSesion->id_estado_aprobacion>0){
										if($row->codigo==$comisionSesion->id_estado_aprobacion){
											echo "selected='selected'";
										}
									}else{
										if($row->codigo=="1"){
											echo "selected='selected'";
										}
									}
									?>><?php echo $row->denominacion?></option>
									<?php 
									}
									?>
								</select>
							</div>
							
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding-right:0px;padding-left:0px">
								<input class="btn btn-info" value="Importar Dictamenes" id="btnImportarDictamenes" style="margin-left:10px;margin-top:30px"/>
							</div>
						<?php } ?>
																	
					</div>
					
					
					<div class="row" style="padding-left:5px">
						<!--	
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Fecha Ejecuci&oacute;n</label>
								<input id="fecha_ejecucion" name="fecha_ejecucion" class="form-control form-control-sm"  value="<?php //if($comisionSesion->fecha_ejecucion!="")echo date("d-m-Y", strtotime($comisionSesion->fecha_ejecucion))?>" type="text">
							</div>
						</div>

						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label form-control-sm">Estado Sesi&oacute;n</label>
								<select name="id_estado_sesion" id="id_estado_sesion" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									//foreach ($estado_sesion as $row) {?>
									<option value="<?php //echo $row->codigo?>" <?php //if($row->codigo==$comisionSesion->id_estado_sesion)echo "selected='selected'"?>><?php //echo $row->denominacion?></option>
									<?php 
									//}
									?>
								</select>
							</div>
						</div>
						-->
						<div class="col-lg-12">
							<div class="form-group">
								<!--<label class="control-label form-control-sm">Delegado</label>-->
								
								<?php if($id>0){?>
								<button style='font-size:12px' type='button' class='btn btn-sm btn-success' data-toggle='modal' onClick="modalAsignarProfesionSesion(0)" ><i class='fa fa-edit'></i> Agregar</button>
								<?php } ?>
								
								<div class="table-responsive">
									<table id="tblDelegado" class="table table-hover table-sm">
										<thead>
										<tr style="font-size:13px">
											<th>Puesto</th>
											<th>CAP</th>
											<th>Delegado</th>
											<th>Situaci&oacute;n</th>
											<th>Coordinador</th>
											<th>Aprobar Pago</th>
											<th>CAP Anterior</th>
											<th>Delegado Anterior</th>
											<th>Delegados</th>
											<th>Editar</th>
											<th>Eliminar</th>
										</tr>
										</thead>
										<tbody>
										<?php 
										foreach ($delegados as $row) {
											$id_delegado = ($row->id_delegado>0)?$row->id_delegado:$row->id_agremiado;
											$id_tipo = ($row->id_delegado>0)?1:2;
										?>
										<tr style='font-size:13px'>
											<input type='hidden' name='id_delegado[]' value='<?php echo $id_delegado?>'>
											<input type='hidden' name='id_tipo[]' value='<?php echo $id_tipo?>'>
											<td class='text-left'>
											<?php
											$puesto = $row->puesto;
											$disabled = "";
											if($puesto=="")$puesto="ASESOR / ESPECIALISTA";
											echo $puesto; 
											
											if($puesto=="ASESOR / ESPECIALISTA" || $puesto=="SUPLENTE")$disabled = "disabled='disabled'";
											?></td>
											<td class='text-left'><?php echo $row->numero_cap?></td>
											<td class='text-left'><?php echo $row->apellido_paterno." ".$row->apellido_materno." ".$row->nombres?></td>
											<td class='text-left'><?php echo $row->situacion?></td>
											<td class='text-center'>
											<input type="radio" <?php echo $disabled?> name="coordinador" value="<?php echo $id_delegado?>" <?php if($row->coordinador==1)echo "checked='checked'"?> onChange="guardar_coordinador(<?php echo $row->id?>,<?php echo $id_delegado?>)" />
											</td>
											<td class='text-center'>
											<input type="checkbox" class="<?php if($row->situacion!="INHABILITADO" && $row->situacion!="FALLECIDO")echo "id_aprobar_pago"?>" name="id_aprobar_pago[<?php echo $id_delegado?>]" value="<?php echo $id_delegado?>" 
											<?php 
											if($row->id_aprobar_pago==2)echo "checked='checked'";
											if($row->situacion=="INHABILITADO" || $row->situacion=="FALLECIDO")echo "disabled='disabled'";
											?> 
											/>
											</td>
											<td class='text-left'><button style='font-size:12px' type='button' class='btn btn-sm btn-success' data-toggle='modal' onclick=modalAsignarDelegadoSesion('<?php echo $row->id?>') >Editar</button></td>
											<td class='text-left'><button style='font-size:12px' type='button' class='btn btn-sm btn-danger' data-toggle='modal' onclick=eliminarDelegadoSesion('<?php echo $row->id?>') >Eliminar</button></td>
										<?php } ?>
										</tbody>
									</table>
                				</div>
								
								<div class="table-responsive" style="overflow-y: visible; height:150px;width:100%;">
								<table id="tblDictamenNuevo" class="table table-hover table-sm">
									<thead>
									<tr style="font-size:13px">
										<!--<th>C&oacute;digo</th>-->
										
										<th>Distrito</th>
										<th>Exp. Municipal</th>
										<th>Tipo de Solicitud</th>
										<th>N&deg; Liquidaci&oacute;n</th>
										<th>Monto</th>
										<th>Dictamen</th>
										<th>Rec. o Apel</th>
										<th>Revis&oacute;n</th>
										<th>Proyectista</th>
										
										<!--Cambio 29/07</th>
										<th>Nombre</th>
										<th>Direcci&oacute;n</th>-->										
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
								</div>
								
							</div>
						</div>
					
					</div>
					
					<div class="row" style="padding-left:5px">
						
						<div class="col-lg-12">
							<div class="form-group">
								<label class="control-label form-control-sm">Observaciones</label>
								<textarea id="observaciones" name="observaciones" class="form-control form-control-sm"><?php echo $comisionSesion->observaciones?></textarea>
								
							</div>
						</div>
						
					</div>
										
					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<?php //if($id==0){
									$btnDisabledGuardar = "";
									if(count($delegados)==0)$btnDisabledGuardar = "disabled='disabled'";
								?>
								
								<button <?php echo $btnDisabledGuardar ?> style="font-size:12px;" type="button" onClick="fn_save()" class="btn btn-sm btn-success" id="btnSesionGuardar">Guardar</button>
								<!--<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>-->
								<?php //}else{?>
								<!--<a href="javascript:void(0)" onClick="$('#openOverlayOpc').modal('hide')" class="btn btn-sm btn-warning">Cerrar</a>-->
								<?php //} ?>
								
							</div>
												
						</div>
					</div> 
					
              </div>
			  
              </form>
			  
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
	
	
	<div id="openOverlayOpc2" class="modal fade" role="dialog">
	  <div class="modal-dialog" >
	
		<div id="id_content_OverlayoneOpc2" class="modal-content" style="padding: 0px;margin: 0px">
		
		  <div class="modal-body" style="padding: 0px;margin: 0px">
	
				<div id="diveditpregOpc2"></div>
	
		  </div>
		
		</div>
	
	  </div>
		
	</div>

	    
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

