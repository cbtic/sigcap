
$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
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
		
	datatablenew();
	
});

function guardar_credipago(){
    
    $.ajax({
			url: "/derecho_revision/send_credipago",
            type: "POST",
            data : $("#frmExpediente").serialize(),
            success: function (result) {  
					datatablenew();
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
			
			var nombre_proyecto = $('#nombre_proyecto').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						nombre_proyecto:nombre_proyecto,estado:estado,
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
				"aTargets": [7]
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
					"aTargets": [8],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalProfesion(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/profesion/modal_profesion_nuevoProfesion/"+id,
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
