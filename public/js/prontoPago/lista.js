//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {
	
	$('#fecha_inicio').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_fin').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });


	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#periodoBus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#fecha_inicio').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#fecha_fin').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#codigo_documento').keypress(function(e){
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
		modalProntoPago(0);
	});
		
	datatablenew();
	
	$(function() {
		$('#modalEmpresaForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaForm #apellido_materno').keyup(function() {
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


function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/prontoPago/listar_prontoPago_ajax",
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
			var periodo = $('#periodoBus').val();
			var fecha_inicio = $('#fecha_inicio').val();
            var fecha_fin = $('#fecha_fin').val();
			var concepto = $('#concepto').val();
			var numero_cuotas = $('#numero_cuotas').val();
			var codigo_documento = $('#codigo_documento').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,periodo:periodo,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,concepto:concepto,numero_cuotas:numero_cuotas,codigo_documento:codigo_documento,estado:estado,
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
					var fecha_inicio = "";
					if(row.fecha_inicio!= null)fecha_inicio = row.fecha_inicio;
					return fecha_inicio;
					},
				"bSortable": false,
				"aTargets": [1],
				"className": "dt-center",
				},
				{
                "mRender": function (data, type, row) {
                	var fecha_fin = "";
					if(row.fecha_fin!= null)fecha_fin = row.fecha_fin;
					return fecha_fin;
                },
                "bSortable": false,
                "aTargets": [2],
				"className": "dt-center",
				//"className": 'control'
                },
                {
                "mRender": function (data, type, row) {
                	var numero_cuotas = "";
					if(row.numero_cuotas!= null)numero_cuotas = row.numero_cuotas;
					return numero_cuotas;
                },
                "bSortable": false,
                "aTargets": [3]
                },
				{
				"mRender": function (data, type, row) {
					var codigo_documento = "";
					if(row.codigo_documento!= null)codigo_documento = row.codigo_documento;
					return codigo_documento;
				},
				"bSortable": false,
				"aTargets": [4]
				},
				/*{
				"mRender": function (data, type, row) {
					var ruta_documento = "";
					if(row.ruta_documento!= null)ruta_documento = row.ruta_documento;
					return ruta_documento;
				},
				"bSortable": false,
				"aTargets": [5]
				},*/
				{
				"mRender": function (data, type, row) {
					var concepto = "";
					if(row.concepto!= null)concepto = row.concepto;
					return concepto;
				},
				"bSortable": false,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var estado = "";
					if(row.estado == 1){
						estado = "Activo";
					}
					if(row.estado == 0){
						estado = "Eliminado";
					}
					if(row.estado == 2){
						estado = "Inactivo";
					}
					return estado;
				},
				"bSortable": false,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var estado = "";
					var clase = "";
					if(row.estado == 1 || row.estado == 2){
						estado = "Eliminar";
						clase = "btn-danger";
					}
					if(row.estado == 0){
						estado = "Activar";
						clase = "btn-success";
					}
						
						var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalProntoPago('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						html += '<a href="javascript:void(0)" onclick=eliminarProntoPago('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [7],
				},

            ]

    });

}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalProntoPago(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/prontoPago/modal_prontoPago_nuevoProntoPago/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}


function eliminarProntoPago(id,estado){
	var act_estado = "";
	if(estado==1 || estado==2 ){
		act_estado = "Eliminar";
		estado_=0;
	}
	if(estado==0){
		act_estado = "Activar";
		estado_=1;
	}
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" Pronto Pago?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_prontoPago(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_prontoPago(id,estado){
	
    $.ajax({
            url: "/prontoPago/eliminar_prontoPago/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
            }
    });
}

