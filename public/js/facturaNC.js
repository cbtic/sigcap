 //alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#fechaF').datepicker({
		autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	});

	$('#f_venci_01').datepicker({
		autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	});
 //alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#fechaF').datepicker({
		autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	});

	$('#f_venci_01').datepicker({
		autoclose: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
	});


	
});

function calculoDetraccion(){
	
	var total_fac = $('#total_fac_').val();
	var total_detraccion =total_fac*12/100;
	var nc_detraccion = "111-111-111-11";
	var tipo_detraccion = "004";
	var afecta_a = "022";
	var medio_pago = "001";
	//var d = new Date();

	//alert(Math.round(total_fac));
	//alert(Math.round(total_fac));

	if (Math.round(total_fac) > 700){
	//	alert(Math.round(total_fac));

		//var f_venci = FormatFecha(d);
		//$('#f_venci_01').val(f_venci);

		$('#porcentaje_detraccion').val("12%");		
		$('#monto_detraccion').val(total_detraccion.toFixed(2));
		$('#nc_detraccion').val(nc_detraccion);
		$('#tipo_detraccion').val(tipo_detraccion);
		$('#afecta_a').val(afecta_a);
		$('#medio_pago').val(medio_pago);con
	}else{
		$('#porcentaje_detraccion').val("");
		$('#monto_detraccion').val("");
		$('#nc_detraccion').val("");
		$('#tipo_detraccion').val("");
		$('#afecta_a').val("");
		//$('#medio_pago').value("");
	}
}

function guardarFactura(){

    var msg = "";
    var smodulo_guia = $('#smodulo_guia').val();
	var tipo_cambio = $('#tipo_cambio').val();
	
	var forma_pago = $('#forma_pago').val();

	var valorizad = $('#valorizad').val();


	var ind = $('#tblMedioPago tbody tr').length;
	
	if(ind==0)msg+="Debe adicionar el Medio de Pago <br>";
	
	var totalMedioPago = $('#totalMedioPago').val();
	var total_fac_ = $('#total_fac_').val();

	var id_formapago_ = $('#id_formapago_').val();

	//alert(id_formapago_);

	
	
	if(totalMedioPago!=total_fac_ && id_formapago_==1){
		msg+="El total de medio de pago no coincide al total del comprobante..<br>";
	}


	//alert(msg); exit();


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

function guardarnd(){

	
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
		
        fn_save_nd();
	}
	

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
				location.href=urlApp+"/comprobante/ver/"+result.id_factura;

            }
    });
}

function fn_save_nd(){

    /*
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	$('#guardar').hide();
	*/
    $.ajax({
			url: "/comprobante/send_nd",
            type: "POST",

			//data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmND").serialize(),
			dataType: 'json',
            success: function (result) {
				
			//	$('.loader').hide();
				
				$('#numerof').val(result.id_factura);
				$('#divNumeroF').show();
				location.href=urlApp+"/comprobante/ver/"+result.id_factura;

            }
    });
}

function fn_save_nc(){

    
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	$('#guardar').hide();
	
	
    $.ajax({
			url: "/comprobante/send_nc",
            type: "POST",

			//data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmNC").serialize(),
			dataType: 'json',
            success: function (result) {
				
				$('.loader').hide();
			
				$('#numerof').val(result.id_factura);
				$('#divNumeroF').show();
				location.href=urlApp+"/comprobante/ver/"+result.id_factura;

				enviar_comprobante(result.id_factura);

            }
    });
}

function ActualizaDetalle(){
	
	var campos = document.querySelectorAll('input[name^="importe"]');
    campos.forEach(function(campo) {
		
        campo.readOnly = true;
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
}

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


	function calculaPorcentaje(fila) {		
		var total_fac=  $("#total_fac_").val();		
		var valorItem = $('#porcentajeproducto'+pad(fila, 2)).val()
		var contador = 0;
		$("input[name^='porcentajeproducto']").each(function(i, obj) {			
			contador++;
		});

		if(contador == 1) {
			$('#porcentajeproducto'+pad(fila, 2)).val(total_fac);
			$('#producto01').val('EFECTIVO');
		}
		else{

			$("input[name^='porcentajeproducto']").each(function(i, obj) {			
				contador++;
				valorItem+=  $('#porcentajeproducto'+pad(fila, 2)).val();
			});
			
			//alert(parseInt(obj.value));

		}


	}

	/*
	AddFila();
	function AddFila(){
		
		var newRow = "";
		var ind = $('#tblMedioPago tbody tr').length;
		var tabindex = 11;
		//var nuevalperiodo = "";

		//var f = new Date();
		var f = new Date();
		var fecha_ = f.getDate() + "-"+ f.getMonth()+ "-" +f.getFullYear();

	
		var item_producto 	= "";
		$('#idMedioPagoTemp option').each(function(){
			item_producto += "<option value="+$(this).val()+" ru='"+$(this).attr("ru")+"'>"+$(this).html()+"</option>"	
		});
	
		newRow +='<tr>';
		newRow +='<td><select class="form-control form-control-sm idMedio" id="idMedio'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="idMedio[]" >'+item_producto+'</select></td>';
		
		newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar el monto y presionar Enter para ingresar el nro operación" name="monto[]" required="" id="monto'+ind+'" class="limpia_text  monto input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="nroOperacion[]" required="" id="nroOperacion'+ind+'" class="limpia_text nroOperacion input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="descripcion[]" required="" id="descripcion'+ind+'" class="limpia_text  descripcion input-sm form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';

		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="fecha[]" required="" id="fecha'+ind+'" class="form-control form-control-sm datepicker fecha input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';

		newRow +='</tr>';
		$('#tblMedioPago tbody').append(newRow);

		$("#idMedio"+ind).select2({max_selected_options: 4});
		
	
		$("#idMedio"+ind).on("change", function (e) {
			var flagx = 0;
			cmb = $(this);
			idMedio = $("#idMedio"+ind).val();
			//id_user={{Auth::user()->id}};
		
			$('.idMedio').each(function(){
				var ind_tmp = $(this).val();
				if($(this).val() == idMedio)flagx++;
			});
		
			if(flagx > 1){
				bootbox.alert("El Medio de Pago ya ha sido ingresado");
				$("#idMedio"+ind).val("").trigger("change");
				return false;			
			}
			else{
				
				if(ind==0){
					monto = $("#total_fac_").val();
					$("#monto"+ind).val(monto);
					$("#totalMedioPago").val(monto);
				}

				$("#fecha"+ind).val(fecha_);
				
			}
					
		});
		
		
		$("#monto"+ind).on("keyup", function (e) {
			monto = $("#monto"+ind).val();

			var total = 0;
			var val_total = 0;
			
			$(".monto").each(function (){
				val_total = $(this).val();
				
				if(val_total!="")total += Number(val_total);
			});

			alert(total);

			
			$("#totalMedioPago").val(total);
			
			
			//$("#precio_peso").val(total);
					
		});
		
	}
	*/

	function obtenerRepresentante(){

		var tipo_documento = "";
		var tipo_comprobante = $("#TipoF").val();

		//alert(tipo_comprobante);
		
		if(tipo_comprobante=="FT") tipo_documento = '79';
		if(tipo_comprobante=="BV") tipo_documento = '78';

		var numero_documento = $("#numero_documento2").val();

		$.ajax({
			url: '/agremiado/obtener_representante/' + tipo_documento + '/' + numero_documento,
			dataType: "json",
			success: function (result) {

				if (result) {
					$('#razon_social2').val(result.agremiado.representante);
					$('#direccion2').val(result.agremiado.direccion);
					$('#email2').val(result.agremiado.email);
					
					if(tipo_comprobante=="FT") $('#ubicacion2').val(result.agremiado.id);
					if(tipo_comprobante=="BV") $('#persona2').val(result.agremiado.id);

					

				}
				else {						
					Swal.fire("registro no encontrado!");
				}

			},
			"error": function (msg, textStatus, errorThrown) {

				Swal.fire("Numero de documento no fue registrado!");

			}
			
			
		});
		
	}
	
    function calcular_total(fila,afectacion){

        var imported=0;    
		imported = $('#imported'+fila).val();

		if (afectacion==30){
			var igv = 0;	
		}
		else{
			var igv = imported*0.18;	
		};

		//var igv = imported*0.18;


		var totald = Number(imported) + Number(igv);

		

		$("#igvd"+fila).val(igv.toFixed(2));

		$("#totald"+fila).val(totald.toFixed(2));

		
		var gravadas=0;
		igv=0;
		var total=0;


		$("input[name^='imported']").each(function(i, obj) {			
			$(this).parent().parent().parent().find('#facturad_pu').val(Number(obj.value));
		});

		

		$("input[name^='imported']").each(function(i, obj) {
			//alert(obj.value);
			gravadas = Number(obj.value) + Number(gravadas);

			//contador += parseInt(obj.value);
		});

		$("#gravadas").val(gravadas.toFixed(2));

		$("input[name^='igvd']").each(function(i, obj) {
			//alert(obj.value);
			igv = Number(obj.value) + Number(igv);

			//contador += parseInt(obj.value);
		});

		$("#igv").val(igv.toFixed(2));

		
		$("input[name^='totald']").each(function(i, obj) {
			//alert(obj.value);
			total = Number(obj.value) + Number(total);

			
		});

		

		$("#totalP").val(total.toFixed(2));

		$("#total_pagar_abono").val(total.toFixed(2));

		$("#total_fac_").val(total.toFixed(2));

		

		//$("#igvd"+fila).val(igv);       
        
    }

	function actualizaimportes(afectacion){
		var i=0;
		
		
	
		if ($('#tiponota_').val()=='01'){	
			i=0;
			$("input[name^='importeantd']").each(function(i, obj) {
				
				$("#totald"+i).val(obj.value);
				calcular_total_2(i,afectacion);
				i++;
				//total = Number(obj.value) + Number(total);

				
			});

			
			}
		else {
			i=0;
			$("input[name^='totald']").each(function(i, obj) {
				//alert(obj.value);
				$("#totald"+i).val(0);
				calcular_total_2(i,afectacion);

				//total = Number(obj.value) + Number(total);

				
			});
						/*
			for (i=0 ;i<('#totald').length;i++){
				$("#totald"+i).val(0);
				calcular_total_2(i);
				
			} */
		}

	}
	         
	$('#addRow1').on('click', function () {
		AddFila();
	});

	AddFila();
	function AddFila(){
		
		var newRow = "";
		var ind = $('#tblMedioPago tbody tr').length;
		var tabindex = 11;
		//var nuevalperiodo = "";

		//var f = new Date();
		var f = new Date();
		var fecha_ = f.getDate() + "-"+ f.getMonth()+ "-" +f.getFullYear();

	
		var item_producto 	= "";
		$('#idMedioPagoTemp option').each(function(){
			item_producto += "<option value="+$(this).val()+" ru='"+$(this).attr("ru")+"'>"+$(this).html()+"</option>"	
		});
	
		newRow +='<tr>';
		newRow +='<td><select class="form-control form-control-sm idMedio" id="idMedio'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="idMedio[]" >'+item_producto+'</select></td>';
		
		newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar el monto y presionar Enter para ingresar el nro operación" name="monto[]" required="" id="monto'+ind+'" class="limpia_text  monto input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="nroOperacion[]" required="" id="nroOperacion'+ind+'" class="limpia_text nroOperacion input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="descripcion[]" required="" id="descripcion'+ind+'" class="limpia_text  descripcion input-sm form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';

		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="fecha[]" required="" id="fecha'+ind+'" class="form-control form-control-sm datepicker fecha input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';

		newRow +='</tr>';
		$('#tblMedioPago tbody').append(newRow);

		$("#idMedio"+ind).select2({max_selected_options: 4});
		
	
		$("#idMedio"+ind).on("change", function (e) {
			var flagx = 0;
			cmb = $(this);
			idMedio = $("#idMedio"+ind).val();
			
			//id_user={{Auth::user()->id}};
		
			$('.idMedio').each(function(){
				var ind_tmp = $(this).val();
				if($(this).val() == idMedio)flagx++;
			});
		
			if(flagx > 1 && idMedio!='254'){
				//alert(idMedio);
				//if (idMedio!='254'){
					bootbox.alert("El Medio de Pago ya ha sido ingresado");
					$("#idMedio"+ind).val("").trigger("change");
					return false;				
				//}
			}
			else{
				
				if(ind==0){
					monto = $("#total_fac_").val();
					//$("#monto"+ind).val(monto);
					$("#totalMedioPago").val(monto);

					if(idMedio=='91'){
						//monto = $("#total_fac_").val();
						monto_r = redondeoContableAFavor(Number(monto), 1);

						$("#monto"+ind).val(monto_r);

						if(monto!=monto_r){
							$("#tr_total_pagar").show();
							$("#total_pagar").val(monto_r);
						}
	

					}else if(idMedio=='254' || idMedio=='545' || idMedio=='543'){

						$("#monto"+ind).val(monto);

						
						//$("#tr_total_pagar_abono").show();
						//$("#total_pagar_abono").val(monto);
						

					}else{

						$("#monto"+ind).val(monto);

						$("#total_pagar").val("0");
						$("#total_pagar_abono").val("0");
						$("#tr_total_pagar").hide();
					}
					$("#tr_total_pagar_abono").show();
					$("#total_pagar_abono").val(monto);
				}

				$("#fecha"+ind).val(fecha_);



				
			}
					
		});
		

		
		$("#monto"+ind).on("keyup", function (e) {
			monto = $("#monto"+ind).val();

			var total = 0;
			var val_total = 0;
			
			$(".monto").each(function (){
				val_total = $(this).val();
				
				if(val_total!="")total += Number(val_total);
			});

			//alert(total);

			
			$("#totalMedioPago").val(total);
			$("#total_pagar_abono").val(total);
			
			
			//$("#precio_peso").val(total);
					
		});
		
	}

	function redondeoContableAFavor(valor, decimales = 1) {
		// Calcular el factor de redondeo según los decimales
		const factor = Math.pow(10, decimales);
		// Redondear hacia abajo al múltiplo más cercano según los decimales
		const valorRedondeado = Math.floor(valor * factor) / factor;
		// Calcular la diferencia (redondeo)
		//const redondeo = valor - valorRedondeado;
		return valorRedondeado;
	}



	
});

function calculoDetraccion(){
	
	var total_fac = $('#total_fac_').val();
	var total_detraccion =total_fac*12/100;
	var nc_detraccion = "111-111-111-11";
	var tipo_detraccion = "004";
	var afecta_a = "022";
	var medio_pago = "001";
	//var d = new Date();

	//alert(Math.round(total_fac));
	//alert(Math.round(total_fac));

	if (Math.round(total_fac) > 700){
	//	alert(Math.round(total_fac));

		//var f_venci = FormatFecha(d);
		//$('#f_venci_01').val(f_venci);

		$('#porcentaje_detraccion').val("12%");		
		$('#monto_detraccion').val(total_detraccion.toFixed(2));
		$('#nc_detraccion').val(nc_detraccion);
		$('#tipo_detraccion').val(tipo_detraccion);
		$('#afecta_a').val(afecta_a);
		$('#medio_pago').val(medio_pago);con
	}else{
		$('#porcentaje_detraccion').val("");
		$('#monto_detraccion').val("");
		$('#nc_detraccion').val("");
		$('#tipo_detraccion').val("");
		$('#afecta_a').val("");
		//$('#medio_pago').value("");
	}
}

function guardarFactura(){

    var msg = "";
    var smodulo_guia = $('#smodulo_guia').val();
	var tipo_cambio = $('#tipo_cambio').val();
	
	var forma_pago = $('#forma_pago').val();

	var valorizad = $('#valorizad').val();


	var ind = $('#tblMedioPago tbody tr').length;
	
	if(ind==0)msg+="Debe adicionar el Medio de Pago <br>";
	
	var totalMedioPago = $('#totalMedioPago').val();
	var total_fac_ = $('#total_fac_').val();

	var id_formapago_ = $('#id_formapago_').val();

	//alert(id_formapago_);

	
	
	if(totalMedioPago!=total_fac_ && id_formapago_==1){
		msg+="El total de medio de pago no coincide al total del comprobante..<br>";
	}


	//alert(msg); exit();


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
	var tipo_cambio = $('#tipo_cambio').val();
	
	if(tiponota=="")msg+="Debe ingresar un el tipo de nota<br>";	
	
	if(motivo=="")msg+="Debe ingresar el motivo<br>";	

	if (tipo_cambio==""){msg+="Debe ingresar el tipo de cambio actual<br>";	}		

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
				location.href=urlApp+"/comprobante/ver/"+result.id_factura;

            }
    });
}

function fn_save_nc(){

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	$('#guardar').hide();

    $.ajax({
			url: "/comprobante/send_nc",
            type: "POST",

			//data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmNC").serialize(),
			dataType: 'json',
            success: function (result) {
				
				$('.loader').hide();
				
				$('#numerof').val(result.id_factura);
				$('#divNumeroF').show();

				location.href=urlApp+"/comprobante/ver/"+result.id_factura;

				enviar_comprobante(result.id_factura);

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
}

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


	function calculaPorcentaje(fila) {		
		var total_fac=  $("#total_fac_").val();		
		var valorItem = $('#porcentajeproducto'+pad(fila, 2)).val()
		var contador = 0;
		$("input[name^='porcentajeproducto']").each(function(i, obj) {			
			contador++;
		});

		if(contador == 1) {
			$('#porcentajeproducto'+pad(fila, 2)).val(total_fac);
			$('#producto01').val('EFECTIVO');
		}
		else{

			$("input[name^='porcentajeproducto']").each(function(i, obj) {			
				contador++;
				valorItem+=  $('#porcentajeproducto'+pad(fila, 2)).val();
			});
			
			//alert(parseInt(obj.value));

		}


	}

	AddFila();
	function AddFila(){
		
		var newRow = "";
		var ind = $('#tblMedioPago tbody tr').length;
		var tabindex = 11;
		//var nuevalperiodo = "";

		//var f = new Date();
		var f = new Date();
		var fecha_ = f.getDate() + "-"+ f.getMonth()+ "-" +f.getFullYear();

	
		var item_producto 	= "";
		$('#idMedioPagoTemp option').each(function(){
			item_producto += "<option value="+$(this).val()+" ru='"+$(this).attr("ru")+"'>"+$(this).html()+"</option>"	
		});
	
		newRow +='<tr>';
		newRow +='<td><select class="form-control form-control-sm idMedio" id="idMedio'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="idMedio[]" >'+item_producto+'</select></td>';
		
		newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar el monto y presionar Enter para ingresar el nro operación" name="monto[]" required="" id="monto'+ind+'" class="limpia_text  monto input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="nroOperacion[]" required="" id="nroOperacion'+ind+'" class="limpia_text nroOperacion input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="descripcion[]" required="" id="descripcion'+ind+'" class="limpia_text  descripcion input-sm form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';

		newRow +='<td><input  type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar " name="fecha[]" required="" id="fecha'+ind+'" class="form-control form-control-sm datepicker fecha input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';

		newRow +='</tr>';
		$('#tblMedioPago tbody').append(newRow);

		$("#idMedio"+ind).select2({max_selected_options: 4});
		
	
		$("#idMedio"+ind).on("change", function (e) {
			var flagx = 0;
			cmb = $(this);
			idMedio = $("#idMedio"+ind).val();
			//id_user={{Auth::user()->id}};
		
			$('.idMedio').each(function(){
				var ind_tmp = $(this).val();
				if($(this).val() == idMedio)flagx++;
			});
		
			if(flagx > 1){
				bootbox.alert("El Medio de Pago ya ha sido ingresado");
				$("#idMedio"+ind).val("").trigger("change");
				return false;			
			}
			else{
				
				if(ind==0){
					monto = $("#total_fac_").val();
					$("#monto"+ind).val(monto);
					$("#totalMedioPago").val(monto);
				}

				$("#fecha"+ind).val(fecha_);
				
			}
					
		});
		
		
		$("#monto"+ind).on("keyup", function (e) {
			monto = $("#monto"+ind).val();

			var total = 0;
			var val_total = 0;
			
			$(".monto").each(function (){
				val_total = $(this).val();
				
				if(val_total!="")total += Number(val_total);
			});

			alert(total);

			
			$("#totalMedioPago").val(total);
			
			
			//$("#precio_peso").val(total);
					
		});
		
	}

	function obtenerRepresentante(){

		var tipo_documento = "";
		var tipo_comprobante = $("#TipoF").val();

		//alert(tipo_comprobante);
		
		if(tipo_comprobante=="FT") tipo_documento = '79';
		if(tipo_comprobante=="BV") tipo_documento = '78';

		var numero_documento = $("#numero_documento2").val();

		$.ajax({
			url: '/agremiado/obtener_representante/' + tipo_documento + '/' + numero_documento,
			dataType: "json",
			success: function (result) {

				if (result) {
					$('#razon_social2').val(result.agremiado.representante);
					$('#direccion2').val(result.agremiado.direccion);
					$('#email2').val(result.agremiado.email);
					
					if(tipo_comprobante=="FT") $('#ubicacion2').val(result.agremiado.id);
					if(tipo_comprobante=="BV") $('#persona2').val(result.agremiado.id);

					

				}
				else {						
					Swal.fire("registro no encontrado!");
				}

			},
			"error": function (msg, textStatus, errorThrown) {

				Swal.fire("Numero de documento no fue registrado!");

			}
			
			
		});
		
	}
	
    function calcular_total(fila,afectacion){

		
        var imported=0;    
		imported = $('#imported'+fila).val();

		var igv = imported*0.18;


		var totald = Number(imported) + Number(igv);

		

		$("#igvd"+fila).val(igv.toFixed(2));

		$("#totald"+fila).val(totald.toFixed(2));

		
		var gravadas=0;
		igv=0;
		var total=0;

		$("input[name^='imported']").each(function(i, obj) {
			//alert(obj.value);
			gravadas = Number(obj.value) + Number(gravadas);

			//contador += parseInt(obj.value);
		});

		$("#gravadas").val(gravadas.toFixed(2));

		$("input[name^='igvd']").each(function(i, obj) {
			//alert(obj.value);
			igv = Number(obj.value) + Number(igv);

			//contador += parseInt(obj.value);
		});

		$("#igv").val(igv.toFixed(2));

		
		$("input[name^='totald']").each(function(i, obj) {
			//alert(obj.value);
			total = Number(obj.value) + Number(total);

			
		});

		$("#totalP").val(total.toFixed(2));

		//$("#igvd"+fila).val(igv);       
        
    }

	function calcular_total_2(fila,afectacion){		
		
        var totald=0;
		var importeantd=0;

		var total = 0;
		var descuento = 0;
		var valor_venta_bruto = 0;
		var valor_venta = 0;
		var igv = 0;
		var stotal = 0;
		var descuento =0;

		var cantidad =1;

		var afectacion_ = 0;

		afectacion_=$('#afect_igv'+fila).val();



		totald =  $('#totald'+fila).val();
		totald= parseFloat(totald.replace(/,/g, ""));
		
		importeantd=$('#importeantd'+fila).val();
		importeantd=parseFloat(importeantd.replace(/,/g, ""));
		//alert(importeantd);
		
		cantidad =  $('#cantidad'+fila).val();
		
		if (totald <=importeantd )  {
			var imported =0;
			var igv =  0;
			var pu =0;
			

			if (afectacion_==30){
				imported =totald;
				igv =  0;
				pu =totald;
			}
			else{
				
				imported =totald/1.18;  
				igv =  Number(totald) - Number(imported);	
	
			};
								
			$("#igvd"+fila).val(igv.toFixed(2));
			$("#imported"+fila).val(imported.toFixed(2));
			
			//$("#totald"+fila).val(totald.toFixed(2)  );
			//$("#imported"+fila).val(pu.toFixed(2));
			
			var gravadas=0;
			igv=0;
			var total=0;


		//	$("input[name^='imported']").each(function(i, obj) {			
		//		$(this).parent().parent().parent().find('#facturad_pu').val(Number(obj.value));
		//	});

			

			$("input[name^='imported']").each(function(i, obj) {
				//alert(obj.value);
				gravadas = Number(obj.value) + Number(gravadas);

				//contador += parseInt(obj.value);
			});

			$("#gravadas").val(gravadas.toFixed(2));

			$("input[name^='igvd']").each(function(i, obj) {
				//alert(obj.value);
				igv = Number(obj.value) + Number(igv);

				//contador += parseInt(obj.value);
			});

			$("#igv").val(igv.toFixed(2));

			
			$("input[name^='totald']").each(function(i, obj) {
				//alert(obj.value);
				total = Number(obj.value) + Number(total);

				
			});

			$("#totalP").val(total.toFixed(2));


			var tasa_igv_ = 0.18;

			if (afectacion_==30)tasa_igv_ = 0;
	

			var PrecioVenta_ =  $('#totald'+fila).val();		
			PrecioVenta_ =PrecioVenta_.toString().replace(',','');


			var Descuento_ = 0;
			var Cantidad_ =  $('#cantidad'+fila).val(); 
			cantidad =  $('#cantidad'+fila).val();
	
			var ValorUnitario_ = PrecioVenta_ /(1+tasa_igv_);	
			//alert(ValorUnitario_);
	
			var ValorVB_ = ValorUnitario_ * Cantidad_;
			var ValorVenta_ = ValorVB_ - Descuento_;
			var Igv_ = ValorVenta_ * tasa_igv_;
			var Total_ = ValorVenta_ + Igv_;
	
			total += Number(Total_);
			stotal += Number(ValorVenta_);
			igv += Number(Igv_);
	
			
			ValorUnitario_ = Number(ValorUnitario_ );		
			ValorVB_ = Number(ValorVB_ );		
			ValorVenta_ = Number(ValorVenta_ );
			Igv_ = Number(Igv_ );		
			Total_ = Number(Total_ );
			PrecioVenta_ = Number(PrecioVenta_ );



			$("#descuento"+fila).val(Descuento_.toFixed(2));

			$("#pu"+fila).val(ValorUnitario_.toFixed(2));
			
			$("#valor_venta"+fila).val(ValorVenta_.toFixed(2));
			$("#valor_venta_bruto"+fila).val(ValorVB_.toFixed(2));
			
			$("#igv"+fila).val(Igv_.toFixed(2));
			$("#total"+fila).val(Total_.toFixed(2));
			$("#pv"+fila).val(PrecioVenta_.toFixed(2));

			$("#monto"+fila).val(Total_.toFixed(2));


/*
			$(this).parent().parent().parent().find('#comprobante_detalle_precio_unitario').val(ValorUnitario_.toFixed(2));
			$(this).parent().parent().parent().find('#comprobante_detalle_sub_total').val(ValorVenta_.toFixed(2));
			$(this).parent().parent().parent().find('#comprobante_detalle_valor_venta_bruto').val(ValorVB_.toFixed(2));
			$(this).parent().parent().parent().find('#comprobante_detalle_monto').val(Total_.toFixed(2));
			$(this).parent().parent().parent().find('#comprobante_detalle_pu').val(ValorUnitario_.toFixed(2));
			$(this).parent().parent().parent().find('#comprobante_detalle_igv').val(Igv_.toFixed(2));
	
			$(this).parent().parent().parent().find('#comprobante_detalle_pv').val(PrecioVenta_.toFixed(2));
			$(this).parent().parent().parent().find('#comprobante_detalle_vv').val(ValorVenta_.toFixed(2));
			$(this).parent().parent().parent().find('#comprobante_detalle_total').val(Total_.toFixed(2));

*/


		} 
		else {
			$("#totald"+fila).val(0);
			$("#igvd"+fila).val(0);

			$("#imported"+fila).val(0);
			alert("El valor no debe ser mayor al total de la factura")
		}
	

		//$("#igvd"+fila).val(igv);       
        
    }
	         
	function calcular_total_2_x(fila,afectacion){

        var totald=0;    
		totald = $('#totald'+fila).val();

		var imported =totald/1.18;  
		var igv =  Number(totald) - Number(imported);


		

		//alert(totald);

		$("#igvd"+fila).val(igv.toFixed(2));

		$("#imported"+fila).val(imported.toFixed(2));

		
		var gravadas=0;
		igv=0;
		var total=0;


		$("input[name^='imported']").each(function(i, obj) {			
			$(this).parent().parent().parent().find('#facturad_pu').val(Number(obj.value));
		});

		

		$("input[name^='imported']").each(function(i, obj) {
			//alert(obj.value);
			gravadas = Number(obj.value) + Number(gravadas);

			//contador += parseInt(obj.value);
		});

		$("#gravadas").val(gravadas.toFixed(2));

		$("input[name^='igvd']").each(function(i, obj) {
			//alert(obj.value);
			igv = Number(obj.value) + Number(igv);

			//contador += parseInt(obj.value);
		});

		$("#igv").val(igv.toFixed(2));

		
		$("input[name^='totald']").each(function(i, obj) {
			//alert(obj.value);
			total = Number(obj.value) + Number(total);

			
		});

		

		$("#totalP").val(total.toFixed(2));

		//$("#igvd"+fila).val(igv);       
        
    }

	function enviar_comprobante(id){

		$.ajax({
			url: '/comprobante/firmar_nc/' + id ,
			dataType: "json",
			success: function (result) {

				if (result) {
					Swal.fire("Enviado al Facturador Electrónica!");

				}
				else {						
					Swal.fire("registro no encontrado!");
				}

			},
			"error": function (msg, textStatus, errorThrown) {

				Swal.fire("Numero de documento no fue registrado!");

			}
	
		});
		
	}