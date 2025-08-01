$(document).ready(function () {
	//$.datepicker.setDefaults($.datepicker.regional['es']);
	actualizarBoton();
	
	obtenerProvincia();

	//calculoVistaPrevia();
	$('#solicitante_solicitud').hide();

	if($('#id_solicitud').val()>0){
		obtenerUbigeo();
		obtenerDatosUbigeo();
		
	}
	
	$('#fecha_registro_bus').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_inicio_bus').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_fin_bus').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnImportar').click(function () {
		//modalProfesion(0);
		importarDatalicencia();
	});

	$('#btnBuscar_solicitud').click(function () {
		fn_ListarBusqueda2();
	});

	$('#nombre').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#estado').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});
		
	$('#btnNuevo').click(function () {
		//modalProfesion(0);
		guardar_credipago()
	});

	$('#btnNuevoProyectista').click(function () {
		//modalProfesion(0);
		modalProyectista(0)
	});

	$('#btnNuevoPropietario').click(function () {
		//modalProfesion(0);
		modalPropietario(0)
	});

	$('#btnNuevoinfoProyecto').click(function () {
		//modalProfesion(0);
		modalInfoProyecto(0)
	});

	$('#btnNuevoComprobante').click(function () {
		//modalProfesion(0);
		modalComprobante(0)
	});

	$('#btnNuevo_solicitud').click(function () {
		//modalProfesion(0);
		guardar_credipago_()
	});

	$('#btnSolicitudDerechoRevision').click(function () {
		guardar_solicitud_derecho_revision()
		//Limpiar();
		//window.location.reload();
	});

	$('#btnSolicitudReintegro').click(function () {
		valida_reintegro()
	});
	
	$("#id_municipalidad_bus").select2();
	$("#municipalidad_bus_hu").select2();
	
	
	/*$('#numero_cap_').hide();
	$('#agremiado_').hide();
	$('#situacion_').hide();
	$('#direccion_agremiado_').hide();
	$('#n_regional_').hide();
	$('#act_gremial_').hide();*/
	$('#dni_').hide();
	$('#persona_').hide();
	$('#fecha_nacimiento_').hide();
	$('#direccion_persona_').hide();
	$('#celular_').hide();
	$('#email_').hide();

	

	$('#area_techada_presupuesto, #valor_unitario').on('blur', function() {
        var input = $(this).val().replace(/[^0-9.]/g, '');
        $(this).val(formatoMoneda(input));
        calcularPresupuesto();
    });

    // Initially format the inputs if they have values
    $('#area_techada_presupuesto, #valor_unitario').each(function() {
        var input = $(this).val().replace(/[^0-9.]/g, '');
        $(this).val(formatoMoneda(input));
    });

	cargarPeriodo();
	cargarPeriodoHu();
	datatablenew();
	datatablenew2();
	obtenerPropietario_();
	calculoVistaPrevia();
	
});

function guardar_credipago(){
    
    $.ajax({
		url: "/derecho_revision/send_credipago",
		type: "POST",
		data : $("#frmExpediente").serialize(),
		success: function (result) {
			if(result.sw==1){
				datatablenew();
			}else{
				//var mensaje ="Existe más de un registro con el mismo DNI o RUC, debe de solicitar a sistemas que actualice la Base de Datos.";
				bootbox.alert({
					message: "Existe más de un registro de propietario con el mismo DNI o RUC, debe de solicitar a sistemas que actualice la Base de Datos.",
					//className: "alert_style"
				});
				datatablenew();
			}
			
		}
    });
}



function guardar_credipago_(){
    
    $.ajax({
			url: "/derecho_revision/send_credipago",
            type: "POST",
            data : $("#frmAfiliacion").serialize(),
            success: function (result) { 
				//alert(result);exit(); 
				if(result.sw==true){
					datatablenew();
				}else{
					//var mensaje ="Existe más de un registro con el mismo DNI o RUC, debe de solicitar a sistemas que actualice la Base de Datos.";
					bootbox.alert({
						message: "Existe más de un registro de propietario con el mismo DNI o RUC, debe de solicitar a sistemas que actualice la Base de Datos.",
						//className: "alert_style"
					});
					datatablenew();
				}
				
            }
    });
}

function obtenerPropietario_(){
	
	var id_tipo_documento = $("#id_tipo_documento").val();

	$('#frmSolicitudDerechoRevisionReintegroall #dni_propietario_').show();
    $('#frmSolicitudDerechoRevisionReintegroall #nombre_propietario_').show();
    $('#frmSolicitudDerechoRevisionReintegroall #direccion_dni_').show();
    $('#frmSolicitudDerechoRevisionReintegroall #celular_dni_').show();
    $('#frmSolicitudDerechoRevisionReintegroall #email_dni_').show();
    $('#frmSolicitudDerechoRevisionReintegroall #ruc_propietario_').hide();
    $('#frmSolicitudDerechoRevisionReintegroall #razon_social_propietario_').hide();
    $('#frmSolicitudDerechoRevisionReintegroall #direccion_ruc_').hide();
    $('#frmSolicitudDerechoRevisionReintegroall #telefono_ruc_').hide();
    $('#frmSolicitudDerechoRevisionReintegroall #email_ruc_').hide();
	
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

function credipago_pdf(id){

	$.ajax({
		url: "/derecho_revision/obtener_tipo_credipago/"+id,
		type: "GET",
		success: function (result) {
			
			//var tipo_solicitud = result[0];
			var tipo_solicitud = result.id_tipo_solicitud;
			var id = result.id;
			//alert(result);exit();

			if(tipo_solicitud=="123"){
				credipago_pdf_eficicaciones(id);
			}else if(tipo_solicitud=="124"){
				credipago_pdf_HU(id);
			}
		}
	});
}

function obtenerUbigeo(){

	var distrito = $("#distrito").val();

	$.ajax({
		url: "/derecho_revision/obtener_ubigeo/"+distrito,
		type: "GET",
		success: function (result) {
			
			//var tipo_solicitud = result[0];
			//var ubigeo = result.datos_formateados;
			//var id = result.id;
			//alert(result[0].id_distrito);

			/*$("#provincia").val(result[0].id_provincia).promise().done(function(){
				
				});
				obtenerDistrito_(function(){
					$("#distrito").val(result[0].id_distrito);
			});*/
			var option = "<option value=''>--Seleccionar--</option>";
			$('#municipalidad').html("");

			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.municipalidad+"'>"+oo.denominacion+"</option>";
			});
			$('#municipalidad').html(option);

			if (result.length > 0) {
				$('#municipalidad').val(result[0].municipalidad);
			}
			//$("#municipalidad").val(result[0].id);
			//$('#distrito').attr("disabled",false);
		}
	});
}

function credipago_pdf_eficicaciones(){
	var href = '/derecho_revision/credipago_pdf/'+id;
	window.open(href, '_blank');
}

function credipago_pdf_HU(){
	var href = '/derecho_revision/credipago_pdf_HU/'+id;
	window.open(href, '_blank');
}

function obtenerSolicitante(){
	
	var tipo_solicitante = $("#tipo_solicitante").val();

	/*$('#frmSolicitudDerechoRevision #numero_cap_').hide();
	$('#frmSolicitudDerechoRevision #agremiado_').hide();
	$('#frmSolicitudDerechoRevision #situacion_').hide();
	$('#frmSolicitudDerechoRevision #direccion_agremiado_').hide();
	$('#frmSolicitudDerechoRevision #n_regional_').hide();
	$('#frmSolicitudDerechoRevision #act_gremial_').hide();*/
	$('#frmSolicitudDerechoRevision #dni_').hide();
	$('#frmSolicitudDerechoRevision #persona_').hide();
	$('#frmSolicitudDerechoRevision #fecha_nacimiento_').hide();
	$('#frmSolicitudDerechoRevision #direccion_persona_').hide();
	$('#frmSolicitudDerechoRevision #celular_').hide();
	$('#frmSolicitudDerechoRevision #email_').hide();
	
	if (tipo_solicitante == "")//SELECCIONAR
	{
		$('#frmSolicitudDerechoRevision #numero_cap').val('');
		$('#frmSolicitudDerechoRevision #agremiado').val('');
		$('#frmSolicitudDerechoRevision #situacion').val('');
		$('#frmSolicitudDerechoRevision #direccion_agremiado').val('');
		$('#frmSolicitudDerechoRevision #n_regional').val('');
		$('#frmSolicitudDerechoRevision #act_gremial').val('');
		$('#frmSolicitudDerechoRevision #dni').val('');
		$('#frmSolicitudDerechoRevision #persona').val('');
		$('#frmSolicitudDerechoRevision #fecha_nacimiento').val('');
		$('#frmSolicitudDerechoRevision #direccion_persona').val('');
		$('#frmSolicitudDerechoRevision #celular').val('');
		$('#frmSolicitudDerechoRevision #email').val('');
		$('#frmSolicitudDerechoRevision #numero_cap_').hide();
		$('#frmSolicitudDerechoRevision #agremiado_').hide();
		$('#frmSolicitudDerechoRevision #situacion_').hide();
		$('#frmSolicitudDerechoRevision #direccion_agremiado_').hide();
		$('#frmSolicitudDerechoRevision #n_regional_').hide();
		$('#frmSolicitudDerechoRevision #act_gremial_').hide();
		$('#frmSolicitudDerechoRevision #dni_').hide();
		$('#persona_').hide();
		$('#frmSolicitudDerechoRevision #fecha_nacimiento_').hide();
		$('#frmSolicitudDerechoRevision #direccion_persona_').hide();
		$('#frmSolicitudDerechoRevision #celular_').hide();
		$('#frmSolicitudDerechoRevision #email_').hide();

	} else if (tipo_solicitante == "1")//PROYECTISTA
	{
		$('#frmSolicitudDerechoRevision #numero_cap').val('');
		$('#frmSolicitudDerechoRevision #agremiado').val('');
		$('#frmSolicitudDerechoRevision #situacion').val('');
		$('#frmSolicitudDerechoRevision #direccion_agremiado').val('');
		$('#frmSolicitudDerechoRevision #n_regional').val('');
		$('#frmSolicitudDerechoRevision #act_gremial').val('');
		$('#frmSolicitudDerechoRevision #dni').val('');
		$('#frmSolicitudDerechoRevision #persona').val('');
		$('#frmSolicitudDerechoRevision #fecha_nacimiento').val('');
		$('#frmSolicitudDerechoRevision #direccion_persona').val('');
		$('#frmSolicitudDerechoRevision #celular').val('');
		$('#frmSolicitudDerechoRevision #email').val('');
		$('#frmSolicitudDerechoRevision #numero_cap_').show();
		$('#frmSolicitudDerechoRevision #agremiado_').show();
		$('#frmSolicitudDerechoRevision #situacion_').show();
		$('#frmSolicitudDerechoRevision #direccion_agremiado_').show();
		$('#frmSolicitudDerechoRevision #n_regional_').show();
		$('#frmSolicitudDerechoRevision #act_gremial_').show();
		$('#frmSolicitudDerechoRevision #dni_').hide();
		$('#frmSolicitudDerechoRevision #persona_').hide();
		$('#frmSolicitudDerechoRevision #fecha_nacimiento_').hide();
		$('#frmSolicitudDerechoRevision #direccion_persona_').hide();
		$('#frmSolicitudDerechoRevision #celular_').hide();
		$('#frmSolicitudDerechoRevision #email_').hide();

	} else if (tipo_solicitante == "2") //Responsable de Tramite
	{
		$('#frmSolicitudDerechoRevision #numero_cap').val('');
		$('#frmSolicitudDerechoRevision #agremiado').val('');
		$('#frmSolicitudDerechoRevision #situacion').val('');
		$('#frmSolicitudDerechoRevision #direccion_agremiado').val('');
		$('#frmSolicitudDerechoRevision #n_regional').val('');
		$('#frmSolicitudDerechoRevision #act_gremial').val('');
		$('#frmSolicitudDerechoRevision #dni').val('');
		$('#frmSolicitudDerechoRevision #persona').val('');
		$('#frmSolicitudDerechoRevision #fecha_nacimiento').val('');
		$('#frmSolicitudDerechoRevision #direccion_persona').val('');
		$('#frmSolicitudDerechoRevision #celular').val('');
		$('#frmSolicitudDerechoRevision #email').val('');
		$('#frmSolicitudDerechoRevision #numero_cap_').hide();
		$('#frmSolicitudDerechoRevision #agremiado_').hide();
		$('#frmSolicitudDerechoRevision #situacion_').hide();
		$('#frmSolicitudDerechoRevision #direccion_agremiado_').hide();
		$('#frmSolicitudDerechoRevision #n_regional_').hide();
		$('#frmSolicitudDerechoRevision #act_gremial_').hide();
		$('#frmSolicitudDerechoRevision #dni_').show();
		$('#frmSolicitudDerechoRevision #persona_').show();
		$('#frmSolicitudDerechoRevision #fecha_nacimiento_').show();
		$('#frmSolicitudDerechoRevision #direccion_persona_').show();
		$('#frmSolicitudDerechoRevision #celular_').show();
		$('#frmSolicitudDerechoRevision #email_').show();

	} else {
		$('#frmSolicitudDerechoRevision #numero_cap').val('');
		$('#frmSolicitudDerechoRevision #agremiado').val('');
		$('#frmSolicitudDerechoRevision #situacion').val('');
		$('#frmSolicitudDerechoRevision #direccion_agremiado').val('');
		$('#frmSolicitudDerechoRevision #n_regional').val('');
		$('#frmSolicitudDerechoRevision #act_gremial').val('');
		$('#frmSolicitudDerechoRevision #dni').val('');
		$('#frmSolicitudDerechoRevision #persona').val('');
		$('#frmSolicitudDerechoRevision #fecha_nacimiento').val('');
		$('#frmSolicitudDerechoRevision #direccion_persona').val('');
		$('#frmSolicitudDerechoRevision #celular').val('');
		$('#frmSolicitudDerechoRevision #email').val('');
		$('#frmSolicitudDerechoRevision #numero_cap_').hide();
		$('#frmSolicitudDerechoRevision #agremiado_').hide();
		$('#frmSolicitudDerechoRevision #situacion_').hide();
		$('#frmSolicitudDerechoRevision #direccion_agremiado_').hide();
		$('#frmSolicitudDerechoRevision #n_regional_').hide();
		$('#frmSolicitudDerechoRevision #act_gremial_').hide();
		$('#frmSolicitudDerechoRevision #dni_').show();
		$('#frmSolicitudDerechoRevision #persona_').show();
		$('#frmSolicitudDerechoRevision #fecha_nacimiento_').show();
		$('#frmSolicitudDerechoRevision #direccion_persona_').show();
		$('#frmSolicitudDerechoRevision #celular_').show();
		$('#frmSolicitudDerechoRevision #email_').show();

	}

}

function obtenerProyectista(){
		
	var numero_cap = $("#numero_cap").val();
	var msg = "";
	
	if(numero_cap == "")msg += "Debe ingresar un n&uacute;mero CAP <br>";
	
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
			//alert(agremiado.situacion);
			if (agremiado.situacion=="HABILITADO"){
				$('#frmSolicitudDerechoRevision #agremiado').val(agremiado.agremiado);
				$('#frmSolicitudDerechoRevision #situacion').val(agremiado.situacion);
				$('#frmSolicitudDerechoRevision #direccion_agremiado').val(agremiado.direccion);
				$('#frmSolicitudDerechoRevision #n_regional').val(agremiado.numero_regional);
				$('#frmSolicitudDerechoRevision #act_gremial').val(agremiado.actividad_gremial);
			}else{
				$('#frmSolicitudDerechoRevision #agremiado').val('');
				$('#frmSolicitudDerechoRevision #situacion').val('');
				$('#frmSolicitudDerechoRevision #direccion_agremiado').val('');
				$('#frmSolicitudDerechoRevision #n_regional').val('');
				$('#frmSolicitudDerechoRevision #act_gremial').val('');
				bootbox.alert("El agremiado no esta HABILITADO");
			}
			
			
			//$('#telefono').val(persona.telefono);
			//$('#email').val(persona.email);
			
			$('.loader').hide();

		}
		
	});
	
}

function obtenerPropietario(){
		
	var dni = $("#dni").val();
	var msg = "";
	
	if(dni == "")msg += "Debe ingresar el n&uacute;mero de documento <br>";
	
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
		url: '/persona/obtener_datos_persona/' + dni,
		dataType: "json",
		success: function(result){
			
			var persona = result.persona;
			//var tipo_documento = parseInt(agremiado.tipo_documento);
			//var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
			//alert(persona.nombres);
			
			$('#frmSolicitudDerechoRevision #persona').val(persona.nombres);
			$('#frmSolicitudDerechoRevision #fecha_nacimiento').val(persona.fecha_nacimiento);
			$('#frmSolicitudDerechoRevision #direccion_persona').val(persona.direccion);
			$('#frmSolicitudDerechoRevision #celular').val(persona.numero_celular);
			$('#frmSolicitudDerechoRevision #email').val(persona.correo);
			
			//$('#telefono').val(persona.telefono);
			//$('#email').val(persona.email);
			
			$('.loader').hide();

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

function obtenerProvinciaBus(){
	
	var id = $('#departamento_bus').val();
	if(id=="")return false;
	$('#provincia_bus').attr("disabled",true);
	$('#distrito_bus').attr("disabled",true);
	
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
			$('#provincia_bus').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#provincia_bus').html(option);
			
			var option2 = "<option value=''>Seleccionar</option>";
			$('#distrito_bus').html(option2);
			
			$('#provincia_bus').attr("disabled",false);
			$('#distrito_bus').attr("disabled",false);
			
			$('.loader').hide();
			
		}
		
	});
	
}

function obtenerDatosUbigeo(){

	var id = $('#id_solicitud').val();
	
	$.ajax({
		url: '/derecho_revision/obtener_provincia_distrito_solicitud/'+id,
		dataType: "json",
		success: function(result){
			
			//alert(result[0].provincia);

			$('#provincia').val(result[0].provincia);

			obtenerDistrito_(function(){

				$('#distrito').val(result[0].distrito);

			});
			
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

function obtenerDistritoBus(){
		
	var departamento = $('#departamento_bus').val();
	var id = $('#provincia_bus').val();
	if(id=="")return false;
	$('#distrito_bus').attr("disabled",true);
	
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
			$('#distrito_bus').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#distrito_bus').html(option);
			
			$('#distrito_bus').attr("disabled",false);
			$('.loader').hide();
			
		}
		
	});
	
}

function obtenerDistrito_(callback){
		
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

			callback();
		
		}
		
	});
}

function obtenerProvinciaDomiciliario(){
	
	var id = $('#id_departamento_domiciliario').val();
	if(id=="")return false;
	$('#id_provincia_domiciliario').attr("disabled",true);
	$('#id_distrito_domiciliario').attr("disabled",true);
	
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
			$('#id_provincia_domiciliario').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_provincia+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#id_provincia_domiciliario').html(option);
			
			var option2 = "<option value=''>Seleccionar</option>";
			$('#id_distrito_domiciliario').html(option2);
			
			$('#id_provincia_domiciliario').attr("disabled",false);
			$('#id_distrito_domiciliario').attr("disabled",false);
			
			$('.loader').hide();
			
		}
		
	});
	
}

function obtenerDistritoDomiciliario(){
	
	var id_departamento = $('#id_departamento_domiciliario').val();
	var id = $('#id_provincia_domiciliario').val();
	if(id=="")return false;
	$('#id_distrito_domiciliario').attr("disabled",true);
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/agremiado/obtener_distrito/'+id_departamento+'/'+id,
		dataType: "json",
		success: function(result){
			var option = "<option value=''>Seleccionar</option>";
			$('#id_distrito_domiciliario').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_ubigeo+"'>"+oo.desc_ubigeo+"</option>";
			});
			$('#id_distrito_domiciliario').html(option);
			
			$('#id_distrito_domiciliario').attr("disabled",false);
			$('.loader').hide();
			
		}
		
	});
	
}

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/derecho_revision/listar_derecho_revision_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "bFilter": false,
        "bSort": false,
        "info": true,
        "language": {"url": "/js/Spanish.json"},
        "autoWidth": false,
        "bLengthChange": true,
        "destroy": true,
        "lengthMenu": [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
        "aoColumns": [
                        {},
        ],
		"dom": '<"top">rt<"bottom"flpi><"clear">',
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
			var anio = $('#anio_bus').val();
			var nombre_proyecto = $('#nombre_proyecto_bus').val();
			var distrito_domiciliario = $('#id_distrito_domiciliario').val();
			var numero_cap = $('#numero_cap_bus').val();
			var proyectista = $('#proyectista_bus').val();
			var numero_documento = $('#numero_documento_bus').val();
			var propietario = $('#propietario_bus').val();
			var tipo_proyecto = $('#tipo_proyecto_bus').val();
			var tipo_solicitud = $('#id_tipo_proyecto_bus').val();
			var credipago = $('#numero_liquidacion_bus').val();
			var municipalidad = $('#id_municipalidad_bus').val();
			var direccion = $('#direccion_proyecto_bus').val();
			var n_solicitud = $('#n_solicitud_bus').val();
			var codigo = $('#codigo_proyecto_bus').val();
			var fecha_inicio_bus = $('#fecha_inicio_bus').val();
			var fecha_fin_bus = $('#fecha_fin_bus').val();
			var estado_proyecto = $('#id_estado_proyecto_bus').val();
			var situacion_credipago = $('#id_situacion_credipago_bus').val();
			var estado = $('#estado_bus').val();
			var departamento = $('#departamento_bus').val();
			var provincia = $('#provincia_bus').val();
			var distrito = $('#distrito_bus').val();
			var sitio = $('#sitio_bus').val();
			var direccion_sitio = $('#direccion_sitio_bus').val();
			var zona = $('#zona_bus').val();
			var direccion_zona = $('#direccion_zona_bus').val();
			var tipo = $('#tipo_bus').val();
			var lote = $('#lote_bus').val();
			var sublote = $('#sublote_bus').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina, NumeroRegistros:iCantMostrar,
						anio:anio, nombre_proyecto:nombre_proyecto, distrito_domiciliario:distrito_domiciliario, numero_cap:numero_cap, proyectista:proyectista,
						numero_documento:numero_documento, propietario:propietario, tipo_proyecto:tipo_proyecto, tipo_solicitud:tipo_solicitud, credipago:credipago,
						municipalidad:municipalidad, direccion:direccion, n_solicitud:n_solicitud, codigo:codigo, estado_proyecto:estado_proyecto,
						fecha_inicio_bus:fecha_inicio_bus, fecha_fin_bus:fecha_fin_bus, situacion_credipago:situacion_credipago, estado:estado, departamento:departamento,
						provincia:provincia, distrito:distrito, sitio:sitio, direccion_sitio:direccion_sitio, zona:zona, direccion_zona:direccion_zona,
						tipo:tipo, lote:lote, sublote:sublote,
						_token:_token
                       },
                "success": function (result) {
                    fnCallback(result);
                },
                "error": function (msg, textStatus, errorThrown) {
                }
            });
        },

        "aoColumnDefs":
            [	
				{
				"mRender": function (data, type, row) {
					var codigo_solicitud = "";
					if(row.codigo_solicitud!= null)codigo_solicitud = row.codigo_solicitud;
					return codigo_solicitud;
				},
				"bSortable": false,
				"aTargets": [0],
				"sWidth": "500px",
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var codigo = "";
					if(row.codigo!= null)codigo = row.codigo;
					return codigo;
				},
				"bSortable": false,
				"aTargets": [1],
				"sWidth": "500px",
				"className": "dt-center",
				},
				{
                "mRender": function (data, type, row) {
                	var nombre_proyecto = "";
					if(row.nombre_proyecto!= null)nombre_proyecto = row.nombre_proyecto;
					return nombre_proyecto;
                },
                "bSortable": false,
                "aTargets": [2],
				"sWidth": "500px",
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var tipo_solicitud = "";
					if(row.tipo_solicitud!= null)tipo_solicitud = row.tipo_solicitud;
					return tipo_solicitud;
				},
				"bSortable": false,
				"aTargets": [3],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var numero_revision = "";
					if(row.numero_revision!= null)numero_revision = row.numero_revision;
					return numero_revision;
				},
				"bSortable": false,
				"aTargets": [4],
				"className": "dt-center",
				},
				{
					"mRender": function (data, type, row) {
						var instancia = "";
						if (row.instancia !== null) {
							if (row.instancia === 'REINTEGRO') {
								
								instancia = `<a href="/derecho_revision/derecho_revision_editar_reintegro/${row.id}" 
											style="font-size: 12px; text-decoration: underline; color: blue;">
												${row.instancia}
											</a>`;
							} else {
								
								instancia = row.instancia;
							}
						}
						return instancia;
					},
					"bSortable": false,
					"aTargets": [5],
					"className": "dt-center",
					},
				{
				"mRender": function (data, type, row) {
					var municipalidad = "";
					if(row.municipalidad!= null)municipalidad = row.municipalidad;
					return municipalidad;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var numero_cap = "";
					if(row.numero_cap!= null)numero_cap = row.numero_cap;
					return numero_cap;
				},
				"bSortable": false,
				"aTargets": [7],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var proyectista = "";
					if(row.proyectista!= null)proyectista = row.proyectista;
					return proyectista;
				},
				"bSortable": false,
				"aTargets": [8],
				"className": "dt-center",
				},
				
				{
				"mRender": function (data, type, row) {
					/*var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					html += '<button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerPropietario('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i>Propietario</button>';
					html += '</div>';
					return html;*/
					var propietario = "";
					if(row.propietario!= null)propietario = row.propietario;
					return propietario;
				},
				"bSortable": false,
				"aTargets": [9],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var credipago = "";
					if(row.credipago!= null)credipago = row.credipago;
					return credipago;
				},
				"bSortable": false,
				"aTargets": [10],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var fecha_registro = "";
					if(row.fecha_registro!= null)fecha_registro = row.fecha_registro;
					return fecha_registro;
				},
				"bSortable": false,
				"aTargets": [11],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var estado_proyecto = "";
					if(row.estado_proyecto!= null)estado_proyecto = row.estado_proyecto;
					return estado_proyecto;
				},
				"bSortable": false,
				"aTargets": [12],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var estado = "";
					if(row.estado == 1){
						estado = "No Anulado";
					}
					if(row.estado == 0){
						estado = "Anulado";
				}
				return estado;
				},
				"bSortable": false,
				"aTargets": [13]
				},
				{
				"mRender": function (data, type, row) {
					var estado = "";
					var clase = "";
					if(row.estado == 1){
						estado = "Eliminar";
						clase = "btn-danger";
					}
					if(row.estado == 0){
						estado = "Activar";
						clase = "btn-success";
					}
				
					var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					html += '<a href="/derecho_revision/editar_derecho_revision_edificaciones/'+row.id+'" onclick="" class="btn btn-sm btn-success" style="font-size:12px;margin-left:10px" id=""><i class="fa fa-edit"></i> Editar</a>';
					//html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarSolicitud('+row.id+')" ><i class="fa fa-edit"></i>Editar</button>';
					
					html += '<button style="font-size:12px;color:#FFFFFF;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalVerCredipago('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i> Ver Credipago</button>';
					if (row.id_resultado == 1 && row.estado != 0) {
						html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalReintegroSolicitud('+row.id+')" ><i class="fa fa-edit"></i>Generar Liquidaci&oacute;n</button>';
					}else{
						html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalReintegroSolicitud('+row.id+')" disabled><i class="fa fa-edit"></i>Generar Liquidaci&oacute;n</button>';
					}

					if (row.id_resultado == 4 && row.estado != 0 || row.id_resultado == 5 && row.estado != 0 || row.id_resultado == 6  && row.estado != 0) {
						html += '<a href="/derecho_revision/derecho_revision_reintegro/'+row.id+'" onclick="" style="font-size: 12px; margin-left: 10px;" class="btn btn-secondary pull-rigth" id="btnReintroEdificaciones"><i class="fa fa-edit"></i> Reintegro</a>'
					}else{
						html += '<a href="/derecho_revision/derecho_revision_reintegro/'+row.id+'" onclick="" style="font-size:12px;margin-left:10px; pointer-events: none; opacity: 0.6; cursor: not-allowed;" class="btn btn-secondary pull-rigth" id="btnReintroEdificaciones"><i class="fa fa-edit"></i> Reintegro</a>'
					}
					
					/*if (row.id_resultado == 1 || row.id_resultado == 2 || row.id_resultado == 3) {
						html += '<a href="javascript:void(0)" onclick=eliminarSolicitudEdificaciones('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					}else{
						html += '<a href="javascript:void(0)" onclick=eliminarSolicitudEdificaciones('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px; pointer-events: none; opacity: 0.6; cursor: not-allowed;">'+estado+'</a>';
					}*/
					if(row.codigo_solicitud){
						html += '<a href="javascript:void(0)" onclick=importarDataLicenciaIndividual('+row.codigo_solicitud+') class="btn btn-sm btn-danger" style="font-size:12px;margin-left:10px">Importar Individual</a>';
					}else{
						html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-danger" disabled>Importar Individual</button>';
					}
					
					html += '</div>';
					return html;
					},
					"bSortable": false,
					"aTargets": [14],
				},
            ]
    });
}

function datatablenew2(){
    var oTable1 = $('#tblSolicitudHU').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/derecho_revision/listar_derecho_revision_hu_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "bFilter": false,
        "bSort": false,
        "info": true,
        "language": {"url": "/js/Spanish.json"},
        "autoWidth": false,
        "bLengthChange": true,
        "destroy": true,
        "lengthMenu": [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
        "aoColumns": [
                        {},
        ],
		"dom": '<"top">rt<"bottom"flpi><"clear">',
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {

            var sEcho           = aoData[0].value;
            var iNroPagina 	= parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
            var iCantMostrar 	= aoData[4].value;
			
			var anio = $('#anio_hu_bus').val();
			var nombre_proyecto = $('#nombre_proyecto_bus_hu').val();
			var distrito = $('#id_distrito_domiciliario_hu').val();
			var numero_cap = $('#numero_cap_hu').val();
			var proyectista = $('#proyectista_hu').val();
			var numero_documento = $('#numero_documento_hu').val();
			var propietario = $('#propietario_hu').val();
			var tipo_proyecto = $('#tipo_proyecto_bus_hu').val();
			var tipo_solicitud = $('#id_tipo_proyecto_bus_hu').val();
			var credipago = $('#numero_liquidacion_hu').val();
			var municipalidad = $('#municipalidad_bus_hu').val();
			var direccion = $('#direccion_proyecto_hu').val();
			var estado_proyecto = $('#estado_solicitud_bus_hu').val();
			var situacion_credipago = $('#id_situacion_credipago').val();
			var departamento = $('#departamento_bus').val();
			var provincia = $('#provincia_bus').val();
			var distrito = $('#distrito_bus').val();
			var sitio = $('#sitio_bus').val();
			var direccion_sitio = $('#direccion_sitio_bus').val();
			var zona = $('#zona_bus').val();
			var direccion_zona = $('#direccion_zona_bus').val();
			var tipo = $('#tipo_bus').val();
			var lote = $('#lote_bus').val();
			var sublote = $('#sublote_bus').val();
			var _token = $('#_token').val();
			

            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						anio:anio, nombre_proyecto:nombre_proyecto, distrito:distrito, numero_cap:numero_cap,
						proyectista:proyectista, numero_documento:numero_documento, propietario:propietario,
						tipo_proyecto:tipo_proyecto, tipo_solicitud:tipo_solicitud, credipago:credipago,
						municipalidad:municipalidad, direccion:direccion, estado_proyecto:estado_proyecto,
						situacion_credipago:situacion_credipago, departamento:departamento, provincia:provincia, sitio:sitio, direccion_sitio:direccion_sitio,
						zona:zona, direccion_zona:direccion_zona, tipo:tipo, lote:lote, sublote:sublote,
						_token:_token
					},
                "success": function (result) {
                    fnCallback(result);
                },
                "error": function (msg, textStatus, errorThrown) {
                }
            });
        },

        "aoColumnDefs":
            [	
				{
                "mRender": function (data, type, row) {
                	var nombre_proyecto = "";
					if(row.nombre_proyecto!= null)nombre_proyecto = row.nombre_proyecto;
					return nombre_proyecto;
                },
                "bSortable": false,
                "aTargets": [0],
				"sWidth": "500px",
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var tipo_proyecto = "";
					if(row.tipo_proyecto!= null)tipo_proyecto = row.tipo_proyecto;
					return tipo_proyecto;
				},
				"bSortable": false,
				"aTargets": [1],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var numero_revision = "";
					if(row.numero_revision!= null)numero_revision = row.numero_revision;
					return numero_revision;
				},
				"bSortable": false,
				"aTargets": [2],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var municipalidad = "";
					if(row.municipalidad!= null)municipalidad = row.municipalidad;
					return municipalidad;
				},
				"bSortable": false,
				"aTargets": [3],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var numero_cap = "";
					if(row.numero_cap!= null)numero_cap = row.numero_cap;
					return numero_cap;
				},
				"bSortable": false,
				"aTargets": [4],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					/*var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					html += '<button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerProyectista('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i>Proyectista</button>';
					html += '</div>';
					return html;*/
					var proyectista = "";
					if(row.proyectista!= null)proyectista = row.proyectista;
					return proyectista;
				},
				"bSortable": false,
				"aTargets": [5],
				"className": "dt-center",
				},
				
				{
				"mRender": function (data, type, row) {
					/*var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					html += '<button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerPropietario('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i>Propietario</button>';
					html += '</div>';
					return html;*/
					var propietario = "";
					if(row.propietario!= null)propietario = row.propietario;
					return propietario;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				/*
				{
				"mRender": function (data, type, row) {
					var nombre_agremiado = "";
					if(row.desc_cliente!= null)nombre_agremiado = row.desc_cliente;
					return nombre_agremiado;
				},
				"bSortable": false,
				"aTargets": [5],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var numero_documento = "";
					if(row.numero_documento!= null)numero_documento = row.numero_documento;
					return numero_documento;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var nombre_propietario = "";
					if(row.propietario!= null)nombre_propietario = row.propietario;
					return nombre_propietario;
				},
				"bSortable": false,
				"aTargets": [7],
				"className": "dt-center",
				},
				*/
				{
				"mRender": function (data, type, row) {
					var credipago = "";
					if(row.credipago!= null)credipago = row.credipago;
					return credipago;
				},
				"bSortable": false,
				"aTargets": [7],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var fecha_registro = "";
					if(row.fecha_registro!= null)fecha_registro = row.fecha_registro;
					return fecha_registro;
				},
				"bSortable": false,
				"aTargets": [8],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var estado_proyecto = "";
					if(row.estado_proyecto!= null)estado_proyecto = row.estado_proyecto;
					return estado_proyecto;
				},
				"bSortable": false,
				"aTargets": [9],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var estado = "";
					var clase = "";
					if(row.estado == 1){
						estado = "Eliminar";
						clase = "btn-danger";
					}
					if(row.estado == 0){
						estado = "Activar";
						clase = "btn-success";
					}
				
					var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					//html += '<a href="/derecho_revision/editar_derecho_revision_nuevo/" onclick="" style="font-size: 12px; margin-left: 10px;" class="btn btn-sm btn-success" id="btnEditar"><i class="fa fa-edit"></i> Editar</a>';
					html += '<a href="/derecho_revision/editar_derecho_revision_nuevo/'+row.id+'" onclick="" class="btn btn-sm btn-success" style="font-size:12px;margin-left:10px" id=""><i class="fa fa-edit"></i> Editar</a>';
					//html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarSolicitudHU('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					
					html += '<button style="font-size:12px;color:#FFFFFF;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalVerCredipago('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i> Ver Credipago</button>';
					html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalReintegroSolicitudRU('+row.id+')" ><i class="fa fa-edit"></i> Generar Liquidaci&oacute;n</button>';
					//html += '<a href="/derecho_revision/editar_derecho_revision_nuevo/'+row.id+'" style="font-size: 12px; margin-left: 10px;" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> Editar</a>';
					if (row.id_resultado == 1 || row.id_resultado == 2 || row.id_resultado == 3) {
						html += '<a href="javascript:void(0)" onclick=eliminarSolicitudHU('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					}else{
						html += '<a href="javascript:void(0)" onclick=eliminarSolicitudHU('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px; pointer-events: none; opacity: 0.6; cursor: not-allowed;">'+estado+'</a>';
					}
					html += '</div>';
					return html;
					},
					"bSortable": false,
					"aTargets": [10],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function fn_ListarBusqueda2() {
    datatablenew2();
};

function modal_solicitud_derecho(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_solicitud_nuevoSolicitud/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalReintegroSolicitud(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_reintegro/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalReintegroSolicitudRU(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_reintegroRU/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarSolicitudEdificaciones(id,estado){
	var act_estado = "";
	if(estado==1){
		act_estado = "Eliminar";
		estado_=0;
	}
	if(estado==0){
		act_estado = "Activar";
		estado_=1;
	}
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" la Solicitud?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_solicitud_edificaciones(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_solicitud_edificaciones(id,estado){
	
    $.ajax({
            url: "/derecho_revision/eliminar_solicitud_edificaciones/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

function eliminarSolicitudHU(id,estado){
	var act_estado = "";
	if(estado==1){
		act_estado = "Eliminar";
		estado_=0;
	}
	if(estado==0){
		act_estado = "Activar";
		estado_=1;
	}
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" la Solicitud?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_solicitud_hu(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_solicitud_hu(id,estado){
	
    $.ajax({
            url: "/derecho_revision/eliminar_solicitud_hu/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

function editarSolicitud(id){
	
	$.ajax({
		url: '/derecho_revision/obtener_solicitud/'+id,
		dataType: "json",
		success: function(result){

			function formatoMoneda(num) {
				return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
			}
			
			var areaTotal = parseFloat(result.area_total.replace(',', '').replace('.', ''));
			var valorObra = parseFloat(result.valor_obra.replace(',', '').replace('.', ''));

			$('#id').val(result.id);
			$('#nombre_proyecto').val(result.nombre_proyecto);
			$('#direccion').val(result.direccion);
			$('#departamento_domiciliario').val(result.departamento);
			$('#provincia_domiciliario').val(result.provincia);
			$('#distrito_domiciliario').val(result.distrito);
			$('#numero_cap').val(result.numero_cap);
			$('#proyectista').val(result.desc_cliente);
			$('#numero_documento').val(result.numero_documento);
			$('#propietario').val(result.propietario);
			$('#municipalidad').val(result.municipalidad);
			$('#tipo_solicitud').val(result.tipo_solicitud);
			$('#tipo_proyecto').val(result.tipo_proyecto);
			$('#numero_revision').val(result.numero_revision);
			$('#area_techada').val(formatoMoneda(areaTotal));
			$('#valor_obra').val(formatoMoneda(valorObra));
			
		}
		
	});

}

function editarSolicitudHU(id){
	
	//$("#divDocumentos").hide();
	
	$.ajax({
		url: '/derecho_revision/obtener_solicitud/'+id,
		dataType: "json",
		success: function(result){

			function formatoMoneda(num) {
				return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
				
			}
			
			$('#id').val(result.id);
			$('#nombre_proyecto').val(result.nombre_proyecto);
			$('#direccion').val(result.direccion);
			$('#departamento_domiciliario').val(result.departamento);
			$('#provincia_domiciliario').val(result.provincia);
			$('#distrito_domiciliario').val(result.distrito);
			$('#numero_cap').val(result.numero_cap);
			$('#proyectista').val(result.desc_cliente);
			$('#numero_documento').val(result.numero_documento);
			$('#propietario').val(result.propietario);
			$('#municipalidad').val(result.municipalidad);
			$('#tipo_solicitud').val(result.tipo_solicitud);
			$('#tipo_proyecto').val(result.tipo_proyecto);
			if (result.area_total !== null && result.area_total !== undefined) {
				// Convertir el valor a número
				var areaTotal = parseFloat(result.area_total.replace(',', '').replace('.', ''));
				// Formatear y asignar el valor
				$('#area_techada').val(formatoMoneda(areaTotal));
			} else {
				$('#area_techada').val('');
			}
			$('#numero_revision').val(result.numero_revision);
			
			$('#valor_obra').val(result.valor_obra);
			$('#id_editar').val(result.id);
			actualizarBoton();
		}
		
	});

}

function editarSolicitudHU_derecho(id){
	
    $.ajax({
            url: "/derecho_revision/editar_derecho_revision_nuevo/"+id,
            type: "GET",
            success: function (result) {
				datatablenew();

            }
    });
}

function actualizarBoton() {
    //alert($('#id_editar').val());
    var id = $('#id_editar').val();
    if (id == "0") {
        $('#btnEditar').addClass('disabled').attr('onclick','return false;');
    } else {
		$('#btnEditar').removeClass('disabled').removeAttr('onclick');
        $('a.btn-success').attr('href', '/derecho_revision/editar_derecho_revision_nuevo/'+id);
    }
}

function modalVerCredipago(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_credipago/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalVerProyectista(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_proyectista/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

/*function datatableProyectista(){
	
	var id_solicitud =  $('#id').val();
	
    $("#tblSolicitud tbody").html("");
	$.ajax({
			url: "/agremiado/obtener_proyectista/"+id_solicitud,
			type: "GET",
			success: function (result) {
					$("#tblSolicitud tbody").html(result);
			}
	});
}*/

function modalVerPropietario(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_propietario/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}


function modalProyectista(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_nuevo_proyectista/"+id,
			type: "GET",
			success: function (result) {  
				$("#diveditpregOpc").html(result);
				$('#openOverlayOpc').modal('show');
			}
	});

}

function modalPropietario(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_nuevo_propietario/"+id,
			type: "GET",
			success: function (result) {
				$("#diveditpregOpc").html(result);
				$('#openOverlayOpc').modal('show');
			}
	});
}

function modalInfoProyecto(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_nuevo_infoProyecto/"+id,
			type: "GET",
			success: function (result) {
				$("#diveditpregOpc").html(result);
				$('#openOverlayOpc').modal('show');
			}
	});
}

function modalComprobante(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/derecho_revision/modal_nuevo_comprobante/"+id,
			type: "GET",
			success: function (result) {
				$("#diveditpregOpc").html(result);
				$('#openOverlayOpc').modal('show');
			}
	});

}

function guardar_solicitud_derecho_revision(){
    
	var msg = "";
	var _token = $('#_token').val();
	var id = "0";
	var id_solicitud = $('#id_solicitud').val();
	var numero_cap = $('#numero_cap').val();
	var n_revision = $('#n_revision').val();
	var direccion_proyecto = $('#direccion_proyecto').val();
	var departamento = $('#departamento').val();
	var provincia = $('#provincia').val();
	var distrito = $('#distrito').val();
	var municipalidad = $('#municipalidad').val();
	var nombre_proyecto = $('#nombre_proyecto').val();
	var parcela = $('#parcela').val();
	var superManzana = $('#superManzana').val();
	var lote = $('#lote').val();
	var sitio = $('#sitio').val();
	var direccion_sitio = $('#direccion_sitio').val();
	var zona = $('#zona').val();
	var direccion_zona = $('#direccion_zona').val();
	var tipo = $('#tipo').val();
	var sublote = $('#sublote').val();
	var fila = $('#fila').val();
	var zonificacion = $('#zonificacion').val();

	if(numero_cap==""){msg+="Ingrese el N&uacute;mero de CAP <br>";}
	if(nombre_proyecto==""){msg+="Ingrese el Nombre del Proyecto<br>";}
	if(municipalidad==""){msg+="Ingrese la Municipalidad<br>";}
	if(n_revision==""){msg+="Ingrese el N&uacute;mero de Revisi&oacute;n<br>";}
	if(departamento==""){msg+="Ingrese el Departamento<br>";}
	if(provincia==""){msg+="Ingrese la Provincia<br>";}
	if(distrito==""){msg+="Ingrese el Distrito<br>";}
	if(direccion_proyecto==""){msg+="Ingrese el Direcci&oacute;n<br>";}

	if(msg!=""){
        bootbox.alert(msg);
        return false;
    }else{
		$.ajax({
			url: "/derecho_revision/send_nuevo_registro_solicitud",
			type: "POST",
			data : {_token:_token,id:id,numero_cap:numero_cap,n_revision:n_revision,direccion_proyecto:direccion_proyecto,
				departamento:departamento,provincia:provincia,distrito:distrito,municipalidad:municipalidad,nombre_proyecto:nombre_proyecto,
				parcela:parcela,superManzana:superManzana,lote:lote,fila:fila,sitio:sitio,zona:zona,tipo:tipo,sublote:sublote,zonificacion:zonificacion,
				direccion_sitio:direccion_sitio,direccion_zona:direccion_zona,id_solicitud:id_solicitud},
			success: function (result) {
				
				//alert();
				var href = '/derecho_revision/editar_derecho_revision_nuevo/'+result;
				window.location.href = href;
				//window.location.reload();
				
			}
		});
	}
}

function valida_reintegro(){
    
    var msg="";
    var situacion=$("#frmSolicitudDerechoRevisionReintegroall #situacion").val();
    
    if(situacion=="FALLECIDO"){msg+="El agremiado est&aacute; FALLECIDO";}

    if(situacion=="INHABILITADO"){msg+="El agremiado est&aacute; INHABILITADO";}
    
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }else if(situacion=="HABILITADO"){
        guardar_solicitud_reintegro();
    } 
}

function guardar_solicitud_reintegro(){
	
	$.ajax({
			url: "/derecho_revision/send_nuevo_reintegro",
			type: "POST",
			data : $("#frmSolicitudDerechoRevisionReintegroall").serialize(),
			success: function (result) {
				
				//$('#openOverlayOpc').modal('hide');
				//modalSituacion(id_agremiado);
				//datatableSuspension();

				window.location.reload();
				
				//$('#openOverlayOpc').modal('hide');
				
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

function cargarPeriodo(){

	$.ajax({
		url: "/derecho_revision/listar_solicitud_periodo",
		type: "POST",
		data : $("#frmExpediente").serialize(),
		success: function(result){
			var option = "<option value='' selected='selected'>--Todos--</option>";
			var currentYear = new Date().getFullYear();
			$('#anio_bus').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.anio+"'>"+oo.anio+"</option>";
			});
			$('#anio_bus').html(option);
			$('#anio_bus').val(currentYear);
			//$('#anio_bus').select2();
			
			//$('.loader').hide();			
		}
		
	});
}

function cargarPeriodoHu(){

	$.ajax({
		url: "/derecho_revision/listar_solicitud_periodo_hu",
		type: "POST",
		data : $("#frmAfiliacion").serialize(),
		success: function(result){
			var option = "<option value='' selected='selected'>--Año--</option>";
			var currentYear = new Date().getFullYear();
			$('#anio_hu_bus').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.anio+"'>"+oo.anio+"</option>";
			});
			$('#anio_hu_bus').html(option);
			$('#anio_hu_bus').val(currentYear);
			//$('#anio_bus').select2();
			
			//$('.loader').hide();			
		}
		
	});
}

function importarDatalicencia(){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

	$.ajax({
		url: "/derecho_revision/importar_dataLicencia",
		type: "GET",
		success: function(result){

			$('.loader').hide();
			bootbox.alert("Se import&oacute; exitosamente los datos"); 
			datatablenew();

		}
	});
}

function importarDataLicenciaIndividual(codigo_solicitud){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

	$.ajax({
		url: "/derecho_revision/importar_dataLicenciaIndividual/"+codigo_solicitud,
		type: "GET",
		success: function(result){

			$('.loader').hide();
			bootbox.alert("Se import&oacute; exitosamente los datos"); 
			datatablenew();

		}
	});
}


function validarProyectistaPrincipal(id){


	$.ajax({
		url: "/derecho_revision/validar_proyectista_hu/"+id,
		type: "GET",
		success: function (result) {
			
			//alert(result[0].id_tipo_proyectista);
			if(result[0].id_tipo_proyectista==1){
				bootbox.alert("No puede eliminar al proyectista principal"); 
			}else{
				eliminarProyectistaHU(id);
			}
		}
});
}

function eliminarProyectistaHU(id){
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas eliminar el Proyectista?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_proyectista_hu(id);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_proyectista_hu(id){
	
	$.ajax({
            url: "/derecho_revision/eliminar_proyectista_hu/"+id,
            type: "GET",
            success: function (result) {
				//datatable_mov();
				window.location.reload();
            }
    });
}

function eliminarPropietarioHU(id){
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas eliminar el Propietario?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_propietario_hu(id);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_propietario_hu(id){
	
	$.ajax({
            url: "/derecho_revision/eliminar_propietario_hu/"+id,
            type: "GET",
            success: function (result) {
				//datatable_mov();
				window.location.reload();
            }
    });
}

function eliminarInfoProyectoHU(id){
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas eliminar el Registro?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_infoProyecto_hu(id);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_infoProyecto_hu(id){
	
	$.ajax({
            url: "/derecho_revision/eliminar_infoProyecto_hu/"+id,
            type: "GET",
            success: function (result) {
				//datatable_mov();
				window.location.reload();
            }
    });
}


function calcularPresupuesto() {
	var areaTechada = parseFloat($('#area_techada_presupuesto').val().replace(/,/g, '')) || 0;
	var valorUnitario = parseFloat($('#valor_unitario').val().replace(/,/g, '')) || 0;
	var presupuesto = areaTechada * valorUnitario;
	$('#presupuesto').val(presupuesto.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
}

function formatoMoneda(input) {
	return parseFloat(input.replace(/,/g, '')).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function copiarArea(){
	var input = document.getElementById('area_techada').value.replace(/[^0-9.]/g, '');
	var valor_formateado = formatoMoneda(input);
    document.getElementById('area_techada').value = valor_formateado;
    document.getElementById('area_techada_total').value = valor_formateado;
}

function AddFilaPresupuesto() {

    var container = document.getElementById('presupuesto-container');
    var newRow = container.children[0].cloneNode(true); // Clona la primera fila

    // Limpia los valores de los campos en la nueva fila
    newRow.querySelectorAll('input').forEach(function(input) {
        input.value = '';
    });
    newRow.querySelectorAll('select').forEach(function(select) {
        select.selectedIndex = "";
    });

    container.appendChild(newRow); // Agrega la nueva fila al contenedor

}


