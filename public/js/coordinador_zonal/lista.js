//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {
	$("#id_municipalidad_bus").select2({ width: '100%' });
	//alert("cc");
	$(".upload").on('click', function() {
		//alert("okkk");
		/*
		var formData = new FormData();
		var files = $('#image')[0].files[0];
		formData.append('file',files);
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "/ingreso_vehiculo_tronco/upload_imagen_ingreso",
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response) {
				
				var ind_img = $("#ind_img").val();
				
				if (response != 0) {
					$("#img_ruta_"+ind_img).attr("src", "/img/ingreso/tmp/"+response).show();
					$(".delete_ruta").show();
					$("#img_foto_"+ind_img).val(response);

					ind_img++;

					var newRow = "";
					newRow += '<div class="img_ruta">';
					newRow += '<img src="" id="img_ruta_'+ind_img+'" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px;display:none;margin-left:10px" />';
					newRow += '<span class="delete_ruta" style="display:none" onclick="DeleteImagen(this)"></span>';
					newRow += '<input type="hidden" id="img_foto_'+ind_img+'" name="img_foto[]" value="" />';
					newRow += '</div>';

					$("#divImagenes").append(newRow);
					$("#ind_img").val(ind_img);

				} else {
					alert('Formato de imagen incorrecto.');
				}
				
			}
		});
		return false;
		*/
	});

	$('#agremiado_2').keypress(function(e){
		if(e.which == 13) {
		datatablenew2();
	}
	});
	
	$('#mes_').keypress(function(e){
		if(e.which == 13) {
		datatablenew2();
	}
	});
	
	$('#id_estado_aprobacion_bus').keypress(function(e){
		if(e.which == 13) {
		datatablenew2();
	}
	});

	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#btnBuscar_').click(function () {
		fn_ListarBusqueda_();
	});

	$('#btnBuscarZonal').click(function () {
		fn_ListarBusqueda3();
	});

	$('#agremiado').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#periodo_').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#numero_cap_').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#agremiado_').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#estado_').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#numero_cap').keypress(function(e){
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
		
	$('#btnNuevo').click(function () {
		GuardarCoordinadorZonal(0);
	});

	$('#btnNuevoZonal').click(function () {
		modalZonalDetalle(0);
	});
		
	datatablenew();
	datatablenew2();
	datatablenew3();
	/*	
	$("#plan_id").select2();
	$("#ubicacion_id").select2();
	
	$('#fecha_inicio').datepicker({
        autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
    });
	
	//$("#fecha_vencimiento").datepicker($.datepicker.regional["es"]);
	$('#fecha_vencimiento').datepicker({
        autoclose: true,
        dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
    });
	*/
	
	/*
    $('#tblAlquiler').dataTable({
    	"language": {
    	"emptyTable": "No se encontraron resultados"
    	}
	});
	*/
	/*
	$('#tblAlquiler').dataTable( {
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningun dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "ultimo",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                },
                "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        } );
	*/


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

function habiliarTitular(){
	/*
	$('#divTitular').hide();
	if(!$("#chkTitular").is(':checked')) {
    	$('#divTitular').show();
	}
	*/
}

function guardarSesion(){

    $.ajax({
			url: "/coordinador_zonal/send_coordinador_sesion",
            type: "POST",
            //data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmCoordinador").serialize(),
            success: function (result) {				

				//alert(result);
								
				$('#openOverlayOpc').modal('hide');

				cargarValorizacion();

				//var jsondata = JSON.parse(result);

				//alert(jsondata[0].idcomprobante);
				//$('#idsolicitud').val(jsondata[0].idcomprobante);
					
            }
    });
}

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
	/*
	if($('input[name=horario]').is(':checked')==true){
		var horario = $('input[name=horario]:checked').val();
		var data = horario.split("#");
		var fecha_cita = data[0];
		var id_medico = data[1];
	}
	*/

	
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
        fn_save();
	}
	
	//fn_save();
}

function fn_save___(){
    
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

function validaTipoDocumento(){
	var tipo_documento = $("#tipo_documento").val();
	$('#nombre_afiliado').val("");
	$('#empresa_afiliado').val("");
	$('#empresa_direccion').val("");
	$('#empresa_representante').val("");
	$('#codigo_afiliado').val("");	
	$('#fecha_afiliado').val("");
				
	if(tipo_documento == "RUC"){
		$('#divNombreApellido').hide();
		$('#divCodigoAfliado').hide();
		$('#divFechaAfliado').hide();
		$('#divDireccionEmpresa').show();
		$('#divRepresentanteEmpresa').show();
	}else{
		$('#divNombreApellido').show();
		$('#divCodigoAfliado').show();
		$('#divFechaAfliado').show();
		$('#divDireccionEmpresa').hide();
		$('#divRepresentanteEmpresa').hide();
	}
}

function obtenerAgremiado(){
		
	var numero_cap = $("#numero_cap").val();
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
		url: '/agremiado/obtener_datos_agremiado/' + numero_cap,
		dataType: "json",
		success: function(result){
			
			var agremiado = result.agremiado;
			//var tipo_documento = parseInt(agremiado.tipo_documento);
			//var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
			$('#dni').val(agremiado.numero_documento);
			$('#apellido_paterno').val(agremiado.apellido_paterno);
			$('#apellido_materno').val(agremiado.apellido_materno);
			$('#nombre').val(agremiado.nombres);
			//$('#telefono').val(persona.telefono);
			//$('#email').val(persona.email);
			
			$('.loader').hide();

		}
		
	});
	
}

function obtenerAgremiadoCoordinador(){
		
	var numero_cap = $("#frmAfiliacion #numero_cap").val();
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
			$('#frmAfiliacion #dni').val(agremiado.numero_documento);
			$('#frmAfiliacion #apellido_paterno').val(agremiado.apellido_paterno);
			$('#frmAfiliacion #apellido_materno').val(agremiado.apellido_materno);
			$('#frmAfiliacion #nombre').val(agremiado.nombres);
			//$('#telefono').val(persona.telefono);
			//$('#email').val(persona.email);
			
			$('.loader').hide();

		}
		
	});
	
}

/*function AddFila(){
	
	var newRow = "";
	var ind = $('#tblSesion tbody tr').length;
	var newRow = $('<tr>');

	newRow.append('<td>Cell 1 Data</td>');
    newRow.append('<td>Cell 2 Data</td>');

	$('#tblSesion tbody').append(newRow);
}*/


function obtenerEmpresa(){
		
	var _id = $("#id").val();	
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	//$('#empresa_id').val("");
	$('#empresa_id').val("");
	
	$.ajax({
		url: '/empresa/obtener_empresa/' + _id,
		dataType: "json",
		success: function(result){
			//var nombre_persona= result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			//$('#nombre_persona').val(nombre_persona);
			$('#empresa_id').val(result.empresa.id);

		},
		error: function(data) {
			alert("Empresa no encontrada en la Base de Datos.");
			$('#empresaModal').modal('show');
		}
		
	});
	
}

function obtenerTitularActual(tipo_documento,numero_documento){
		
	//var tipo_documento = $("#tipo_documento_tit").val();
	//var numero_documento = $("#numero_documento_tit").val();
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	//$('#empresa_id').val("");
	$('#titular_id').val("");
	
	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var nombre_titular = result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#nombre_titular').val(nombre_titular);
			$('#titular_id').val(result.persona.id);
		},
		error: function(data) {
			alert("Persona no encontrada en la Base de Datos.");
			$('#personaTitularModal').modal('show');
		}
		
	});
	
}

function obtenerTitular(){
		
	var tipo_documento = $("#tipo_documento_tit").val();
	var numero_documento = $("#numero_documento_tit").val();
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	//$('#empresa_id').val("");
	$('#titular_id').val("");
	
	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var nombre_titular = result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#nombre_titular').val(nombre_titular);
			$('#titular_id').val(result.persona.id);
		},
		error: function(data) {
			alert("Persona no encontrada en la Base de Datos.");
			$('#personaTitularModal').modal('show');
		}
		
	});
	
}

function obtenerPlanDetalle(){
	
	var plan_costo = $('#plan_id option:selected').attr("plan_costo");
	var periodo = $('#plan_id option:selected').attr("periodo");
	$('#plan_costo').val(plan_costo);
	$('#periodo').val(periodo);
	
	var id = $('#plan_id').val();
	$.ajax({
		url: '/supervision/obtener_plan_detalle/'+id,
		dataType: "json",
		success: function(result){
			//var productos = result.productos;
			var option = "";
			$('#tblPlan tbody').html("");
			$(result).each(function (ii, oo) {
				option += "<tr style='font-size:13px'><td class='text-left'>"+oo.pasm_smodulod+"</td><td class='text-left'>"+oo.pasm_precio+"</td></tr>";
			});
			$('#tblPlan tbody').html(option);
		}
		
	});
	
}

/*
function cargarAlquiler(){
    
    var empresa_id = $('#empresa_id').val();
	if(empresa_id == "")empresa_id=0;
	
    $("#tblAlquiler tbody").html("");
	$.ajax({
			url: "/alquiler/obtener_alquiler/"+empresa_id,
			type: "GET",
			success: function (result) {  
					$("#tblAlquiler tbody").html(result);
					//$('#tblAlquiler').dataTable();
			}
	});

}


function cargarDevolucion(){
    
    
    var numero_documento = $("#numero_documento").val();
    $("#tblPago tbody").html("");
	$.ajax({
			url: "/alquiler/obtener_devolucion/"+numero_documento,
			type: "GET",
			success: function (result) {  
					$("#tblDevolucion tbody").html(result);
			}
	});

}
*/


$('#modalEmpresaSaveBtn').click(function (e) {
	e.preventDefault();
	$(this).html('Enviando datos..');

	$.ajax({
	  data: $('#modalEmpresaForm').serialize(),
	  url: "/afiliacion/nueva_inscripcion_ajax",
	  type: "POST",
	  dataType: 'json',
	  success: function (data) {

		  $('#modalEmpresaForm #modalEmpresaForm').trigger("reset");
		  $('#personaModal').modal('hide');
		  $('#numero_documento').val(data.numero_documento);
		  $('#nombre_persona').val(data.nombre_apellido);

		  alert("La persona ha sido ingresada correctamente!");

	  },
	  error: function(data) {
	mensaje = "Revisar el formulario:\n\n";
	$.each( data["responseJSON"].errors, function( key, value ) {
	  mensaje += value +"\n";
	});
	$("#modalEmpresaForm #modalEmpresaSaveBtn").html("Grabar");
	alert(mensaje);
  }
  });
});

$('#modalEmpresaTitularSaveBtn').click(function (e) {
	e.preventDefault();
	$(this).html('Enviando datos..');

	$.ajax({
	  data: $('#modalEmpresaTitularForm').serialize(),
	  url: "/afiliacion/nueva_inscripcion_ajax",
	  type: "POST",
	  dataType: 'json',
	  success: function (data) {

		  $('#modalEmpresaTitularForm #modalEmpresaForm').trigger("reset");
		  $('#personaTitularModal').modal('hide');
		  $('#numero_documento_tit').val(data.numero_documento);
		  $('#nombre_titular').val(data.nombre_apellido);

		  alert("La persona ha sido ingresada correctamente!");

	  },
	  error: function(data) {
	mensaje = "Revisar el formulario:\n\n";
	$.each( data["responseJSON"].errors, function( key, value ) {
	  mensaje += value +"\n";
	});
	$("#modalEmpresaTitularForm  #modalEmpresaSaveBtn").html("Grabar");
	alert(mensaje);
  }
  });
});


function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/coordinador_zonal/listar_coordinadorZonal_ajax",
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
			var periodo = $('#periodo_').val();
			var numero_cap = $('#numero_cap_').val();
            var agremiado = $('#agremiado_').val();
			var id_municipalidad = $('#id_municipalidad_bus').val();
			var estado = $('#estado_').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,periodo:periodo,numero_cap:numero_cap,agremiado:agremiado,id_municipalidad:id_municipalidad,estado:estado,
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
					var zonal = "";
					if(row.zonal!= null)zonal = row.zonal;
					return zonal;
				},
				"bSortable": false,
				"aTargets": [3]
				},
				{
				"mRender": function (data, type, row) {
					var municipalidad = "";
					if(row.municipalidad!= null)municipalidad = row.municipalidad;
					return municipalidad;
				},
				"bSortable": false,
				"aTargets": [4]
				},
				{
				"mRender": function (data, type, row) {
					var estado_coordinador = "";
					if(row.estado_coordinador!= null)estado_coordinador = row.estado_coordinador;
					return estado_coordinador;
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarCoordinadorZonal('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=modalCoordinadorZonal('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Registrar sesi&oacute;n</a>';
					html += '<a href="javascript:void(0)" onclick=eliminarCoordinadorZonal('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [6],
				},

            ]
    });

}

function datatablenew2(){
    var oTable1 = $('#tblCoordinadorSesion').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/coordinador_zonal/listar_coordinadorZonalSesion_ajax",
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
			var periodo = $('#periodo_2').val();
			var agremiado = $('#agremiado_2').val();
			var mes = $('#mes_').val();
			var estado_aprobado = $('#id_estado_aprobacion_bus').val();
			var fecha_inicio_bus = $('#fecha_inicio_bus').val();
			var fecha_fin_bus = $('#fecha_fin_bus').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,periodo:periodo,agremiado:agremiado,mes:mes,estado_aprobado:estado_aprobado,estado:estado,
						fecha_inicio_bus:fecha_inicio_bus,fecha_fin_bus:fecha_fin_bus,_token:_token
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
				//"className": 'control'
                },
                {
                "mRender": function (data, type, row) {
                	var tipo_comision = "";
					if(row.tipo_comision!= null)tipo_comision = row.tipo_comision;
					return tipo_comision;
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
				"aTargets": [2]
				},
				{
					"mRender": function (data, type, row) {
						var comision = "";
						if(row.comision!= null)comision = row.comision;
						return comision;
					},
					"bSortable": false,
					"aTargets": [3]
				},
				{
					"mRender": function (data, type, row) {
						var fecha_programado = "";
						if(row.fecha_programado!= null)fecha_programado = row.fecha_programado;
						return fecha_programado;
					},
					"bSortable": false,
					"aTargets": [4]
				},
				{
					"mRender": function (data, type, row) {
						var fecha_ejecucion = "";
						if(row.fecha_ejecucion!= null)fecha_ejecucion = row.fecha_ejecucion;
						return fecha_ejecucion;
					},
					"bSortable": false,
					"aTargets": [5]
				},
				{
					"mRender": function (data, type, row) {
						var tipo_programacion = "";
						if(row.tipo_programacion!= null)tipo_programacion = row.tipo_programacion;
						return tipo_programacion;
					},
					"bSortable": false,
					"aTargets": [6]
				},
				{
					"mRender": function (data, type, row) {
						var estado_sesion = "";
						if(row.estado_sesion!= null)estado_sesion = row.estado_sesion;
						return estado_sesion;
					},
					"bSortable": false,
					"aTargets": [7]
				},
				{
					"mRender": function (data, type, row) {
						var estado_aprobacion = "";
						if(row.estado_aprobacion!= null)estado_aprobacion = row.estado_aprobacion;
						return estado_aprobacion;
					},
					"bSortable": false,
					"aTargets": [8]
				},
				{
					"mRender": function (data, type, row) {
						/*var ruta_informe = "";
						if(row.ruta_informe!= null){
							ruta_informe = row.ruta_informe;
							
							//ruta_informe_ = "<button onclick=<a href="/' + ruta + '" target="_blank" class="btn btn-sm btn-secondary">Ver Imagen</a>";
							//ruta_informe_ = '<a href="/' + ruta + '" target="_blank" class="btn btn-sm btn-secondary">Ver Imagen</a>';
						}
						return ruta_informe;*/
						var html = '<div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">';
						
						html += '<button style="font-size:12px;color:#FFFFFF;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="modalVerInforme('+row.id+')"><i class="fa fa-edit" style="font-size:9px!important"></i> Ver Informe</button>';
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [9]
				},
				/*{
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
				},*/
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalEditarCoordinador('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=eliminarComisionSesionDelegado('+row.id+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
					//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
					
					html += '</div>';
					return html;
				},
				"bSortable": false,
				"aTargets": [10],
				},
            ]
    });

}

function datatablenew3(){
    var oTable1 = $('#tblZonal').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/coordinador_zonal/listar_coordinadorZonal_detalle_ajax",
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
			var zonal = $('#zonal').val();
			var estado = $('#estado').val();
			var periodo = $('#id_periodo_bus').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,zonal:zonal,periodo:periodo,estado:estado,
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
				},
				{
                "mRender": function (data, type, row) {
                	var periodo = "";
					if(row.periodo!= null)periodo = row.periodo;
					return periodo;
                },
                "bSortable": false,
                "aTargets": [1],
				"className": "dt-center",
                },
                {
                "mRender": function (data, type, row) {
                	var tipo_coordinador = "";
					if(row.tipo_coordinador!= null)tipo_coordinador = row.tipo_coordinador;
					return tipo_coordinador;
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
				"aTargets": [3]
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="editarZonal('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=eliminarZonalDetalle('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
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

function fn_ListarBusqueda_() {
    datatablenew2();
};

function fn_ListarBusqueda3() {
    datatablenew3();
};

function modalVerInforme(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/coordinador_zonal/modal_informes/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function editarCoordinadorZonal(id){

	$.ajax({
		url: '/coordinador_zonal/obtener_coordinador/'+id,
		dataType: "json",
		success: function(result){
			
			$('#frmAfiliacion #id').val(result.id);
			$('#frmAfiliacion #regional').val(result.id_regional);
			$('#frmAfiliacion #periodo').val(result.id_periodo);
			$('#frmAfiliacion #numero_cap').val(result.numero_cap);
			$('#frmAfiliacion #dni').val(result.numero_documento);
			$('#frmAfiliacion #apellido_paterno').val(result.apellido_paterno);
			$('#frmAfiliacion #apellido_materno').val(result.apellido_materno);
			$('#frmAfiliacion #nombre').val(result.nombres);
			$('#frmAfiliacion #zonal').val(result.id_zonal);
			$('#frmAfiliacion #estado_coordinador').val(result.estado_coordinador);
			
		}
		
	});

}

function modalEditarCoordinador(id){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/coordinador_zonal/modal_coordinadorZonal_editarCoordinadorZonal/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function editarZonal(id){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/coordinador_zonal/modal_zonal_nuevoZonalDetalle/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalCoordinadorZonal(id){
	
	//alert(id);
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/coordinador_zonal/modal_coordinadorZonal_nuevoCoordinadorZonal/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalZonalDetalle(id){
	
	//alert(id);
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/coordinador_zonal/modal_zonal_nuevoZonalDetalle/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function GuardarCoordinadorZonal(){
    
	var _token = $('#_token').val();
	var id = $('#id').val();
	var numero_cap = $('#numero_cap').val();
	var periodo = $('#periodo').val();
	var regional = $('#regional').val();
	var dni = $('#dni').val();
	var apellido_paterno = $('#apellido_paterno').val();
	var apellido_materno = $('#apellido_materno').val();
	var nombre = $('#nombre').val();
	var zonal = $('#zonal').val();
	var estado_coordinador = $('#estado_coordinador').val();
	var zonal_texto = $('#zonal option:selected').text();
	//var moneda = $('#moneda').val();
	//var importe = $('#importe').val();
	//var estado = $('#estado').val();
	//alert(id_agremiado);
	//return false;
	
    $.ajax({
			url: "/coordinador_zonal/send_coordinador_zonal_nuevoCoordinadorZonal",
            type: "POST",
            data : {_token:_token,id:id,numero_cap:numero_cap,periodo:periodo,regional:regional,dni:dni,apellido_paterno:apellido_paterno,apellido_materno:apellido_materno,nombre:nombre,zonal:zonal,estado_coordinador:estado_coordinador,zonal_texto:zonal_texto},
            success: function (result) {
				
				$('#openOverlayOpc').modal('hide');
				//window.location.reload();
				datatablenew();
				limpiar();
				/*
				$('#openOverlayOpc').modal('hide');
				if(result==1){
					bootbox.alert("La persona o empresa ya se encuentra registrado");
				}else{
					window.location.reload();
				}
				*/
            }
    });
}

function limpiar(){
	$("#numero_cap").val("");
	$("#zonal").val("");
	$("#estado_coordinador").val("");
	$("#dni").val("");
	$("#apellido_paterno").val("");
	$("#apellido_materno").val("");
	$("#nombre").val("");
}

function modalDetalle(id){
	
	//alert(id);
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/adelanto/modal_detalle_adelanto/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalResponsable(id){

	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/afiliacion/modal_afiliacion_empresa/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarCoordinadorZonal(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el Coordinador Zonal?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_coordinador_zonal(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_coordinador_zonal(id,estado){

    $.ajax({
            url: "/coordinador_zonal/eliminar_coordinador_zonal/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
				limpiar();
            }
    });
}

function eliminarZonalDetalle(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Municipalidad?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_zonal_detalle(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_zonal_detalle(id,estado){

    $.ajax({
            url: "/coordinador_zonal/eliminar_zonal_detalle/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew3();
				//limpiar();
				//datatableZonalDetalle()
            }
    });
}


function eliminarComisionSesionDelegado(id){
	
	var act_estado = "Eliminar";

    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" la Sesion?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_comision_sesion_delegado(id);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_comision_sesion_delegado(id){
	
    $.ajax({
            url: "/sesion/eliminar_comision_sesion_delegados/"+id,
            type: "GET",
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew2();
            }
    });
}
