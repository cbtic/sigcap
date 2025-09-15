//alert("ok");
//jQuery.noConflict(true);


$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#denominacion_muni').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});
	
	$('#tipo_afectacion').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});

	$('#partida_presupuestalBus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
		}
	});
		
	$('#btnNuevo').click(function () {
		//modalComision(0);
		fn_guardar();
	});
	
	$('#btnCerrarComision').click(function () {
		fn_cerrar_comision();
	});

	$('#btnNuevoComision').click(function () {
		var tipo_comision = $("#tipo_comision").val();
		if(tipo_comision==2)fn_guardarMunicipalidadIntegrada();
		else modalDiaSemana(0);
		//fn_guardarMunicipalidadIntegrada();
	});
	
	//datatablenew();
	cargarMunicipalidades();

	//cargarMunicipalidadesIntegradas();
	//cargarComisiones();

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

function obtenerPeriodo(){

	var periodo=$("#periodo").val();
	if(periodo!=""){
		cargarMunicipalidadesIntegradas();	
	}

}

function obtenerTipoComision(){
	
	var tipo_comision=$("#tipo_comision").val();
	if(tipo_comision!=""){
		cargarComisiones();	
	}
}


function habiliarTitular(){
	/*
	$('#divTitular').hide();
	if(!$("#chkTitular").is(':checked')) {
    	$('#divTitular').show();
	}
	*/
}

function cargarMunicipalidades(){

	$.ajax({
			url: "/comision/obtener_municipalidades/",
			type: "GET",
			success: function (result) {  
			
					$('#tblMunicipalidad').dataTable().fnDestroy(); //la destruimos
					$("#tblMunicipalidad tbody").html("");
					
					$("#tblMunicipalidad tbody").html(result);
					//alert("ok");
					$('#tblMunicipalidad').DataTable({
						"paging":false,
						"dom": '<"top">rt<"bottom"flpi><"clear">',
						"language": {"url": "/js/Spanish.json"},
					});
					
					$("#system-search").keyup(function() {
						var dataTable = $('#tblMunicipalidad').dataTable();
					   dataTable.fnFilter(this.value);
					});
					
			}
	});

}

function cargarMunicipalidadesIntegradas(){
    
	//$('#tblMunicipalidadIntegrada').dataTable().fnDestroy(); //la destruimos
	//$("#tblMunicipalidadIntegrada tbody").html("");
	var periodo = $("#frmAfiliacion #periodo").val();
	var tipo_agrupacion = $("#tipo_agrupacion").val();
	var tipo_comision = $("#frmAfiliacion #tipo_comision").val();
	if(tipo_comision=="")tipo_comision="0";
	
	$.ajax({
			url: "/comision/obtener_municipalidadesIntegradas/"+periodo+"/"+tipo_agrupacion+"/"+tipo_comision,
			type: "GET",
			success: function (result) {
					$('#tblMunicipalidadIntegrada').dataTable().fnDestroy(); //la destruimos
					$("#tblMunicipalidadIntegrada tbody").html("");

					$("#tblMunicipalidadIntegrada tbody").html(result);
					
					$('#tblMunicipalidadIntegrada').DataTable({
						"paging":false,
						"dom": '<"top">rt<"bottom"flpi><"clear">',
						"language": {"url": "/js/Spanish.json"},
					});

					$("#system-search2").keyup(function() {
						var dataTable = $('#tblMunicipalidadIntegrada').dataTable();
					   dataTable.fnFilter(this.value);
					});
					
			}
	});

	
}

function modalMunicipalidadIntegrada(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/comision/modal_municipalidadesIntegrada/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function cargarComisiones(){
	
	var periodo = $("#frmAfiliacion #periodo").val();
	var cad_id = $("#cad_id").val();
	if(cad_id=="")cad_id="0";

	var estado = $("#estado").val();
	var tipo_comision = $("#frmAfiliacion #tipo_comision").val();
	
	$.ajax({
			url: "/comision/obtener_comision/"+periodo+"/"+tipo_comision+"/"+cad_id+"/"+estado,
			type: "GET",
			success: function (result) {  
			
					$('#tblComision').dataTable().fnDestroy(); //la destruimos
					$("#tblComision tbody").html("");
					
					$("#tblComision tbody").html(result);
					//alert("ok");
					$('#tblComision').DataTable({
						"paging":false,
						"dom": '<"top">rt<"bottom"flpi><"clear">',
						"language": {"url": "/js/Spanish.json"},
					});
					
					$("#system-search3").keyup(function() {
						var dataTable = $('#tblComision').dataTable();
					   dataTable.fnFilter(this.value);
					});
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

function fn_save_fila(id,id_municipalidad){
 
	var _token = $('#_token').val();
	
	var mov = $('.mov:checked').length;

	var id_municipalidad = $('#id_municipalidad').val();
	//var id_agremiado = $('#id_agremiado').val();
	var id_plan = $('#id_plan').val();

	if(mov=="0")msg+="Debe seleccionar por lo menos a una municipalidad <br>";

    $.ajax({
			url: "/comision/send_parentesco_fila",
            type: "POST",
            data : {_token:_token,id:id,idafiliacion:idafiliacion,id_agremiado:id_agremiado,idfamilia:idfamilia},
			success: function (result) {
				//$('#openOverlayOpc').modal('hide');
				Plan();
				limpiar();
								
            }
    });
	
}

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/comision/listar_comision_ajax",
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
			var denominacion = $('#denominacion_muni').val();
			var tipo_municipalidad = $('#tipo_municipalidad').val();
			var estado = $('#estado').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                //"contentType": "application/json; charset=utf-8",
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						id:id,denominacion:denominacion,tipo_municipalidad:tipo_municipalidad,estado:estado,
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
						
						var html = '<div class="form-check form-switch">';
						html += '<input class="form-check-input" value="'+row.id+'"  onclick=fn_save_fila('+row.id+','+ row.id_familia +') type="checkbox" role="switch" id="check_" name="check_[]">';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [0],
				},
				{
                "mRender": function (data, type, row) {
                	var denominacion = "";
					if(row.denominacion!= null)denominacion = row.denominacion;
					return denominacion;
                },
                "bSortable": false,
                "aTargets": [1]
                },

				{
				"mRender": function (data, type, row) {
					var tipo_municipalidad = "";
					if(row.tipo_municipalidad!= null)tipo_municipalidad = row.tipo_municipalidad;
					return tipo_municipalidad;
				},
				"bSortable": false,
				"aTargets": [2]
				},
				{
					"mRender": function (data, type, row) {
						var monto = "";
						if(row.monto!= null)monto = row.monto;
						return monto;
					},
					"bSortable": false,
					"aTargets": [3]
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
				"aTargets": [2]
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
						html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalConcepto('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
						html += '<a href="javascript:void(0)" onclick=eliminarConcepto('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
						
						//html += '<a href="javascript:void(0)" onclick=modalResponsable('+row.id+') class="btn btn-sm btn-info" style="font-size:12px;margin-left:10px">Detalle Responsable</a>';
						
						html += '</div>';
						return html;
					},
					"bSortable": false,
					"aTargets": [9],
				},*/

            ]

    });

}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalDiaSemana(id){
	
	$(".modal-dialog").css("width","40%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/comision/modalDiaSemana/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});
}

function filtrar_comision(obj){

	//alert("ok");
	if($(obj).is(':checked')){

		var cad_id="";
		$("#tblMunicipalidadIntegrada input[name^='check_[]']:checked").each(function (i){
			var id = $(this).val();
			cad_id += ","+id;
		});

		if(cad_id!="")cad_id=cad_id.substring(1);

		$("#cad_id").val(cad_id);

		cargarComisiones();
	}else{
		
		var cad_id="";
		$("#tblMunicipalidadIntegrada input[name^='check_[]']:checked").each(function (i){
			var id = $(this).val();
			cad_id += ","+id;
		});

		if(cad_id!="")cad_id=cad_id.substring(1);
		$("#cad_id").val(cad_id);

		cargarComisiones();
		
	}

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

function eliminarMuniIntegrada(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Municipalidad Integrada?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_muniIntegrada(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function eliminarComision(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Comisi&oacute;n?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_comision(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}


function fn_eliminar_muniIntegrada(id,estado){
	
	/*
	var periodo = $("#frmAfiliacion #periodo").val();
	var cad_id = $("#cad_id").val();
	if(cad_id=="")cad_id="0";

	var estado = $("#estado").val();
	var tipo_comision = $("#frmAfiliacion #tipo_comision").val();
	*/
    $.ajax({
            url: "/comision/eliminar_muniIntegrada/"+id+"/"+estado,
            type: "GET",
			dataType: 'json',
            success: function (result) {
				if(result.msg!=""){
					bootbox.alert(result.msg);
					return false;	
				}
                //if(result="success")obtenerPlanDetalle(id_plan);
				datatablenew();
				cargarMunicipalidadesIntegradas();
            }
    });
}

function fn_eliminar_comision(id,estado){
	
    $.ajax({
            url: "/comision/eliminarComision/"+id+"/"+estado,
            type: "GET",
			dataType: 'json',
            success: function (result) {
                //if(result="success")obtenerPlanDetalle(id_plan);
				if(result.msg!=""){
					bootbox.alert(result.msg);
					return false;	
				}
				datatablenew();
				cargarComisiones();
            }
    });
}

function fn_guardar(){

	var msg = "";
    var periodo = $("#periodo").val();
	var tipo_comision = $("#tipo_comision").val();
	
	if(periodo=="")msg += "Debe seleccionar un periodo<br>";
	if(tipo_comision=="")msg += "Debe seleccionar un tipo de comision<br>";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
    $.ajax({
			url: "/comision/send_comision",
            type: "POST",
            data : $("#frmComision").serialize()+"&periodo="+periodo+"&tipo_comision="+tipo_comision,
			dataType: 'json',
            success: function (result) {
				
					if(result.obs!=""){

						//bootbox.alert("Las Municipalidad "+result.obs+" ya tiene una comisi&oacute;n registrada");
						//return false;

						bootbox.confirm({ 
							size: "small",
							message: "Las Municipalidad "+result.obs+" ya tiene una comisi&oacute;n registrada, desea volver a registrar", 
							callback: function(result){
								if (result==true) {
									fn_guardar_nuevo();
								}
							}
						});


					}else{

						cargarMunicipalidades();
						cargarMunicipalidadesIntegradas();
						cargarComisiones();

					}	
				
					
				if(result.sw=='false'){
					Swal.fire("El RUC ingresado ya existe !!!")
				}
					
            }
    });
}

function fn_guardar_nuevo(){

	var msg = "";
    var periodo = $("#periodo").val();
	var tipo_comision = $("#tipo_comision").val();
	
	if(periodo=="")msg += "Debe seleccionar un periodo<br>";
	if(tipo_comision=="")msg += "Debe seleccionar un tipo de comision<br>";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
    $.ajax({
			url: "/comision/send_comision_nuevo",
            type: "POST",
            data : $("#frmComision").serialize()+"&periodo="+periodo+"&tipo_comision="+tipo_comision,
			dataType: 'json',
            success: function (result) {
				
					/*
					if(result.obs!=""){

						bootbox.alert("Las Municipalidad "+result.obs+" ya tiene una comisi&oacute;n registrada");
						return false;

					}
					*/
				
					cargarMunicipalidades();
					cargarMunicipalidadesIntegradas();
					cargarComisiones();
						
            }
    });
}



function fn_guardarMunicipalidadIntegrada(){

	var tipo_comision=$("#tipo_comision").val();
	var dia_semana = $('#dia_semana').val();
	
    $.ajax({
			url: "/comision/send_municipalidad_integrada",
            type: "POST",
            data : $("#frmComision").serialize()+"&tipo_comision="+tipo_comision+"&dia_semana="+dia_semana,
            success: function (result) {  
					//datatablenew();
				cargarMunicipalidades();
				cargarMunicipalidadesIntegradas();
				cargarComisiones();
				$('#openOverlayOpc').modal('hide');
            }
    });
}


function modalAsignarDelegado(id){
	
	//var id = 0;
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/comision/modal_asignar_delegado_comision/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function fn_cerrar_comision(){

	var periodo = $("#frmAfiliacion #periodo").val();
	var tipo_comision=$("#frmAfiliacion #tipo_comision").val();
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
    $.ajax({
			url: "/comision/send_asignar_agremiado_rol",
            type: "POST",
            data : $("#frmComision").serialize()+"&periodo="+periodo+"&tipo_comision="+tipo_comision,
            success: function (result) {  
				bootbox.alert("Se cerro correctamente la asignaci&oacute;n de plaza"); 
				cargarMunicipalidades();
				cargarMunicipalidadesIntegradas();
				cargarComisiones();
				$('#openOverlayOpc').modal('hide');
				$('.loader').hide();
				return false;
            }
    });
}

function eliminarMunicipalidadDetalle(id){
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas Eliminar la Municipalidad del detalle?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_municipalidad_detalle(id);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_municipalidad_detalle(id){
	
    $.ajax({
            url: "/comision/eliminar_municipalidad_detalle/"+id,
            type: "GET",
            success: function (result) {
				cargarMunicipalidadDetalle();
				limpiar();
				
				obtenerPeriodo();
				obtenerTipoComision();
                
				//datatablenew();
				//cargarMunicipalidadesIntegradas();
            }
    });
}

