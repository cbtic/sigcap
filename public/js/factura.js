//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#fechaF').datepicker({
		autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	});

});


function guardarFactura(){

    var msg = "";
    var smodulo_guia = $('#smodulo_guia').val();
	var tipo_cambio = $('#tipo_cambio').val();
	
	var forma_pago = $('#forma_pago').val();
	//alert(forma_pago); exit();

    if(smodulo_guia=="32"){
		var guia_llegada_direccion = $('#guia_llegada_direccion').val();
		if(guia_llegada_direccion=="")msg+="Debe ingresar un direcci&oacute;n de punto de llegada<br>";	
	}
	
	if (tipo_cambio==""&& forma_pago=="EFECTIVO DOLARES"){msg+="Debe ingresar el tipo de cambio<br>";	}


    if(msg!=""){
		
		bootbox.alert(msg);
        return false;
    }
    else{
        fn_save();
	}
	//fn_save();

}

function guardarnc(){

	
    var msg = "";
    var tiponota = $('#tiponota_').val();
	var motivo = $('#motivo_').val();
	

		if(tiponota=="")msg+="Debe ingresar un el tipo de nota<br>";	
		if(motivo=="")msg+="Debe ingresar el motivo<br>";	
		

    if(msg!=""){
		
        Swal.fire(msg);
        return false;
    }
    else{
		
        fn_save_nc();
	}
	

}


function fn_save(){

    //var fecha_atencion_original = $('#fecha_atencion').val();
	//var id_user = $('#id_user').val();
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	$('#guardar').hide();
	
    $.ajax({
			url: "/comprobante/send",
            type: "POST",

			//data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmFacturacion").serialize(),
			dataType: 'json',
            success: function (result) {
				/*
				if(result.sw==false){
					bootbox.alert(result.msg);
					return false;
				}
				*/
				
				//$('#numerof').val(result);
				//$('#divNumeroF').show();
				//location.href=urlApp+"/factura/"+result;
				$('.loader').hide();
				
				$('#numerof').val(result.id_factura);
				$('#divNumeroF').show();
				location.href=urlApp+"/comprobante/"+result.id_factura;

            }
    });
}

function fn_save_nc(){

    /*
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	$('#guardar').hide();
	*/
    $.ajax({
			url: "/comprobante/send_nc",
            type: "POST",

			//data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmNC").serialize(),
			dataType: 'json',
            success: function (result) {
				
			//	$('.loader').hide();
				
				$('#numerof').val(result.id_factura);
				$('#divNumeroF').show();
				location.href=urlApp+"/comprobante/"+result.id_factura;

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

	if(tipo_documento == "78"){
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

function validaNumeroComprobante(){
	var trans = $('#trans').val();
    alert(trans);
       // $('#numerof').val("2343");
        //$('#divNumeroF').show();
}

function obtenerPersona(){

	var tipo_documento = $("#tipo_documento").val();
	var numero_documento = $("#numero_documento").val();
	var msg = "";

	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}

	//$('#empresa_id').val("");
	$('#persona_id').val("");

	$.ajax({
		url: '/persona/obtener_persona/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			var nombre_persona= result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#nombre_persona').val(nombre_persona);
			$('#persona_id').val(result.persona.id);
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
		}

	});

	$('#modalNuevoDuenoCargaCancelBtn').click(function (e) {
		$("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-success').addClass('btn-primary');
		$("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
		$("#numero_ruc_dni").val("");
		$("#empresa_nuevo_dueno_carga").val("");
		$("#persona_nuevo_dueno_carga").val("");
	});

	$('#modalNuevoDuenoCargaSaveBtn').click(function (e) {
        e.preventDefault();
        if ($("#modalNuevoDuenoCargaSaveBtn").html() != "Confirmar datos") {

            $(this).html('Realizando la consulta..');

            $.ajax({
              data: $('#modalNuevoDuenoCargaForm').serialize(),
              url: "/empresa/buscar_ajax",
              type: "POST",
              dataType: 'json',
              success: function (data) {

                //   $('#modalNuevoDuenoCargaForm').trigger("reset");
                //   $('#duenoCargaModal').modal('hide');

                 //alert(data.msg);

                if (typeof data.ruc != "undefined") {
                    $("#numero_ruc_dni").val(data.ruc);
                } else {
                    $("#numero_ruc_dni").val(data.numero_documento);
                }

                $("#empresa_nuevo_dueno_carga").val(data.razon_social);
                $("#persona_nuevo_dueno_carga").val(data.nombre_completo);
                $("#empresa_direccion").val(data.direccion);
                $("#email").val(data.email);
				$("#persona_id").val(data.persona_id);
				$("#id_ubicacion").val(data.ubicacion_id);

                if (typeof data.ruc !== "undefined") {
                    $("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-primary').addClass('btn-success');
                    $("#modalNuevoDuenoCargaSaveBtn").html("Confirmar datos");
                } else if (typeof data.numero_documento !== "undefined") {
                    $("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-primary').addClass('btn-success');
                    $("#modalNuevoDuenoCargaSaveBtn").html("Confirmar datos");
                } else {
                    alert(data.msg);
                    if (data.nueva != "") {
                        $("#modalNuevoEmpresaPersonaBtn").html("Nueva "+data.nueva);
                        $("#modalNuevoEmpresaPersonaBtn").show();
                        // $('#empresa_numero_ruc').val(data.numero_ruc_dni);
                        // $('#numero_documento_nueva_persona').val(data.numero_ruc_dni);
                    }

                    $("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-success').addClass('btn-primary');
                    $("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
                }

              },
              error: function(data) {
                mensaje = "Revisar el formulario:\n\n";
                $.each( data["responseJSON"].errors, function( key, value ) {
                mensaje += value +"\n";
                });
                $("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
                alert(mensaje);
          }
          });
        } else {
            if ($("#persona_nuevo_dueno_carga").val() == '') {
                $("#badge_particular").removeClass("badge-success");
                $("#badge_empresa").addClass("badge-success");
                $("#btn_boleta").attr("style", "display:none");
                $("#btn_factura").attr("style", "display:");
            } else {
                $("#badge_empresa").removeClass("badge-success");
                $("#badge_particular").addClass("badge-success");
                $("#btn_boleta").attr("style", "display:");
                $("#btn_factura").attr("style", "display:none");
            }

            // Carga los datos en el formulario padre
            $("#numero_documento").val($("#numero_ruc_dni").val());
            $("#nombres_razon_social").val($("#empresa_nuevo_dueno_carga").val()+$("#persona_nuevo_dueno_carga").val());
            // Reinicia el formulario modal
            $("#empresa_nuevo_dueno_carga").attr("style", "display:block");
            $("#persona_nuevo_dueno_carga").attr("style", "display:none");
            $("#modalNuevoDuenoCargaSaveBtn").html("Buscar");
            $("#modalNuevoDuenoCargaSaveBtn").removeClass('btn-success').addClass('btn-primary');
            $('#modalNuevoDuenoCargaForm').trigger("reset");
            $('#duenoCargaModal').modal('hide');
        }
	});

	function datatablenew(){
                      
		var oTable1 = $('#tblFactura').dataTable({
			"bServerSide": true,
			"sAjaxSource": "/comprobante/listar_comprobante",
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
				
				var cap = $('#cap_').val();
				var nombre = $('#denominacion').val();
				var estado = $('#estado').val();
				
				var _token = $('#_token').val();
				oSettings.jqXHR = $.ajax({
					"dataType": 'json',
					//"contentType": "application/json; charset=utf-8",
					"type": "POST",
					"url": sSource,
					"data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
							nombre:nombre,cap:cap,estado:estado,
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
						var numero_cap = "";
						if(row.numero_cap!= null)numero_cap = row.numero_cap;
						return numero_cap;
					},
					"bSortable": true,
					"aTargets": [1]
					},
					
					{
					"mRender": function (data, type, row) {
						var desc_cliente = "";
						if(row.desc_cliente!= null)desc_cliente = row.desc_cliente;
						return desc_cliente;
					},
					"bSortable": true,
					"aTargets": [2]
					},
					
					{
					"mRender": function (data, type, row) {
						var tipo_certificado = "";
						if(row.tipo_certificado!= null)tipo_certificado = row.tipo_certificado;
						return tipo_certificado;
					},
					"bSortable": true,
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
							
							html += '<button style="font-size:12px" type="button" class="btn btn-sm btn-success" data-toggle="modal" onclick="modalCertificado('+row.id+')" ><i class="fa fa-edit"></i> Editar</button>';
							html += '<button style="font-size:12px;margin-left:10px" type="button" class="btn btn-sm btn-info" data-toggle="modal" onclick="Certificado_pdf('+row.id+')" ><i class="fa fa-edit"></i> Ver Certificado</button>';    
							html += '<a href="javascript:void(0)" onclick=eliminar('+row.id+','+row.estado+') class="btn btn-sm '+clase+'" style="font-size:12px;margin-left:10px">'+estado+'</a>';
							
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
}

