
$(document).ready(function () {
	
	//$('#id_proyecto').select2();
	
	//datatablenew();
	var id_ubigeo_nacimiento = $("#id_ubigeo_nacimiento").val();
	var idProvincia = id_ubigeo_nacimiento.substring(2,4);
	var idDistrito = id_ubigeo_nacimiento.substring(4,6);
	obtenerProvinciaEdit(idProvincia);
	obtenerDistritoEdit(idProvincia,idDistrito);
	
	var id_ubigeo_domicilio = $("#id_ubigeo_domicilio").val();
	//var idDepartamentoDomiciliario = id_ubigeo_domicilio.substring(0,2);
	var idProvinciaDomiciliario = id_ubigeo_domicilio.substring(2,4);
	var idDistritoDomiciliario = id_ubigeo_domicilio.substring(4,6);
	obtenerProvinciaDomiciliarioEdit(idProvinciaDomiciliario);
	obtenerDistritoDomiciliarioEdit(idProvinciaDomiciliario,idDistritoDomiciliario);
	
	$('#btnNuevoLit').on('click', function () {
		modalLitigante(0);
	});
	
	$('#btnEliminarLit').on('click', function () {
		eliminarLit();
	});
	
	$('#btnEliminarMov').on('click', function () {
		eliminarMov();
	});
	
	$('#btnEliminarSeg').on('click', function () {
		eliminarSeg();
	});
	
	$('#btnNuevoEstudio').on('click', function () {
		modalEstudio(0);
	});
	
	$('#btnNuevoIdioma').on('click', function () {
		modalIdioma(0);
	});
	
	$('#btnNuevoParentesco').on('click', function () {
		modalParentesco(0);
	});
	
	$('#btnNuevoTrabajo').on('click', function () {
		modalTrabajo(0);
	});
	
	$('#btnNuevoSeg').on('click', function () {
		modalSeguimiento(0);
	});
	
	$('#addRow').on('click', function () {
		AddFila();
	});
	
	$('#btnNuevo').on('click', function () {
		window.location.reload();
	});
	
	$('#btnGuardar').on('click', function () {
		guardar_agremiado()
		//Limpiar();
		//window.location.reload();
	});

	$('#btnNuevoMulta').on('click', function () {
		modalMulta(0);
	});
	$('#btnNuevoProntoPago').on('click', function () {
		modalProntoPago(0);
	});
	
	/*
	$('.delete_ruta').on('click', function () {
		DeleteImagen(this);
	});
	*/
	
	$('#tblProductos tbody').on('click', 'button.deleteFila', function () {
		var obj = $(this);
		obj.parent().parent().remove();
	});
	
	$('#btnBuscar').click(function () {
		fn_ListarBusqueda();
	});
	
	/*
	$('#fecha_desde').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });
	
	$('#fecha_hasta').datepicker({
        autoclose: true,
		format: 'dd/mm/yyyy',
		changeMonth: true,
		changeYear: true,
    });
	*/
	
});

function formato_miles(numero){
	
	return parseFloat(numero).toFixed(2).replace(/\D/g, "").replace(/([0-9])([0-9]{2})$/, '$1.$2').replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
}

function aperturar(accion){
	var id_caja_ingreso = $('#id_caja_ingreso').val();
    var id_caja = $('#id_caja').val();
	var saldo_inicial = $('#saldo_inicial').val();
	var total_recaudado = $('#total_recaudado').val();
	var saldo_total = $('#saldo_total').val();
	var estado = '1';
	var _token = $('#_token').val();
	
	var msg = "";
	
	if(id_caja == "0")msg += "Debe seleccionar una Caja disponible <br>";
	if(saldo_inicial == "")msg += "Debe ingresar el saldo inicial de caja <br>";

	if(msg!=""){
        bootbox.alert(msg);
        return false;
    }
	
    $.ajax({
			url: "/ingreso/sendCaja",
            type: "POST",
            data : {accion:accion,id_caja_ingreso:id_caja_ingreso,id_caja:id_caja,saldo_inicial:saldo_inicial,total_recaudado:total_recaudado,saldo_total:saldo_total,estado:estado,_token:_token},
            success: function (result) {  
					location.reload();
              
            }
    });
}

function guardar_agremiado(){
    //alert("cvvfv");
    var msg = "";
    
	fn_save();
}

function fn_save(){
    
    $.ajax({
			url: "/agremiado/send",
            type: "POST",
            //data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmExpediente").serialize(),
            success: function (result) {  
                    
					window.location.reload();
					//Limpiar();
					/*$('#openOverlayOpc').modal('hide');
					$('#calendar').fullCalendar("refetchEvents");
					modalDelegar(fecha_atencion_original);*/
					//modalTurnos();
					//modalHistorial();
					//location.href="ver_cita/"+id_user+"/"+result;
            }
    });
}

function Limpiar(){
	
	//$('#tblProductos tbody').html("");
	//$('#id_solicitud').val("0");
	$('#nombre_py').val("");
	$('#detalle_py').val("");
	$('#txtIdUbiDepar').val("");
	$('#txtIdUbiProv').html('<option value="">- Seleccione -</option>');
	$('#ubigeodireccionprincipal').html('<option value="">- Seleccione -</option>');
	
	/*
	var newRow = "";
	newRow += '<img src="" id="img_ruta_1" class="img_ruta" width="130px" height="165px" alt="" style="text-align:center;margin-top:8px;display:none;margin-left:10px" />';
	newRow += '<input type="hidden" id="img_foto_1" name="img_foto[]" value="" />';
	$('#divImagenes').html(newRow);
	*/
	
}

function DeleteImagen(obj){
	
	//var obj = $(obj).parent().html();
	//console.log(obj);
	var obj = $(obj).parent().remove();
	
	//alert(obj);
	
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
		
	var numero_placa = $("#numero_placa").val();
	var flagBalanza = $("#flagBalanza").val();
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	$('#tblProductos tbody').html("");
	$('#nombre_empresa').val("");
	$('#numero_ejes').val("");
	$('#numero_ejes').val("");
	$('#peso_seco').val("");
	$('#procedencia').val("");
	$('#conductor').val("");
	$('#numero_documento').val("");
	$('#nombres_razon_social').val("");
	$('#servicio').val("");
	
	$.ajax({
		url: '/pesaje/obtener_datos_vehiculo/' + numero_placa,
		dataType: "json",
		success: function(result){
			if (result) {
				// Ver por la placa si el camion sigue dentro del estacionamiento.
				$('#estado_pesaje').val(result.estado);
				if (result.estado == '1') {
					bootbox.alert("El vehiculo no ha ingresado");
        			return false;
				} else {
					$("#id_ingreso_vehiculo").val(result.id);
					//$("#id_ubicacion").val(result.ubicacion_id);
					$('#nombre_empresa').val(result.empresa_transporte);
					$('#numero_ejes').val(result.ejes);
					$('#numero_documento').val(result.dueno_carga_documento);
					$('#nombres_razon_social').val(result.dueno_carga_nombre);
					$('#empresa_direccion').val(result.direccion);
					$('#procedencia').val(result.procedencia);
					$('#servicio').val(result.servicio);
					$('#peso_seco').val(result.peso_seco);
					if(result.peso_seco==null){
						$('#peso_seco').attr("disabled",false);
					}
					$('#exonerado').val(result.exonerado);
					$('#id_estacionamiento').val(result.id_estacionamiento);
					$('#msg_estacionamiento').html("Estacionamiento : "+result.estacionamiento);
					$('#tipo_comercio').attr("disabled",true);
					$('#conductor').val(result.conductor);

					var peso_ingreso = result.peso_ingreso;
					var fecha_ingreso = result.fecha_ingreso;
					$('#peso_ingreso_tmp').val(peso_ingreso);
					$('#fecha_ingreso_tmp').val(fecha_ingreso);
					$('#id_ubicacion').val(result.id_ubicacion);
					$('#persona_id').val(result.persona_id);

					$.ajax({
						url: '/pesaje/obtener_datos_carga/' + result.id,
						dataType: "json",
						success: function(data){
							
							var newRow = "";
							var ind = $('#tblProductos tbody tr').length;
							var tabindex = 11;
							$.map(data,function(obj){
								//cargaProductoExistente(obj.producto, obj.porcentaje)
								newRow ='<tr>';
								newRow +='<td><input value="'+obj.producto+'" onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="producto_especie_[]" required="" readonly="readonly" id="producto_especie'+ind+'" class="limpia_text nro_solicitado producto_especie input-sm   form-control form-control-sm text-left" style="margin-left:4px; width:80%" /></td>';
								
								newRow +='<td><input value="'+obj.unidad+'" onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="medida_especie[]" required="" readonly="readonly" id="medida_especie'+ind+'" class="limpia_text nro_solicitado medida_especie input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:120px" /></td>';
								
								newRow +='<td><input value="'+obj.porcentaje+'" onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="porcentaje_especie_[]" required="" readonly="readonly" id="porcentaje_especie'+ind+'" class="limpia_text nro_solicitado porcentaje_especie input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
								
								newRow +='<td><input value="'+obj.peso+'" onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="cantidad_especie_[]" required="" readonly="readonly" id="cantidad_especie'+ind+'" class="limpia_text nro_solicitado cantidad_especie input-sm   form-control form-control-sm text-right" style="margin-left:4px; width:100px" /></td>';
								
								newRow +='<td><button type="button" class="btn btn-danger btn-xs" style="margin-left:4px" disabled="disabled"><i class="fa fa-times"></i> Eliminar</button></td>';
								newRow +='</tr>';
								$('#tblProductos tbody').append(newRow);
								ind++;
								 
							}); 
							
						}
					});
					
					$('#ventaRecarga').prop("disabled",false);
					$('#boton_pesar').html("PESAR_SALIDA");
				}
				
			} else {
				alert("El vehículo no esta registrado");
			}
		}
		
	});
	
}

function AddFila(){
	
	var newRow = "";
	var ind = $('#tblProductos tbody tr').length;
	var tabindex = 11;
	var nuevalperiodo = "";
	
	var item_tipo 	= "";
	$('#idTipoGarantiaTemp option').each(function(){
		item_tipo += "<option value="+$(this).val()+">"+$(this).html()+"</option>"	
	});
	/*
	var item_moneda		= "";
	$('#idMoneda option').each(function(){
		item_medida += "<option value="+$(this).val()+">"+$(this).html()+"</option>"	
	});
	*/
	newRow +='<tr>';
	newRow +='<td><select class="form-control form-control-sm id_tipo" id="id_tipo'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="id_tipo[]">'+item_tipo+'</select></td>';
	//newRow +='<td><select class="form-control form-control-sm idUnidad" id="idUnidad'+ind+'" ind="'+ind+'" tabindex="'+tabindex+'" name="id_unidad[]" style="margin-left:4px; width:120px">'+item_medida+'</select>';
	
	newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="descripcion[]" required="" id="descripcion'+ind+'" class="limpia_text nro_solicitado descripcion input-sm form-control form-control-sm text-left" style="margin-left:4px;" /></td>';
	
	newRow +='<td><input onKeyPress="return soloNumerosMenosCero(event)" type="text" tabindex="'+(tabindex+2)+'" data-toggle="tooltip" data-placement="top" title="Ingresar la cantidad prescrita y presionar Enter para ingresar la cantidad entregada" name="valor_actual[]" required="" id="valor_actual'+ind+'" class="limpia_text nro_solicitado valor_actual input-sm form-control form-control-sm text-right" style="margin-left:4px;" /></td>';
	
	//newRow +='<td><button type="button" class="btn btn-danger deleteFila btn-xs" style="margin-left:4px"><i class="fa fa-times"></i> Eliminar</button></td>';
	newRow +='</tr>';
	$('#tblProductos tbody').append(newRow);
	
	$("#id_tipo"+ind).select2({max_selected_options: 4});
	
	$("#id_tipo"+ind).on("change", function (e) {
		var flagx = 0;
		cmb = $(this);
		id_especie = $("#id_tipo"+ind).val();
	
		$('.id_tipo').each(function(){
			var ind_tmp = $(this).val();
			if($(this).val() == id_especie)flagx++;
		});
	
		if(flagx > 1){
			bootbox.alert("El Tipo de Garantia ya ha sido ingresado");
			$("#idEspecie"+ind).val("").trigger("change");
			return false;
		}
		
	});
	
	
}

// Padding Zeros
function pad (str, max) {
	str = str.toString();
	return str.length < max ? pad("0" + str, max) : str;
  }

// Funciones para Agregar y eliminar productos en la Declaracionde carga

var cuentaproductos=1;


// Funcion para evitar escribir texto no numerico en un input text
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}




function validar() {
	
	var msg = "";
	var sw = true;
	
	//var MonAd = $('#MonAd').val();
	var total = $('#precio_peso').val();

	
	if (sw == false) {
		bootbox.alert(msg);
		return sw;
	} else {
		//submitFrm();
		document.frmPesajeCarreta.submit();
	}
	return false;
}



// Codigo Alternativo para Autocompletar con Ajax para el producto
$(document).ready(function () {

	// Poner el foco en la placa
	//$('#numero_placa').focus();

	// El brevete, nombre, apellidis deben estar escritos con mayuscula 
	$(function() {
		$('#modalChoferForm #nro_brevete').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalChoferForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalChoferForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalChoferForm #nombres_chofer').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #apellido_paterno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #apellido_materno').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalPersonaForm #nombres_chofer').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#empresa_razon_social').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#modalEmpresaForm #empresa_razon_social').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#vehiculo_numero_placa').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#vehiculo_empresa').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#producto01').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#empresa_persona').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#empresa_nuevo_dueno_carga').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
	$(function() {
		$('#persona_nuevo_dueno_carga').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});

	$('#modalChoferSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');
	
		$.ajax({
		  data: $('#modalChoferForm').serialize(),
		  url: "/afiliacion/send_ajax",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {
	
			  $('#modalPersonaForm').trigger("reset");
			  $('#choferModal').modal('hide');

			  var mySelect = $('#lista_chofer');
			  mySelect.append(
				  $('<option></option>').val(data.persona_id).html(data.nombre_apellido)
			  );
			  alert("El chofer ha sido ingresado correctamente!");

	
		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalChoferSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
    });
    
	$('#modalPersonaSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');
	
		$.ajax({
		  data: $('#modalPersonaForm').serialize(),
		  url: "/afiliacion/nueva_persona_ajax",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {
	
			  $('#modalPersonaForm').trigger("reset");
              $('#personaModal').modal('hide');
			  $('#numero_documento').val(data.numero_documento);
			  $('#persona_id').val(data.persona_id);
			  $("#id_ubicacion").val(data.ubicacion_id);//
              $('#nombres_razon_social').val(data.nombre_apellido);

			  alert("La persona ha sido ingresada correctamente!");
	
		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalPersonaSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
	});
    
	$('#modalPersonaCarretaSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');
	
		$.ajax({
		  data: $('#modalPersonaForm').serialize(),
		  url: "/afiliacion/nueva_persona_ajax",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {
	
			  $('#modalPersonaForm').trigger("reset");
              $('#personaModal').modal('hide');
			  $('#numero_documento').val(data.numero_documento);
			  $('#persona_id').val(data.persona_id);
			  $('#nombres_razon_social').val(data.nombre_apellido);
			  $('#id_ubicacion').val(3070);

			  alert("La persona ha sido ingresada correctamente!");
	
		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalPersonaSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
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
			var empresa_id = $('#empresa_id').val();
            $.ajax({
              data: $('#modalNuevoDuenoCargaForm').serialize()+"&empresa_id="+empresa_id,
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


    $("#modalNuevoEmpresaPersonaBtn").click(function (e) {
        e.preventDefault();
        $('#duenoCargaModal').modal('hide');
        if ($("#modalNuevoEmpresaPersonaBtn").html() == "Nueva persona") {
            $('#personaModal').modal('show');
        } else {
            $('#empresaNuevaModal').modal('show');
        }
	});

	$('#modalNuevaEmpresaSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');
	
		$.ajax({
		  data: $('#modalNuevaEmpresaForm').serialize(),
		  url: "/empresa/send_nueva_empresa_ajax",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {
	
			  $('#modalNuevaEmpresaForm').trigger("reset");
              $('#empresaNuevaModal').modal('hide');
              $('#numero_documento').val(data.ruc);
              $('#nombres_razon_social').val(data.razon_social);
              $('#empresa_direccion').val(data.direccion);
              $('#email').val(data.email);
			  $('#id_ubicacion').val(data.id_ubicacion);
              $('#persona_id').val('0');
              $('#modalNuevoEmpresaPersonaBtn').hide();

			  alert(data.msg);
              $("#modalNuevaEmpresaSaveBtn").html("Grabar");
	
		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalNuevaEmpresaSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
    });
    
	$('#modalEmpresaSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');
	
		$.ajax({
		  data: $('#modalEmpresaForm').serialize(),
		  url: "/empresa/send_ajax",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {
	
			  $('#modalEmpresaForm').trigger("reset");
			  $('#empresaModal').modal('hide');

			  alert(data.msg);
              $("#modalEmpresaSaveBtn").html("Grabar");
	
		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalEmpresaSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
	});

	$('#modalVehiculoSaveBtn').click(function (e) {
		e.preventDefault();
		$(this).html('Enviando datos..');
	
		$.ajax({
		  data: $('#modalVehiculoForm').serialize(),
		  url: "/vehiculo/send_ajax",
		  type: "POST",
		  dataType: 'json',
		  success: function (data) {
	
			  $('#modalVehiculoForm').trigger("reset");
			  $('#vehiculoModal').modal('hide');

        alert(data.msg);
        $("#nombre_empresa").val(data.vehiculo_empresa);
        $("#numero_placa").val(data.vehiculo_numero_placa);
        $("#numero_ejes").val(data.ejes);
        $("#numero_documento").val(data.ruc);
        $("#nombres_razon_social").val(data.razon_social);
        $("#empresa_direccion").val(data.direccion);

        $("#modalVehiculoSaveBtn").html("Grabar");
	
		  },
		  error: function(data) {
        mensaje = "Revisar el formulario:\n\n";
        $.each( data["responseJSON"].errors, function( key, value ) {
          mensaje += value +"\n";
        });
        $("#modalVehiculoSaveBtn").html("Grabar");
        alert(mensaje);
      }
	  });
	});

	$('#vehiculo_empresa').focusin(function() { $('#vehiculo_empresa').select(); });

	$('#empresa_nuevo_dueno_carga').focusin(function() { $('#empresa_nuevo_dueno_carga').select(); });

	$('#persona_nuevo_dueno_carga').focusin(function() { $('#persona_nuevo_dueno_carga').select(); });
	
	
	$('#btn_guardar___').click(function (e) {
        e.preventDefault();
        msg = "";

        if ($("#numero_placa").val() == '') {
            msg += "\nIngrese el numero de placa";
        }
        if ($("#nombre_empresa").val() == '') {
            msg += "\nIngrese el nombre de empresa del vehículo";
        }
        if ($("#procedencia").val() == '0') {
            msg += "\nElija la procedencia de la carga";
        }
        if ($("#lista_chofer").val() == '') {
            msg += "\nElija un conductor";
        }
        if ($("#numero_documento").val() == '' || $("#nombres_razon_social").val() == '') {
            msg += "\nElija un dueño de carga";
        }
        if ($("#producto01").val() == '') {
            msg += "\nElija un al menos un producto en la declaración de carga";
        }

        if (msg != "") {
            alert("Atencion, faltan los siguientes datos:\n"+msg);
        } else {
            

        if ($("#boton_pesar").html() == "PESAR_INGRESO") {
            alert("Aun no ha pesado el ingreso");
        } else {
            $.ajax({
                data: $('#frmPesaje').serialize(),
                url: "/vehiculo/ingreso_ajax",
                type: "POST",
                dataType: 'json',
                success: function (data) {
            
                        $('#modalVehiculoForm').trigger("reset");
                        $('#vehiculoModal').modal('hide');
                
                        alert(data.msg);
                        $("#nombre_empresa").val(data.vehiculo_empresa);
                        $("#numero_placa").val(data.vehiculo_numero_placa);
                        $("#numero_ejes").val(data.ejes);
                        $("#numero_documento").val(data.ruc);
                        $("#nombres_razon_social").val(data.razon_social);
                        $("#empresa_direccion").val(data.direccion);
                
                        $("#modalVehiculoSaveBtn").html("Grabar");
            
                    },
                    error: function(data) {
                    mensaje = "Revisar el formulario:\n\n";
                    $.each( data["responseJSON"].errors, function( key, value ) {
                        mensaje += value +"\n";
                });
                $("#modalVehiculoSaveBtn").html("Grabar");
                alert(mensaje);
                }
                });
        }


            $("#btn_boleta").prop('disabled', false);
            $("#btn_factura").prop('disabled', false);
        }
    });
        
});

// Manejar Ajax para mandar datos del Formulario Modal

function datatablenew(){
    var oTable = $('#tblSolicitud').dataTable({
        "bServerSide": true,
        "sAjaxSource": "/empresa/listar_empresa_ajax",
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
			
			var nombre_py_bus = $('#nombre_py_bus').val();
			var detalle_py_bus = $('#detalle_py_bus').val();
			var estado = $('#estado').val();
			var estado_py = $('#estado_py_bus').val();
			
			var _token = $('#_token').val();
            oSettings.jqXHR = $.ajax({
				"dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data":{NumeroPagina:iNroPagina,NumeroRegistros:iCantMostrar,
						nombre_py_bus:nombre_py_bus,detalle_py_bus:detalle_py_bus,
						estado:estado,estado_py:estado_py,
						_token:_token
                       },
                "success": function (result) {
                    fnCallback(result);
					
					//var moneda = result.aaData[0].moneda;
					//alert(moneda);
					
					
                },
                "error": function (msg, textStatus, errorThrown) {
                }
            });
        },
		"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			if (aData.moneda == "DOLARES") {
				$('td', nRow).addClass('verde');
			} 
		},
        "aoColumnDefs":
            [	
			 	{
                "mRender": function (data, type, row, meta) {	
                	var numero = "";
					if(row.numero!= null)numero = row.numero;
					return numero;
                },
                "bSortable": false,
                "aTargets": [0]
                },
				{
                "mRender": function (data, type, row) {
                	var anio = "";
					if(row.anio!= null)anio = row.anio;
					return anio;
                },
                "bSortable": false,
                "aTargets": [1],
				},
				{
                "mRender": function (data, type, row) {
					var glosa = "";
					if(row.glosa!= null)glosa = row.glosa;
					return glosa;
                },
                "bSortable": false,
                "aTargets": [2],
                },
				{
                "mRender": function (data, type, row) {
					var descripcion = "";
					if(row.descripcion!= null)descripcion = row.descripcion;
					return descripcion;
                },
                "bSortable": false,
                "aTargets": [3],
                },
				{
                "mRender": function (data, type, row) {
                    var departamento = "";
					if(row.departamento!= null)departamento = row.departamento;
					return departamento;
                },
                "bSortable": false,
                "aTargets": [4]
                },
                {
                "mRender": function (data, type, row) {
                	var provincia = "";
					if(row.provincia!= null)provincia = row.provincia;
					return provincia;
                },
                "bSortable": false,
                "aTargets": [5]
                },
				{
                "mRender": function (data, type, row) {
                	var distrito = "";
					if(row.distrito!= null)distrito = row.distrito;
					return distrito;
                },
                "bSortable": false,
                "aTargets": [6]
                },
				{
                "mRender": function (data, type, row) {
                	var distrito_judicial = "";
					if(row.distrito_judicial!= null)distrito_judicial = row.distrito_judicial;
					return distrito_judicial;
                },
                "bSortable": false,
                "aTargets": [7]
                },
				{
                "mRender": function (data, type, row) {
                	var organo_jurisdiccional = "";
					if(row.organo_jurisdiccional!= null)organo_jurisdiccional = row.organo_jurisdiccional;
					return organo_jurisdiccional;
                },
                "bSortable": false,
                "aTargets": [8]
                },
				{
                "mRender": function (data, type, row) {
                	var nombre_materia = "";
					if(row.nombre_materia!= null)nombre_materia = row.nombre_materia;
					return nombre_materia;
                },
                "bSortable": false,
                "aTargets": [9]
                },
				{
                "mRender": function (data, type, row) {
                	var estado_exp = "";
					if(row.estado_exp!= null)estado_exp = row.estado_exp;
					return estado_exp;
                },
                "bSortable": false,
                "aTargets": [10]
                },
				{
                "mRender": function (data, type, row) {
                	var nombre_py = "";
					if(row.nombre_py!= null)nombre_py = row.nombre_py;
					return nombre_py;
                },
                "bSortable": false,
                "aTargets": [11]
                },
				
            ]


    });


	fn_util_LineaDatatable("#tblSolicitud");
	
	/*
    $('#tblSolicitud tbody').on('click', 'tr', function () {
        var anSelected = fn_util_ObtenerNumeroFila(oTable);
        if (anSelected.length != 0) {
			var odtable = $("#tblSolicitud").DataTable();
			var idSolicitud = odtable.row(this).data().id;
			var id_estado = odtable.row(this).data().id_estado;
			$('#estado').val(id_estado);
			//alert(idSolicitud);
			Limpiar();
			obtenerSolicitud(idSolicitud);
			
			//var iIdProducto = odtable.row(this).data().iIdProducto;
			//AsignarDatosProductoCompra(iIdProveedor,iIdProducto)
        }
    });
	*/
	
	
	$('#tblSolicitud tbody').on('dblclick', 'tr', function () {
		var anSelected = fn_util_ObtenerNumeroFila(oTable);
		if (anSelected.length != 0) {
			
			var odtable = $("#tblSolicitud").DataTable();
			//console.log(odtable.row(this).data());
			var idExpediente = odtable.row(this).data().id;
			
			obtenerExpediente(idExpediente);
			
		}
	});

}

function fn_ListarBusqueda() {
    datatablenew();
};

function modalEstudio(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/agremiado/modal_agremiado_estudio/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalEmpresa(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/empresa/modal_empresa_nuevoEmpresa/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

function modalMulta(id){
	
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/multa/listar_datosAgremiado_ajax/"+id,
			type: "GET",
			success: function (result) {
					$("#diveditpregOpc").html(result);
					$('#openOverlayOpc').modal('show');
			}
	});

}

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
