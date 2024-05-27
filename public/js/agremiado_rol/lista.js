
$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#denominacion').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#numero_cap').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#nombre').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#rol').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#rol_especifico').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#codigo').keypress(function(e){
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
		modalPlanContable(0);
	});
		
	datatablenew();
	
});

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/agremiado_rol/listar_agremiado_rol_ajax",
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
			
			var periodo = $('#id_periodo_bus').val();
			var numero_cap = $('#numero_cap').val();
			var agremiado = $('#nombre').val();
			var rol = $('#rol').val();
			var sub_rol = $('#sub_rol').val();
			var rol_especifico = $('#rol_especifico').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						periodo:periodo,numero_cap:numero_cap,agremiado:agremiado,rol:rol,rol_especifico:rol_especifico,estado:estado,sub_rol:sub_rol,
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
                	var numero_cap = "";
					if(row.numero_cap!= null)numero_cap = row.numero_cap;
					return numero_cap;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var agremiado = "";
					if(row.agremiado!= null)agremiado = row.agremiado;
					return agremiado;
				},
				"bSortable": false,
				"aTargets": [2],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var rol = "";
					if(row.rol!= null)rol = row.rol;
					return rol;
				},
				"bSortable": false,
				"aTargets": [3],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var sub_rol = "";
					if(row.sub_rol!= null)sub_rol = row.sub_rol;
					return sub_rol;
				},
				"bSortable": false,
				"aTargets": [4],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var rol_especifico = "";
					if(row.rol_especifico!= null)rol_especifico = row.rol_especifico;
					return rol_especifico;
				},
				"bSortable": false,
				"aTargets": [5],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var fecha_inicio = "";
					if(row.fecha_inicio!= null)fecha_inicio = row.fecha_inicio;
					return fecha_inicio;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var fecha_fin = "";
					if(row.fecha_fin!= null)fecha_fin = row.fecha_fin;
					return fecha_fin;
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
				/*{
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalPlanContable('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=eliminarPlanContable('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
					html += '</div>';
					return html;
					},
					"bSortable": false,
					"aTargets": [3],
				},*/
            ]
    });
}

function obtenerSubTipoConcurso(){
	
	var id_tipo_concurso = $('#rol').val();
	
	$.ajax({
		url: '/concurso/listar_maestro_by_tipo_subtipo/93/'+id_tipo_concurso,
		dataType: "json",
		success: function(result){
			var option = "<option value='0'>--Seleccionar Sub Rol--</option>";
			$("#id_sub_rol").html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.codigo+"'>"+oo.denominacion+"</option>";
			});
			$("#id_sub_rol").html(option);
		}
		
	});
	
}

function obtenerRoEspecifico(){
	
	var id_sub_rol = $('#id_sub_rol').val();
	
	$.ajax({
		url: '/concurso/listar_maestro_by_tipo_subtipo/94/'+id_sub_rol,
		dataType: "json",
		success: function(result){
			var option = "<option value='0'>--Seleccionar Espec&iacute;fico--</option>";
			$("#rol_especifico").html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.codigo+"'>"+oo.denominacion+"</option>";
			});
			$("#rol_especifico").html(option);
		}
		
	});
	
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalPlanContable(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/plan_contable/modal_plan_contable_nuevoPlanContable/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarPlanContable(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Plan Contable?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_plan_contable(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_plan_contable(id,estado){
	
    $.ajax({
            url: "/plan_contable/eliminar_plan_contable/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

