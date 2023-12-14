const { truncate } = require("lodash");

$(document).ready(function () {

	$('#numero_documento').keypress(function (e) {
		if (e.keyCode == 13) {
			obtenerBeneficiario();
		}
	});

	
	
	$('#example-select-all').on('click', function(){
		if($(this).is(':checked')){
			$('.mov').prop('checked', true);
		}else{
			$('.mov').prop('checked', false);
		}
		
		calcular_total();
		/*
		var total = 0;
		$(".mov:checked").each(function (){
			var val_total = $(this).parent().parent().parent().find('.val_total').html();
			total += Number(val_total); 
		});
		$('#total').val(total);
		*/
	});
});


function validarMonAd(){

	var total = $('#total').val();
	var MonAd = $('#MonAd').val();
	
	total = parseFloat(total);
	MonAd = parseFloat(MonAd);

	if(MonAd > total){
		bootbox.alert("El monto ingresado no puede ser mayor al valor seleccionado");
		$('#MonAd').val(total)
		return false;
	}
	
}

function guardarValorizacion(){
    
    var msg = "";
    //var id_establecimiento = $('#id_establecimiento').val();
    //var id_servicio = $('#id_servicio').val();
	
	//if(dni_beneficiario == "")msg += "Debe ingresar el Numero de Documento <br>";
    //if(id_establecimiento=="")msg+="Debe seleccionar un Establecimiento<br>";
    //if(id_servicio=="")msg+="Debe ingresar un Servicio<br>";
	//if($('input[name=horario]').is(':checked')==false)msg+="Debe seleccionar un Turno<br>";
	/*
	if($('input[name=horario]').is(':checked')==true){
		var horario = $('input[name=horario]:checked').val();
		var data = horario.split("#");
		var fecha_cita = data[0];
		var id_medico = data[1];
	}
	*/

	/*
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
        fn_save();
	}
	*/
	fn_save();
}

function fn_save(){
    
    //var fecha_atencion_original = $('#fecha_atencion').val();
	//var id_user = $('#id_user').val();
    $.ajax({
			url: "/ingreso/send",
            type: "POST",
            //data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmValorizacion").serialize(),
            success: function (result) {  
					cargarValorizacion();
					cargarPagos();
					//cargarDudoso();
                    /*$('#openOverlayOpc').modal('hide');
					$('#calendar').fullCalendar("refetchEvents");
					modalDelegar(fecha_atencion_original);*/
					//modalTurnos();
					//modalHistorial();
					//location.href="ver_cita/"+id_user+"/"+result;
            }
    });
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
	//alert(id_caja);return false;
    //var fecha_atencion_original = $('#fecha_atencion').val();
	//var id_user = $('#id_user').val();
    $.ajax({
			url: "/ingreso/sendCaja",
            type: "POST",
            //data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : {accion:accion,id_caja_ingreso:id_caja_ingreso,id_caja:id_caja,saldo_inicial:saldo_inicial,total_recaudado:total_recaudado,saldo_total:saldo_total,estado:estado,_token:_token},
            success: function (result) {  
					//cargarValorizacion();
					//cargarPagos();
					location.reload();
              
            }
    });
}
function cargarcboTipoConcepto(){    	

	$.ajax({
		url: "/ingreso/listar_valorizacion_concepto",
		type: "POST",
		data : $("#frmValorizacion").serialize(),
		success: function(result){
			var option = "<option value='' selected='selected'>Seleccionar Concepto</option>";
			$('#cboTipoConcepto_b').html("");
			$(result).each(function (ii, oo) {
				option += "<option value='"+oo.id+"'>"+oo.denominacion+"</option>";
			});
			$('#cboTipoConcepto_b').html(option);
			$('#cboTipoConcepto_b').select2();
			
			//$('.loader').hide();			
		}
		
	});
}



function calcular_total(obj){
	
	if(id_caja_usuario=="0"){
		bootbox.alert("Debe seleccionar una Caja disponible");
		$(obj).prop("checked",false);
		return false;
	}
	
	if($(obj).is(':checked')){
		var key = $(obj).attr("key");
		//console.log($(obj).parent().parent().parent().prev().find(".mov").html());
		$(obj).parent().parent().parent().prev().find(".mov").prop('disabled',false);
		//var key2 = $(obj).parent().parent().parent().prev().find(".mov").attr("key");
		//alert(key+"|"+key2);
		$(obj).parent().parent().parent().find('.chek').val("1");


	}else{
		var key = $(obj).attr("key");
		var key2 = 0;
		$(".mov:checked").each(function (i){
			if(i==0)key2 = $(this).attr("key")-1;
		});
		
		if(key!=key2){
			bootbox.alert("Debe seleccionar el ultimo registro");
			$(obj).prop("checked",true);
			return false;
		}
		
		$(obj).parent().parent().parent().prev().find(".mov").prop('disabled',true);

		$(obj).parent().parent().parent().find('.chek').val("");
		
		
		//alert(key2);
		//var key2 = $(obj).parent().parent().parent().prev().find(".mov").attr("key");
		
		//$('.mov').prop('checked', false);
	}
		
	
	var total = 0;
	var descuento = 0;
	var valor_venta_bruto = 0;
	var valor_venta = 0;
	var igv = 0;
	//var cantidad = $("#tblValorizacion input[type='checkbox']:checked").length;
	var cantidad = $(".mov:checked").length;
	//alert(cantidad);
	//$("#tblValorizacion input[type='checkbox']:checked").each(function (){
	if(cantidad == 0)$('#tipo_factura').val("");
	var tipo_factura = $('#tipo_factura').val();
	$('#id_concepto_sel').val(tipo_factura);
	
	//alert(tipo_factura);
	var tipo_factura_actual = $(obj).parent().parent().parent().find('.tipo_factura').val();

	$('#idConcepto').val(tipo_factura_actual);
	
	
	if(tipo_factura!="" && tipo_factura!=tipo_factura_actual){
		bootbox.alert("La seleccion no pertence a los tipos de documento seleccionados");
		$(obj).prop("checked",false);
		return false;
	}
	
	
	
	

	$("#btnBoleta").prop('disabled', true);
    $("#btnFactura").prop('disabled', true);
	//$("#btnTicket").prop('disabled', true).hide();

	$("#btnFracciona").prop('disabled', true);
	if(cantidad != 0){
		$("#btnFracciona").prop('disabled', false);
		//$("#btnBoleta").prop('disabled', false);
		//$("#btnFactura").prop('disabled', false);

		if(tipo_documento == "79"){//RUC
			
			$("#btnBoleta").prop('disabled', true);
			$("#btnFactura").prop('disabled', false);
		}else
		{
			$("#btnBoleta").prop('disabled', false);
			if(ruc_p!= "") $("#btnFactura").prop('disabled', false);
		}
	}
	

	
	
	if(tipo_documento == "79"){//RUC
		//$("#btnBoleta").prop('disabled', false);
        //$("#btnFactura").prop('disabled', false);
		//$("#btnBoleta").show();
		//$("#btnTicket").hide();

		//$("#btnBoleta").prop('disabled', true);
		//$("#btnFactura").prop('disabled', false);
	}else
	{
		//$("#btnBoleta").prop('disabled', false);
		//$("#btnFactura").prop('disabled', true);
	}

	//if(tipo_factura_actual=="TK"){
		//$("#btnTicket").prop('disabled', false);
		//$("#btnTicket").show();
		//$("#btnBoleta").hide();
	//}


//$("#btnBoleta").prop('disabled', false);
//$("#btnFactura").prop('disabled', false);

	//alert(tipo_factura_actual);
	
	$(".mov:checked").each(function (){
		var val_total = $(this).parent().parent().parent().find('.val_total').html();
		var val_descuento = $(this).parent().parent().parent().find('.val_descuento').html();
		tipo_factura = $(this).parent().parent().parent().find('.tipo_factura').val();
		
		if(val_descuento!=""){
			valor_venta_bruto = val_total/1.18;
			descuento = (val_total*val_descuento/100)/1.18;
			valor_venta = valor_venta_bruto - descuento;
			igv = valor_venta*0.18;
			total += igv + valor_venta_bruto - descuento;	
		}else{
			total += Number(val_total);
		}
		//alert(val_total);
		

	});
	
	$('#tipo_factura').val(tipo_factura);
	//total -= descuento;
	$('#total').val(total.toFixed(2));

	if(cantidad > 1){
		$('#MonAd').attr("readonly",true);
		$('#MonAd').val("0");
	}else{
		$('#MonAd').attr("readonly",false);
		$('#MonAd').val(total.toFixed(2));
	}	
}

function calcular_total_(obj){
		
	var total = 0;
	var cantidad = $(".mov_:checked").length;
	
	$(".mov_:checked").each(function (){
		var val_total = $(this).parent().parent().parent().find('.val_total').html();
		total += Number(val_total);
	});
	
	$('#total_concepto_').val(total.toFixed(2));

	
}

function calcular_dudoso(obj){
	
	if(id_caja_usuario=="0"){
		bootbox.alert("Debe seleccionar una Caja disponible");
		$(obj).prop("checked",false);
		return false;
	}
	
	var total = 0;
	var descuento = 0;
	var valor_venta_bruto = 0;
	var valor_venta = 0;
	var igv = 0;
	
	var cantidad = $(".mov_dudoso:checked").length;
	
	$(".mov_dudoso:checked").each(function (){
		var val_total = $(this).parent().parent().parent().find('.val_total_dudoso').html();
		var val_descuento = $(this).parent().parent().parent().find('.val_descuento_dudoso').html();
		
		if(val_descuento!=""){
			valor_venta_bruto = val_total/1.18;
			descuento = (val_total*val_descuento/100)/1.18;
			valor_venta = valor_venta_bruto - descuento;
			igv = valor_venta*0.18;
			total += igv + valor_venta_bruto - descuento;	
		}else{
			total += Number(val_total);
		}

	});
	
	$('#total_dudoso').val(total.toFixed(2));
	
}

function validaTipoDocumento(){
	var tipo_documento = $("#tipo_documento").val();
	$('#nombre_afiliado').val("");
	$('#empresa_afiliado').val("");
	$('#empresa_direccion').val("");
	$('#empresa_representante').val("");
	$('#codigo_afiliado').val("");	
	$('#fecha_afiliado').val("");
	$('#numero_documento').val("");
	$('#empresa_razon_social').val("");
	$('#nombre_').val("");
	

	//$("#btnBoleta").prop('disabled', false);
    //$("#btnFactura").prop('disabled', false);

	//$("#btnTicket").prop('disabled', true).hide();
	//alert(tipo_documento);
	if(tipo_documento == "79"){ //RUC
		$('#divNombreApellido').hide();
		$('#divCodigoAfliado').hide();
		$('#divFechaAfliado').hide();
		$('#divRucP').hide();		
		$('#divDireccionEmpresa').show();
		$('#divRepresentanteEmpresa').show();
		$('#divEmpresaRazonSocial').show();
		

		//$("#btnBoleta").prop('disabled', false);
		//$("#btnFactura").prop('disabled', true);
	

	}else{
		$('#divNombreApellido').show();
		$('#divCodigoAfliado').show();
		$('#divFechaAfliado').show();
		$('#divRucP').show();
		$('#divDireccionEmpresa').hide();
		$('#divRepresentanteEmpresa').hide();
		$('#divEmpresaRazonSocial').hide();
		

		//$("#btnBoleta").prop('disabled', true);
		//$("#btnFactura").prop('disabled', false);
	
	}
	
	//obtenerBeneficiario();
}

function obtenerBeneficiario(){
	
	var tipo_documento = $("#tipo_documento").val();
	var numero_documento = $("#numero_documento").val();
	var msg = "";
	
	//alert(tipo_documento);
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	$('#empresa_id').val("");
	$('#id_persona').val("");
	$('#divTarjeta').hide();
	$('#numero_tarjeta').html("");
	$('#codigo_afiliado').val("");
	$('#btnDesafiliar').attr("disabled",true);
	$('#btnInactivar').attr("disabled",true);
	$('#foto').attr('src','/img/profile-icon.png');

	$('#btnOtroConcepto').attr("disabled",true);

	$("#btnFracciona").prop('disabled', true);
	$("#btnBoleta").prop('disabled', true);
	$("#btnFactura").prop('disabled', true);

	
	
	$.ajax({
		url: '/agremiado/obtener_agremiado/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){

			if (result) {
				//alert(result.agremiado.id);
				//alert(result);

				if (tipo_documento == "79")//RUC
				{
					$('#empresa_razon_social').val(result.agremiado.razon_social);
					$('#empresa_direccion').val(result.agremiado.direccion);
					$('#empresa_representante').val(result.agremiado.representante);
					$('#empresa_id').val(result.agremiado.id);
					$('#id_ubicacion').val(result.agremiado.id);

					$('#nombre_').val(result.agremiado.razon_social);
					$('#fecha_colegiatura').val(result.agremiado.representante);
					$('#id_tipo_documento_').val(tipo_documento);
					$('#id_tipo_documento').val(tipo_documento);


					$('#btnOtroConcepto').attr("disabled", false);

					

				} else if (tipo_documento == "85") //CAP
				{
					var agremiado = result.agremiado.apellido_paterno + " " + result.agremiado.apellido_materno + ", " + result.agremiado.nombres;
					$('#nombre_').val(agremiado);
					$('#situacion_').val(result.agremiado.situacion);
					$('#fecha_colegiatura').val(result.agremiado.actividad);
					$('#fecha_').val(result.agremiado.fecha_colegiado);
					$('#id_persona').val(result.agremiado.id_p);
					$('#id_agremiado').val(result.agremiado.id);
					$('#ruc_p').val(result.agremiado.numero_ruc);
					$('#id_ubicacion_p').val("0");

					$('#numero_documento_').val(result.agremiado.numero_documento);
					$('#id_tipo_documento_').val(tipo_documento);
					$('#id_tipo_documento').val(tipo_documento);
					
					$('#btnOtroConcepto').attr("disabled", false);
					 

				} else {
					var agremiado = result.agremiado.apellido_paterno + " " + result.agremiado.apellido_materno + ", " + result.agremiado.nombres;
					$('#nombre_').val(agremiado);
					$('#situacion_').val(result.agremiado.situacion);
					$('#fecha_colegiatura').val(result.agremiado.actividad);
					$('#fecha_').val(result.agremiado.fecha_colegiado);
					$('#id_persona').val(result.agremiado.id_p);
					$('#id_agremiado').val(result.agremiado.id);
					$('#ruc_p').val(result.agremiado.numero_ruc);
					$('#id_ubicacion_p').val("0");

					$('#numero_documento_').val(tipo_documento);
					$('#id_tipo_documento_').val(tipo_documento);
					$('#btnOtroConcepto').attr("disabled", false);
					
					

				}

				if (result.agremiado.foto != null && result.agremiado.foto != "") {
					$('#foto').attr('src', '/img/dni_asociados/' + result.agremiado.foto);
				} else {
					$('#foto').attr('src', '/img/profile-icon.png');
				}


				cargarValorizacion();
				cargarPagos();
				cargarcboTipoConcepto();
				//cargarDudoso();
			}
			else {

				alert("registro no registrado");

			}
			
		},
		"error": function (msg, textStatus, errorThrown) {

			if(tipo_documento == "85" || tipo_documento == "79"){
				Swal.fire("Numero de documento no fue registrado!");
			}else{
				confirma_accion();
			}
			

		}
		
		
	});
	
}

function confirma_accion(){
	Swal.fire({
	  title: 'El numero de documento no existe',
	  text: "¿Desea registrar como  nueva persona?",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Si, Crear!'
	}).then((result) => {
	  if (result.value) {
		modal_persona_new();
		//document.location="eliminar.php?codigo="+id;
		
	  }
	});
  }


function eliminarAfiliado(id){
	
	var id = $('#id_persona').val();
	//alert(id_persona);return false;
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Seguro que deseas desafiliar?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_afiliado(id);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_afiliado(id){
	
	var id_plan = $('#id_plan').val();
    $.ajax({
            url: "/afiliacion/desafiliar/"+id,
            type: "GET",
            success: function (result) {
                if(result="success"){
					obtenerBeneficiario();	
				}
            }
    });
}


function cargarValorizacion1(){
    
    
	//var numero_documento = $("#numero_documento").val();
	var tipo_documento = $("#tipo_documento").val();
	var id_persona = 0;
	if(tipo_documento=="RUC")id_persona = $('#empresa_id').val();
	else id_persona = $('#id_persona').val();

    $("#tblValorizacion tbody").html("");
	$.ajax({
			url: "/ingreso/obtener_valorizacion/"+tipo_documento+"/"+id_persona,
			type: "GET",
			success: function (result) {  
					$("#tblValorizacion tbody").html(result);
			}
	});

}
function cargarValorizacion(){
    
    
	//var numero_documento = $("#numero_documento").val();
	var tipo_documento = $("#tipo_documento").val();
	var id_persona = 0;

	//if(tipo_documento=="RUC")id_persona = $('#empresa_id').val();
	//else id_persona = $('#id_persona').val();

    $("#tblValorizacion tbody").html("");
	$.ajax({
		url: "/ingreso/listar_valorizacion",
		type: "POST",
		data : $("#frmValorizacion").serialize(),
		success: function (result) {  
			$("#tblValorizacion tbody").html(result);
		}
});

}




function cargarPagos(){
	var tipo_documento = $("#tipo_documento").val();
	var id_persona = 0;
	if(tipo_documento=="RUC")id_persona = $('#id_ubicacion').val();
	else id_persona = $('#id_persona').val();
	
	$('#tblPago').dataTable().fnDestroy();
    $("#tblPago tbody").html("");
	$.ajax({
			//url: "/ingreso/obtener_pago/"+numero_documento,
			url: "/ingreso/obtener_pago/"+tipo_documento+"/"+id_persona,
			type: "GET",
			success: function (result) {  
					$("#tblPago").html(result);
					$('[data-toggle="tooltip"]').tooltip();
					
					$('#tblPago').DataTable({
						//"sPaginationType": "full_numbers",
						//"paging":false,
						"searching": false,
						"info": false,
						"bSort" : false,
						"dom": '<"top">rt<"bottom"flpi><"clear">',
						"language": {"url": "/js/Spanish.json"},
					});
							
			}
	});

}

function cargarDudoso(){
    
	var tipo_documento = $("#tipo_documento").val();
	var id_persona = 0;
	if(tipo_documento=="RUC")id_persona = $('#id_ubicacion').val();
	else id_persona = $('#id_persona').val();

    $("#tblDudoso tbody").html("");
	$.ajax({
			url: "/ingreso/obtener_dudoso/"+tipo_documento+"/"+id_persona,
			type: "GET",
			success: function (result) {  
					$("#tblDudoso tbody").html(result);
			}
	});


}



function enviarTipo(tipo){
	if(tipo == 1)$('#TipoF').val("FTFT");
	if(tipo == 2)$('#TipoF').val("BVBV");
	if(tipo == 3)$('#TipoF').val("TKTK");
	if(tipo == 4)$('#NCFT').val("NCFT"); //'Nueva Nota Crédito Factura'
	if(tipo == 5)$('#NCBV').val("NCBV"); //'Nueva Nota Crédito Boleta de Venta'
	if(tipo == 6)$('#NDFT').val("NDFT"); //'Nueva Nota Dévito Factura'
	if(tipo == 7)$('#NDBV').val("NDBV"); //'Nueva Nota Dévito Boleta de Venta'



	validar(tipo);
}

function validar(tipo) {
	
	var msg = "";
	var sw = true;
	
	var MonAd = $('#MonAd').val();
	var total = $('#total').val();
	
	var tipo_documento = $('#tipo_documento').val();
    var id_persona = $('#id_persona').val();
	var empresa_id = $('#empresa_id').val();
	var mov = $('.mov:checked').length;

	var id_ubicacion_p = $('#id_ubicacion_p').val();

	//alert("id_persona-->"+ tipo_documento);
	//alert("id_persona-->"+ id_persona);
	//alert("empresa_id-->"+ empresa_id);
	
	if(tipo_documento != "79" && id_persona == "")msg += "Debe ingresar el Numero de Documento <br>";
	if(tipo_documento == "79" && empresa_id == "")msg += "Debe ingresar el Numero de Documento <br>";
	/*
	if (tipo != 4) {
		if(mov=="0")msg+="Debe seleccionar minimo un Concepto del Estado de Cuenta <br>";
	}
*/
	//if(tipo_documento == "DNI" && id_ubicacion_p == "" && tipo == 1)msg += "Para crear la Factura requiere RUC Personal <br>";

	
	if(msg!=""){
		bootbox.alert(msg);
		//return false;
	} else{
		if(tipo == 1 || tipo==2 || tipo==3) {
		//submitFrm();
		document.frmValorizacion.submit();
		//document.frmPagos.submit();
		}

		if(tipo = 5){

			


			//fn_nota_credito();
		}
	}

	return false;
}


function modalLiquidacion(id){
	
	$(".modal-dialog").css("width","80%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/ingreso/modal_liquidacion/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
			}
	});

}


function guardarEstado(estado){
    
    var msg = "";
    //var id_establecimiento = $('#id_establecimiento').val();
    //var id_servicio = $('#id_servicio').val();
	
	//if(dni_beneficiario == "")msg += "Debe ingresar el Numero de Documento <br>";
    //if(id_establecimiento=="")msg+="Debe seleccionar un Establecimiento<br>";
    //if(id_servicio=="")msg+="Debe ingresar un Servicio<br>";
	//if($('input[name=horario]').is(':checked')==false)msg+="Debe seleccionar un Turno<br>";
	/*
	if($('input[name=horario]').is(':checked')==true){
		var horario = $('input[name=horario]:checked').val();
		var data = horario.split("#");
		var fecha_cita = data[0];
		var id_medico = data[1];
	}
	*/

	/*
    if(msg!=""){
        bootbox.alert(msg); 
        return false;
    }
    else{
        fn_save();
	}
	*/
	fn_save_estado(estado);
}

function fn_save_estado(estado){
    
    $.ajax({
			url: "/ingreso/send_estado",
            type: "POST",
            data : $("#frmValorizacion").serialize()+"&estado="+estado,
            success: function (result) {  
					cargarValorizacion();
					cargarPagos();
					//cargarDudoso();
            }
    });
}


function eliminarPersonaTarjeta(){
	
	var id = $('#id_persona').val();
	var act_estado = "";	
	act_estado = "Inactivar";
	estado_=2;
	
    bootbox.confirm({ 
        size: "small",
        message: "&iquest;Deseas "+act_estado+" la Tarjeta?", 
        callback: function(result){
            if (result==true) {
                fn_eliminar_persona_tarjeta(id,estado_);
            }
        }
    });
    $(".modal-dialog").css("width","30%");
}

function fn_eliminar_persona_tarjeta(id_persona,estado){
	
    $.ajax({
            url: "/tarjeta/eliminar_persona_tarjeta/"+id_persona+"/"+estado,
            type: "GET",
			dataType: 'json',
            success: function (result) {
                
				if(result.sw==true){
					obtenerBeneficiario();
				}
				
            }
    });
}

function modal_otro_pago(){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');
	var perido = "2023";
	var idPersona = $('#id_persona').val();
	var idAgremiado = $('#id_agremiado').val();
	
	
	$.ajax({
			url: "/ingreso/modal_otro_pago/"+perido+"/"+idPersona+"/"+idAgremiado,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					//$('#openOverlayOpc').modal('show');
					
			}
	});
	//cargarConceptos();

}


function cargarConceptos(){
        
	//var numero_documento = $("#numero_documento").val();
	var periodo = "2023";

    $("#tblConceptos tbody").html("");
	$.ajax({
			url: "/ingreso/obtener_conceptos/"+periodo,
			type: "GET",
			success: function (result) {  
					$("#tblConceptos tbody").html(result);
			}
	});

}

function modalValorizacionFactura(id){
	
	$(".modal-dialog").css("width","80%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/ingreso/modal_valorizacion_factura/"+id,
			type: "GET",
			success: function (result) {  
					$("#diveditpregOpc").html(result);
			}
	});

}



function guardar_concepto_valorizacion(){

    $.ajax({
			url: "/ingreso/send_concepto",
            type: "POST",
            //data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmOtroPago").serialize(),
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

function modal_fraccionar(){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	var idPersona = $('#id_persona').val();
	var idAgremiado = $('#id_agremiado').val();
	var TotalFraccionar = $('#total').val();
	//alert(TotalFraccionar);
	var idConcepto = $('#idConcepto').val();
	//alert(idConcepto);
	
	
	$.ajax({
			url: "/ingreso/modal_fraccionar"+idConcepto+"/"+idPersona+"/"+idAgremiado+"/"+TotalFraccionar,
			type: "GET",
			//data : $("#frmOtroPago").serialize(),
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					//$('#openOverlayOpc').modal('show');
					
			}
	});

	//cargarConceptos();

}
function modal_fraccionamiento(){

	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	var idPersona = $('#id_persona').val();
	var idAgremiado = $('#id_agremiado').val();
	var TotalFraccionar = $('#total').val();
	//alert(TotalFraccionar);
	var idConcepto = $('#idConcepto').val();
	//alert(idConcepto);
	
	
	$.ajax({
			url: "/ingreso/modal_fraccionamiento",
			type: "POST",
			data : $("#frmValorizacion").serialize(),
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					//$('#openOverlayOpc').modal('show');
					
			}
	});
}

function modal_persona_new(){
	$(".modal-dialog").css("width","85%");
	$('#openOverlayOpc').modal('show');
	$('#openOverlayOpc .modal-body').css('height', 'auto');

	$.ajax({
			url: "/persona/modal_persona_new",
			type: "get",
			data : $("#frmValorizacion").serialize(),
			success: function (result) {  
					$("#diveditpregOpc").html(result);
					//$('#openOverlayOpc').modal('show');
					
			}
	});

	//cargarConceptos();

}

function guardar_fracciona_deuda(){

    $.ajax({
			url: "/ingreso/send_fracciona_deuda",
            type: "POST",
            //data : $("#frmCita").serialize()+"&id_medico="+id_medico+"&fecha_cita="+fecha_cita,
            data : $("#frmFracionaDeuda").serialize(),
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

function nc(){
	/*
	var id = $(obj).parent().parent().parent().find('.id_comprobante').val();

	$('#id_comprobante_').val(id);

	document.frmPagos.submit();
	*/
	
	document.forms["frmPagos"].submit();
	return false;
};

function nd(){
	
	document.forms["frmPagos_nd"].submit();
	return false;
};




function fn_nota_credito(id){
	
	var id_caja = $('#id_caja').val();


	$.ajax({
			url: "/comprobante/nc_edit/"+id+"/"+id_caja,
			type: "GET",
			data : $("#frmNC").serialize(),
			success: function (result) {  

				//	$("#diveditpregOpc").html(result);
					//$('#openOverlayOpc').modal('show');
					
			}
	});
	//cargarConceptos();
}
