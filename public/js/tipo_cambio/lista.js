
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

	$(document).ready(function () {

	$('#fecha_b').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			changeMonth: true,
			changeYear: true,
	});
	
	});
		
	$('#btnNuevo').click(function () {
		modalTipoCambio(0);
	});
		
	datatablenew();
	/*
	datatablenew({
		sAjaxSource: "/tipo_cambio/listar_tipo_cambio_ajax",
		extraData: {
			id: $('#id').val(),
			denominacion: $('#denominacion_muni').val(),
			tipo_municipalidad: $('#tipo_municipalidad').val(),
			estado: $('#estado').val()
		},
		columns: [
			'fecha', // Nombre de la propiedad
			'valor_venta',
			'valor_compra',
			'estado',
			'estado'
		]
	});
	*/
});

function datatablenew(){ 
    var oTable1 = $('#tblTipoCambio').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/tipo_cambio/listar_tipo_cambio_ajax",
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
			var fecha = $('#fecha_b').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,fecha:fecha,estado:estado,
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
                	var fecha = "";
					if(row.fecha!= null)fecha = row.fecha;
					return fecha;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var valor_venta = "";
					if(row.valor_venta!= null)valor_venta = parseFloat(row.valor_venta).toFixed(3);
					return valor_venta;
				},
				"bSortable": false,
				"aTargets": [1],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var valor_compra = "";
					if(row.valor_compra!= null)valor_compra = parseFloat(row.valor_compra).toFixed(3);
					return valor_compra;
				},
				"bSortable": false,
				"aTargets": [2],
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
				"aTargets": [3]
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalTipoCambio('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=eliminarTipoCambio('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
					html += '</div>';
					return html;
					},
					"bSortable": false,
					"aTargets": [4],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalTipoCambio(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/tipo_cambio/modal_tipo_cambio_nuevoTipoCambio/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarTipoCambio(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Tipo de Cambio?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_tipo_cambio(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_tipo_cambio(id,estado){
	
    $.ajax({
            url: "/tipo_cambio/eliminar_tipo_cambio/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

/*function datatablenew(options) {
    // Valores predeterminados
    var defaults = {
        sAjaxSource: "/comision/listar_comision_ajax", // URL predeterminada
        bFilter: false,
        bSort: false,
        info: true,
        language: {"url": "/js/Spanish.json"},
        autoWidth: false,
        bLengthChange: true,
        destroy: true,
        lengthMenu: [[10, 50, 100, 200, 60000], [10, 50, 100, 200, "Todos"]],
        dom: '<"top">rt<"bottom"flpi><"clear">',
        extraData: {}, // Datos extra para la petición
        columns: [] // Solo los nombres de las propiedades que se desean mostrar
    };

    // Combina las configuraciones personalizadas con los valores predeterminados
    var config = $.extend(true, {}, defaults, options);

    // Llenar `columns` dinámicamente
    var columns = [];
	for (let i = 0; i < config.columns.length; i++) {
		let field = config.columns[i]; // Usamos `let` para que `field` tenga un ámbito local a cada iteración
		
		columns.push({
			"mRender": function(data, type, row) {
				return row[field] !== null ? row[field] : ''; // Devuelve el valor de la propiedad de cada fila
			},
			"bSortable": false, // Predeterminado en false
			"className": "", // Predeterminado en vacío
			"aTargets": [i] // Índice de la columna
		});
	}
	//console.log(columns);
    // Llenar `extraData` dinámicamente, si existe en las opciones
    var extraData = {};
    for (var key in config.extraData) {
        if (config.extraData.hasOwnProperty(key)) {
            extraData[key] = config.extraData[key];
        }
    }

    var oTable1 = $('#tblTipoCambio').dataTable({
        "bServerSide": true,
        "sAjaxSource": config.sAjaxSource,
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "bFilter": config.bFilter,
        "bSort": config.bSort,
        "info": config.info,
        "language": config.language,
        "autoWidth": config.autoWidth,
        "bLengthChange": config.bLengthChange,
        "destroy": config.destroy,
        "lengthMenu": config.lengthMenu,
        "dom": config.dom,
        "fnDrawCallback": function(json) {
            $('[data-toggle="tooltip"]').tooltip();
        },

        "fnServerData": function(sSource, aoData, fnCallback, oSettings) {
            // Construir datos dinámicamente
            var data = {
                NumeroPagina: parseFloat(fn_util_obtieneNroPagina(aoData[3].value, aoData[4].value)).toFixed(),
                NumeroRegistros: aoData[4].value,
                _token: $('#_token').val()
            };

            // Agregar los parámetros adicionales si existen
            data = $.extend(data, extraData);

            oSettings.jqXHR = $.ajax({
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": data,
                "success": function(result) {
                    fnCallback(result);
                },
                "error": function(msg, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX:", msg, textStatus, errorThrown);
                }
            });
        },

        "aoColumnDefs": columns // Usar las columnas configuradas
    });
}
*/