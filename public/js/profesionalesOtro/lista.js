
$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#colegiatura').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#colegiatura_abrev').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#nombres').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#dni').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#profesion').keypress(function(e){
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
		modalProfesionalesOtro(0);
	});
		
	datatablenew();
	
});

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/profesionalesOtro/listar_profesionalesOtro_ajax",
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
			
			var colegiatura = $('#colegiatura').val();
			var numero_documento = $('#numero_documento').val();
			var agremiado = $('#agremiado').val();
			var profesion = $('#profesion').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						colegiatura:colegiatura,numero_documento:numero_documento,agremiado:agremiado,profesion:profesion,estado:estado,
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
                	var colegiatura = "";
					if(row.colegiatura!= null)colegiatura = row.colegiatura;
					return colegiatura;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var colegiatura_abreviatura = "";
					if(row.colegiatura_abreviatura!= null)colegiatura_abreviatura = row.colegiatura_abreviatura;
					return colegiatura_abreviatura;
				},
				"bSortable": false,
				"aTargets": [1],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var tipo_documento = "";
					if(row.tipo_documento!= null)tipo_documento = row.tipo_documento;
					return tipo_documento;
				},
				"bSortable": false,
				"aTargets": [2],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var numero_documento = "";
					if(row.numero_documento!= null)numero_documento = row.numero_documento;
					return numero_documento;
				},
				"bSortable": false,
				"aTargets": [3],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var agremiado = "";
					if(row.agremiado!= null)agremiado = row.agremiado;
					return agremiado;
				},
				"bSortable": false,
				"aTargets": [4],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var fecha_nacimiento = "";
					if(row.fecha_nacimiento!= null)fecha_nacimiento = row.fecha_nacimiento;
					return fecha_nacimiento;
				},
				"bSortable": false,
				"aTargets": [5],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var profesion = "";
					if(row.profesion!= null)profesion = row.profesion;
					return profesion;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var ruta_firma = "";
					if(row.ruta_firma!= null)ruta_firma = row.ruta_firma;
					return ruta_firma;
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalProfesionalesOtro('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=eliminarProfesionalesOtro('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
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

function modalProfesionalesOtro(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/profesionalesOtro/modal_profesionalesOtro_nuevoProfesionalesOtro/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarProfesionalesOtro(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Profesional?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_profesionalesOtro(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_profesionalesOtro(id,estado){
	
    $.ajax({
            url: "/profesionalesOtro/eliminar_profesionalesOtro/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

