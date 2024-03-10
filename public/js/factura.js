//alert("ok");
//jQuery.noConflict(true);

$(document).ready(function () {

	$('#producto01').autocomplete({
		appendTo: "#producto01_list",
		source: function (request, response) {
			$.ajax({
				url: '/comprobante/forma_pago/' + $('#producto01').val(),
				dataType: "json",
				success: function (data) {
					//alert("fddf");					
					 //alert(JSON.stringify(data));
					var resp = $.map(data, function (obj) {
						console.log(obj);
						//return obj.denominacion;
						var hash = { key: obj.codigo, value: obj.denominacion };
						return hash;
					});
					//alert(JSON.stringify(resp));
					response(resp);
					
				},
				error: function () {
					//alert("cc");
				}
			});
		},
		select: function (event, ui) {
			alert(ui.item.key);
			flag_select = true;
			$('#producto01').attr("readonly", true);
		},
		minLength: 2,
		delay: 100
	}).blur(function () {
		if (typeof flag_select == "undefined") {
			$('#producto01').val("");
		}
	});


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

/*
	$(function() {
		$('#producto01').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
*/

	$('#tblProducto tbody').on('click', 'button.deleteFila', function () {
		var obj = $(this);
		obj.parent().parent().remove();
		
		var val_total = 0;
		var total = 0;
		$(".importe_especie").each(function (){
			val_total = $(this).val();
			if(val_total>0)total += Number(val_total);
		});
		
		$("#precio_peso").val(total);
		simulaPesarCarreta();
		
	});
	

	calculoDetraccion();

	calculaPorcentaje(1);

	
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
		$('#medio_pago').val(medio_pago);
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

	

	//alert(valorizad); exit();

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

	
	
	$(function() {
		$('#producto01').click(function() {
		  $('#producto01').select();
		});		
	  });

	var cuentaproductos=1;

	function cargaProductoNuevo() {
		cuentaproductos = cuentaproductos + 1;
		$('#tblProductos tr:last').after(
			'<tr id="fila'+pad(cuentaproductos, 2)+'"><td class="text-right">#</td> <td><input type="text" name="producto[]" id="producto'+pad(cuentaproductos, 2)+'" onkeyup="var query = $(this).val();$.ajax({url:\'../especie/search\',type:\'GET\',data:{\'denominacion\':query,\'listadoproducto\':\''+pad(cuentaproductos, 2)+'\'},success:function (data) {$(\'#producto'+pad(cuentaproductos, 2)+'_list\').html(data);}})" class="form-control form-control-sm"><div id="producto'+pad(cuentaproductos, 2)+'_list"></div></td><td><input type="text" name="porcentajeproducto[]" id="porcentajeproducto'+pad(cuentaproductos, 2)+'" class="form-control form-control-sm" onchange="calculaPorcentaje('+cuentaproductos+')" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"></td><td><input readonly="readonly" style="border:0px" type="text" name="peso_aprox[]" value="0" id=peso_aprox_'+pad(cuentaproductos, 2)+' /><input type="hidden" name="origen[]" value="" id=origen'+pad(cuentaproductos, 2)+' /><input type="hidden" name="idproducto[]" value="" id=idproducto'+pad(cuentaproductos, 2)+' /></td></tr>');

	}


	function eliminaFila(fila) {
		if (fila>1) {
			cuentaproductos = cuentaproductos - 1;
			$('#fila'+pad(fila, 2)).remove();
		}else{
			$('#producto01').val("");
			$('#producto01').attr("readonly",false);
		}
	}

	function calculaPorcentaje(fila) {
		
		var total_fac=  $("#total_fac_").val();

		//alert (total_fac);

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

		
/*

		alert(contador);
		
		//alert(total_fac);

		if (total_fac == "") {
			contador = 0;
			$("input[name^='porcentajeproducto']").each(function(i, obj) {
				contador += parseInt(obj.value);
			});
			if (contador > total_fac) {
				bootbox.alert("La suma no debe exceder al total del comprobante"); 
			}
		} else {
			contador = 0;
			$("input[name^='porcentajeproducto']").each(function(i, obj) {
				contador += parseInt(obj.value);
			});
			if (contador > total_fac) {
				//alert("La suma no debe exceder del 100%");
				bootbox.alert("La suma no debe exceder al total del comprobante"); 
			}
			//console.log($('#porcentajeproducto'+pad(fila, 2)).val());
			valor_procentaje =contador;
			$('#porcentajeproducto_'+pad(fila, 2)).val(Math.round(valor_procentaje));
			
		}
		*/
	}

	AddFila();
	function AddFila(){
		
		var newRow = "";
		var ind = $('#tblProducto tbody tr').length;
		var tabindex = 11;
		var nuevalperiodo = "";
		/*
		if(ind > 0){
			$('.idEspecie').each(function(){
				var ind_tmp = $(this).attr("ind");
				if(ind_tmp => ind){
					ind=Number(ind_tmp)+1;
					tabindex+=3;
				}
			});
		
			fila_medicamentos=$('#tblProducto tbody').children('tr');
			rowIndex=$('#hidden_rowIndex').val();
			var idval = ind - 1;
		}
		*/
	
		var item_producto 	= "";
		$('#idEspecieTemp option').each(function(){
		item_producto += "<option value="+$(this).val()+" ru='"+$(this).attr("ru")+"'>"+$(this).html()+"</option>"	
		});
	
		newRow +='<tr>';
		newRow +='<td><select class="form-control form-control-sm idEspecie" id="idEspecie'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="id_especie[]" >'+item_producto+'</select></td>';
		newRow +='<td><select class="form-control form-control-sm idUnidad" id="idUnidad'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="id_unidad[]" ></select>';
		
		newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="precio_especie[]" required="" readonly="readonly" id="precio_especie'+ind+'" class="limpia_text nro_solicitado precio_especie input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="cantidad_especie[]" required="" id="cantidad_especie'+ind+'" class="limpia_text nro_solicitado cantidad_especie input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="importe_especie[]" required="" readonly="readonly" id="importe_especie'+ind+'" class="limpia_text nro_solicitado importe_especie input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
		
		newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
		newRow +='</tr>';
		$('#tblProducto tbody').append(newRow);
		//$("#idEspecie"+ind).select2({max_selected_options: 4}).focus();
		$("#idEspecie"+ind).select2({max_selected_options: 4});
		
		/*
		$("#precio_especie"+ind).keypress(function(e){
			if(e.which == 13) {
				AddFila();
			}
		});
		*/
	
		$("#idEspecie"+ind).on("change", function (e) {
			var flagx = 0;
			cmb = $(this);
			id_especie = $("#idEspecie"+ind).val();
			//id_user={{Auth::user()->id}};
		
			$('.idEspecie').each(function(){
				var ind_tmp = $(this).val();
				if($(this).val() == id_especie)flagx++;
			});
		
			if(flagx > 1){
				bootbox.alert("El producto ya ha sido ingresado");
				$("#idEspecie"+ind).val("").trigger("change");
				return false;
			}
		
			option = {
				url: '/pesaje/obtener_producto_medida/' + id_especie,
				type: 'GET',
				dataType: 'json',
				data: {}
			};
			$.ajax(option).done(function (data) {
				
				var option = "<option value='0'>Seleccionar</option>";
				$("#idUnidad"+ind).html("");
				$(data).each(function (ii, oo) {
					option += "<option value='"+oo.id+"'>"+oo.denominacion+"</option>";
				});
				$("#idUnidad"+ind).html(option);
				$("#idUnidad"+ind).val(id).select2();
				
				/*
				var cantidad = data.cantidad;
				var cantidadEstablecimiento = data.cantidadEstablecimiento;
				var cantidadAlmacen = data.cantidadAlmacen;
				$(cmb).closest("tr").find(".limpia_text").val("");                
				$(cmb).closest("tr").find("#nro_stocks").val(cantidad);
				$(cmb).closest("tr").find("#nro_stocks_establecimiento").val(cantidadEstablecimiento);
				$(cmb).closest("tr").find("#nro_stocks_almacen").val(cantidadAlmacen);
				$(cmb).closest("tr").find("#nro_med_solictados").val("");  
				$(cmb).closest("tr").find("#nro_med_entregados").val("");
				$(cmb).closest("tr").find("#lotes_lote").val("");
				$(cmb).closest("tr").find("#lotes_cantidad").val("");
				$(cmb).closest("tr").find("#lotes_registro_sanitario").val("");
				$(cmb).closest("tr").find("#lotes_fecha_vencimiento").val("");
				*/
			});
		
			
		});
		
		$("#idUnidad"+ind).on("change", function (e) {
			var flagx = 0;
			cmb = $(this);
			id_especie = $("#idEspecie"+ind).val();
			id_unidad = $("#idUnidad"+ind).val();
			//id_user={{Auth::user()->id}};
			/*
			$('.idEspecie').each(function(){
				var ind_tmp = $(this).val();
				if($(this).val() == id_producto)flagx++;
			});
		
			if(flagx > 1){
				bootbox.alert("El producto farmaceutico ya ha sido ingresado");
				$("#idEspecie"+ind).val("").trigger("change");
				return false;
			}
			*/
			option = {
				url: '/pesaje/obtener_precio_producto_medida/' + id_especie + '/' + id_unidad,
				type: 'GET',
				dataType: 'json',
				data: {}
			};
			$.ajax(option).done(function (data) {
				$("#precio_especie"+ind).val(data[0].precio);
				
				/******************/
				cantidad_especie = $("#cantidad_especie"+ind).val();
				precio_especie = $("#precio_especie"+ind).val();
				var importe_especie = cantidad_especie*precio_especie;
				$("#importe_especie"+ind).val(importe_especie);
				
				var val_total = 0;
				var total = 0;
				$(".importe_especie").each(function (){
					val_total = $(this).val();
					if(val_total>0)total += Number(val_total);
				});
				
				$("#precio_peso").val(total);
				simulaPesarCarreta();
				/******************/
			});
		
			
		});
		
		$("#cantidad_especie"+ind).on("keyup", function (e) {
			cantidad_especie = $("#cantidad_especie"+ind).val();
			precio_especie = $("#precio_especie"+ind).val();
			var importe_especie = cantidad_especie*precio_especie;
			$("#importe_especie"+ind).val(importe_especie);
			
			var val_total = 0;
			var total = 0;
			$(".importe_especie").each(function (){
				val_total = $(this).val();
				if(val_total>0)total += Number(val_total);
			});
			
			$("#precio_peso").val(total);
			simulaPesarCarreta();
			
		});
		
	}
	
	


