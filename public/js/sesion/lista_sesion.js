
$(document).ready(function () {
	
	$("#id_regional_bus").select2({ width: '100%' });
	$("#id_comision_bus").select2({ width: '100%' });
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnNuevo').click(function () {
		modalSesion(0);
	});
	
	$('#btnEjecutar').click(function () {
		guardar_sesion_bloque();
	});

	$('#btnImportarDictamenes').click(function () {
		importarDatalicenciaDictamenes();
	});

	$('#denominacion').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
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
	
	datatablenew();

	$(function() {
		$('#modalSeguro #nombre_plan_').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#nombre').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});


	$(function() {
		$('#modalEmpresaTitularForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaTitularForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaTitularForm #nombres').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
});

function guardar_sesion_bloque(){
    
	var _token = $('#_token').val();
	var id_periodo = $('#id_periodo_bus').val();
	
    $.ajax({
			url: "/sesion/send_sesion_bloque",
            type: "POST",
            data : {_token:_token,id_periodo:id_periodo},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				datatablenew();
				
            }
    });
}

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

function fn_save___(){
    
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

function obtenerEmpresa(){
		
	var _id = $("#id").val();	
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	//$('#empresa_id').val("");
	$('#empresa_id').val("");
	
	$.ajax({
		url: '/empresa/obtener_empresa/' + _id,
		dataType: "json",
		success: function(result){
			//var nombre_persona= result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			//$('#nombre_persona').val(nombre_persona);
			$('#empresa_id').val(result.empresa.id);

		},
		error: function(data) {
			alert("Empresa no encontrada en la Base de Datos.");
			$('#empresaModal').modal('show');
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

function obtenerComision(){
	
	var id_periodo = $('#id_periodo').val();
	var tipo_comision = $('#tipo_comision').val();
	var id_tipo_sesion = $('#id_tipo_sesion').val();
	var id_comision = $("#id_comision_bus").val();
	
	$.ajax({
		url: '/sesion/obtener_comision/'+id_periodo+'/'+tipo_comision,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_comision').html("");
			var sel = "";
			option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				sel = "";
				if(id_comision==oo.id)sel = "selected='selected'";
				option += "<option value='"+oo.id+"' "+sel+">"+oo.denominacion+" "+oo.comision+"</option>";
			});
			$('#id_comision').html(option);
		}
		
	});
	
	$("#divFechaProgramado").hide();
	
	var id_dia_semana = $("#id_dia_semana").val();
	
	if(id_dia_semana==398 || id_tipo_sesion==402){
		$("#divFechaProgramado").show();
	}
	
	/*
	if(tipo_comision==2){
		$("#divFechaProgramado").show();
	}
	
	if(tipo_comision!=2 && id_tipo_sesion==402){
		$("#divFechaProgramado").show();
	}
	*/
	
}

function habilitarProgramacion(){
	
	var id_tipo_sesion = $('#id_tipo_sesion').val();
	var tipo_comision = $("#tipo_comision").val();
	var id_dia_semana = $("#id_dia_semana").val();
	
	$("#divFechaProgramado").hide();
	
	if(id_dia_semana==398 || id_tipo_sesion==402){
		$("#divFechaProgramado").show();
	}
	
	/*
	if(tipo_comision==2){
		$("#divFechaProgramado").show();
	}
	
	if(tipo_comision!=2 && id_tipo_sesion==402){
		$("#divFechaProgramado").show();
	}
	*/
	
}

function habilitarAprobarPago(){
	
	var id_estado_aprobacion = $('#id_estado_aprobacion').val();
	
	$(".id_aprobar_pago").prop("checked",false);
	
	
	if(id_estado_aprobacion==2){
		$(".id_aprobar_pago").prop("checked",true);
		
		$(".edit_delegado").prop("disabled",true);	
		$(".delete_delegado").prop("disabled",true);
		
	}else{
		
		$(".edit_delegado").prop("disabled",false);	
		$(".delete_delegado").prop("disabled",false);
	}
	
	
}

function obtenerComisionBusOld(){
	
	var id_periodo = $('#id_periodo_bus').val();
	$.ajax({
		url: '/sesion/obtener_comision/'+id_periodo,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_comision_bus').html("");
			option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id+"'>"+oo.comision+" "+oo.denominacion+"</option>";
			});
			$('#id_comision_bus').html(option);
		}
		
	});
	
}

function obtenerComisionBus(){
	
	var id_periodo = $('#id_periodo_bus').val();
	var tipo_comision_bus = $('#tipo_comision_bus').val();
	
	$.ajax({
		url: '/sesion/obtener_comision/'+id_periodo+'/'+tipo_comision_bus,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_comision_bus').html("");
			option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				//option += "<option value='"+oo.id+"'>"+oo.comision+" "+oo.denominacion+"</option>";
				option += "<option value='"+oo.id+"'>"+oo.denominacion+" "+oo.comision+"</option>";
			});
			$('#id_comision_bus').html(option);
		}
		
	});
	
}

function obtenerComisionDelegado(){
	
	var id = $("#id").val();
	
	var id_comision = $('#id_comision').val();
	
	$.ajax({
		url: '/sesion/obtener_comision_delegado/'+id_comision,
		dataType: "json",
		success: function(result){
			var delegado = result.delegado;
			var dia_semana = result.dia_semana[0];
			var option = "";
			$('#tblDelegado tbody').html("");
			$(delegado).each(function (ii, oo) {
				option += "<tr style='font-size:13px'>";
				option += "<input type='hidden' name='id_delegado[]' value='"+oo.id+"' >";
				option += "<td class='text-left'>"+oo.puesto+"</td>";
				option += "<td class='text-left'>"+oo.numero_cap+"</td>";
				option += "<td class='text-left'>"+oo.apellido_paterno+" "+oo.apellido_materno+" "+oo.nombres+"</td>";
				option += "<td class='text-left'>"+oo.situacion+"</td>";
				var sel = "";
				if(oo.coordinador==1)sel = "checked='checked'";
				option += "<td class='text-center'><input type='radio' name='coordinador' "+sel+" value='"+oo.id+"' /></td>";
				
				if(id>0){
				option += "<td class='text-left'><button style='font-size:12px' type='button' class='btn btn-sm btn-success' data-toggle='modal' onclick=modalAsignarDelegadoSesion('"+oo.id+"') ><i class='fa fa-edit'></i> Editar</button></td>";
				}else{
				option += "<td class='text-left'></td><td class='text-left'></td><td class='text-left'></td><td class='text-left'></td><td class='text-left'></td><td class='text-left'></td>";
				}
				
				
				option += "</tr>";
			});
			
			if(option!="")$("#btnSesionGuardar").prop("disabled",false);
			else $("#btnSesionGuardar").prop("disabled",true);
			
			$('#tblDelegado tbody').html(option);
			
			$("#dia_semana").val(dia_semana.denominacion);
			$("#id_dia_semana").val(dia_semana.codigo);
		}
		
	});
	
}

function obtenerComisionDelegadoNuevo(id_comision){
	
	var id = $("#id").val();
	
	//var id_comision = $('#id_comision').val();
	$.ajax({
		url: '/sesion/obtener_comision_delegado/'+id_comision,
		dataType: "json",
		success: function(result){
			var delegado = result.delegado;
			var dia_semana = result.dia_semana[0];
			var option = "";
			$('#tblDelegado tbody').html("");
			$(delegado).each(function (ii, oo) {
				option += "<tr style='font-size:13px'>";
				option += "<input type='hidden' name='id_delegado[]' value='"+oo.id+"' >";
				option += "<td class='text-left'>"+oo.puesto+"</td>";
				option += "<td class='text-left'>"+oo.numero_cap+"</td>";
				option += "<td class='text-left'>"+oo.apellido_paterno+" "+oo.apellido_materno+" "+oo.nombres+"</td>";
				option += "<td class='text-left'>"+oo.situacion+"</td>";
				var sel = "";
				if(oo.coordinador==1)sel = "checked='checked'";
				option += "<td class='text-center'><input type='radio' name='coordinador' "+sel+" value='"+oo.id+"' /></td>";
				
				if(id>0){
				option += "<td class='text-left'><button style='font-size:12px' type='button' class='btn btn-sm btn-success' data-toggle='modal' onclick=modalAsignarDelegadoSesion('"+oo.id+"') ><i class='fa fa-edit'></i> Editar</button></td>";
				}else{
				option += "<td class='text-left'></td><td class='text-left'></td><td class='text-left'></td><td class='text-left'></td><td class='text-left'></td><td class='text-left'></td>";
				}
				
				
				option += "</tr>";
			});
			$('#tblDelegado tbody').html(option);
			
			$("#dia_semana").val(dia_semana.denominacion);
			$("#id_dia_semana").val(dia_semana.codigo);
		}
		
	});
	
}

function modalAsignarDelegadoSesion(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc2 .modal-body').css('height', 'auto');

	$.ajax({
			url: "/sesion/modal_asignar_delegado_sesion/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc2").html(result);
					$('#openOverlayOpc2').modal('show');
			}
	});

}

function modalAsignarProfesionSesion(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc2 .modal-body').css('height', 'auto');

	$.ajax({
			url: "/sesion/modal_asignar_profesion_sesion/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc2").html(result);
					$('#openOverlayOpc2').modal('show');
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

function modalSesion(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/sesion/modal_sesion/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalPuestos(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/concurso/modal_puesto/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalRequisitos(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/concurso/modal_requisito/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}


$('#modalEmpresaSaveBtn').click(function (e) {
	e.preventDefault();
	$(this).html('Enviando datos..');

	$.ajax({
	  data: $('#modalEmpresaForm').serialize(),
	  url: "/afiliacion/nueva_inscripcion_ajax",
	  type: "POST",
	  dataType: 'json',
	  success: function (data) {

		  $('#modalEmpresaForm #modalEmpresaForm').trigger("reset");
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
	$("#modalEmpresaForm #modalEmpresaSaveBtn").html("Grabar");
	alert(mensaje);
  }
  });
});

$('#modalEmpresaTitularSaveBtn').click(function (e) {
	e.preventDefault();
	$(this).html('Enviando datos..');

	$.ajax({
	  data: $('#modalEmpresaTitularForm').serialize(),
	  url: "/afiliacion/nueva_inscripcion_ajax",
	  type: "POST",
	  dataType: 'json',
	  success: function (data) {

		  $('#modalEmpresaTitularForm #modalEmpresaForm').trigger("reset");
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
	$("#modalEmpresaTitularForm  #modalEmpresaSaveBtn").html("Grabar");
	alert(mensaje);
  }
  });
});


function datatablenew(){
    var oTable = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/sesion/lista_programacion_sesion_ajax",
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        //"paging":false,
        "bFilter": false,
        "bSort": false,
        "info": true,
		//"responsive": true,
        "language": {"url": "/js/Spanish.json"},
        "autoWidth": false,
        "bLengthChange": true,
        "destroy": true,
        "lengthMenu": [[8,10, 50, 100, 200, 60000], [8,10, 50, 100, 200, "Todos"]],
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
			
			var id_regional = $('#id_regional_bus').val();
            var id_periodo = $('#id_periodo_bus').val();
			var tipo_comision = $('#tipo_comision_bus').val();
			var id_comision = $('#id_comision_bus').val();
			var id_tipo_sesion = $('#id_tipo_sesion_bus').val();
			var id_estado_sesion = $('#id_estado_sesion_bus').val();
			var id_estado_aprobacion = $('#id_estado_aprobacion_bus').val();
			var fecha_inicio_bus = $('#fecha_inicio_bus').val();
			var fecha_fin_bus = $('#fecha_fin_bus').val();
			var cantidad_delegado = $('#cantidad_delegado').val();
			var id_situacion = $('#id_situacion_bus').val();
			var campo = $('#campo').val();
			var orden = $('#orden').val();
			var _token = $('#_token').val();
			
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id_regional:id_regional,id_periodo:id_periodo,tipo_comision:tipo_comision,id_comision:id_comision,
						id_tipo_sesion:id_tipo_sesion,id_estado_sesion:id_estado_sesion,
						fecha_inicio_bus:fecha_inicio_bus,fecha_fin_bus:fecha_fin_bus,
						id_estado_aprobacion:id_estado_aprobacion,cantidad_delegado:cantidad_delegado,id_situacion:id_situacion,
						campo:campo,orden:orden,
						_token:_token
                       },
                "success": function (result) {
                    fnCallback(result);
					/*		
					var rowIndex = oTable.fnGetData().length - 1;
                       var strNameIdImg = 'ima_1_' + rowIndex;
                       var strHtml = "<img id='" + strNameIdImg + "' src='/img/details_open.png' style='cursor:pointer;' title='Editar' onclick=fn_AbrirDetalle(" + rowIndex + ",'" + row.id +"') />";
                       return strHtml;
					*/
                },
                "error": function (msg, textStatus, errorThrown) {
                    //location.href="login";
                }
            });
        },
		"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			//fn_AbrirDetalle(iDisplayIndex,aData.id);
		},
        "aoColumnDefs":
            [	
			 	/*
			 	{
                "mRender": function (data, type, row) {
                	var region = "";
					if(row.region!= null)region = row.region;
					return region;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
				},
				*/
				{
                "mRender": function (data, type, row) {
                	var periodo = "";
					if(row.periodo!= null)periodo = row.periodo;
					return periodo;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
                },
				
				{
                "mRender": function (data, type, row) {
                	var tipo_comision = "";
					if(row.tipo_comision!= null)tipo_comision = row.tipo_comision;
					return tipo_comision;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
                },
				
				{
                "mRender": function (data, type, row) {
                	var comision = "";
					if(row.comision!= null)comision = row.comision;
					return comision;
                },
                "bSortable": false,
                "aTargets": [2],
				"className": "dt-center",
                },
				
				{
                "mRender": function (data, type, row) {
                	var fecha_programado = "";
					if(row.fecha_programado!= null)fecha_programado = row.fecha_programado;
					return fecha_programado;
                },
                "bSortable": false,
                "aTargets": [3],
				"className": "dt-center",
                },
				{
                "mRender": function (data, type, row) {
                	var fecha_ejecucion = "";
					if(row.fecha_ejecucion!= null)fecha_ejecucion = row.fecha_ejecucion;
					return fecha_ejecucion;
                },
                "bSortable": true,
                "aTargets": [4]
                },
				/*
                {
                "mRender": function (data, type, row) {
                	var hora_inicio = "";
					if(row.hora_inicio!= null)hora_inicio = row.hora_inicio;
					return hora_inicio;
                },
                "bSortable": true,
                "aTargets": [5]
                },
				
				{
                "mRender": function (data, type, row) {
                	var hora_fin = "";
					if(row.hora_fin!= null)hora_fin = row.hora_fin;
					return hora_fin;
                },
                "bSortable": true,
                "aTargets": [6]
                },
				*/
				{
                "mRender": function (data, type, row) {
                	var tipo_sesion = "";
					if(row.tipo_sesion!= null)tipo_sesion = row.tipo_sesion;
					return tipo_sesion;
                },
                "bSortable": true,
                "aTargets": [5]
                },
				
				{
                "mRender": function (data, type, row) {
                	var estado_sesion = "";
					if(row.estado_sesion!= null)estado_sesion = row.estado_sesion;
					return estado_sesion;
                },
                "bSortable": true,
                "aTargets": [6]
                },
				
				{
                "mRender": function (data, type, row) {
                	var estado_aprobacion = "";
					if(row.estado_aprobacion!= null)estado_aprobacion = row.estado_aprobacion;
					return estado_aprobacion;
                },
                "bSortable": true,
                "aTargets": [7]
                },
				
				{
                "mRender": function (data, type, row) {
                	var cantidad_delegado = "";
					if(row.cantidad_delegado!= null)cantidad_delegado = row.cantidad_delegado;
					return cantidad_delegado;
                },
                "bSortable": true,
				"className": "text-center",
                "aTargets": [8]
                },
				
				{
                "mRender": function (data, type, row) {
                	var cantidad_situacion = "";
					if(row.cantidad_situacion!= null)cantidad_situacion = row.cantidad_situacion;
					return cantidad_situacion;
                },
                "bSortable": true,
				"className": "text-center",
                "aTargets": [9]
                },
				
				{
                "mRender": function (data, type, row) {
                	var observaciones = "";
					if(row.observaciones!= null)observaciones = row.observaciones;
					return '<span data-toggle="tooltip" title="'+observaciones+'">' + observaciones.substring(0,12) + '</span>';
                },
                "bSortable": true,
				"className": "text-center",
                "aTargets": [10]
                },
				
				{
                "mRender": function (data, type, row) {
                	var newRow = "";
					var btnDisabled="";
					if(row.flag_cz==1)btnDisabled="disabled='disabled'";
						newRow="<button "+btnDisabled+" style='font-size:12px' type='button' class='btn btn-sm btn-info' data-toggle='modal' onclick=cargarDictamen('"+row.id+"') ><i class='fa fa-edit'></i> Ver Dictamen</button>"
					
					return newRow;
                },
                "bSortable": true,
                "aTargets": [11]
                },
				
				{
                "mRender": function (data, type, row) {
                	var newRow = "";
					var btnDisabled="";
					if(row.flag_cz==1)btnDisabled="disabled='disabled'";
					newRow="<button "+btnDisabled+" style='font-size:12px' type='button' class='btn btn-sm btn-success' data-toggle='modal' onclick=modalSesion('"+row.id+"') ><i class='fa fa-edit'></i> Editar - Ejecutar</button>"
					return newRow;
                },
                "bSortable": true,
                "aTargets": [12]
                },

            ]


    });
	
	$('#tblAfiliado').on('draw.dt', function () {
		$('[data-toggle="tooltip"]').tooltip();
	});
	
}

function cargarDictamen(id_concurso_inscripcion){
       
    $("#tblDictamen tbody").html("");
	$.ajax({
			url: "/sesion/obtener_dictamen/"+id_concurso_inscripcion,
			type: "GET",
			success: function (result) {  
					$("#tblDictamen tbody").html(result);
			}
	});

}

function cargarDictamenNuevo(id_concurso_inscripcion){
       
    $("#tblDictamenNuevo tbody").html("");
	$.ajax({
			url: "/sesion/obtener_dictamen/"+id_concurso_inscripcion,
			type: "GET",
			success: function (result) {  
					$("#tblDictamenNuevo tbody").html(result);
			}
	});

}

function fn_ListarBusqueda() {
    datatablenew();
};

function importarDatalicenciaDictamenes(){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();

	$.ajax({
		url: "/sesion/importar_dataLicencia_dictamenes",
		type: "GET",
		success: function(result){

			$('.loader').hide();
			bootbox.alert("Se import&oacute; exitosamente los datos"); 
			datatablenew();
		}
	});
}

function fn_AbrirDetalle(pValor, piIdMovimientoCompra) {
    //fn_util_bloquearPantalla("Buscando");
    setTimeout(function () { fn_CargaSuGrilla(pValor, piIdMovimientoCompra) }, '001');//500
}

function fn_CargaSuGrilla(pValor, piIdMovimientoCompra) {

    var iRow = pValor;


    var tr = $("#ima_1_" + iRow).closest('tr');
    var row = $("#tblAfiliado").DataTable().row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');


        $("#ima_1_" + iRow).attr("src", "/img/details_open.png");
    } else {
        $("#ima_1_" + iRow).attr("src", "/img/details_close.png");

        var iNumeroLinea = $("#lbl_0_" + pValor).text();
        var iCodigoOficina = $("#lbl_1_" + pValor).text();

        var vNombreSubGrilla = "SubGrd" + iRow;
		//var vNombreSubGrilla2 = "SubGrd2" + iRow;
        fn_DevuelveSubGrilla(piIdMovimientoCompra, vNombreSubGrilla,row,tr);
        
    }

    //fn_util_desbloquearPantalla();
}

function fn_DevuelveSubGrilla(piIdMovimientoCompra, vNombreSubDataTable,row,tr) {
	
	//var id_moneda = $('#id_moneda').val();
	
	$.ajax({
		type: "GET",
		url: "/comision/obtener_comision_delegado/"+piIdMovimientoCompra,
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		async :  "false",
		success: function (result) {
			if(result=="")return false;
			var sInicio = '<div>';
			//var sInicio = ''; 
			sInicio += '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 3px 8px 10px 30px;float:left">';
			sInicio += '<table width="100%" id="' + vNombreSubDataTable + '" class="table table-hover table-sm">';
        	sInicio += '<thead>';
            sInicio += '<tr style="font-size:13px">';
			sInicio += '<th style="text-align: left;">Delegado</th>';
			sInicio += '<th style="text-align: right;">N&deg; CAP</th>';
			sInicio += '<th style="text-align: right;">Situaci&oacute;n</th>';
			sInicio += '<th style="text-align: right;">Tipo de Titular</th>';
			sInicio += '<th style="text-align: right;">Vigencia</th>';
			sInicio += '<th style="text-align: right;">Programaci&oacute;n</th>';
            sInicio += '</tr>';
        	sInicio += '</thead>';
		
			var sIntermedio = '';
			var vImagen = "";
			var monto_pagado = "";
			var delegado = "";
			$.each(result, function (index , value) {
				delegado = value.apellido_paterno + " " + value.apellido_materno + " " + value.nombres;
				sIntermedio += '<tr style="font-size:13px">';
				sIntermedio +='<td style="text-align: left;">' + delegado+ '</td>';
				sIntermedio +='<td style="text-align: right;">' + value.numero_cap+ '</td>';
				sIntermedio +='<td style="text-align: right;">' + value.situacion+ '</td>';
				sIntermedio +='<td style="text-align: right;">' + value.puesto+ '</td>';
				sIntermedio +='<td style="text-align: right;"></td>';
				sIntermedio +='<td style="text-align: right;"></td>';
				sIntermedio +='</tr>';
			});
			
			var sFinal = '</table></div></div>';
			
			var sResultado = sInicio + sIntermedio + sFinal;
			
			//alert(sResultado);
			row.child(sResultado).show();
        	fn_Datatable_Cast(vNombreSubDataTable);
        	tr.addClass('shown');
	
		},
		error: function (resultado) {
			var error = "Ocurrio un Error";
			//parent.fn_util_MuestraMensaje(error, "E");
		
		}
	});
	    
}

function fn_Datatable_Cast(vNombreSubGrilla) {

    $("#" + vNombreSubGrilla).dataTable({
        bDestroy: true,
        bFilter: false,
        bSort: false,
        bLengthChange: false,
        bPaginate: false,
        bInfo: false,
        aoColumnDefs: [
            /*{
                "sWidth": "100px",
                "aTargets": [0]
            },
			{
				"sClass": "center",
                "sWidth": "150px",
                "aTargets": [1]
            },*/
			/*
			{
				"sClass": "right",
                "sWidth": "100px",
                "aTargets": [3]
            },
			{
				"sClass": "right",
                "sWidth": "100px",
                "aTargets": [4]
            },
			{
				"sClass": "right",
                "sWidth": "100px",
                "aTargets": [5]
            }
		*/
        ]
		
    });

    //fn_util_LineaDatatable("#tbaDetalleSolicitud");
}


function modalEmpresa(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/empresa/modal_empresa/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalResponsable(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/afiliacion/modal_afiliacion_empresa/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminar(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Municipalidad?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar(id,estado){
	
    $.ajax({
            url: "/municipalidad/eliminar_municipalidad/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}


function eliminarDelegadoSesion(id){
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas Eliminar al delegado?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_delegado_sesion(id);
            }
        }
    });
    //$(".modal-dialog").css("width","30%");
}

function fn_eliminar_delegado_sesion(id){
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
    $.ajax({
            url: "/sesion/eliminar_comision_sesion_delegados/"+id,
            type: "GET",
            success: function (result) {
                $('.loader').hide();
				//$('#openOverlayOpc').modal('hide');
				//datatablenew();
				cargarDelegados();
            }
    });
}

function guardar_coordinador(id,id_delegado){
	
	bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas cambiar de coordinador en todas las sesiones?", 
        callback: function(result){
            if (result==true) {
                fn_guardar_coordinador(id,id_delegado);
            }
        }
    });
	
}

function fn_guardar_coordinador(id,id_delegado){
    
	var msg = "";
	var _token = $('#_token').val();
	
    $.ajax({
			url: "/sesion/send_coordinador_delegado_sesion",
            type: "POST",
            data : {_token:_token,id:id,id_delegado:id_delegado},
            success: function (result) {
				$('#openOverlayOpc').modal('hide');
				//location.reload();
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

function modalHistorialDelegadoSesion(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc2 .modal-body').css('height', 'auto');

	$.ajax({
			url: "/sesion/modal_historial_delegado_sesion/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc2").html(result);
					$('#openOverlayOpc2').modal('show');
			}
	});

}

function habilitarAprobar(obj){
	
	
	if(!$(obj).is(':checked')) {
		$(obj).parent().parent().find(".edit_delegado").prop("disabled",false);	
		$(obj).parent().parent().find(".delete_delegado").prop("disabled",false);	
	}else{
		$(obj).parent().parent().find(".edit_delegado").prop("disabled",true);
		$(obj).parent().parent().find(".delete_delegado").prop("disabled",true);
	}
	

}



