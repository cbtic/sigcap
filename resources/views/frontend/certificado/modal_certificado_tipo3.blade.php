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
		height: 250px;
	}


	.modal-dialog {
		width: 100%;
		max-width: 70% !important
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
		//$("#nombre_proyecto").select2({ width: '100%' });
		//$('#hora_solicitud').focus();
		//$('#hora_solicitud').mask('00:00');
		//$("#id_empresa").select2({ width: '100%' });
		obtenerProvincia();
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

	/*if($('#id_tipo').val() =="0"){
		$('#nombre_proyecto_').hide();
		$('#tipo_tramite_').hide();
	}*/
	$('#dni_propietario_').show();
	$('#nombre_propietario_').show();
	$('#direccion_dni_').show();
	$('#celular_dni_').show();
	$('#email_dni_').show();
	$('#ruc_propietario_').hide();
	$('#razon_social_propietario_').hide();
	$('#direccion_ruc_').hide();
	$('#telefono_ruc_').hide();
	$('#email_ruc_').hide();

	$('#dni_comprobante_').show();
	$('#nombre_comprobante_').show();
	$('#direccion_dni_comprobante_').show();
	$('#celular_dni_comprobante_').show();
	$('#email_dni_comprobante_').show();
	$('#ruc_comprobante_').hide();
	$('#razon_social_comprobante_').hide();
	$('#direccion_ruc_comprobante_').hide();
	$('#telefono_ruc_comprobante_').hide();
	$('#email_ruc_comprobante_').hide();

	$('#tipo_obra_hu_').hide();
	$('#tipo_uso_hu_').hide();
	$('#tipo_obra_edificaciones_').hide();
	$('#tipo_uso_edificaciones_').hide();

	$('#valor_obra_edificaciones_').hide();
	$('#area_techada_edificaciones_').hide();
	$('#area_intervenida_edificaciones_').hide();
	$('#area_bruta_hu_').hide();
	$('#zonificacion_hu_').hide();
	$('#costo_unitario_').hide();
	$('#area_terreno_').hide();
	$('#n_pisos_').hide();
	$('#sotanos_').hide();
	$('#semisotanos_').hide();
	$('#piso_nivel_').hide();
	$('#otro_piso_nivel_').hide();
	$('#total_area_techada_').hide();
	
});

function obtener_tipo_proyecto(){

	if($('#tipo_proyecto').val()==123){
		$('#tipo_obra_hu_').hide();
		$('#tipo_uso_hu_').hide();
		$('#tipo_obra_edificaciones_').show();
		$('#tipo_uso_edificaciones_').show();
		$('#valor_obra_edificaciones_').show();
		$('#area_techada_edificaciones_').show();
		$('#area_intervenida_edificaciones_').show();
		$('#area_bruta_hu_').hide();
		$('#zonificacion_hu_').show();
		$('#costo_unitario_').show();
		$('#area_terreno_').show();
		$('#n_pisos_').show();
		$('#sotanos_').show();
		$('#semisotanos_').show();
		$('#piso_nivel_').show();
		$('#otro_piso_nivel_').show();
		$('#total_area_techada_').show();
	}else if($('#tipo_proyecto').val()==124){
		$('#tipo_obra_hu_').show();
		$('#tipo_uso_hu_').show();
		$('#tipo_obra_edificaciones_').hide();
		$('#tipo_uso_edificaciones_').hide();
		$('#valor_obra_edificaciones_').hide();
		$('#area_techada_edificaciones_').hide();
		$('#area_intervenida_edificaciones_').hide();
		$('#area_bruta_hu_').show();
		$('#zonificacion_hu_').show();
		$('#costo_unitario_').hide();
		$('#area_terreno_').hide();
		$('#n_pisos_').hide();
		$('#sotanos_').hide();
		$('#semisotanos_').hide();
		$('#piso_nivel_').hide();
		$('#otro_piso_nivel_').hide();
		$('#total_area_techada_').hide();
	}
}

function validacion() {

	var msg = "";
	var cobservaciones = $("#frmComentar #cobservaciones").val();

	if (cobservaciones == "") {
		msg += "Debe ingresar una Observacion <br>";
	}

	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
}

function obtenerDatosDni(){
	
	var dni_propietario = $("#dni_propietario").val();
	var msg = "";
	
	if(dni_propietario == "")msg += "Debe ingresar el numero de documento <br>";
	
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
		url: '/persona/obtener_datos_persona/' + dni_propietario,
		dataType: "json",
		success: function(result){
			var persona = result.persona;

			if(persona!="0")
			{
				$('#nombre_propietario').val(persona.nombres);
				$('#direccion_dni').val(persona.direccion);
				$('#celular_dni').val(persona.numero_celular);
				$('#email_dni').val(persona.correo);
				
				$('.loader').hide();
				
			}else{
				msg += "La Persona no esta registrado en la Base de Datos de CAP <br>";
				$('#nombre_propietario').val("");
				$('#direccion_dni').val("");
				$('#celular_dni').val("");
				$('#email_dni').val("");
				$('.loader').hide();
				
			}

			if (msg != "") {
				bootbox.alert(msg);
				return false;
			}


		}
		
	});
	
}


function obtenerDatosRuc(){
	
	var ruc_propietario = $("#ruc_propietario").val();
	var msg = "";
	
	if(ruc_propietario == "")msg += "Debe ingresar el RUC <br>";
	
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
		url: '/empresa/obtener_datos_empresa/' + ruc_propietario,
		dataType: "json",
		success: function(result){
			var empresa = result.empresa;

			if(empresa!="0")
			{
				$('#razon_social_propietario').val(empresa.razon_social);
				$('#direccion_ruc').val(empresa.direccion);
				$('#telefono_ruc').val(empresa.telefono);
				$('#email_ruc').val(empresa.email);
				
				$('.loader').hide();
				
			}else{
				msg += "La Empresa no esta registrada en la Base de Datos de CAP <br>";
				$('#razon_social_propietario').val("");
				$('#direccion_ruc').val("");
				$('#telefono_ruc').val("");
				$('#email_ruc').val("");
				$('.loader').hide();
				
			}

			if (msg != "") {
				bootbox.alert(msg);
				return false;
			}


		}
		
	});
	
}

function obtenerProvincia(){
	
	var id = $('#departamento').val();
	if(id=="")return false;
	$('#provincia').attr("disabled",true);
	$('#distrito').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();
	
	$.ajax({
		url: '/agremiado/obtener_provincia/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value='' selected='selected'>Seleccionar</option>";
			$('#provincia').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia').html(option);
			
			var option2 = "<option value=''>Seleccionar</option>";
			$('#distrito').html(option2);
			
			$('#provincia').attr("disabled",false);
			$('#distrito').attr("disabled",false);
			
			$('.loader').hide();
			
		}
		
	});
	
}

function obtenerDistrito(){
		
	var departamento = $('#departamento').val();
	var id = $('#provincia').val();
	if(id=="")return false;
	$('#distrito').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
	$('.loader').show();
	
	$.ajax({
		url: '/agremiado/obtener_distrito/'+departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#distrito').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito').html(option);
			
			$('#distrito').attr("disabled",false);
			$('.loader').hide();
			
		}
		
	});
	
}

function obtenerPropietario(){
	
	var id_tipo_documento = $("#id_tipo_documento").val();

	$('#dni_propietario_').show();
    $('#nombre_propietario_').show();
    $('#direccion_dni_').show();
    $('#celular_dni_').show();
    $('#email_dni_').show();
    $('#ruc_propietario_').hide();
    $('#razon_social_propietario_').hide();
    $('#direccion_ruc_').hide();
    $('#telefono_ruc_').hide();
    $('#email_ruc_').hide();
	
	if (id_tipo_documento == "")//SELECCIONAR
	{
		
		$('#dni_propietario_').show();
        $('#nombre_propietario_').show();
        $('#direccion_dni_').show();
        $('#celular_dni_').show();
        $('#email_dni_').show();
        $('#ruc_propietario_').hide();
        $('#razon_social_propietario_').hide();
        $('#direccion_ruc_').hide();
        $('#telefono_ruc_').hide();
        $('#email_ruc_').hide();

	} else if (id_tipo_documento == "78")//DNI
	{
		
		$('#dni_propietario_').show();
        $('#nombre_propietario_').show();
        $('#direccion_dni_').show();
        $('#celular_dni_').show();
        $('#email_dni_').show();
        $('#ruc_propietario_').hide();
        $('#razon_social_propietario_').hide();
        $('#direccion_ruc_').hide();
        $('#telefono_ruc_').hide();
        $('#email_ruc_').hide();

	} else if (id_tipo_documento == "79") //Responsable de Tramite
	{
		$('#dni_propietario_').hide();
        $('#nombre_propietario_').hide();
        $('#direccion_dni_').hide();
        $('#celular_dni_').hide();
        $('#email_dni_').hide();
        $('#ruc_propietario_').show();
        $('#razon_social_propietario_').show();
        $('#direccion_ruc_').show();
        $('#telefono_ruc_').show();
        $('#email_ruc_').show();

	} 
}

function obtenerDatosComprobante(){
	
	var id_tipo_documento = $("#id_tipo_documento_comprobante").val();

	$('#dni_comprobante_').show();
    $('#nombre_comprobante_').show();
    $('#direccion_dni_comprobante_').show();
    $('#celular_dni_comprobante_').show();
    $('#email_dni_comprobante_').show();
    $('#ruc_comprobante_').hide();
    $('#razon_social_comprobante_').hide();
    $('#direccion_ruc_comprobante_').hide();
    $('#telefono_ruc_comprobante_').hide();
    $('#email_ruc_comprobante_').hide();
	
	if (id_tipo_documento == "")//SELECCIONAR
	{
		
		$('#dni_comprobante_').show();
        $('#nombre_comprobante_').show();
        $('#direccion_dni_comprobante_').show();
        $('#celular_dni_comprobante_').show();
        $('#email_dni_comprobante_').show();
        $('#ruc_comprobante_').hide();
        $('#razon_social_comprobante_').hide();
        $('#direccion_ruc_comprobante_').hide();
        $('#telefono_ruc_comprobante_').hide();
        $('#email_ruc_comprobante_').hide();

	} else if (id_tipo_documento == "78")//DNI
	{
		
		$('#dni_comprobante_').show();
        $('#nombre_comprobante_').show();
        $('#direccion_dni_comprobante_').show();
        $('#celular_dni_comprobante_').show();
        $('#email_dni_comprobante_').show();
        $('#ruc_comprobante_').hide();
        $('#razon_social_comprobante_').hide();
        $('#direccion_ruc_comprobante_').hide();
        $('#telefono_ruc_comprobante_').hide();
        $('#email_ruc_comprobante_').hide();

	} else if (id_tipo_documento == "79") //Responsable de Tramite
	{
		$('#dni_comprobante_').hide();
        $('#nombre_comprobante_').hide();
        $('#direccion_dni_comprobante_').hide();
        $('#celular_dni_comprobante_').hide();
        $('#email_dni_comprobante_').hide();
        $('#ruc_comprobante_').show();
        $('#razon_social_comprobante_').show();
        $('#direccion_ruc_comprobante_').show();
        $('#telefono_ruc_comprobante_').show();
        $('#email_ruc_comprobante_').show();

	} 
}


function fn_save() {

	var _token = $('#_token').val();
	var id = $('#id').val();
	var id_regional = 5;
	var idagremiado = $('#idagremiado_').val();
	var fecha_sol = $('#fecha_r_').val();
	var fecha_emi = $('#fecha_e_').val();
	var validez = $('#vigencia_').val();
	var ev = "";
	var codigo = $('#codigo_').val();
	var observaciones = $('#observacion_').val();
	var estado = 1;
	var tipo = $('#id_tipo').val();
	var nombre_proyecto = $('#nombre_proyecto').val();
	var id_proyecto = $('#id_proyecto').val();
	var tipo_tramite = $('#tipo_tramite').val();
	var tipo_proyectista = $('#tipo_proyectista').val();
	var dni_propietario = $('#dni_propietario').val();
	var ruc_propietario = $('#ruc_propietario').val();
	var nombre_propietario = $('#nombre_propietario').val();
	var razon_social_propietario = $('#razon_social_propietario').val();
	var direccion_dni = $('#direccion_dni').val();
	var direccion_ruc = $('#direccion_ruc').val();
	var celular_dni = $('#celular_dni').val();
	var telefono_ruc = $('#telefono_ruc').val();
	var email_dni = $('#email_dni').val();
	var email_ruc = $('#email_ruc').val();
	var nombre_proyecto = $('#nombre_proyecto').val();
	var tipo_proyecto = $('#tipo_proyecto').val();
	var tipo_obra = $('#tipo_obra_edificaciones').val();
	var tipo_uso = $('#tipo_uso_edificaciones').val();
	var valor_obra = $('#valor_obra').val();
	var area_techada = $('#area_techada').val();
	var area_intervenida = $('#area_intervenida').val();
	var departamento = $('#departamento').val();
	var provincia = $('#provincia').val();
	var distrito = $('#distrito').val();
	var sitio = $('#sitio').val();
	var direccion_sitio = $('#direccion_sitio').val();
	var tipo_direccion = $('#tipo_direccion').val();
	var direccion_tipo = $('#direccion_tipo').val();
	var tipo_obra_hu = $('#tipo_obra_hu').val();
	var tipo_uso_hu = $('#tipo_uso_hu').val();
	

	$.ajax({
		url: "/certificado/send_proyecto_tipo3",
		type: "POST",
		data : $("#frmCertificadoTipo3").serialize(),
		/*
		data: {
			_token:_token,
			id:id,
			id_regional:id_regional,
			idagremiado:idagremiado,
			observaciones:observaciones,
			estado:estado,
			codigo:codigo,
			ev:ev,
			fecha_emi:fecha_emi,
			validez:validez,
			fecha_sol:fecha_sol,
			tipo:tipo,
			tipo_tramite:tipo_tramite,
			id_proyecto:id_proyecto,
			nombre_proyecto:nombre_proyecto,
			idagremiado: idagremiado,
			tipo_proyectista:tipo_proyectista,
			dni_propietario:dni_propietario,
			ruc_propietario:ruc_propietario,
			nombre_propietario:nombre_propietario,
			razon_social_propietario:razon_social_propietario,
			direccion_dni:direccion_dni,
			direccion_ruc:direccion_ruc,
			celular_dni:celular_dni,
			telefono_ruc:telefono_ruc,
			email_dni:email_dni,
			email_ruc:email_ruc,
			nombre_proyecto:nombre_proyecto,
			tipo_proyecto:tipo_proyecto,
			tipo_obra:tipo_obra,
			tipo_uso:tipo_uso,
			valor_obra:valor_obra,
			area_techada:area_techada,
			area_intervenida:area_intervenida,
			departamento:departamento,
			provincia:provincia,
			distrito:distrito,
			sitio:sitio,
			direccion_sitio:direccion_sitio,
			tipo_direccion:tipo_direccion,
			direccion_tipo:direccion_tipo
		},
		*/
		//dataType: 'json',
		success: function(result) {
			$('#openOverlayOpc').modal('hide');
			//window.location.reload();
			datatablenew();

		}
	});
}

/*function obtenerNombreProyecto() {

var ncap = $('#cap_').val();

$.ajax({
	url: '/proyecto/obtener_proyecto/' + ncap,
	dataType: "json",
	success: function(result) {

		//print_r(result).exit();
		//alert(result);
		console.log(result);
		var option = "<option value='0'>--Seleccionar--</option>";
		$("#nombre_proyecto").html("");
		$("#id_proyecto").html("");
		var selected = "";
		$(result).each(function (ii, oo) {
			selected = "";
			if(id == oo.id)selected = "selected='selected'";
			option += "<option value='"+oo.id+"' "+selected+" >"+oo.nombre+"</option>";
		});
		$("#nombre_proyecto").html(option);
		$("#id_proyecto").html(option);
	}
});
}*/

function obtenerAgremiado() {

	var ncap = $('#cap_').val();

	$.ajax({
		url: '/afiliacion_seguro/obtener_agremiado/' + ncap,
		dataType: "json",
		success: function(result) {
			//alert(result);
			console.log(result);

			$('#idagremiado_').val(result.id);
			$('#nombre_').val(result.nombre_completo);
			$('#situacion_').val(result.situacion);
			$('#n_regional_').val(result.numero_regional);
			$('#regional_').val(result.regional);
			$('#aut_tramite_').val(result.autoriza_tramite);
			$('#act_gremial_').val(result.actividad);
			$('#ubicacion_').val(result.ubicacion);

			//$('#email_').val(result.email);
			//obtenerNombreProyecto();
		}
	});
}

function obtenerProyectistaAsociado($i) {

var numero = $i;

var ncap = $('#numero_cap_asociado' + numero).val();

$.ajax({
	url: '/afiliacion_seguro/obtener_agremiado/'+ncap,
	dataType: "json",
	success: function(result) {
		//alert(result);
		console.log(result);

		//$('#idagremiado_').val(result.id);
		//var numero = $('#id_n');
		//for (var i = 0; i < numero+1; i++) {

		$('#nombre_asociado'+numero).val(result.nombre_completo);
		$('#aut_tramite_asociado'+numero).val(result.autoriza_tramite);
		$('#situacion_asociado'+numero).val(result.situacion);
		$('#regional_asociado'+numero).val(result.regional);
		$('#act_gremial_'+numero).val(result.actividad);
		$('#ubicacion_asociado'+numero).val(result.ubicacion);

		//$('#email_').val(result.email);
		//obtenerNombreProyecto();
		//}
	}
});
}

function valida_pago() {
	var idagremiado = $('#idagremiado_').val();
	var serie = $('#serie_').val();
	var numero = $('#numero_').val();
	var concepto = 1;

	$.ajax({
		url: '/certificado/valida_pago/' + idagremiado + "/" + serie + "/" + numero + "/" + concepto,
		dataType: "json",
		success: function(result) {
			//alert(result);
			console.log(result);

			$('#fecha_e_').val(result.fecha_e);
			$('#vigencia_').val(result.vigencia);
			$('#codigo_').val(result.codigo);

		}

	});

}
</script>


<body class="hold-transition skin-blue sidebar-mini">

	<div>

		<div class="justify-content-center">
			
			
			<div class="card">

				<div class="card-header" style="padding:5px!important;padding-left:20px!important">
					Edici&oacute;n de Certificados
				</div>
				
				<form method="post" id="frmCertificadoTipo3" action="#" enctype="multipart/form-data">
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
				
				
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id" id="id" value="<?php echo $id ?>">


					<?php
					/*
						$readonly = $id > 0 ? "readonly='readonly'" : '';
						$readonly_ = $id > 0 ? '' : "readonly='readonly'";
						*/
					?>

					<div class="card-body" style="margin-top:1px;margin-bottom:1px">
						<div class="row">
							<div style="margin-bottom:10px">
								<strong>
									Datos de Proyectista
								</strong>
							</div>
						</div>

						<div class="row">
							
							<div class="col-lg-2">
								<div class="form-group">
									<label class="form-control-sm form-control-sm">Nº CAP</label>
									<input type="text" name="cap_" id="cap_" value="<?php echo $agremiado->numero_cap ?>" placeholder="" class="form-control form-control-sm">
								</div>
							</div>
							<div class="col-lg-2" style="padding-top:12px;padding-left:0px;padding-right:0px">
								<br>
								<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#vehiculoModal" onClick="obtenerAgremiado('<?php echo $id ?>')">
									Buscar
								</button>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label class="control-label form-control-sm">Apellidos y Nombres</label>
									<input id="nombre_" name="nombre_" class="form-control form-control-sm" value="<?php echo $persona->nombres ?>" type="text" readonly>
									<input id="idagremiado_" name="idagremiado_" class="form-control form-control-sm" value="<?php echo $agremiado->nombres ?>" type="hidden" readonly>
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label form-control-sm">N° Regional</label>
									<input id="n_regional_" name="n_regional_" class="form-control form-control-sm" value="<?php echo $agremiado->numero_regional?>" type="text" readonly>
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label form-control-sm">Regional</label>
									<input id="regional_" name="regional_" class="form-control form-control-sm" value="<?php echo $agremiado->id_regional?>" type="text" readonly>
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label form-control-sm">Aut. Tr&aacute;mite</label>
									<input id="aut_tramite_" name="aut_tramite_" class="form-control form-control-sm" value="<?php echo $agremiado->id_autoriza_tramite?>" type="text" readonly>
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label form-control-sm">Actividad Gremial</label>
									<input id="act_gremial_" name="act_gremial_" class="form-control form-control-sm" value="<?php echo $agremiado->id_actividad_gremial?>" type="text" readonly>
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label form-control-sm">Ubicaci&oacute;n</label>
									<input id="ubicacion_" name="ubicacion_" class="form-control form-control-sm" value="<?php echo $agremiado->id_ubicacion?>" type="text" readonly>
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label form-control-sm">Situaci&oacute;n</label>
									<input id="situacion_" name="situacion_" class="form-control form-control-sm" value="<?php echo $agremiado->id_situacion?>" type="text" readonly>
								</div>
							</div>
						</div>

						<!--<div class="row">

							<div class="col-lg-4">
								<label class="control-label form-control-sm">Tipo Tr&aacute;mite</label>
								<select name="tipo_tramite_tipo3" id="tipo_tipo_tramite_tipo3tramite" class="form-control form-control-sm" onchange="">
									<option value="">--Selecionar--</option>
									<?php
									//foreach ($tipo_tramite as $row) {?>
									<option value="<?php //echo $row->codigo?>" <?php //if($row->codigo==$certificado->id_tipo_tramite)echo "selected='selected'"?>><?php //echo $row->denominacion?></option>
									<?php
									//}
									?>
								</select>
							</div>
						</div>-->

						<div class="row">
							<div style="margin-bottom:10px">
								<strong>
									Datos T&eacute;cnicos de la Obra
								</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<label class="control-label form-control-sm">Tipo de Proyectista</label>
								<select name="tipo_proyectista" id="tipo_proyectista" class="form-control form-control-sm" onChange="activarNumeroProyectista()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_proyectista as $row)  {
									?>
										<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$persona->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="form-group" id="numero_proyectistas_">
								<div class="col-lg-12 col-md-1 col-sm-12 col-xs-12">
									<label class="control-label form-control-sm">N&uacute;mero Proyectistas</label>
									<select name="numero_proyectistas" id="numero_proyectistas" class="form-control form-control-sm" onChange="AddFila()">
										<option value="" selected="selected">--Seleccionar--</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
							</div>
						</div>
							<div id="frmProyectistaAsociado">
							<!--<label class="control-label form-control-sm">aaaaaaa</label>-->
							</div>
						<div class="row">
							<div style="margin-bottom:10px">
								<strong>
									Datos del Propietario
								</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<label class="control-label form-control-sm">Tipo Documento</label>
								<select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" onChange="obtenerPropietario()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_documento as $row)  {
									if ($row->codigo == 78 || $row->codigo == 79){
									?>
										<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$persona->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
									}}
									?>
								</select>
							</div>

							<div class="col-lg-2">
								<div class="form-group" id="dni_propietario_">
								<label class="control-label form-control-sm">DNI</label>
								<input id="dni_propietario" name="dni_propietario" on class="form-control form-control-sm"  value="<?php echo $persona->numero_documento?>" type="text" onChange="obtenerDatosDni()">
								</div>
								<div class="form-group" id="ruc_propietario_">
									<label class="control-label form-control-sm">RUC</label>
									<input id="ruc_propietario" name="ruc_propietario" on class="form-control form-control-sm"  value="<?php echo $empresa->ruc?>" type="text" onChange="obtenerDatosRuc()">
								</div>
							</div>

							<div class="col-lg-6" >
								<div class="form-group" id="nombre_propietario_">
									<label class="control-label form-control-sm">Apellidos y Nombre</label>
									<input id="nombre_propietario" name="nombre_propietario" on class="form-control form-control-sm"  value="<?php echo $persona->desc_cliente_sunat?>" type="text" onChange="" readonly='readonly'>
								</div>
								<div class="form-group" id="razon_social_propietario_">
									<label class="control-label form-control-sm">Raz&oacute;n Social</label>
									<input id="razon_social_propietario" name="razon_social_propietario" on class="form-control form-control-sm"  value="<?php echo $empresa->razon_social?>" type="text" onChange="" readonly='readonly'>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-5" >
								<div class="form-group" id="direccion_dni_">
									<label class="control-label form-control-sm">Direcci&oacute;n</label>
									<input id="direccion_dni" name="direccion_dni" on class="form-control form-control-sm"  value="<?php echo $persona->direccion?>" type="text" onChange="" readonly='readonly'>
								</div>
								<div class="form-group" id="direccion_ruc_">
									<label class="control-label form-control-sm">Direcci&oacute;n</label>
									<input id="direccion_ruc" name="direccion_ruc" on class="form-control form-control-sm"  value="<?php echo $empresa->direccion?>" type="text" onChange="" readonly='readonly'>
								</div>
							</div>
							
							<div class="col-lg-2" >
								<div class="form-group" id="celular_dni_">
									<label class="control-label form-control-sm">Celular</label>
									<input id="celular_dni" name="celular_dni" on class="form-control form-control-sm"  value="<?php echo $persona->numero_celular?>" type="text" onChange="" readonly='readonly'>
								</div>
								<div class="form-group" id="telefono_ruc_">
									<label class="control-label form-control-sm">Tel&eacute;fono</label>
									<input id="telefono_ruc" name="telefono_ruc" on class="form-control form-control-sm"  value="<?php echo $empresa->telefono?>" type="text" onChange="" readonly='readonly'>
								</div>
							</div>

							<div class="col-lg-4" >
								<div class="form-group" id="email_dni_">
									<label class="control-label form-control-sm">Email</label>
									<input id="email_dni" name="email_dni" on class="form-control form-control-sm"  value="<?php echo $persona->correo?>" type="text" onChange="" readonly='readonly'>
								</div>
								<div class="form-group" id="email_ruc_">
									<label class="control-label form-control-sm">Email</label>
									<input id="email_ruc" name="email_ruc" on class="form-control form-control-sm"  value="<?php echo $empresa->email?>" type="text" onChange="" readonly='readonly'>
								</div>
							</div>
						</div>
						<div class="row">
							<div style="margin-bottom:10px">
								<strong>
									Datos T&eacute;cnicos de la Obra
								</strong>
							</div>
						</div>
						<div class="row">

							<!--<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label form-control-sm">Expediente N°</label>
									<input id="expediente" name="expediente" class="form-control form-control-sm" value="" type="text">
								</div>
							</div>-->

							<div class="col-lg-8">
								<div class="form-group">
									<label class="control-label form-control-sm">Nombre del Proyecto</label>
									<input name="nombre_proyecto" id="nombre_proyecto" class="form-control form-control-sm" onChange="" type="text">
								</div>
							</div>
							<div class="col-lg-4">
								<label class="control-label form-control-sm">Tipo Proyecto</label>
								<select name="tipo_proyecto" id="tipo_proyecto" class="form-control form-control-sm" onChange="obtener_tipo_proyecto()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($tipo_proyecto as $row){
									if ($row->codigo == 123 || $row->codigo == 124 || $row->codigo == 241){
									?>
										<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$proyecto->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
									<?php
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 form-group" style="padding: 0px 0px 0px 0px" id="tipo_obra_edificaciones_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">Tipo Obra</label>
									<select name="tipo_obra_edificaciones" id="tipo_obra_edificaciones" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($tipo_obra as $row){
										?>
											<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$proyecto->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-lg-3 form-group" style="padding: 0px 0px 0px 0px" id="tipo_uso_edificaciones_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">Tipo Uso</label>
									<select name="tipo_uso_edificaciones" id="tipo_uso_edificaciones" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($tipo_uso as $row){
										?>
											<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$proyecto->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-lg-3 form-group" style="padding: 0px 0px 0px 0px" id="tipo_obra_hu_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">Tipo Obra</label>
									<select name="tipo_obra_hu" id="tipo_obra_hu" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($tipo_obra_hu as $row){
										?>
											<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$proyecto->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-lg-3 form-group" style="padding: 0px 0px 0px 0px" id="tipo_uso_hu_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">Tipo Uso</label>
									<select name="tipo_uso_hu" id="tipo_uso_hu" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($tipo_uso_hu as $row){
										?>
											<option value="<?php echo $row->codigo?>" <?php //if($row->codigo==$proyecto->id_tipo_documento)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-lg-2 form-group" style="padding: 0px 0px 0px 0px" id="valor_obra_edificaciones_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">Valor Total de Obra</label>
									<input id="valor_obra_edificaciones" name="valor_obra_edificaciones" on class="form-control form-control-sm"  value="<?php //echo $proyecto->valor_obra?>" type="text" onChange="" >
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding: 0px 0px 0px 0px" id="area_techada_edificaciones_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">&Aacute;rea Techada M2</label>
									<input id="area_techada_edificaciones" name="area_techada_edificaciones" on class="form-control form-control-sm"  value="<?php //echo $proyecto->area_techada?>" type="text" onChange="" >
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding: 0px 0px 0px 0px" id="area_intervenida_edificaciones_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">&Aacute;rea Intervenida M2</label>
									<input id="area_intervenida_edificaciones" name="area_intervenida_edificaciones" on class="form-control form-control-sm"  value="<?php //echo $proyecto->area_intervenida?>" type="text" onChange="" >
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding: 0px 0px 0px 0px" id="area_bruta_hu_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">&Aacute;rea Bruta de Terreno (m2)</label>
									<input id="area_bruta_hu" name="area_bruta_hu" on class="form-control form-control-sm" value="<?php //echo $proyecto->area_intervenida?>" type="text" onChange="" >
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding: 0px 0px 0px 0px" id="zonificacion_hu_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">Zonificaci&oacute;n</label>
									<input id="zonificacion_hu" name="zonificacion_hu" on class="form-control form-control-sm" value="<?php //echo $proyecto->area_intervenida?>" type="text" onChange="" >
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding: 0px 0px 0px 0px" id="costo_unitario_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">Costo Unitario</label>
									<input id="costo_unitario" name="costo_unitario" on class="form-control form-control-sm" value="<?php //echo $proyecto->area_intervenida?>" type="text" onChange="" >
								</div>
							</div>
							<div class="col-lg-2 form-group" style="padding: 0px 0px 0px 0px" id="area_terreno_">
								<div class="col-lg-12">
									<label class="control-label form-control-sm">&Aacute;rea del Terreno</label>
									<input id="area_terreno" name="area_terreno" on class="form-control form-control-sm" value="<?php //echo $proyecto->area_intervenida?>" type="text" onChange="" >
								</div>
							</div>
						</div>
						<!--<div class="row">
							<div class="col-lg-2">
								<div class="form-group" id="n_pisos_">
									<label class="control-label">N° de pisos o niveles</label>
									<input id="n_pisos" name="n_pisos" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="sotanos_">
									<label class="control-label">S&oacute;tano(s)(m2)</label>
									<input id="sotanos" name="sotanos" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="semisotanos_">
									<label class="control-label">Semis&oacute;tano(m2)</label>
									<input id="semisotanos" name="semisotanos" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="piso_nivel_">
									<label class="control-label">1er. Piso o Nivel(m2)</label>
									<input id="piso_nivel" name="piso_nivel" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="otro_piso_nivel_">
									<label class="control-label">Otros Pisos o Nivel(m2)</label>
									<input id="otro_piso_nivel" name="otro_piso_nivel" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="total_area_techada_">
									<label class="control-label">Total &Aacute;rea Techada(m2)</label>
									<input id="total_area_techada" name="total_area_techada" class="form-control form-control-sm" value="<?php //echo $email1 ?>" type="text">
								</div>
							</div>
						</div>-->
						<div class="row">
							<div style="margin-bottom:10px">
								<strong>
									Ubicaci&oacute;n
								</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-2">
								<label class="control-label form-control-sm">Departamento</label>
								<select name="departamento" id="departamento" class="form-control form-control-sm" onChange="obtenerProvincia()">
									<option value="">--Selecionar--</option>
									<?php
									foreach ($departamento as $row) {?>
									<option value="<?php echo $row->id_departamento?>" <?php if($row->id_departamento==15)echo "selected='selected'"?>><?php echo $row->desc_ubigeo ?></option>
									<?php 
									}
									?>
								</select>
							</div>
						
								<div class="col-lg-3">
									<label class="control-label form-control-sm">Provincia</label>
									<select name="provincia" id="provincia" class="form-control form-control-sm" onChange="obtenerDistrito()">
										<option value="">--Selecionar--</option>
									</select>
								</div>
								

								<div class="col-lg-3">
									<label class="control-label form-control-sm">Distrito</label>
									<select name="distrito" id="distrito" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
									</select>
								</div>

								<div class="col-lg-2">
									<label class="control-label form-control-sm">Sitio</label>
									<select name="sitio" id="sitio" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($sitio as $row) {?>
										<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto->id_sitio)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-lg-4">
									<label class="control-label form-control-sm">Direcci&oacute;n</label>
									<input id="direccion_sitio" name="direccion_sitio" on class="form-control form-control-sm"  value="<?php //echo $proyecto->valor_obra?>" type="text" onChange="" >
								</div>
								<div class="col-lg-2">
									<label class="control-label form-control-sm">Tipo Direcci&oacute;n</label>
									<select name="tipo_direccion" id="tipo_direccion" class="form-control form-control-sm" onChange="">
										<option value="">--Selecionar--</option>
										<?php
										foreach ($tipo_direccion as $row) {?>
										<option value="<?php echo $row->codigo?>" <?php if($row->codigo==$proyecto->id_sitio)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php 
										}
										?>
									</select>
								</div>
								<div class="col-lg-4">
									<label class="control-label form-control-sm">Direcci&oacute;n</label>
									<input id="direccion_tipo" name="direccion_tipo" on class="form-control form-control-sm"  value="<?php //echo $proyecto->valor_obra?>" type="text" onChange="" >
								</div>
							</div>


							<!--<div class="row" style="padding-left:10px;padding-top:25px">

								<div class="col-lg-4">
                                    <label class="control-label form-control-sm">Tipo Documento</label>
                                    <select name="id_tipo_documento_comprobante" id="id_tipo_documento_comprobante" class="form-control form-control-sm" onchange="obtenerDatosComprobante()">
                                        <option value="">--Selecionar--</option>
                                        <?php
                                        //foreach ($tipo_documento as $row) {?>
                                        <option value="<?php //echo $row->codigo?>" <?php //if($row->codigo==$persona->id_tipo_documento)echo "selected='selected'"?>><?php //echo $row->denominacion?></option>
                                        <?php
                                        //}
                                        ?>
                                    </select>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group" id="dni_comprobante_">
                                    <label class="control-label form-control-sm">DNI</label>
                                    <input id="dni_comprobante" name="dni_comprobante" on class="form-control form-control-sm"  value="<?php //echo $persona->numero_documento?>" type="text" onChange="obtenerDatosDni()">
                                    </div>
                                    <div class="form-group" id="ruc_comprobante_">
                                        <label class="control-label form-control-sm">RUC</label>
                                        <input id="ruc_comprobante" name="ruc_comprobante" on class="form-control form-control-sm"  value="<?php //echo $empresa->ruc?>" type="text" onChange="obtenerDatosRuc()">
                                    </div>
                                </div>

                                <div class="col-lg-5" >
                                <div class="form-group" id="nombre_comprobante_">
                                    <label class="control-label form-control-sm">Nombre</label>
                                    <input id="nombre_comprobante" name="nombre_comprobante" on class="form-control form-control-sm"  value="<?php //echo $persona->desc_cliente_sunat?>" type="text" onChange="" readonly='readonly'>
                                    </div>
                                    <div class="form-group" id="razon_social_comprobante_">
                                        <label class="control-label form-control-sm">Raz&oacute;n Social</label>
                                        <input id="razon_social_comprobante" name="razon_social_comprobante" on class="form-control form-control-sm"  value="<?php //echo $empresa->razon_social?>" type="text" onChange="" readonly='readonly'>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-left:10px;padding-top:25px">
                                <div class="col-lg-6" >
                                    <div class="form-group" id="direccion_dni_comprobante_">
                                        <label class="control-label form-control-sm">Direcci&oacute;n</label>
                                        <input id="direccion_dni_comprobante" name="direccion_dni_comprobante" on class="form-control form-control-sm"  value="<?php //echo $persona->direccion?>" type="text" onChange="" readonly='readonly'>
                                    </div>
                                    <div class="form-group" id="direccion_ruc_comprobante_">
                                        <label class="control-label form-control-sm">Direcci&oacute;n</label>
                                        <input id="direccion_ruc_comprobante" name="direccion_ruc_comprobante" on class="form-control form-control-sm"  value="<?php //echo $empresa->direccion?>" type="text" onChange="" readonly='readonly'>
                                    </div>
                                </div>
                               
                                <div class="col-lg-4" >
                                    <div class="form-group" id="celular_dni_comprobante_">
                                        <label class="control-label form-control-sm">Celular</label>
                                        <input id="celular_dni_comprobante" name="celular_dni_comprobante" on class="form-control form-control-sm"  value="<?php //echo $persona->numero_celular?>" type="text" onChange="" readonly='readonly'>
                                    </div>
                                    <div class="form-group" id="telefono_ruc_comprobante_">
                                        <label class="control-label form-control-sm">Tel&eacute;fono</label>
                                        <input id="telefono_ruc_comprobante" name="telefono_ruc_comprobante" on class="form-control form-control-sm"  value="<?php //echo $empresa->telefono?>" type="text" onChange="" readonly='readonly'>
                                    </div>
                                </div>

                                <div class="col-lg-5" >
                                    <div class="form-group" id="email_dni_comprobante_">
                                        <label class="control-label form-control-sm">Email</label>
                                        <input id="email_dni_comprobante" name="email_dni_comprobante" on class="form-control form-control-sm"  value="<?php //echo $persona->correo?>" type="text" onChange="" readonly='readonly'>
                                    </div>
                                    <div class="form-group" id="email_ruc_comprobante_">
                                        <label class="control-label form-control-sm">Email</label>
                                        <input id="email_ruc_comprobante" name="email_ruc_comprobante" on class="form-control form-control-sm"  value="<?php //echo $empresa->email?>" type="text" onChange="" readonly='readonly'>
                                    </div>
                                </div>
                            </div>-->

						</div>

						<!--<div class="row">
							<div class="col-lg-2">
								<div class="form-group">
									<label class="control-label">Fecha Emision</label>
									<input id="fecha_e_" name="fecha_e_" class="form-control form-control-sm" value="<?php if($certificado->fecha_emision!=""){echo date("Y-m-d",strtotime($certificado->fecha_emision));}else echo date('Y-m-d'); ?>" type="date">
								</div>
							</div>
							
							<div class="form-group" id="tipo_tramite_">
								<div class="col-lg-12">
									<label class="control-label">Tipo de Tramite</label>
									<select name="tipo_tramite" id="tipo_tramite" class="form-control form-control-sm" onChange="obtenerTipoCertificado()">
										<option value="0">--Selecionar--</option>
										<?php
										//foreach ($tipo_tramite as $row) { ?>
											<option value="<?php //echo $row->codigo ?>" <?php //if ($row->codigo == $certificado->id_tipo_tramite) echo "selected='selected'" ?>><?php //echo $row->denominacion ?></option>
										<?php
										//}
										?>
									</select>
								</div>
							</div>
							<div class="form-group" id="vigencia_group">
								<div class="col-lg-12">
									<label class="control-label">Dias Vigencia</label>
									<input id="vigencia_" name="vigencia_" class="form-control form-control-sm" value="<?php //echo $certificado->dias_validez ?>" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<label class="control-label">Codigo</label>
									<input id="codigo_" name="codigo_" class="form-control form-control-sm" value="<?php //echo $certificado->codigo ?>" type="text" readonly="readonly">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label class="control-label">Observaciones</label>
									<input id="observacion_" name="observacion_" class="form-control form-control-sm" value="<?php //echo $certificado->observaciones ?>" type="textarea">
								</div>
							</div>
						</div>-->
						<div class="row">

							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
										<a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>

									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			
			</form>
			
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

function AddFila(){
	
	//var newRow = "";
  var cantidad = $('#numero_proyectistas').val();
  //$('#tblConceptos tbody').html("");
  $('#frmProyectistaAsociado').html("");
  //var newRow = "";
  var nuevoContenido = "";
  //var formulario = '<form id="frmProyectistaAsociado">';
  for (var i = 0; i < cantidad; i++) {
    //newRow = "";
    
    var n = i+1;
    //var año = $('#periodo').val();
	var id_n = '<input type="hidden" name="id_n" id="'+ i +'" value="">'
	var etiqueta_numero_cap_asociado = '<label class="form-control-sm form-control-sm">Nº CAP</label>'
    var numero_cap_asociado = '<input type="text" name="numero_cap_asociado[]" id="numero_cap_asociado' + i + '" value="" placeholder="" class="form-control form-control-sm" onchange ="obtenerProyectistaAsociado('+i+')">';
    var etiqueta_nombre_asociado = '<label class="form-control-sm form-control-sm">Apellidos y Nombres</label>'
	var nombre_asociado = '<input id="nombre_asociado' + i + '" name="nombre_asociado[]" class="form-control form-control-sm" value="" type="text" readonly>'
    var etiqueta_aut_tramite_asociado = '<label class="form-control-sm form-control-sm">Aut. Tr&aacute;mite</label>'
	var aut_tramite_asociado = '<input id="aut_tramite_asociado' + i + '" name="aut_tramite_asociado[]" class="form-control form-control-sm" value="" type="text" readonly>'
    var etiqueta_situacion_asociado = '<label class="form-control-sm form-control-sm">Situaci&oacute;n</label>'
	var situacion_asociado = '<input id="situacion_asociado' + i + '" name="situacion_asociado[]" class="form-control form-control-sm" value="" type="text" readonly>'
    var etiqueta_regional_asociado = '<label class="form-control-sm form-control-sm">Regional</label>'
	var regional_asociado = '<input id="regional_asociado' + i + '" name="regional_asociado[]" class="form-control form-control-sm" value="" type="text" readonly>'
    //var informe = '<select name="informe[]" id="informe" class="form-control form-control-sm"> <option value="" selected="selected">--Seleccionar--</option> <option value="1">Si</option> <option value="0">No</option> </select>'
    var etiqueta_act_gremial_asociado = '<label class="form-control-sm form-control-sm">Actividad Gremial</label>'
	var act_gremial_asociado = '<input id="act_gremial_' + i + '" name="act_gremial_[]" class="form-control form-control-sm" value="" type="text" readonly>'
    var etiqueta_ubicacion_asociado = '<label class="form-control-sm form-control-sm">Ubicaci&oacute;n</label>'
	var ubicacion_asociado =  '<input id="ubicacion_asociado' + i + '" name="ubicacion_asociado[]" class="form-control form-control-sm" value="" type="text" readonly>'
    
	
	nuevoContenido +='<div class="form-group">';
	//nuevoContenido += '<label class="control-label form-control-sm">Fila ' + n + '</label>';
	nuevoContenido += '<div class="row">';
	nuevoContenido += '<div class="col-lg-1-5">' + '<div class="form-group">' + etiqueta_numero_cap_asociado;
	nuevoContenido += numero_cap_asociado;
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
	nuevoContenido += '<div class="col-lg-3">' + '<div class="form-group">' + etiqueta_nombre_asociado;
	nuevoContenido += nombre_asociado;
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
	nuevoContenido += '<div class="col-lg-2">' + '<div class="form-group">' + etiqueta_aut_tramite_asociado;
	nuevoContenido += aut_tramite_asociado;
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
	//nuevoContenido += '<div class="row">';
	nuevoContenido += '<div class="col-lg-2">' + '<div class="form-group">' + etiqueta_situacion_asociado;
	nuevoContenido += situacion_asociado;
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
	nuevoContenido += '<div class="col-lg-2">' + '<div class="form-group">' + etiqueta_regional_asociado;
	nuevoContenido += regional_asociado;
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
	nuevoContenido += '<div class="col-lg-2">' + '<div class="form-group">' + etiqueta_act_gremial_asociado;
	nuevoContenido += act_gremial_asociado;
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
	//nuevoContenido += '<div class="row">';
	nuevoContenido += '<div class="col-lg-1-5">' + '<div class="form-group">' + etiqueta_ubicacion_asociado;
	nuevoContenido += ubicacion_asociado;
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
	nuevoContenido += '</div>';
    //$('#tblSesion tbody').append(newRow);
  }
  //formulario += '</form>';

  $('#frmProyectistaAsociado').html(nuevoContenido);

}
</script>



<script type="text/javascript">

function activarNumeroProyectista(){

	var tipo_proyectista = $("#tipo_proyectista").val();

	if(tipo_proyectista == 211){
		
		$("#numero_proyectistas_").hide();
	}else {
		$("#numero_proyectistas_").show();
	}
}


$(document).ready(function() {

	$("#numero_proyectistas_").hide();

	$('#ruc_').blur(function() {
		var id = $('#id').val();
		if (id == 0) {
			validaRuc(this.value);
		}
		//validaRuc(this.value);
	});

});
</script>


