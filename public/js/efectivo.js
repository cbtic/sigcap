//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#monto').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#estado').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#btnNuevo').click(function () {
		modalEfectivo(0);
	});
		
	datatablenew();

	$('#fecha_bus').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
	});
	
});

function datatablenew(){
    var oTable1 = $('#tblEfectivo').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/ingreso/listar_consulta_efectivo_ajax",
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
			
			var id = $('#id').val();
			//var denominacion = $('#denominacion').val();
			var fecha = $('#fecha_bus').val();
			var caja = $('#caja_bus').val();
			//var estado = $('#estado').val();

			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,fecha:fecha,caja:caja,
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
                	var caja = "";
					if(row.caja!= null)caja = row.caja;
					return caja;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
				//"className": 'control'
                },
                {
                "mRender": function (data, type, row) {
                	var fecha = "";
					if(row.fecha!= null)fecha = row.fecha;
					return fecha;
                },
                "bSortable": false,
                "aTargets": [2],
				"className": "dt-center",
                },
				/*{
				"mRender": function (data, type, row) {
					var moneda = "";
					if(row.moneda!= null)moneda = row.moneda;
					return moneda;
				},
				"bSortable": false,
				"aTargets": [3]
				},*/
				{
					"mRender": function (data, type, row) {
						var importe_soles = "";
						if(row.importe_soles!= null)importe_soles = row.importe_soles;
						return importe_soles;
					},
					"bSortable": false,
					"aTargets": [3]
				},
				{
					"mRender": function (data, type, row) {
						var importe_dolares = "";
						if(row.importe_dolares!= null)importe_dolares = row.importe_dolares;
						return importe_dolares;
					},
					"bSortable": false,
					"aTargets": [4]
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
				"aTargets": [5]
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
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEfectivo('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						html += '<a href="javascript:void(0)" onclick=eliminarEfectivo('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [6],
				},

            ]


    });

}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalEfectivo(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/ingreso/modal_efectivo_nuevoEfectivo/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');

			}
	});

}

function eliminarEfectivo(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el registro?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_efectivo(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_efectivo(id,estado){
	
	//alert(id,estado);
    $.ajax({
            url: "/ingreso/eliminar_efectivo/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                
				datatablenew();
            }
    });
}

function generarPdfCaja(){

	var msg = "";

	var fecha = $('#fecha_bus').val();
	var caja = $('#caja_bus').val();

	if(fecha==""){msg+="Ingrese una Fecha <br>";}
	if(caja==""){msg+="Ingrese una Caja <br>";}

	if(msg!=""){
        bootbox.alert(msg);
        return false;
	}else{

		var href = '/ingreso/reporte_efectivo_caja_pdf/'+fecha+'/'+caja;
		window.open(href, '_blank');

	}

}

function generarPdfConsolidado(){

	var msg = "";

	var fecha = $('#fecha_bus').val();

	if(fecha==""){msg+="Ingrese una Fecha <br>";}

	if(msg!=""){
        bootbox.alert(msg);
        return false;
	}else{

		$.ajax({
            url: "/ingreso/reporte_efectivo_consolidado_pdf/" + fecha,
            type: "get",
            success: function () {
                window.open('/ingreso/reporte_efectivo_consolidado_pdf/' + fecha, '_blank');
            },
            error: function (xhr) {
                if (xhr.status == 404) {
                    bootbox.alert("No hay datos para la fecha seleccionada.");
                } else {
                    bootbox.alert("Ocurrió un error al generar el PDF.");
                }
            }
        });
	}

}
