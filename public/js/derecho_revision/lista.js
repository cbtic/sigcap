$(document).ready(function () {
	
	$('#fecha_registro_bus').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
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
	
	$("#id_municipalidad_bus").select2();
	
	datatablenew();
	datatablenew2();
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

	$('#frmSolicitudDerechoRevision #numero_cap_').hide();
	$('#frmSolicitudDerechoRevision #agremiado_').hide();
	$('#frmSolicitudDerechoRevision #situacion_').hide();
	$('#frmSolicitudDerechoRevision #direccion_agremiado_').hide();
	$('#frmSolicitudDerechoRevision #n_regional_').hide();
	$('#frmSolicitudDerechoRevision #act_gremial_').hide();
	$('#frmSolicitudDerechoRevision #dni_').hide();
	$('#frmSolicitudDerechoRevision #persona_').hide();
	$('#frmSolicitudDerechoRevision #fecha_nacimiento_').hide();
	$('#frmSolicitudDerechoRevision #direccion_persona_').hide();
	$('#frmSolicitudDerechoRevision #celular_').hide();
	$('#frmSolicitudDerechoRevision #email_').hide();
	
	if (tipo_solicitante == "")//SELECCIONAR
	{
		
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
			
			var nombre_proyecto = $('#nombre_proyecto_bus').val();
			var id_tipo_proyecto = $('#id_tipo_proyecto_bus').val();
			var id_municipalidad = $('#id_municipalidad_bus').val();
			var fecha_registro = $('#fecha_registro_bus').val();
			var id_estado_proyecto = $('#id_estado_proyecto_bus').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						nombre_proyecto:nombre_proyecto,id_tipo_proyecto:id_tipo_proyecto,
						id_municipalidad:id_municipalidad,fecha_registro:fecha_registro,
						id_estado_proyecto:id_estado_proyecto,
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
					var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					html += '<button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerProyectista('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i>Proyectista</button>';
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [4],
				"className": "dt-center",
				},
				
				{
				"mRender": function (data, type, row) {
					var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					html += '<button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerPropietario('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i>Propietario</button>';
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [5],
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
					var fecha_registro = "";
					if(row.fecha_registro!= null)fecha_registro = row.fecha_registro;
					return fecha_registro;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var estado_proyecto = "";
					if(row.estado_proyecto!= null)estado_proyecto = row.estado_proyecto;
					return estado_proyecto;
				},
				"bSortable": false,
				"aTargets": [7],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var estado = "";
					if(row.estado == 1){
						estado = "Activo";
					}
					if(row.estado == 0){
						estado = "Inactivo";
				}
				return estado;
				},
				"bSortable": false,
				"aTargets": [8]
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarSolicitud('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					
					html += '<button style="font-size:12px;color:#FFFFFF;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalVerCredipago('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i> Ver Credipago</button>';
					
					html += '<a href="javascript:void(0)" onclick=eliminarProfesion('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
					html += '</div>';
					return html;
					},
					"bSortable": false,
					"aTargets": [9],
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
			
			var nombre_proyecto = $('#nombre_proyec	to_bus').val();
			var id_tipo_proyecto = $('#id_tipo_proyecto_bus').val();
			var id_municipalidad = $('#id_municipalidad_bus').val();
			var fecha_registro = $('#fecha_registro_bus').val();
			var id_estado_proyecto = $('#id_estado_proyecto_bus').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						nombre_proyecto:nombre_proyecto,id_tipo_proyecto:id_tipo_proyecto,
						id_municipalidad:id_municipalidad,fecha_registro:fecha_registro,
						id_estado_proyecto:id_estado_proyecto,
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
					var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					html += '<button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerProyectista('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i>Proyectista</button>';
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [4],
				"className": "dt-center",
				},
				
				{
				"mRender": function (data, type, row) {
					var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
					html += '<button style="font-size:12px;" type="button" class="btn btn-sm btn-warning" data-toggle="modal" onclick="modalVerPropietario('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i>Propietario</button>';
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [5],
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
					var fecha_registro = "";
					if(row.fecha_registro!= null)fecha_registro = row.fecha_registro;
					return fecha_registro;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var estado_proyecto = "";
					if(row.estado_proyecto!= null)estado_proyecto = row.estado_proyecto;
					return estado_proyecto;
				},
				"bSortable": false,
				"aTargets": [7],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var estado = "";
					if(row.estado == 1){
						estado = "Activo";
					}
					if(row.estado == 0){
						estado = "Inactivo";
				}
				return estado;
				},
				"bSortable": false,
				"aTargets": [8]
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarSolicitudHU('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					
					html += '<button style="font-size:12px;color:#FFFFFF;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalVerCredipago('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i> Ver Credipago</button>';
					
					html += '<a href="javascript:void(0)" onclick=eliminarProfesion('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
					html += '</div>';
					return html;
					},
					"bSortable": false,
					"aTargets": [9],
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

function eliminarProfesion(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Profesion?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_profesion(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_profesion(id,estado){
	
    $.ajax({
            url: "/profesion/eliminar_profesion/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

function editarSolicitud(id){
	
	//$("#divDocumentos").hide();
	
	$.ajax({
		url: '/derecho_revision/obtener_solicitud/'+id,
		dataType: "json",
		success: function(result){
			
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
			$('#area_techada').val(result.area_total);
			$('#valor_obra').val(result.valor_obra);
			
		}
		
	});

}

function editarSolicitudHU(id){
	
	//$("#divDocumentos").hide();
	
	$.ajax({
		url: '/derecho_revision/obtener_solicitud/'+id,
		dataType: "json",
		success: function(result){
			
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
			$('#area_techada').val(result.area_total);
			$('#valor_obra').val(result.valor_obra);
			
		}
		
	});

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
	var zona = $('#zona').val();
	var tipo = $('#tipo').val();
	var sublote = $('#sublote').val();
	var fila = $('#fila').val();
	var zonificacion = $('#zonificacion').val();
	
	$.ajax({
			url: "/derecho_revision/send_nuevo_registro_solicitud",
			type: "POST",
			data : {_token:_token,id:id,numero_cap:numero_cap,n_revision:n_revision,direccion_proyecto:direccion_proyecto,
				departamento:departamento,provincia:provincia,distrito:distrito,municipalidad:municipalidad,nombre_proyecto:nombre_proyecto,
				parcela:parcela,superManzana:superManzana,lote:lote,fila:fila,sitio:sitio,zona:zona,tipo:tipo,sublote:sublote,zonificacion:zonificacion},
			success: function (result) {
				
				//$('#openOverlayOpc').modal('hide');
				//modalSituacion(id_agremiado);
				//datatableSuspension();

				//window.location.reload();
				
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