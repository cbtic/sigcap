
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

	$('#estado').keypress(function(e){
		if(e.which == 13) {
			datatablenew();
			return false;
		}
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
					//cargarRequisitos(id_concurso_inscripcion);
					//editarConcursoInscripcion(id_concurso_inscripcion);
            }
    });
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
			//$('#telefono').val(persona.telefono);
			//$('#email').val(persona.email);
			
			$('.loader').hide();

		}
		
	});
	
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
			
			var numero_cap = $('#numero_cap').val();
			var situacion = $('#situacion').val();
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						numero_cap:numero_cap,situacion:situacion,
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
                	var agremiado = "";
					if(row.agremiado!= null)agremiado = row.agremiado;
					return agremiado;
                },
                "bSortable": false,
                "aTargets": [0],
				"className": "dt-center",
                },
				{
				"mRender": function (data, type, row) {
					var fecha_colegiado = "";
					if(row.fecha_colegiado!= null)fecha_colegiado = row.fecha_colegiado;
					return fecha_colegiado;
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
				"aTargets": [2],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var codigo_itf = "";
					if(row.codigo_itf!= null)codigo_itf = row.codigo_itf;
					return codigo_itf;
				},
				"bSortable": false,
				"aTargets": [3],
				"className": "dt-center",
				},
				{
				"mRender": function (data, type, row) {
					var codigo_ru = "";
					if(row.codigo_ru!= null)codigo_ru = row.codigo_ru;
					return codigo_ru;
				},
				"bSortable": false,
				"aTargets": [4],
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
					html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalProfesion('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
					html += '<a href="javascript:void(0)" onclick=eliminarProfesion('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
					
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

function eliminarProfesion(id,estado){
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
        message: "&iquest;Deseas "+act_estado+" la Profesion?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_profesion(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_profesion(id,estado){
	
    $.ajax({
            url: "/profesion/eliminar_profesion/"+id+"/"+estado,
            type: "GET",
            success: function (result) {
				datatablenew();
            }
    });
}

