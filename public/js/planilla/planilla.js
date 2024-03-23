
$(document).ready(function () {
	
	datatablenew();

	$("#id_regional_bus").select2({ width: '100%' });
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#fecha_comprobante').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#btnGuardar').click(function () {
		//modalProfesion(0);
		save_recibo()
	});
		
	$('#btnNuevo').click(function () {
		bootbox.confirm({ 
			size: "small",
			message: "&iquest;Esta seguro de generar el reporte?", 
			callback: function(result){
				if (result==true) {
					guardar_computo()
				}
			}
		});
	});
	
	
});

obtenerAnioPerido();

function obtenerAnioPerido(){
	
	var id_periodo = $('#id_periodo_bus').val();
	
	$.ajax({
		url: '/planilla/obtener_anio_periodo/'+id_periodo,
		dataType: "json",
		success: function(result){
			var option = "";
			$('#anio').html("");
			//option += "<option value='0'>--Seleccionar--</option>";
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.anio+"'>"+oo.anio+"</option>";
			});
			$('#anio').html(option);
		}
		
	});
	
}

function obtenerAgremiadoPlanilla(){
		
	var numero_cap = $("#frmPlanillaDetalle #numero_cap").val();
	var msg = "";
	
	if(numero_cap == "")msg += "Debe ingresar el numero de documento <br>";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/agremiado/obtener_datos_agremiado_coordinador_zonal/' + numero_cap,
		dataType: "json",
		success: function(result){
			
			var agremiado = result.agremiado;
			//var tipo_documento = parseInt(agremiado.tipo_documento);
			//var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
			
			$('#frmPlanillaDetalle #nombres').val(agremiado.apellido_paterno + ' ' + agremiado.apellido_materno + ' ' +agremiado.nombres);
			//$('#telefono').val(persona.telefono);
			//$('#email').val(persona.email);
			
			$('.loader').hide();

		}
		
	});
	
}

function cargarPlanillaDelegado(){
       
	$("#divPlanilla").html("");
	$.ajax({
			//url: "/concurso/obtener_concurso_documento/"+id_concurso_inscripcion,
			url: "/planillaDelegado/obtener_planilla_delegado",
			data : $("#frmPlanilla").serialize(),
			type: "POST",
			success: function (result) {  
					$("#divPlanilla").html(result);
			}
	});

}

function generarPlanilla(){
	
	$.ajax({
			url: "/planilla/send_planilla_delegado",
			type: "POST",
			data : $("#frmPlanilla").serialize(),
			success: function (result) {
					
					if(result==false){
						bootbox.alert("Planilla ya esta registrado"); 
						return false;
					}
					
					cargarPlanillaDelegado();
			}
	});
	
}

function datatablenew(){
    var oTable1 = $('#tblReciboHonorario').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/planillaDelegado/listar_recibo_honorario_ajax",
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
			var numero_cap = $('#numero_cap').val();
            var agremiado = $('#agremiado').val();
			var numero_comprobante = $('#numero_comprobante').val();
			var fecha_comprobante = $('#fecha_comprobante').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,numero_cap:numero_cap,agremiado:agremiado,numero_comprobante:numero_comprobante,
						fecha_comprobante:fecha_comprobante,estado:estado,
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
                	var numero_cap = "";
					if(row.numero_cap!= null)numero_cap = row.numero_cap;
					return numero_cap;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
                },
				
                {
                "mRender": function (data, type, row) {
                	var agremiado = "";
					if(row.agremiado!= null)agremiado = row.agremiado;
					return agremiado;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var situacion = "";
					if(row.situacion!= null)situacion = row.situacion;
					return situacion;
				},
				"bSortable": false,
				"aTargets": [2]
				},
				{
				"mRender": function (data, type, row) {
					var numero_comprobante = "";
					if(row.numero_comprobante!= null)numero_comprobante = row.numero_comprobante;
					return numero_comprobante;
				},
				"bSortable": false,
				"aTargets": [3]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_comprobante = "";
					if(row.fecha_comprobante!= null)fecha_comprobante = row.fecha_comprobante;
					return fecha_comprobante;
				},
				"bSortable": false,
				"aTargets": [4]
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
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarRecibo('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						//html += '<a href="javascript:void(0)" onclick=eliminarPrestamo('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [5],
				},

            ]
    });

}

function fn_ListarBusqueda() {
    datatablenew();
};

function editarRecibo(id){

	//var id_periodo = $('#id_periodo').val();
	//$('#id_recibo').val(id);
	$.ajax({
		url: '/planillaDelegado/obtener_datos_recibo/'+id,
		type: 'GET',
		contentType: 'application/json',
		processData: false,
		dataType: "json",
		success: function(result){
			//console.log(result[0].numero_cap);
			$('#id_recibo').val(result[0].id);
			$('#numero_cap').val(result[0].numero_cap);
			$('#nombres').val(result[0].agremiado);
			
        }
			
		
	});

}

function save_recibo(){
    
	var _token = $('#_token').val();
	var id = $('#id_recibo').val();
    var tipo_comprobante = $('#tipo_comprobante').val();
	var numero_comprobante = $('#numero_comprobante').val();
    var fecha_comprobante = $('#fecha_comprobante').val();
	
	$.ajax({
			url: "/planillaDelegado/send_recibo_honorario",
            type: "POST",
            data : {_token:_token,id:id,tipo_comprobante:tipo_comprobante,numero_comprobante:numero_comprobante,fecha_comprobante:fecha_comprobante},
			success: function (result) {
				//$('#openOverlayOpc').modal('hide');
				window.location.reload();
				//datatablenew();
								
            }
    });
}

