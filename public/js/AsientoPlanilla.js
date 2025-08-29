
$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnVou').click(function () {
		fn_importar_Vou();
	});
	
	$('#btnNuevo').click(function () {
		modalAsignacion(0);
	});
		
	//datatablenew();
	cargarAsientoPlanilla();
	
	$("#plan_id").select2();
	$("#ubicacion_id").select2();
	
	
	$(function() {
		$('#modalAsignacion Form #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	
});



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

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/asignacion/listar_asignacion_ajax",
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
		"pageLength": 60000,
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
		
			var cuenta = $('#cuenta_b').val();
			var denominacion = $('#denominacion_b').val();
			var tipo_cuenta = $('#tipo_cuenta_b').val();
			var centro_costo = $('#centro_costo_b').val();
			var partida_presupuestal = $('#partida_presupuestal_b').val();
			var codigo_financiero = $('#codigo_financiero_b').val();
			var medio_pago = $('#medio_pago_b').val();
			var origen = $('#origen_b').val();
			var estado = $('#estado_b').val();

			var _token = $('#_token').val();

            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						vou:vou,cuenta:cuenta,denominacion:denominacion,tipo_cuenta:tipo_cuenta,centro_costo:centro_costo,
						partida_presupuestal:partida_presupuestal,codigo_financiero:codigo_financiero,medio_pago:medio_pago,origen:origen,estado:estado,
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
                	var vou = "";
					if(row.vou!= null)vou = row.vou;
					return vou;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
				//"className": 'control'
                },
				{
                "mRender": function (data, type, row) {
                	var cuenta = "";
					if(row.cuenta!= null)cuenta = row.cuenta;
					return cuenta;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
				//"className": 'control'
                },
				{
                "mRender": function (data, type, row) {
                    var denominacion = "";
					if(row.denominacion!= null)denominacion = row.denominacion;
					return denominacion;
                },
                "bSortable": false,
                "aTargets": [1]
                },
                {
                "mRender": function (data, type, row) {
                	var tipo_cuenta = "";
					if(row.tipo_cuenta!= null)tipo_cuenta = row.tipo_cuenta;
					return tipo_cuenta;
                },
                "bSortable": false,
                "aTargets": [2]
                },
				{
                "mRender": function (data, type, row) {
                	var centro_costo = "";
					if(row.centro_costo!= null)centro_costo = row.centro_costo;
					return centro_costo;
                },
                "bSortable": false,
                "aTargets": [3]
                },
				{
                "mRender": function (data, type, row) {
                	var partida_presupuestal = "";
					if(row.partida_presupuestal!= null)partida_presupuestal = row.partida_presupuestal;
					return partida_presupuestal;
                },
                "bSortable": false,
                "aTargets": [4]
                },
				{
                "mRender": function (data, type, row) {
                	var codigo_financiero = "";
					if(row.codigo_financiero!= null)codigo_financiero = row.codigo_financiero;
					return codigo_financiero;
                },
                "bSortable": false,
                "aTargets": [5]
                },
				{
					"mRender": function (data, type, row) {
						var medio_pago = "";
						if(row.medio_pago!= null)medio_pago = row.medio_pago;
						return medio_pago;
					},
					"bSortable": false,
					"aTargets": [6]
				},				
				{
					"mRender": function (data, type, row) {
						var origen = "";
						if(row.origen!= null)origen = row.origen;
						return origen;
					},
					"bSortable": false,
					"aTargets": [7]
				},					
				{
                "mRender": function (data, type, row) {
                	var nombre_estado = "";
					if(row.estado == 1)nombre_estado = "Activo";
					if(row.estado == 0)nombre_estado = "Eliminado";
					return nombre_estado;
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalAsignacion('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=eliminarAsignacion('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
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




function modalAsignacion(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/asignacion/modal_asignacion/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}


function fn_importar_Vou(){
	
	//$(".modal-dialog").css("width","85%");
	//$('#openOverlayOpc .modal-body').css('height', 'auto');
	var id_periodo = $("#id_periodo").val();
	var anio = $("#anio").val();
	var mes = $("#mes").val();
	$.ajax({
			url: "/asiento_planilla/importar_vou_siscont/" +id_periodo+"/"+anio+"/"+mes,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}





function eliminarAsignacion(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Asignación?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_asignacion(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_asignacion(id,estado){
	
    $.ajax({
            url: "/asignacion/eliminar_asignacion/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

function fn_ListarBusqueda() {
    cargarAsientoPlanilla();
};

function fn_genera_asiento(){
	//var anio = $('#anio').val();
	//var mes = $('#mes').val();
	var p = {};
	p.anio =  $('#anio').val();
	p.mes = $('#mes').val();
	p.periodo  = $('#id_periodo').val();


	//alert(mes);
    $.ajax({
            url: "/asiento/generar_asiento_planilla",
            type: "GET",
			data: p,
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				cargarAsientoPlanilla();
            }
    });
}


function cargarAsientoPlanilla() {

	$("#divPlanilla").html("");
	$.ajax({
		//url: "/concurso/obtener_concurso_documento/"+id_concurso_inscripcion,
		url: "/asiento/obtener_asiento_planilla",
		data: $("#frmAfiliacion").serialize(),
		type: "POST",
		success: function(result) {
			$("#divPlanilla").html(result);
		}
	});

}



