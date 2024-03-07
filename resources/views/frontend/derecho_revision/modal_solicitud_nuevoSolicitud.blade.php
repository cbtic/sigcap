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

	$('#ruc').blur(function () {
		var id = $('#id').val();
			if(id==0) {
				validaRuc(this.value);
			}
		//validaRuc(this.value);
	});

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
	$('#fecha_graduado').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		container: '#openOverlayOpc modal-body'
	});
});

$(document).ready(function() {
	 
	$('#numero_cap_').hide();
	$('#agremiado_').hide();
	$('#situacion_').hide();
	$('#direccion_agremiado_').hide();
	$('#n_regional_').hide();
	$('#act_gremial_').hide();
	$('#dni_').hide();
	$('#persona_').hide();
	$('#fecha_nacimiento_').hide();
	$('#direccion_persona_').hide();
	$('#celular_').hide();
	$('#email_').hide();

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

function validaRuc(ruc){
	var settings = {
		"url": "https://apiperu.dev/api/ruc/"+ruc,
		"method": "GET",
		"timeout": 0,
		"headers": {
		  "Authorization": "Bearer 20b6666ddda099db4204cf53854f8ca04d950a4eead89029e77999b0726181cb"
		},
	  };
	  
	  $.ajax(settings).done(function (response) {
		console.log(response);
		
		if (response.success == true){

			var data= response.data;

			$('#razon_social').val('')
			$('#direccion').val('')
			$('#nombre_comercial').val('')
			
			$('#razon_social').val(data.nombre_o_razon_social).attr('readonly', true);
			$('#nombre_comercial').val(data.nombre_o_razon_social).attr('readonly', true);
			//$('#direccion').attr('readonly', true);

			if (data.direccion_completa != ""){
				$('#direccion').val(data.direccion_completa).attr('readonly', true);
			}
			else{
				$('#direccion').attr('readonly', false);
			}
			
			//alert(data.direccion_completa);

		}
		else{
			bootbox.alert("RUC Invalido,... revise el RUC digitado ¡");
			return false;
		}

		
	  });
}

function obtenerSolicitante(){
	
	var tipo_solicitante = $("#tipo_solicitante").val();

	$('#numero_cap_').hide();
	$('#agremiado_').hide();
	$('#situacion_').hide();
	$('#direccion_agremiado_').hide();
	$('#n_regional_').hide();
	$('#act_gremial_').hide();
	$('#dni_').hide();
	$('#persona_').hide();
	$('#fecha_nacimiento_').hide();
	$('#direccion_persona_').hide();
	$('#celular_').hide();
	$('#email_').hide();
	
	if (tipo_solicitante == "")//SELECCIONAR
	{
		
		$('#numero_cap_').hide();
		$('#agremiado_').hide();
		$('#situacion_').hide();
		$('#direccion_agremiado_').hide();
		$('#n_regional_').hide();
		$('#act_gremial_').hide();
		$('#dni_').hide();
		$('#persona_').hide();
		$('#fecha_nacimiento_').hide();
		$('#direccion_persona_').hide();
		$('#celular_').hide();
		$('#email_').hide();

	} else if (tipo_solicitante == "1")//PROYECTISTA
	{
		
		$('#numero_cap_').show();
		$('#agremiado_').show();
		$('#situacion_').show();
		$('#direccion_agremiado_').show();
		$('#n_regional_').show();
		$('#act_gremial_').show();
		$('#dni_').hide();
		$('#persona_').hide();
		$('#fecha_nacimiento_').hide();
		$('#direccion_persona_').hide();
		$('#celular_').hide();
		$('#email_').hide();

	} else if (tipo_solicitante == "2") //Responsable de Tramite
	{
		$('#numero_cap_').hide();
		$('#agremiado_').hide();
		$('#situacion_').hide();
		$('#direccion_agremiado_').hide();
		$('#n_regional_').hide();
		$('#act_gremial_').hide();
		$('#dni_').show();
		$('#persona_').show();
		$('#fecha_nacimiento_').show();
		$('#direccion_persona_').show();
		$('#celular_').show();
		$('#email_').show();

	} else {
		$('#numero_cap_').hide();
		$('#agremiado_').hide();
		$('#situacion_').hide();
		$('#direccion_agremiado_').hide();
		$('#n_regional_').hide();
		$('#act_gremial_').hide();
		$('#dni_').show();
		$('#persona_').show();
		$('#fecha_nacimiento_').show();
		$('#direccion_persona_').show();
		$('#celular_').show();
		$('#email_').show();

	}

}

		
		
function obtenerProyectista(){
		
		var numero_cap = $("#numero_cap").val();
		var msg = "";
		
		if(numero_cap == "")msg += "Debe ingresar el numero de documento <br>";
		
		if (msg != "") {
			bootbox.alert(msg);
			return false;
		}
		
		var msgLoader = "";
		msgLoader = "Procesando, espere un momento por favor";
		var heightBrowser = $(window).width()/2;
		$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
		$('.loader').show();
		
		$.ajax({
			url: '/agremiado/obtener_datos_agremiado/' + numero_cap,
			dataType: "json",
			success: function(result){
				
				var agremiado = result.agremiado;
				//var tipo_documento = parseInt(agremiado.tipo_documento);
				//var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
				$('#frmSolicitudDerechoRevision #agremiado').val(agremiado.agremiado);
				$('#frmSolicitudDerechoRevision #situacion').val(agremiado.situacion);
				$('#frmSolicitudDerechoRevision #direccion_agremiado').val(agremiado.direccion);
				$('#frmSolicitudDerechoRevision #n_regional').val(agremiado.numero_regional);
				$('#frmSolicitudDerechoRevision #act_gremial').val(agremiado.actividad_gremial);
				
				//$('#telefono').val(persona.telefono);
				//$('#email').val(persona.email);
				
				$('.loader').hide();
	
			}
			
		});
		
	}

function fn_save_multa_mantenimiento(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var denominacion = $('#denominacion').val();
	var monto = $('#monto').val();
	var moneda = $('#moneda').val();
	var concepto = $('#concepto').val();
	//var importe = $('#importe').val();
	//var estado = $('#estado').val();
	//alert(id_agremiado);
	//return false;
	
    $.ajax({
			url: "/multa/send_multa_nuevoMultaMantenimiento",
            type: "POST",
            data : {_token:_token,id:id,denominacion:denominacion,monto:monto,moneda:moneda,concepto:concepto},
            success: function (result) {
				
				$('#openOverlayOpc').modal('hide');
				window.location.reload();
				datatablenew();
				
				/*
				$('#openOverlayOpc').modal('hide');
				if(result==1){
					bootbox.alert("La persona o empresa ya se encuentra registrado");
				}else{
					window.location.reload();
				}
				*/
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
				Registro de Solicitud de Derecho de Revisi&oacute;n - HU
			</div>
			
            <div class="card-body">
			<form method="post" action="#" id="frmSolicitudDerechoRevision" name="frmCoordinador">
			<div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
					
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					
					<div style="padding: 0px 0px 15px 10px; font-weight: bold">
						Datos Generales del Proyecto
					</div>
					<div class="row" style="padding-left:10px">

						<div class="col-lg-3">
							<div class="form-group">
								<label class="control-label form-control-sm">Solicitante</label>
								<select name="tipo_solicitante" id="tipo_solicitante" class="form-control form-control-sm" onchange="obtenerSolicitante()">
									<option value="" selected="selected">--Seleccionar--</option>
									<option value="1">Proyectista</option>
									<option value="2">Responsable de Tramite</option>
									<option value="3">Administrado / Propietario</option>
									<!--<option value="">--Selecionar--</option>
									<?/*php
										foreach ($tipo_solicitante as $row) {*/?>
									<option value="<?php /*echo $row->id*/?>" <?php/* if($row->id==$derecho_revision->id_solicitante)echo "selected='selected'"*/?>><?php /*echo $row->denominacion*/?></option>
									<?php
									/*}*/
									?>-->
								</select>
							</div>
						</div>
					
						<div class="col-lg-2">
							<div class="form-group" id="numero_cap_">
								<label class="control-label form-control-sm">N° CAP</label>
								<input id="numero_cap" name="numero_cap" on class="form-control form-control-sm"  value="<?php echo $agremiado->numero_cap?>" type="text" onchange="obtenerProyectista()">
							</div>
							<div class="form-group" id="dni_">
								<label class="control-label form-control-sm">DNI</label>
								<input id="dni" name="dni" on class="form-control form-control-sm"  value="<?php echo $persona->numero_documento?>" type="text" onchange="obtenerProyectista()">
							</div>
						</div>

						<div class="col-lg-4" >
							<div class="form-group "id="agremiado_">
								<label class="control-label form-control-sm">Nombre</label>
								<input id="agremiado" name="agremiado" on class="form-control form-control-sm"  value="<?php echo $persona->nombre?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="persona_">
								<label class="control-label form-control-sm">Nombre</label>
								<input id="persona" name="persona" on class="form-control form-control-sm"  value="<?php echo $persona->nombres?>" type="text" readonly='readonly'>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group" id="situacion_">
								<label class="control-label form-control-sm">Situaci&oacute;n</label>
								<input id="situacion" name="situacion" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_situacion?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="fecha_nacimiento_">
								<label class="control-label form-control-sm">Fecha de Nacimiento</label>
								<input id="fecha_nacimiento" name="fecha_nacimiento" on class="form-control form-control-sm"  value="<?php echo $persona->fecha_nacimiento?>" type="text" readonly='readonly'>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="form-group" id="direccion_agremiado_">
								<label class="control-label form-control-sm">Direcci&oacute;n</label>
								<input id="direccion_agremiado" name="direccion_agremiado" on class="form-control form-control-sm"  value="<?php echo $persona->direccion?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="direccion_persona_">
								<label class="control-label form-control-sm">Direcci&oacute;n</label>
								<input id="direccion_persona" name="direccion_persona" on class="form-control form-control-sm"  value="<?php echo $persona->direccion?>" type="text" readonly='readonly'>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group" id="n_regional_">
								<label class="control-label form-control-sm">N° Regional</label>
								<input id="n_regional" name="n_regional" on class="form-control form-control-sm"  value="<?php echo $agremiado->numero_regional?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="celular_">
								<label class="control-label form-control-sm">Celular</label>
								<input id="celular" name="celular" on class="form-control form-control-sm"  value="<?php echo $persona->numero_celular?>" type="text" readonly='readonly'>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Actividad Gremial</label>
								<input id="act_gremial" name="act_gremial" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text" readonly='readonly'>
							</div>
							<div class="form-group" id="email_">
								<label class="control-label form-control-sm">Email</label>
								<input id="email" name="email" on class="form-control form-control-sm"  value="<?php echo $persona->correo?>" type="text" readonly='readonly'>
							</div>
						</div>
					</div>

					<div style="padding: 0px 0px 15px 10px; font-weight: bold">
						Datos del Proyecto
					</div>
					<div class="row" style="padding-left:10px">

						<div class="col-lg-4">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Nombre del Proyecto</label>
								<input id="nombre_proyecto" name="nombre_proyecto" on class="form-control form-control-sm"  value="<?php echo $proyecto->nombre?>" type="text">
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Municipalidad</label>
								<input id="municipalidad" name="municipalidad" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">N° de Revisi&oacute;n</label>
								<input id="n_revision" name="n_revision" on class="form-control form-control-sm"  value="<?php echo $derechoRevision->numero_revision?>" type="text">
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Departamento</label>
								<input id="departamento" name="departamento" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:10px">
						<div class="col-lg-3">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Provincia</label>
								<input id="provincia" name="provincia" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Distrito</label>
								<input id="distrito" name="distrito" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>

						<div class="col-lg-1-5" style=";padding-right:15px">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Sitio</label>
								<select name="sitio" id="sitio" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($sitio as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto->id_tipo_sitio)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-1-5" style="padding-left:15px">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Zona</label>
								<select name="zona" id="zona" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($zona as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto->manzana)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Parcela</label>
								<input id="parcela" name="parcela" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>

						<div class="col-lg-1-5">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">SuperManzana</label>
								<input id="superManzana" name="superManzana" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>
					</div>
					<div class="row" style="padding-left:10px">
						<div class="col-lg-1-5">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Tipo</label>
								<select name="tipo" id="tipo" class="form-control form-control-sm" onChange="">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo as $row) {?>
									<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto->numero)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
					
						<div class="col-lg-4">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Direccion</label>
								<input id="direccion_proyecto" name="direccion_proyecto" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Lote</label>
								<input id="lote" name="lote" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">SubLote</label>
								<input id="sublote" name="sublote" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>

						<div class="col-lg-1">
							<div class="form-group" id="act_gremial_">
								<label class="control-label form-control-sm">Fila</label>
								<input id="fila" name="fila" on class="form-control form-control-sm"  value="<?php echo $agremiado->id_actividad_gremial?>" type="text">
							</div>
						</div>

					</div>
					
					<div style="margin-top:15px" class="form-group">
						<div class="col-sm-12 controls">
							<div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
								<a href="javascript:void(0)" onClick="fn_save_solicitud_derecho_revision()" class="btn btn-sm btn-success">Registrar</a>
							</div>
							
						</div>
					</div>

					<div style="clear:both;padding-top:15px"></div>
					
						<div class="card">
						
						<nav>
							<div class="nav nav-pills" id="nav-tab" role="tablist">
								<a
									class="nav-link active"
									id="proyectista_propietario-tab"
									data-toggle="pill"
									href="#proyectista_propietario"
									role="tab"
									aria-controls="proyectista_propietario"
									aria-selected="true">Proyectistas y Propietario</a>
								
								<a
									class="nav-link"
									id="informacion_proyecto-tab"
									data-toggle="pill"
									href="#informacion_proyecto"
									role="tab"
									aria-controls="informacion_proyecto"
									aria-selected="false"
									>Informaci&oacute;n del proyecto</a>
								
								<a
									class="nav-link"
									id="datos_comprobante-tab"
									data-toggle="pill"
									href="#datos_comprobante"
									role="tab"
									aria-controls="datos_comprobante"
									aria-selected="false"
									>Datos del Comprobante</a>
								
							</div>
						</nav>
						<div class="tab-content" id="my-profile-tabsContent">
							<div class="tab-pane fade pt-3" id="proyectista_propietario" role="tabpanel" aria-labelledby="proyectista_propietario-tab">
								
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Proyectistas
														</strong>
														
													</div>
												</div>
											</div>

											<!--<div class="card-body" style="margin-top:15px;margin-bottom:15px">-->
											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoProyectista" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblSolicitud" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>N° CAP</th>
																	<th>Nombres</th>
																	<th>Celular</th>
																	<th>Email</th>
																	<!--<th>Firma</th> agregar despues-->
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php /*foreach($proyectista as $row){*/?>
																<!--<tr>
																	<th><?php //echo $row->universidad?></th>
																	<th><?php //echo $row->especialidad?></th>
																	<th><?php //echo $row->tesis?></th>
																	<th><?php //echo $row->fecha_egresado?></th>
																	<th><?php //echo $row->fecha_graduado?></th>
																	<th><?php //echo $row->libro?></th>
																	<th><?php //echo $row->folio?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->													
																<?php/* }*/?>
															</tbody>							
															</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>		
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Propietario
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
											
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoPropietario" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblSolicitud" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Persona</th>
																	<th>N&uacute;mero Documento</th>
																	<th>Nombres</th>
																	<th>celular</th>
																	<th>Email</th>
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php //foreach($agremiado_idioma as $row){?>
																<!--<tr>
																	<th><?php //echo $row->idioma?></th>
																	<th><?php //echo $row->grado?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalIdioma(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarIdioma(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->					
																<?php //}?>
															</tbody>							
															</table>
															
															</div>
														
														</div>
													
													</div>
													
												</div>
													
											</div>
											
											
										</div>
										
									</div>
							
								</div>
							</div>

							<div class="tab-pane fade pt-3" id="informacion_proyecto" role="tabpanel" aria-labelledby="informacion_proyecto-tab">
							
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Informaci&oacute;n del Proyecto
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoinfoProyecto" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblSolicitud" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Tramite</th>
																	<th>Tipo de Habilitacion Urbana</th>
																	<th>Etapas</th>
																	<th>Modalidad de Aprobaci&oacute;n</th>
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php //foreach($agremiado_estudio as $row){?>
																<!--<tr>
																	<th><?php //echo $row->universidad?></th>
																	<th><?php //echo $row->especialidad?></th>
																	<th><?php //echo $row->tesis?></th>
																	<th><?php //echo $row->fecha_egresado?></th>
																	<th><?php //echo $row->fecha_graduado?></th>
																	<th><?php //echo $row->libro?></th>
																	<th><?php //echo $row->folio?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->													
																<?php //}?>
															</tbody>							
															</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>		
									</div>
								</div>
							</div>
							<div class="tab-pane fade pt-3" id="datos_comprobante" role="tabpanel" aria-labelledby="datos_comprobante-tab">
							
								<div class="row" style="padding-top:0px">

									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										
										<div class="card">
											<div class="card-header">
												<div id="" class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<strong>
															Datos del Comprobante
														</strong>
														
													</div>
												</div>
											</div>

											<div class="card-body" style="margin-top:15px;margin-bottom:15px">
												
												<input class="btn btn-success btn-sm float-right" value="NUEVO" type="button" id="btnNuevoComprobante" style="width:120px;margin-right:15px"/>
												
												<div style="clear:both"></div>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													
														<div class="card-body">
										
															<div class="table-responsive">
															<table id="tblSolicitud" class="table table-hover table-sm">
															<thead>
																<tr style="font-size:13px">
																	<th>Tipo Persona</th>
																	<th>N&uacute;mero Documento</th>
																	<th>Nombre/Razon Social</th>
																	<th>Direcci&oacute;n</th>
																	<th>Departamento</th>
																	<th>Provincia</th>
																	<th>Distrito</th>
																	<th>Opciones</th>
																</tr>
															</thead>
															<tbody style="font-size:13px">
																<?php //foreach($agremiado_estudio as $row){?>
																<!--<tr>
																	<th><?php //echo $row->universidad?></th>
																	<th><?php //echo $row->especialidad?></th>
																	<th><?php //echo $row->tesis?></th>
																	<th><?php //echo $row->fecha_egresado?></th>
																	<th><?php //echo $row->fecha_graduado?></th>
																	<th><?php //echo $row->libro?></th>
																	<th><?php //echo $row->folio?></th>
																	<th>
																	<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
																	<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEstudio(<?php //echo $row->id?>)" ><i class="fa fa-edit"></i> Editar</button>
																	<a href="javascript:void(0)" onclick="eliminarEstudio(<?php //echo $row->id?>)" class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Eliminar</a>
																	</div>
																	</th>
																</tr>	-->													
																<?php //}?>
															</tbody>							
															</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>		
									</div>
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

