
$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
		
	$('#btnNuevo').click(function () {
		modalSeguro(0);
	});

	$('#denominacion').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
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

function modalSeguro(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/planilla/modal_reintegro/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalPlanes(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/seguro/modal_plan/"+id,
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
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/planilla/listar_reintegro_ajax",
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
			
			var agremiado = $('#agremiado').val();
			var numero_cap = $('#numero_cap').val();
			var mes_reintegro = $('#mes_reintegro_bus').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						agremiado:agremiado,numero_cap:numero_cap,mes_reintegro:mes_reintegro,estado:estado,
						_token:_token
                       },
                "success": function (result) {
                    fnCallback(result);
                },
                "error": function (msg, textStatus, errorThrown) {
                    //location.href="login";
                }
            });
        },

        "aoColumnDefs":
            [	
				{
                "mRender": function (data, type, row) {
                	var id = "";
					if(row.id!= null)id = row.id;
					return id;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
				//"className": 'control'
                },
				
				{
                "mRender": function (data, type, row) {
                	var regional = "";
					if(row.regional!= null)regional = row.regional;
					return regional;
                },
                "bSortable": true,
                "aTargets": [1]
                },
				
                {
                "mRender": function (data, type, row) {
                	var periodo = "";
					if(row.periodo!= null)periodo = row.periodo;
					return periodo;
                },
                "bSortable": true,
                "aTargets": [2]
                },
				
				{
				"mRender": function (data, type, row) {
					var numero_cap = "";
					if(row.numero_cap!= null)numero_cap = row.numero_cap;
					return numero_cap;
				},
				"bSortable": true,
				"aTargets": [3]
				},
				
				{
                "mRender": function (data, type, row) {
                	var agremiado = "";
					if(row.agremiado!= null)agremiado = row.agremiado;
					return agremiado;
                },
                "bSortable": true,
                "aTargets": [4]
                },
				
				{
                "mRender": function (data, type, row) {
                	var comision = "";
					if(row.comision!= null)comision = row.comision;
					return comision;
                },
                "bSortable": true,
                "aTargets": [5]
                },
				
				{
				"mRender": function (data, type, row) {
					var mes = "";
					if(row.mes!= null)mes = row.mes;
					return mes;
				},
				"bSortable": true,
				"aTargets": [6]
				},
				
				{
				"mRender": function (data, type, row) {
					var importe_total = "";
					if(row.importe_total!= null){importe_total = parseFloat(row.importe_total).toFixed(2)};
					return '<div style="text-align: right;">' + importe_total + '</div>';
				},
				"bSortable": true,
				"aTargets": [7],
				"className": "text-right"
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalSeguro('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						
						//html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalPlanes('+row.id+')" ><i class="fa fa-edit"></i> Planes</button>';

						html += '<a href="javascript:void(0)" onclick=eliminarReintegro('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
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

function eliminarReintegro(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Reintegro?", 
        callback: function(result){
            if (result==true) {
                fn_eliminarReintegro(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminarReintegro(id,estado){
	
    $.ajax({
            url: "/planilla/eliminar_reintegro/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

function eliminarReintegroDetalle(id){
	var act_estado = "";
	act_estado = "Eliminar";

    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" el Detalle del Reintegro?", 
        callback: function(result){
            if (result==true) {
                fn_eliminarReintegroDetalle(id);
            }
        }
    });
    //$(".modal-dialog").css("width","30%");
}

function fn_eliminarReintegroDetalle(id){
	
    $.ajax({
            url: "/planilla/eliminar_reintegro_detalle/"+id,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

function obtenerDelegadoPerido(){
	
	var id_periodo = $('#id_periodo').val();
	
	$.ajax({
		url: '/planilla/obtener_delegado_periodo/'+id_periodo,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_agremiado').html("");
			option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_agremiado+"'>"+oo.numero_cap+" - "+oo.apellido_paterno+" "+oo.apellido_materno+" "+oo.nombres+"</option>";
			});
			$('#id_agremiado').html(option);
		}
		
	});
	
}

function obtenerDelegadoPerido_(id_periodo){
	
	//var id_periodo = $('#id_periodo').val();
	
	$.ajax({
		url: '/planilla/obtener_delegado_periodo/'+id_periodo,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_agremiado').html("");
			option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id_agremiado+"'>"+oo.numero_cap+" - "+oo.apellido_paterno+" "+oo.apellido_materno+" "+oo.nombres+"</option>";
			});
			$('#id_agremiado').html(option);
		}
		
	});
	
}


function obtenerDelegadoPeridoEdit(id_periodo,id_agremiado){
	
	//var id_periodo = $('#id_periodo').val();
	
	$.ajax({
		url: '/planilla/obtener_delegado_periodo/'+id_periodo,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_agremiado').html("");
			option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				var selected = "";
				if(oo.id_agremiado==id_agremiado)selected = "selected='selected'";
				option += "<option value='"+oo.id_agremiado+"' "+selected+" >"+oo.numero_cap+" - "+oo.apellido_paterno+" "+oo.apellido_materno+" "+oo.nombres+"</option>";
			});
			$('#id_agremiado').html(option);
		}
		
	});
	
}


function obtenerComisionDelegadoPerido(){
	
	var id_periodo = $('#id_periodo').val();
	var id_agremiado = $('#id_agremiado').val();
	
	$.ajax({
		url: '/planilla/obtener_comision_delegado_periodo/'+id_periodo+'/'+id_agremiado,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_comision').html("");
			option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				option += "<option id_delegado='"+oo.id_delegado+"' value='"+oo.id_comision+"'>"+oo.comision+"</option>";
			});
			$('#id_comision').html(option);
		}
		
	});
	
}

function obtenerComisionDelegadoPeridoEdit(id_periodo,id_agremiado,id_comision){
	
	//var id_periodo = $('#id_periodo').val();
	//var id_agremiado = $('#id_agremiado').val();
	
	$.ajax({
		url: '/planilla/obtener_comision_delegado_periodo/'+id_periodo+'/'+id_agremiado,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#id_comision').html("");
			option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				var selected = "";
				if(oo.id_comision==id_comision)selected = "selected='selected'";
				option += "<option id_delegado='"+oo.id_delegado+"' value='"+oo.id_comision+"' "+selected+" >"+oo.comision+"</option>";
			});
			$('#id_comision').html(option);
		}
		
	});
	
}



