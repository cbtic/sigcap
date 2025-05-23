//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	$('#btnCalcular').click(function () {
		fn_calcular();
	});
		
	cargarFondoComun();
	
	$("#plan_id").select2();
	$("#ubicacion_id").select2();

	$('#btnDescargar').on('click', function () {
		DescargarPdfFondoComun()

	});
	
	/*
	$('#fecha_inicio').datepicker({
        autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
    });
	
	$('#fecha_vencimiento').datepicker({
        autoclose: true,
        dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
    });
	*/
	
	/*
    $('#tblAlquiler').dataTable({
    	"language": {
    	"emptyTable": "No se encontraron resultados"
    	}
	});
	*/
	/*
	$('#tblAlquiler').dataTable( {
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningun dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "ultimo",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                },
                "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        } );
	*/


	$(function() {
		$('#modalPersonaForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});


	$(function() {
		$('#modalPersonaTitularForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaTitularForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaTitularForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
});

function habiliarTitular(){
	/*
	$('#divTitular').hide();
	if(!$("#chkTitular").is(':checked')) {
    	$('#divTitular').show();
	}
	*/
}

function guardarAfiliacion(){
    
    var msg = "";
    var persona_id = $('#persona_id').val();
    var titular_id = $('#titular_id').val();
	var plan_id = $('#plan_id').val();
	var fecha_inicio = $('#fecha_inicio').val();
	var fecha_vencimiento = $('#fecha_vencimiento').val();
	
	if(persona_id == "")msg += "Debe ingresar el Numero de Documento <br>";
	if(!$("#chkTitular").is(':checked')) {
    	if(titular_id == "")msg += "Debe ingresar el Numero de Documento del Titular<br>";
	}
    if(plan_id == "0")msg+="Debe seleccionar un Plan/Tarifario <br>";
	if(fecha_inicio == "")msg += "Debe ingresar la fecha de inicio de la afiliacion <br>";
	if(fecha_vencimiento == "")msg += "Debe ingresar la fecha de fin de la afiliacion <br>";
	/*
	if($('input[name=horario]').is(':checked')==true){
		var horario = $('input[name=horario]:checked').val();
		var data = horario.split("#");
		var fecha_cita = data[0];
		var id_medico = data[1];
	}
	*/

	
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
        fn_save();
	}
	
	//fn_save();
}

function fn_save_(){
    
    //var fecha_atencion_original = $('#fecha_atencion').val();
	//var id_user = $('#id_user').val();
    $.ajax({
			url: "/afiliacion/send",
            type: "POST",
            //data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmAfiliacion").serialize(),
            success: function (result) {  
                    /*$('#openOverlayOpc').modal('hide');
					$('#calendar').fullCalendar("refetchEvents");
					modalDelegar(fecha_atencion_original);*/
					//modalTurnos();
					//modalHistorial();
					//location.href="ver_cita/"+id_user+"/"+result;
					location.href="/afiliacion";
            }
    });
}

function validaTipoDocumento(){
	var tipo_documento = $("#tipo_documento").val();
	$('#nombre_afiliado').val("");
	$('#empresa_afiliado').val("");
	$('#empresa_direccion').val("");
	$('#empresa_representante').val("");
	$('#codigo_afiliado').val("");	
	$('#fecha_afiliado').val("");
				
	if(tipo_documento == "RUC"){
		$('#divNombreApellido').hide();
		$('#divCodigoAfliado').hide();
		$('#divFechaAfliado').hide();
		$('#divDireccionEmpresa').show();
		$('#divRepresentanteEmpresa').show();
	}else{
		$('#divNombreApellido').show();
		$('#divCodigoAfliado').show();
		$('#divFechaAfliado').show();
		$('#divDireccionEmpresa').hide();
		$('#divRepresentanteEmpresa').hide();
	}
}



function obtenerPersona(){
		
	var tipo_documento = $("#tipo_documento").val();
	var numero_documento = $("#numero_documento").val();
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	//$('#empresa_id').val("");
	$('#persona_id').val("");
	
	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var nombre_persona= result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#nombre_persona').val(nombre_persona);
			$('#persona_id').val(result.persona.id);
			if(result.persona.titular_id > 0){
				$("#chkTitular").attr("checked",false);
				$("#numero_documento_tit").val(result.persona.numero_documento_titular);
				obtenerTitularActual(result.persona.tipo_documento_titular,result.persona.numero_documento_titular);
			}
			if(result.persona.titular_id == 0){
				$("#chkTitular").attr("checked",true);
				$("#numero_documento_tit").val(numero_documento);
				obtenerTitularActual(tipo_documento,numero_documento);
			}
		},
		error: function(data) {
			alert("Persona no encontrada en la Base de Datos.");
			$('#personaModal').modal('show');
		}
		
	});
	
}

function obtenerTitularActual(tipo_documento,numero_documento){
		
	//var tipo_documento = $("#tipo_documento_tit").val();
	//var numero_documento = $("#numero_documento_tit").val();
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	//$('#empresa_id').val("");
	$('#titular_id').val("");
	
	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var nombre_titular = result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#nombre_titular').val(nombre_titular);
			$('#titular_id').val(result.persona.id);
		},
		error: function(data) {
			alert("Persona no encontrada en la Base de Datos.");
			$('#personaTitularModal').modal('show');
		}
		
	});
	
}

function obtenerTitular(){
		
	var tipo_documento = $("#tipo_documento_tit").val();
	var numero_documento = $("#numero_documento_tit").val();
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	//$('#empresa_id').val("");
	$('#titular_id').val("");
	
	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var nombre_titular = result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#nombre_titular').val(nombre_titular);
			$('#titular_id').val(result.persona.id);
		},
		error: function(data) {
			alert("Persona no encontrada en la Base de Datos.");
			$('#personaTitularModal').modal('show');
		}
		
	});
	
}

function obtenerPlanDetalle(){
	
	var plan_costo = $('#plan_id option:selected').attr("plan_costo");
	var periodo = $('#plan_id option:selected').attr("periodo");
	$('#plan_costo').val(plan_costo);
	$('#periodo').val(periodo);
	
	var id = $('#plan_id').val();
	$.ajax({
		url: '/supervision/obtener_plan_detalle/'+id,
		dataType: "json",
		success: function(result){
			//var productos = result.productos;
			var option = "";
			$('#tblPlan tbody').html("");
			$(result).each(function (ii, oo) {
				option += "<tr style='font-size:13px'><td class='text-left'>"+oo.pasm_smodulod+"</td><td class='text-left'>"+oo.pasm_precio+"</td></tr>";
			});
			$('#tblPlan tbody').html(option);
		}
		
	});
	
}

/*
function cargarAlquiler(){
    
    var empresa_id = $('#empresa_id').val();
	if(empresa_id == "")empresa_id=0;
	
    $("#tblAlquiler tbody").html("");
	$.ajax({
			url: "/alquiler/obtener_alquiler/"+empresa_id,
			type: "GET",
			success: function (result) {  
					$("#tblAlquiler tbody").html(result);
					//$('#tblAlquiler').dataTable();
			}
	});

}


function cargarDevolucion(){
    
    
    var numero_documento = $("#numero_documento").val();
    $("#tblPago tbody").html("");
	$.ajax({
			url: "/alquiler/obtener_devolucion/"+numero_documento,
			type: "GET",
			success: function (result) {  
					$("#tblDevolucion tbody").html(result);
			}
	});

}
*/


$('#modalPersonaSaveBtn').click(function (e) {
	e.preventDefault();
	$(this).html('Enviando datos..');

	$.ajax({
	  data: $('#modalPersonaForm').serialize(),
	  url: "/afiliacion/nueva_inscripcion_ajax",
	  type: "POST",
	  dataType: 'json',
	  success: function (data) {

		  $('#modalPersonaForm #modalPersonaForm').trigger("reset");
		  $('#personaModal').modal('hide');
		  $('#numero_documento').val(data.numero_documento);
		  $('#nombre_persona').val(data.nombre_apellido);

		  alert("La persona ha sido ingresada correctamente!");

	  },
	  error: function(data) {
	mensaje = "Revisar el formulario:\n\n";
	$.each( data["responseJSON"].errors, function( key, value ) {
	  mensaje += value +"\n";
	});
	$("#modalPersonaForm #modalPersonaSaveBtn").html("Grabar");
	alert(mensaje);
  }
  });
});

$('#modalPersonaTitularSaveBtn').click(function (e) {
	e.preventDefault();
	$(this).html('Enviando datos..');

	$.ajax({
	  data: $('#modalPersonaTitularForm').serialize(),
	  url: "/afiliacion/nueva_inscripcion_ajax",
	  type: "POST",
	  dataType: 'json',
	  success: function (data) {

		  $('#modalPersonaTitularForm #modalPersonaForm').trigger("reset");
		  $('#personaTitularModal').modal('hide');
		  $('#numero_documento_tit').val(data.numero_documento);
		  $('#nombre_titular').val(data.nombre_apellido);

		  alert("La persona ha sido ingresada correctamente!");

	  },
	  error: function(data) {
	mensaje = "Revisar el formulario:\n\n";
	$.each( data["responseJSON"].errors, function( key, value ) {
	  mensaje += value +"\n";
	});
	$("#modalPersonaTitularForm  #modalPersonaSaveBtn").html("Grabar");
	alert(mensaje);
  }
  });
});


function datatablenew() {
	var oTable1 = $('#tblAfiliado').dataTable({
		"bServerSide": true,
		"sAjaxSource": "/fondoComun/listar_fondo_comun_ajax",
		"bProcessing": true,
		"sPaginationType": "full_numbers",
		//"paging":false,
		"bFilter": false,
		"bSort": false,
		"info": true,
		//"responsive": true,
		"language": { "url": "/js/Spanish.json" },
		"autoWidth": false,
		"bLengthChange": true,
		"pageLength": 60000,
		"destroy": true,
		"lengthMenu": [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
		"aoColumns": [
			{},
		],
		"dom": '<"top">rt<"bottom"flpi><"clear">',
		"fnDrawCallback": function (json) {
			$('[data-toggle="tooltip"]').tooltip();
		},

		"fnServerData": function (sSource, aoData, fnCallback, oSettings) {

			var sEcho = aoData[0].value;
			var iNroPagina = parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed();
			var iCantMostrar = aoData[4].value;

			var anio = $('#anio').val();
			var mes = $('#mes').val();
				
			var idMunicipalidad = $('#id_municipalidad').val();
			var idComision = $('#id_comision').val();
			var credipago = $('#credipago').val();

			var _token = $('#_token').val();

			oSettings.jqXHR = $.ajax({
				"dataType": 'json',
				//"contentType": "application/json; charset=utf-8",
				"type": "POST",
				"url": sSource,
				"data": {
					NumeroPagina: iNroPagina, NumeroRegistros: iCantMostrar,
					anio: anio, mes: mes, idMunicipalidad: idMunicipalidad, idComision: idComision, credipago: credipago,
					_token: _token
				},
				"success": function (result) {
					fnCallback(result);
				},
				"error": function (msg, textStatus, errorThrown) {
					//location.href="login";	2
				}
			});
		},

		"aoColumnDefs":
			[
				{
					"mRender": function (data, type, row) {
						var denominacion = "";
						if (row.denominacion != null) denominacion = row.denominacion;
						return denominacion;
					},
					"bSortable": false,
					"aTargets": [0],
					"className": "dt-center",
					//"className": 'control'
				},
				{
					"mRender": function (data, type, row) {
						var importe_bruto = "";
						if (row.importe_bruto != null) importe_bruto = row.importe_bruto;
						return importe_bruto;
					},
					"bSortable": false,
					"className": "text-right",
					"aTargets": [1]
				},
				{
					"mRender": function (data, type, row) {
						var importe_igv = "";
						if (row.importe_igv != null) importe_igv = row.importe_igv;
						return importe_igv;
					},
					"bSortable": false,
					"className": "text-right",
					"aTargets": [2]
				},
				{
					"mRender": function (data, type, row) {
						var importe_comision_cap = "";
						if (row.importe_comision_cap != null) importe_comision_cap = row.importe_comision_cap;
						return importe_comision_cap;
					},
					"bSortable": false,
					"className": "text-right",
					"aTargets": [3]
				},
				{
					"mRender": function (data, type, row) {
						var importe_fondo_asistencia = "";
						if (row.importe_fondo_asistencia != null) importe_fondo_asistencia = row.importe_fondo_asistencia;
						return importe_fondo_asistencia;
					},
					"bSortable": false,
					"className": "text-right",
					"aTargets": [4]
				},
				{
					"mRender": function (data, type, row) {
						var saldo = "";
						if (row.saldo != null) saldo = row.saldo;
						return saldo;
					},
					"bSortable": false,
					"className": "text-right",
					"aTargets": [5]
				},
			]
	}
	);

}

function fn_ListarBusqueda() {
    cargarFondoComun();
};

function modalPersona(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/persona/modal_persona/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalPersonaVacuna(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/persona/modal_persona_vacuna/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalFlagNegativo(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/persona/modal_flag_negativo/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalPersonaSanidad(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/persona/modal_persona_sanidad/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarPersona(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Persona?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_persona(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_persona(id,estado){
	
    $.ajax({
            url: "/persona/eliminar_persona/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

function cargarFondoComun() {

	$("#divPlanilla").html("");
	$.ajax({
		//url: "/concurso/obtener_concurso_documento/"+id_concurso_inscripcion,
		url: "/fondoComun/obtener_fondo_comun",
		data: $("#frmAfiliacion").serialize(),
		type: "POST",
		success: function(result) {
			$("#divPlanilla").html(result);
		}
	});
}

//obtenerAnioPerido();

function obtenerAnioPerido(){
	
	var id_periodo = $('#id_periodo').val();
	
	$.ajax({
		url: '/planilla/obtener_anio_periodo/'+id_periodo,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#anio').html("");
			//option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.anio+"'>"+oo.anio+"</option>";
			});
			$('#anio').html(option);
		}
		
	});
	
}

function fn_calcular(){
	//var anio = $('#anio').val();
	//var mes = $('#mes').val();
    var msg = "";
    var periodo = $('#id_periodo').val();
	
	if(periodo == "")msg += "Debe seleccionar el Periodo a Generar <br>";
	
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }

	var p = {};
	p.anio =  $('#anio').val();
	p.mes = $('#mes').val();
	p.periodo  = $('#id_periodo').val();

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	//alert(mes);
    $.ajax({
            url: "/fondoComun/calcula_fondo_comun",
            type: "GET",
			data: p,
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				cargarFondoComun();
				$('.loader').hide();	
            }
			
    });
}

function validarComprobanteSunat() {
	var ruc = $('#txtNroRUCComp').val();
	var p = {};
	p.txtNroRUCComp = $("#txtNroRUCComp").val();
	p.cboTipoComprobante = $("#cboTipoComprobante").val();
	p.txtSerie = $("#txtSerie").val();
	p.txtNroComprobante = $("#txtNroComprobante").val();
	p.txtFechaComprobante = $("#txtFechaComprobante").val();
	p.txtImporteSunat = $("#txtImporteSunat").val();


	$.ajax({
		url: "/validar_comprobante_sunat",
		type: "GET",
		data: p, //$("#frmSolicitud").serialize(),
		success: function (result) {
			//alert(result);
			var jsondata = JSON.parse(result);
			$('#txtValidaSunat').val(jsondata.msg);
			//alert(jsondata.estadoCp);
			$("#flagValidaSunat").val(jsondata.estadoCp);
			//$('.loader').hide();
			
			var newRow="";

			if(jsondata.estadoCp==1){
				newRow+='<div class="alert_ alert-success_">';
				newRow+='<i class="fa fa-check" aria-hidden="true"></i> ';
				newRow+='Comprobante validado correctamente por SUNAT !!!';
				newRow+='</div>';
				$("#divMensajeSunat").show();

			}else{
				newRow+='<div class="alert_ alert-warning_">';
				newRow+='<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>' ;
				newRow+='Comprobante no validado  por SUNAT !!!';
				newRow+='</div>';
				$("#divMensajeSunat").show();
			}

			$("#divMensajeSunat").html(newRow);

		}
	});


}

function DescargarPdfFondoComun(){

	var periodo = $('#id_periodo_').val();
	var anio = $('#anio').val();
	var mes = $('#mes').val();

	if (periodo == "")periodo = 0;
	if (anio == "")anio = 0;
	if (mes == "")mes = 0;

	var href = '/fondoComun/descargar_pdf_fondo_comun/'+periodo+'/'+anio+'/'+mes;
	window.open(href, '_blank');

}

