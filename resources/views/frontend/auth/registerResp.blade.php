@extends('frontend.layouts.app')

@section('title', __('Register'))

@section('content')
    <div class="container py-4" style="max-width:1500px">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        Registro de Propietarios / Administrados
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.registerResp')" id="frmUsuario" name="frmUsuario" enctype="multipart/form-data" onsubmit="return validacion(event)">

                            <div class="form-row">
                                <div class="col-md-12 mb-3 d-flex justify-content-around">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value="PROP" checked="">
                                        <label class="form-check-label" for="inlineRadio1">Administrador/Propietario</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="inlineRadio2" value="RETRA">
                                        <label class="form-check-label" for="inlineRadio2">Responsable del tramite</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label>Tipo de Documento:</label>
                                    <select name="id_tipo_documento" id="id_tipo_documento" class="form-control" onchange="validarTipoDocumento()">
                            			<!--<option value="">--Seleccionar--</option>-->
										<?php
										foreach ($tipo_documento as $row) {
										?>
										<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
										<?php 
										}
										?>										        
                                    </select>
                                    
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label id="lbl_numero_documento">DNI:</label>
                                    <input type="number" name="numero_documento" class="form-control other-doc-case dni-case" maxlength="15"  id="numero_documento" onchange="obtenerDatosDni()">
                                    
                                </div>
                                
                            

                                <div class="col-md-4 mt-2" id="names_div">
                                    <label id="lbl_nombre">Nombres:</label>
                                    <input type="text" name="nombre" class="form-control upper-case just-letters" maxlength="100"  id="nombre" readonly="readonly">
                                    
                                </div>

                                <div class="col-md-4 mt-2 apellido" id="first_surname_div" style="display: block;">
                                    <label>Primer Apellido:</label>
                                    <input type="text" name="apellido_paterno" class="form-control upper-case just-letters" maxlength="50" id="apellido_paterno" readonly="readonly">
                                    
                                </div>
                                <div class="col-md-4 mt-2 apellido" id="second_surname_div" style="display: block;">
                                    <label>Segundo Apellido:</label>
                                    <input type="text" name="apellido_materno" class="form-control upper-case just-letters" maxlength="50" id="apellido_materno" readonly="readonly">
                                    
                                </div>
                                
                                <div class="col-md-4 mt-2">
                                    <label>Correo Electrónico:</label>
                                    <input type="text" name="email" class="form-control" maxlength="50" id="email">
                                    
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label>Correo Electrónico 2:</label>
                                    <input type="email" name="email2" id="email2" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" autocomplete="email" />
                                    
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label>Teléfono Celular:</label>
                                    <input type="number" name="celular" class="form-control cellphone-case" min="900000000" max="999999999" maxlength="20" id="celular">
                                    
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label>Teléfono Fijo:</label>
                                    <input type="number" name="telefono" class="form-control" placeholder="Ejemplo: 01202120" maxlength="20" id="telefono">
                                    
                                </div>
                                <div class="col-md-4 mt-2" id="address_div">
                                    <label id="address_title">Dirección:</label>
                                    <input type="text" name="direccion" class="form-control upper-case" maxlength="200" id="direccion">
                                    
                                </div>
                            </div>

                            <div class="form-row mb-2 mt-2">
                                <div class="col-md-4 foto">
                                    <label class="mb-3">Fotografía:</label>
                                    <input type="file" name="foto" class="form-control-file" accept="image/*" id="foto">
                                    
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Firma:</label>
                                    <input type="file" name="ruta_firma" class="form-control-file" accept="image/*" required="" id="ruta_firma">
                                </div>
                                
                                <div class="col-md-4 ">
                                    
                                    <img src="#" id="peview" width="100%" style="display: none;">
                                    
                                    
                                </div>
                                <div class="col-md-8 offset-md-4 foto">
                                    
                                    <span>Suba una imágen escaneada de su sello y firma, los cuales será utilizados como validación de las solicitudes que realice através del portal</span>
                                    
                                </div>
                            </div>
                            
                            <!--
                            <div class="btns">
                                <button class="btn btn-primary"> 
                                    Registrarme
                                </button>
                            </div>
                            -->

                            @if(config('boilerplate.access.captcha.registration'))
                                <div class="row">
                                    <div class="col">
                                        @captcha
                                        <input type="hidden" name="captcha_status" value="true" />
                                    </div><!--col-->
                                </div><!--row-->
                            @endif
                            <br>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" type="submit" id="btnRegister">Registrarse</button>
                                </div>
                            </div><!--form-group-->
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection


<script type="text/javascript">

function validarProfesion(){
    
    var id_profesion = $("#id_profesion").val();
    $(".divCap").hide();
    $(".divColegiatura").hide();

    if(id_profesion==1){
        $(".divCap").show();
        $('#numero_documento').prop("readonly",true);
        $('#apellido_paterno').prop("readonly",true);
        $('#apellido_materno').prop("readonly",true);
        $('#nombre').prop("readonly",true);
    }

    if(id_profesion==2){
        $(".divColegiatura").show();

        //$('#tipo_documento').val(agremiado.tipo_documento);
        $('#numero_documento').prop("readonly",false);
        $('#apellido_paterno').prop("readonly",true);
        $('#apellido_materno').prop("readonly",true);
        $('#nombre').prop("readonly",true);
        
    }

}

function validacion(evento){

    evento.preventDefault();

    var msg = "";
    var id_tipo_documento = $("#id_tipo_documento").val();
    var numero_documento = $("#numero_documento").val();
	var celular = $("#celular").val();
	var email = $("#email").val();
    var email2 = $("#email2").val();
    var direccion = $("#direccion").val();
    var password = $("#password").val();
    var password_confirmation = $("#password_confirmation").val();
    var id_agremiado = $("#id_agremiado").val();

    if(id_tipo_documento == "")msg += "Debe seleccionar el tipo de documento <br>";
    if(numero_documento == "")msg += "Debe ingresar el numero de documento <br>";
    if(celular == "")msg += "Debe ingresar el celular <br>";
    if(email == "")msg += "Debe ingresar el correo 1 <br>";
    if(direccion == "")msg += "Debe ingresar la direccion <br>";
    if(password == "")msg += "Debe ingresar la contraseña <br>";
	if(password_confirmation == "")msg += "Debe ingresar la confirmacion de la contraseña <br>";

	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	/*
    var buscar = "";
    if(id_profesion==1){
        buscar = numero_cap;
    }

    if(id_profesion==2){
        buscar = colegiatura;
    }
    */
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/persona/obtener_responsable/' + id_tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			
            var cantidad = result.cantidad;
            if (cantidad > 0) {
                bootbox.alert("Usted ya se encuentra inscrito. En caso de haber olvidado su contraseña seguir los pasos dando clic en ¿Olvidaste tu contraseña?");
                return false;
            }else{
                document.frmUsuario.submit();
            }
			$('.loader').hide();

		}
		
	});

}

function obtenerAgremiado(){
		
	var numero_cap = $("#numero_cap").val();
    var id_secret_code = $("#id_secret_code").val();
	var msg = "";
	
	if(numero_cap == "")msg += "Debe ingresar el numero de CAP <br>";
    if(id_secret_code == "")msg += "Debe ingresar el codigo secreto <br>";
	
	if (msg != "") {
		//bootbox.alert(msg);
		return false;
	}

    $('#tipo_documento').val("");
    $('#numero_documento').val("");
    $('#apellido_paterno').val("");
    $('#apellido_materno').val("");
    $('#nombre').val("");
    $('#celular').val("");
    $('#telefono').val("");
    $('#email').val("");
    $('#email2').val("");
    $('#direccion').val("");
    $('#id_agremiado').val("");
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/persona/obtener_agremiado_login/' + numero_cap + '/' + id_secret_code,
		dataType: "json",
		success: function(result){
			
			var agremiado = result.agremiado;
			$('#tipo_documento').val(agremiado.tipo_documento);
			$('#numero_documento').val(agremiado.numero_documento);
			$('#apellido_paterno').val(agremiado.apellido_paterno);
			$('#apellido_materno').val(agremiado.apellido_materno);
			$('#nombre').val(agremiado.nombres);
            $('#celular').val(agremiado.celular1);
			$('#telefono').val(agremiado.celular2);
			$('#email').val(agremiado.email1);
            $('#email2').val(agremiado.email2);
            $('#direccion').val(agremiado.direccion);
            $('#id_agremiado').val(agremiado.id);
            //$('#id_secret_code').val(agremiado.clave);

			$('.loader').hide();

		}
		
	});
	
}

function obtenerPersona(){
		
	var tipo_documento = $("#id_tipo_documento").val();
	var numero_documento = $("#numero_documento").val();
	var msg = "";
	
	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
	$.ajax({
		url: '/persona/obtener_persona_login/' + tipo_documento + '/' + numero_documento,
		dataType: "json",
		success: function(result){
			
			if(result.persona.id_situacion==83){
				bootbox.alert("No se puede registrar a un fallecido");
				$("#btnRegister").attr("disabled",true);
				return false;
			}
		
			var nombre_persona= result.persona.apellido_paterno+" "+result.persona.apellido_materno+", "+result.persona.nombres;
			$('#name').val(nombre_persona);
		},
		error: function(data) {
			//alert("Persona no encontrada en la Base de Datos.");
		}
		
	});
	
}

function obtenerDatosDni(){
    
    var id_tipo_documento = $("#id_tipo_documento").val();
    if(id_tipo_documento==84){
        $('#nombre_propietario').val("");
        $('#direccion_dni').val("");
        $('#celular_dni').val("");
        $('#email_dni').val("");
        $('#nombre_propietario').attr("readonly",false);
        $('#direccion_dni').attr("readonly",false);
        $('#celular_dni').attr("readonly",false);
        $('#email_dni').attr("readonly",false);
        return;
    }
    var numero_documento = $("#numero_documento").val();
    var msg = "";
    
    if(numero_documento == "")msg += "Debe ingresar el numero de documento <br>";
    
    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }
    
    var msgLoader = "";
    msgLoader = "Procesando, espere un momento por favor";
    var heightBrowser = $(window).width()/2;
    $('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
    
    if(id_tipo_documento==1){

        $.ajax({
            url: '/persona/obtener_datos_persona/' + numero_documento,
            dataType: "json",
            success: function(result){
                var persona = result.persona;

                if(persona!="0")
                {
                    $('#nombre').val(persona.nombre);
                    $('#apellido_paterno').val(persona.apellido_paterno);
                    $('#apellido_materno').val(persona.apellido_materno);
                    $('.loader').hide();
                    
                }else{
                    //alert("ok");
                    $('#nombre').val("");
                    $('#apellido_paterno').val("");
                    $('#apellido_materno').val("");
                    $('.loader').hide();
                    validaDni(numero_documento);
                    
                }

                if (msg != "") {
                    bootbox.alert(msg);
                    return false;
                }


            }
            
        });
        
    }

    if(id_tipo_documento==2){
        validaRuc(numero_documento)
    }

}


function validaDni(dni) {

    var numero_documento = $("#numero_documento").val();
    var tipo_documento = 78;
    var msg = "";

    if (msg != "") {
        bootbox.alert(msg);
        return false;
    }

    if (tipo_documento == "0" || numero_documento == "") {
        bootbox.alert(msg);
        return false;
    }

    var settings = {
        "url": "https://apiperu.dev/api/dni/" + dni,
        "method": "GET",
        "timeout": 0,
        "headers": {
            "Authorization": "Bearer 20b6666ddda099db4204cf53854f8ca04d950a4eead89029e77999b0726181cb"
        },
    };

    $.ajax(settings).done(function(response) {
        console.log(response);

        if (response.success == true) {

            var data = response.data;

            //$('#nombre_propietario').val('')

            var apellidoPaterno = data.apellido_paterno;
            var apellidoMaterno = data.apellido_materno;
            var nombres = data.nombres;

            var nombreCompleto = apellidoPaterno + ' ' + apellidoMaterno + ', ' + nombres;

            //$('#nombre_propietario').val(nombreCompleto);
            $('#nombre').val(nombres);
            $('#apellido_paterno').val(apellidoPaterno);
            $('#apellido_materno').val(apellidoMaterno);
            //$('#direccion_dni').attr("readonly",false);
            //$('#celular_dni').attr("readonly",false);
            //$('#email_dni').attr("readonly",false);

        } else {
            Swal.fire("DNI Inv&aacute;lido. Revise el DNI digitado!");
            return false;
        }

    });
}

function validarTipoDocumento(){
    
    var id_tipo_documento = $("#id_tipo_documento").val();
    $(".apellido").hide();
    //$(".divColegiatura").hide();
    $(".foto").show();

    $("#numero_documento").val("");
    $("#nombre").val("");
    $("#apellido_paterno").val("");
    $("#apellido_materno").val("");

    $("#nombre").prop("readonly",false);
    $("#apellido_paterno").prop("readonly",false);
    $("#apellido_materno").prop("readonly",false);

    if(id_tipo_documento==1){

        $("#nombre").prop("readonly",true);
        $("#apellido_paterno").prop("readonly",true);
        $("#apellido_materno").prop("readonly",true);

        $(".apellido").show();
        $("#lbl_numero_documento").html("DNI");
        $("#lbl_nombre").html("Nombres");
    }

    if(id_tipo_documento==2){
        $("#nombre").prop("readonly",true);
        $("#lbl_numero_documento").html("RUC");
        $("#lbl_nombre").html("Razón Social");
        $(".foto").hide();
    }

    if(id_tipo_documento==3){
        $(".apellido").show();
        $("#lbl_numero_documento").html("Carné de Extranjería");
        $("#lbl_nombre").html("Nombres");
    }

    if(id_tipo_documento==4){
        $(".apellido").show();
        $("#lbl_numero_documento").html("No Domiciliario");
        $("#lbl_nombre").html("Nombres");
    }

    if(id_tipo_documento==5){
        $(".apellido").show();
        $("#lbl_numero_documento").html("Pasaporte");
        $("#lbl_nombre").html("Nombres");
    }

    if(id_tipo_documento==6){
        $(".apellido").show();
        $("#lbl_numero_documento").html("Cédula");
        $("#lbl_nombre").html("Nombres");
    }

}

function validaRuc(ruc){
	var settings = {
		"url": "https://apiperu.dev/api/ruc/"+ruc,
		"method": "GET",
		"timeout": 0,
		"headers": {
		  "Authorization": "Bearer 20b6666ddda099db4204cf53854f8ca04d950a4eead89029e77999b0726181cb"
		},
	  };
	  
	  $.ajax(settings).done(function (response) {
		console.log(response);
		
		if (response.success == true){

			var data= response.data;

			$('#nombre').val('')
			$('#direccion').val('')
			
			$('#nombre').val(data.nombre_o_razon_social).attr('readonly', true);
			//$('#nombre_comercial').val(data.nombre_o_razon_social).attr('readonly', true);
			//$('#direccion').attr('readonly', true);

			if (data.direccion_completa != ""){
				$('#direccion').val(data.direccion_completa).attr('readonly', true);
			}
			else{
				$('#direccion').attr('readonly', false);
			}
			
			//alert(data.direccion_completa);

		}
		else{
			Swal.fire("RUC Inv&aacute;lido. Revise el RUC digitado!");
			return false;
		}

		
	  });
}

</script>