
$(document).ready(function () {
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});

	$('#frmCodigoRU #numero_cap_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#frmCodigoRU #agremiado_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#frmCodigoRU #codigo_itf_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#frmCodigoRU #codigo_ru_bus').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#frmCodigoRU #estado').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
	});

	$('#btnDescargar').on('click', function () {
		DescargarArchivosRU()

	});
		
	$('#btnNuevo').click(function () {
		//modalProfesion(0);
		generar_codigo_ru();
	});

	$('#numero_documento').blur(function() {
		var id = $('#id').val();
		if (id == 0) {
			obtener_agremiado(this.value);
		}
	});
		
	datatablenew();
	
});

function generar_codigo_ru(){
    
	//var id_concurso_inscripcion = $("#id_concurso_inscripcion").val();
	var _token = $("#_token").val();
	var numero_cap = $("#numero_cap").val();

	if($("#codigo_itf").val()==''){
		bootbox.alert('Debe ingresar un codigo ITF');
	}else{

		$.ajax({
				url: "/revisorUrbano/send_revisor_urbano",
				type: "POST",
				dataType: "json",
				data : $("#frmRevisorUrbano").serialize()+"&_token="+_token+"&numero_cap="+numero_cap,
				success: function (result) {
						var mensaje = result.mensaje;
						
						if(mensaje!=""){
							bootbox.alert(mensaje);
							return false;
						}
						$("#codigo_itf").val("");
						$("#numero_cap").val("");
						
						datatablenew();
						limpiar()
						//cargarRequisitos(id_concurso_inscripcion);
						//editarConcursoInscripcion(id_concurso_inscripcion);
				}
		});
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
		url: '/agremiado/obtener_datos_agremiado_revisor_urbano/' + numero_cap,
		dataType: "json",
		success: function(result){
			//$('#frmRevisorUrbano #codigo_itf')=="";
			var agremiado = result.agremiado;
			var sw1 = result.sw;
			
			if(agremiado!="0")
			{

				if(agremiado.situacion==73)
				{
					//var tipo_documento = parseInt(agremiado.tipo_documento);
					//var nombre = persona.apellido_paterno+" "+persona.apellido_materno+", "+persona.nombres;
					$('#id_tipo_documento').val(agremiado.tipo_documento);
					$('#numero_documento').val(agremiado.numero_documento);
					$('#apellido_paterno').val(agremiado.apellido_paterno);
					$('#apellido_materno').val(agremiado.apellido_materno);
					$('#nombres').val(agremiado.nombres);
					$('#numero_regional').val(agremiado.numero_regional);
					$('#id_regional').val(agremiado.regional);
					$('#fecha_colegiado').val(agremiado.fecha_colegiado);
					$('#id_ubicacion').val(agremiado.ubicacion);
					$('#id_situacion').val(agremiado.situacion);
					$('#frmRevisorUrbano #codigo_itf').val("");
					//$('#telefono').val(persona.telefono);
					//$('#email').val(persona.email);
					
					$('.loader').hide();
				}else
				{
					if(agremiado.situacion==74){
						msg += "El Agremiado esta INHABILITADO <br>";
					}else if(agremiado.situacion==83){
						msg += "El Agremiado esta FALLECIDO <br>";
					}else if(agremiado.situacion==265){
						msg += "El Agremiado pertenece a otra REGIONAL <br>";
					}else if(agremiado.situacion==266){
						msg += "El Agremiado esta en otra PROVINCIA <br>";
					}else if(agremiado.situacion==267){
						msg += "El Agremiado esta en el EXTRANJERO <br>";
					}
					
					$('.loader').hide();
					$('#id_tipo_documento').val(agremiado.tipo_documento);
					$('#numero_documento').val(agremiado.numero_documento);
					$('#apellido_paterno').val(agremiado.apellido_paterno);
					$('#apellido_materno').val(agremiado.apellido_materno);
					$('#nombres').val(agremiado.nombres);
					$('#numero_regional').val(agremiado.numero_regional);
					$('#id_regional').val(agremiado.regional);
					$('#fecha_colegiado').val(agremiado.fecha_colegiado);
					$('#id_ubicacion').val(agremiado.ubicacion);
					$('#id_situacion').val(agremiado.situacion);
					$('#frmRevisorUrbano #codigo_itf').val("");
				}
			}else{
				msg += "El Agremiado no existe <br>";
				$('.loader').hide();
				
			}

			if (msg != "") {
				bootbox.alert(msg);
				$('#frmRevisorUrbano #codigo_itf').val("");
				return false;
			}

		}
		
	});
	
}

function limpiar()
{
	$('#frmAfiliacion #id').val("0");
	$('#frmAfiliacion #id_tipo_documento').val("");
	$('#frmAfiliacion #numero_documento').val("");
	$('#frmAfiliacion #apellido_paterno').val("");
	$('#frmAfiliacion #apellido_materno').val("");
	$('#frmAfiliacion #nombres').val("");
	$('#frmAfiliacion #numero_regional').val("");
	$('#frmAfiliacion #id_regional').val("");
	$('#frmAfiliacion #fecha_colegiado').val("");
	$('#frmAfiliacion #id_ubicacion').val("");
	$('#frmAfiliacion #id_situacion').val("");
}

function datatablenew(){
    var oTable1 = $('#tblAfiliado').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/revisorUrbano/listar_revisorUrbano_ajax",
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
			
			var numero_cap = $('#frmCodigoRU #numero_cap_bus').val();
			var agremiado = $('#frmCodigoRU #agremiado_bus').val();
			var codigo_itf = $('#frmCodigoRU #codigo_itf_bus').val();
			var codigo_ru = $('#frmCodigoRU #codigo_ru_bus').val();
			var estado = $('#frmCodigoRU #estado').val();
			var situacion_pago = $('#frmCodigoRU #situacion_pago').val();
			if(situacion_pago=="")
			{ 
				situacion_pago = situacion_pago
			}else if(situacion_pago=="0"){
				situacion_pago = "PE";
			}
			else if(situacion_pago=="1"){
				situacion_pago = "P";
			}
			else if(situacion_pago=="2"){
				situacion_pago = "E";
			}
			else if(situacion_pago=="3"){
				situacion_pago = "A";
			}
			var _token = $('#frmCodigoRU #_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						numero_cap:numero_cap,agremiado:agremiado,codigo_itf:codigo_itf,codigo_ru:codigo_ru,situacion_pago:situacion_pago,
						estado:estado,_token:_token
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
					var fecha_colegiado = "";
					if(row.fecha_colegiado!= null)fecha_colegiado = row.fecha_colegiado;
					return fecha_colegiado;
				},
				"bSortable": false,
				"aTargets": [2],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var situacion = "";
					if(row.situacion!= null)situacion = row.situacion;
					return situacion;
				},
				"bSortable": false,
				"aTargets": [3],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var codigo_itf = "";
					if(row.codigo_itf!= null)codigo_itf = row.codigo_itf;
					return codigo_itf;
				},
				"bSortable": false,
				"aTargets": [4],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var codigo_ru = "";
					if(row.codigo_ru!= null)codigo_ru = row.codigo_ru;
					return codigo_ru;
				},
				"bSortable": false,
				"aTargets": [5],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var fecha = "";
					if(row.fecha!= null)fecha = row.fecha;
					return fecha;
				},
				"bSortable": false,
				"aTargets": [6],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var serie = "";
					if(row.serie!= null)serie = row.serie;
					return serie;
				},
				"bSortable": false,
				"aTargets": [7],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var numero = "";
					if(row.numero!= null)numero = row.numero;
					return numero;
				},
				"bSortable": false,
				"aTargets": [8],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var situacion_pago = "";
					//if(row.situacion_pago!= null){
						if(row.situacion_pago=="P"){
							situacion_pago = "PAGADO"
						} else if (row.situacion_pago=="E"){
							situacion_pago = "EXONERADO"
						}
						else if (row.situacion_pago=="A"){
							situacion_pago = "ANULADO"
						}else if (row.situacion_pago=="PE"){
							situacion_pago = "PENDIENTE"
						}
					//}else{
					//}
					return situacion_pago;
				},
				"bSortable": false,
				"aTargets": [9],
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
				"aTargets": [10]
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
					//html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalProfesion('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					if (row.situacion_pago != 'C') {
						html += '<a href="javascript:void(0)" onclick=eliminarRevisorUrbano('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					}else{
						html += '<a href="javascript:void(0)" onclick=eliminarRevisorUrbano('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px; pointer-events: none; opacity: 0.6; cursor: not-allowed;">'+estado+'</a>';
					}
					html += '</div>';
					return html;
					},
					"bSortable": false,
					"aTargets": [11],
				},
            ]
    });
}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalProfesion(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/profesion/modal_profesion_nuevoProfesion/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function eliminarRevisorUrbano(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" el registro del codigo de RU?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_revisor_urbano(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_revisor_urbano(id,estado){
	
    $.ajax({
            url: "/revisorUrbano/eliminar_revisor_urbano/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

function DescargarArchivosRU(){
		
	var numero_cap = $('#numero_cap_bus').val();
	var agremiado = $('#agremiado_bus').val();
	var codigo_itf = $('#codigo_itf_bus').val();
	var codigo_ru = $('#codigo_ru_bus').val();
	var situacion_pago = $('#situacion_pago').val();
	var estado = $('#estado').val();
	//var id_agremiado = 0;
	//var id_regional = 0;
	if (numero_cap == "")numero_cap = 0;
	if (agremiado == "")agremiado = 0;
	if (codigo_itf == "")codigo_itf = 0;
	if (codigo_ru == "")codigo_ru = 0;
	if (situacion_pago == "")situacion_pago = 9;
	if (estado == "")estado = 0;
	//if (campo == "")campo = 0;
	//if (orden == "")orden = 0;
	
	
	location.href = '/revisorUrbano/exportar_listar_revisor_urbano/'+numero_cap+'/'+agremiado+'/'+codigo_itf+'/'+codigo_ru+'/'+situacion_pago+'/'+estado;
}

