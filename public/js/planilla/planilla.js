
$(document).ready(function () {
	
	$('#numero_operacion').prop('readonly', true);
	$('#chk_activar_numero_operacion').change(function(){
        if($(this).is(':checked')){
            $('#numero_operacion').prop('readonly', false);
        } else {
            $('#numero_operacion').prop('readonly', true);
        }
    });

	datatablenew();

	$("#id_regional_bus").select2({ width: '100%' });
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnGenerarProv').click(function () {
		$('#TipoAsiento').val("1");
		generarAsientoPlanilla();
	});

	$('#btnGenerarCanc').click(function () {
		$('#TipoAsiento').val("2");
		generarAsientoPlanilla();
	});
	
	$('#btnDescargar').on('click', function () {
		descargarExcel()

	});

	$('#btnDescargarRH').on('click', function () {
		DescargarArchivosRH()

	});
	
	$('#btnDescargarPdf').on('click', function () {
		descargarPdf()

	});

	$('#agremiado_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#situacion_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#municipalidad_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});
	

	$('#numero_cap_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#numero_comprobante_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});


	$('#fecha_inicio_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#fecha_fin_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#btnBuscar_').click(function () {
		fn_ListarBusqueda();
	});

	$('#fecha_comprobante').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_vencimiento').datepicker({
        autoclose: true,
		format: 'dd-mm-yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_inicio_bus').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });
	
	$('#fecha_fin_bus').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });

	$('#fecha_comprobante_bus').datepicker({
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

function eliminarPlanilla(){
	
	$.ajax({
			url: "/planilla/eliminar_planilla_delegado",
			type: "POST",
			data : $("#frmPlanilla").serialize(),
			success: function (result) {
					/*
					if(result==false){
						bootbox.alert("Planilla ya esta registrado"); 
						return false;
					}
					*/

					alert(result);
					cargarPlanillaDelegado();
					
			}
	});
	
}

/*
function generarAsientoPlanilla(){
	
	$.ajax({
			url: "/asiento/generar_asiento_planilla",
			
			type: "POST",
			data : $("#frmPlanilla").serialize(),
			success: function (result) {
					
					if(result==false){
						bootbox.alert("Asiento provisión ya esta registrado"); 
						return false;
					}
					
					cargarPlanillaDelegado();
			}
	});
	
}
*/

function generarAsientoPlanilla(){

	var p = {};
	p.anio =  $('#anio').val();
	p.mes = $('#mes').val();
	p.periodo  = $('#id_periodo').val();
	p.tipo  = $('#TipoAsiento').val();
	p.id_periodo_bus_  = $('#id_periodo_bus_').val();
	p.id_periodo_bus  = $('#id_periodo_bus').val();

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
    $.ajax({
            url: "/asiento/generar_asiento_planilla", 
            type: "GET",
			data: p,
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);				
				fn_ListarBusqueda();
				$('.loader').hide();
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
			var periodo = $('#id_periodo_bus').val();
			var anio = $('#anio').val();
			var mes = $('#mes').val();
			var numero_cap = $('#numero_cap_bus').val();
            var agremiado = $('#agremiado_bus').val();
			var municipalidad = $('#municipalidad_bus').val();
			var situacion = $('#situacion_bus').val();
			var numero_comprobante = $('#numero_comprobante_bus').val();
			var fecha_inicio = $('#fecha_inicio_bus').val();
			var fecha_fin = $('#fecha_fin_bus').val();

			var provision = $('#provision_b').val();
			var cancelacion = $('#cancelacion_b').val();
			var grupo = '';
			var tiene_ruc = $('#ruc_b').val();

			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,periodo:periodo,anio:anio,mes:mes,numero_cap:numero_cap,municipalidad:municipalidad,
						agremiado:agremiado,situacion:situacion,numero_comprobante:numero_comprobante,
						fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,estado:estado,provision:provision,cancelacion:cancelacion,grupo:grupo,
						tiene_ruc:tiene_ruc,_token:_token
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
					var ruc = "";
					if(row.ruc!= null)ruc = row.ruc;
					return ruc;
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
					var situacion = "";
					if(row.situacion!= null)situacion = row.situacion;
					return situacion;
				},
				"bSortable": false,
				"aTargets": [4]
				},
				{
				"mRender": function (data, type, row) {
					var numero_comprobante = "";
					if(row.numero_comprobante!= null)numero_comprobante = row.numero_comprobante;
					return numero_comprobante;
				},
				"bSortable": false,
				"aTargets": [5]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_comprobante = "";
					if(row.fecha_comprobante!= null){
						var dateParts = row.fecha_comprobante.split(' ');
            			fecha_comprobante = dateParts[0];
					}
					return fecha_comprobante;
				},
				"bSortable": false,
				"aTargets": [6]
				},
				{
				"mRender": function (data, type, row) {
					var fecha_vencimiento = "";
					if(row.fecha_vencimiento!= null){
						var dateParts = row.fecha_vencimiento.split(' ');
						fecha_vencimiento = dateParts[0];
					}
					return fecha_vencimiento;
				},
				"bSortable": false,
				"aTargets": [7]
				},
				{
					"mRender": function (data, type, row) {
						var cancelado = "";
						if(row.cancelado == 1){
							cancelado = "Si";
						}
						if(row.cancelado == 0){
							cancelado = "No";
						}
						return cancelado;
					},
					"bSortable": false,
					"aTargets": [8]
				},
				{
					"mRender": function (data, type, row) {
						var numero_operacion = "";
						if(row.numero_operacion!= null)numero_operacion = row.numero_operacion;
						return numero_operacion;
					},
					"bSortable": false,
					"aTargets": [9]
				},
				{
					"mRender": function (data, type, row) {
						var fecha_operacion= "";
						if(row.fecha_operacion!= null){
							var dateParts = row.fecha_operacion.split(' ');
							fecha_operacion = dateParts[0];
						}
						return fecha_operacion;
					},
					"bSortable": false,
					"aTargets": [10]
				},
				{
					"mRender": function (data, type, row) {
						var id_grupo = "";
						if(row.id_grupo!= null)id_grupo = row.id_grupo;
						return id_grupo;
					},
					"bSortable": false,
					"aTargets": [11]
				},									
				{
					"mRender": function (data, type, row) {
						var provision = "";
						if(row.provision!= null)provision = row.provision;
						return provision;
					},
					"bSortable": false,
					"aTargets": [12]
				},
				{
					"mRender": function (data, type, row) {
						var cancelacion = "";
						if(row.cancelacion!= null)cancelacion = row.cancelacion;
						return cancelacion;
					},
					"bSortable": false,
					"aTargets": [13]
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
						
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalRecibo('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						//html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarRecibo('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						//html += '<a href="javascript:void(0)" onclick=eliminarPrestamo('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [14],
				},

            ]
    });

}

function fn_ListarBusqueda() {
    datatablenew();
};

function limpiar(){
	$("#numero_cap").val("");
	$("#nombres").val("");
	$("#numero_comprobante").val("");
	$("#fecha_comprobante").val("");
	$("#fecha_vencimiento").val("");
	$("#numero_operacion").val("");
	$('#chk_activar_numero_operacion').prop('checked', false);
	$('#numero_operacion').prop('readonly', true);
}

function modalRecibo(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/planillaDelegado/modal_recibo/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

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

				limpiar();
				if(result[0].ruc!=null)
				{
					if(result[0].fecha_comprobante==null)
					{
						$('#fecha_comprobante').val('');
					}
	
					$('#id_recibo').val(result[0].id);
					$('#numero_cap').val(result[0].numero_cap);
					$('#nombres').val(result[0].agremiado);
					$('#numero_comprobante').val(result[0].numero_comprobante);
					$('#fecha_comprobante').val(result[0].fecha_comprobante.split(' ')[0]);
					$('#fecha_vencimiento').val(result[0].fecha_vencimiento.split(' ')[0]);
					$('#numero_operacion').val(result[0].numero_operacion);
					$('#id_grupo').val(result[0].id_grupo);

					//alert($('#id_grupo').val());
					
					//var_dump(result[0].cancelado);exit;
					if(result[0].cancelado == 1) {
						$('#chk_activar_numero_operacion').prop('checked', true);
						$('#numero_operacion').prop('readonly', false);
					} else{
						$('#chk_activar_numero_operacion').prop('checked', false);
						$('#numero_operacion').prop('readonly', true);
					}
				}else {
					bootbox.alert('El delegado no tiene RUC, coordine con el Área Gremial para que le ingrese el RUC.');
				}
        }
			
		
	});

}

function save_recibo(){

	var msg = "";
	

    
	var _token = $('#_token').val();
	var id = $('#id_recibo').val();
    var tipo_comprobante = $('#tipo_comprobante').val();
	var numero_comprobante = $('#numero_comprobante').val();
    var fecha_comprobante = $('#fecha_comprobante').val();
	var fecha_vencimiento = $('#fecha_vencimiento').val();
	var numero_operacion = $('#numero_operacion').val();
	var cancelado = $('#chk_activar_numero_operacion').prop('checked') ? 1 : 0;
	$('#cancelado').val(cancelado);

	if(numero_comprobante == "")msg += "Debe ingresar el numero de comprobante <br>";
	if(fecha_comprobante == "")msg += "Debe ingresar la fecha de comprobante del comprobante <br>";
	if(fecha_vencimiento == "")msg += "Debe ingresar la fecha de vencimiento del comprobante <br>";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}

	var selTipo = '';
	$('#selTipo').val(selTipo);

	if(cancelado==1){

	  const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-warning"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: 'Cancelación',
		text: "Seleccionar el tipo de cancelación!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Solo Selccionado!",
		cancelButtonText: "Todo el Grupo!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {
			selTipo = 'S';
			$('#selTipo').val(selTipo);
			send_recibo_honorario();
/*
			$.ajax({
				url: "/planillaDelegado/send_recibo_honorario",
				type: "POST",
				data : {_token:_token,id:id,tipo_comprobante:tipo_comprobante,numero_comprobante:numero_comprobante,fecha_comprobante:fecha_comprobante,fecha_vencimiento:fecha_vencimiento,numero_operacion:numero_operacion,cancelado:cancelado,sel:sel},
				success: function (result) {

					datatablenew();
	
					limpiar();					
				}
			});
			*/
		} else if 
			(result.dismiss === Swal.DismissReason.cancel) 
			  
			{
				selTipo = 'T';
				$('#selTipo').val(selTipo);

				send_recibo_honorario();
				/*
				$.ajax({
					url: "/planillaDelegado/send_recibo_honorario",
					type: "POST",
					data : {_token:_token,id:id,tipo_comprobante:tipo_comprobante,numero_comprobante:numero_comprobante,fecha_comprobante:fecha_comprobante,fecha_vencimiento:fecha_vencimiento,numero_operacion:numero_operacion,cancelado:cancelado,sel:sel},
					success: function (result) {

						datatablenew();
		
						limpiar();					
					}
				});
				*/
			}
	  });

	}else{
		send_recibo_honorario();
		/*
		$.ajax({
			url: "/planillaDelegado/send_recibo_honorario",
			type: "POST",
			data : {_token:_token,id:id,tipo_comprobante:tipo_comprobante,numero_comprobante:numero_comprobante,fecha_comprobante:fecha_comprobante,fecha_vencimiento:fecha_vencimiento,numero_operacion:numero_operacion,cancelado:cancelado,sel:sel},
			success: function (result) {

				datatablenew();

				limpiar();					
			}
		});
		*/
	}
	//datatablenew();	
	//limpiar();	

}

function send_recibo_honorario(){
    $.ajax({
			url:"/planillaDelegado/send_recibo_honorario",
            type: "POST",
            data : $("#frmPlanillaDetalle").serialize(),
            success: function (result) {				
				datatablenew();

				limpiar();
					
            }
    });
}

function descargarExcel(){
		
	var periodo = $('#id_periodo_bus').val();
	var anio = $('#anio').val();
	var mes = $('#mes').val();
	
	if (periodo == "")periodo = 0;
	if (anio == "")anio = 0;
	if (mes == "")mes = 0;
	
	location.href = '/planilla/exportar_planilla_delegado/' + periodo + '/' + anio + '/' + mes;
	
}


function descargarPdf(){

	var periodo = $('#id_periodo_bus').val();
	var anio = $('#anio').val();
	var mes = $('#mes').val();

	if (periodo == "")periodo = 0;
	if (anio == "")anio = 0;
	if (mes == "")mes = 0;

	var href = '/planilla/ver_planilla_delegado_pdf/' + periodo + '/' + anio + '/' + mes;
	window.open(href, '_blank');

}

