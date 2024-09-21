
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

	$('#anio').keypress(function(e){
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
		modalParametro(0);
	});
		
	datatablenew();
	
});

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/parametro/listar_parametro_ajax",
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
			
			var id = $('#id').val();
			var anio = $('#anio').val();
			var porcentaje_calculo_edificaciones = $('#porcentaje_calculo_edificaciones').val();
			var valor_metro_cuadrado_habilitacion_urbana = $('#valor_metro_cuadrado_habilitacion_urbana').val();
			var valor_uit = $('#valor_uit').val();
			var igv = $('#igv').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,anio:anio,porcentaje_calculo_edificaciones:porcentaje_calculo_edificaciones,estado:estado,
						valor_metro_cuadrado_habilitacion_urbana:valor_metro_cuadrado_habilitacion_urbana,
						valor_uit:valor_uit,igv:igv,
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
                	var anio = "";
					if(row.anio!= null)anio = row.anio;
					return anio;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var porcentaje_calculo_edificacion = "";
					if(row.porcentaje_calculo_edificacion!= null)porcentaje_calculo_edificacion = row.porcentaje_calculo_edificacion;
					return porcentaje_calculo_edificacion;
				},
				"bSortable": false,
				"aTargets": [1],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var valor_minimo_edificaciones = "";
					if(row.valor_minimo_edificaciones!= null)valor_minimo_edificaciones = row.valor_minimo_edificaciones;
					return valor_minimo_edificaciones;
				},
				"bSortable": false,
				"aTargets": [2],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var valor_metro_cuadrado_habilitacion_urbana = "";
					if(row.valor_metro_cuadrado_habilitacion_urbana!= null)valor_metro_cuadrado_habilitacion_urbana = row.valor_metro_cuadrado_habilitacion_urbana;
					return valor_metro_cuadrado_habilitacion_urbana;
				},
				"bSortable": false,
				"aTargets": [3],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var valor_minimo_hu = "";
					if(row.valor_minimo_hu!= null)valor_minimo_hu = row.valor_minimo_hu;
					return valor_minimo_hu;
				},
				"bSortable": false,
				"aTargets": [4],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var valor_maximo_hu = "";
					if(row.valor_maximo_hu!= null)valor_maximo_hu = row.valor_maximo_hu;
					return valor_maximo_hu;
				},
				"bSortable": false,
				"aTargets": [5],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var valor_uit = "";
					if(row.valor_uit!= null)valor_uit = row.valor_uit;
					return valor_uit;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var igv = "";
					if(row.igv!= null)igv = row.igv;
					return igv;
				},
				"bSortable": false,
				"aTargets": [7],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var monto_minimo_rh = "";
					if(row.monto_minimo_rh!= null)monto_minimo_rh = row.monto_minimo_rh;
					return monto_minimo_rh;
				},
				"bSortable": false,
				"aTargets": [8],
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
				"aTargets": [9]
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalParametro('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=eliminarParametro('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
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

function modalParametro(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/parametro/modal_parametro_nuevoParametro/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarParametro(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Parametro?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_parametro(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_parametro(id,estado){
	
    $.ajax({
            url: "/parametro/eliminar_parametro/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

