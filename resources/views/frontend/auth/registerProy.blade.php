@extends('frontend.layouts.app')

@section('title', __('Register'))

@section('content')
    <div class="container py-4" style="max-width:1500px">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        Registro de Arquitectos y Profesionales
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.registerProy')" id="frmUsuario" name="frmUsuario" enctype="multipart/form-data" onsubmit="return validacion(event)">

                        <input type="hidden" name="id_agremiado" id="id_agremiado" value=""/>

                            <div class="form-row mb-2">

                                <div class="col-md-3 " data-select2-id="4">
                                    <label>Profesión:</label>
                                    <select name="id_profesion" id="id_profesion" class="form-control form-control-sm" type="text" onchange="validarProfesion()">
                            			<option value="">--Seleccionar--</option>
										<?php
										foreach ($profesion as $row) {
										?>
										<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
										<?php 
										}
										?>										        
                                    </select>
                                </div>
                                <div class="col-md-3 divCap">
                                    <label id="tuition_title">CAP No.:</label>
                                    <input type="text" name="numero_cap" id="numero_cap" class="form-control" placeholder="{{ __('Numero de CAP') }}" maxlength="100"  autocomplete="numero_documento" onblur="obtenerAgremiado()" />
                                    
                                </div>

                                <div class="col-md-3 divColegiatura" style="display:none">
                                    <label id="tuition_title">CIP No.:</label>
                                    <input type="text" name="colegiatura" id="colegiatura" class="form-control" placeholder="{{ __('Colegiatura') }}" maxlength="100"  autocomplete="numero_documento" />
                                    
                                </div>

                                <div class="col-md-3 divCap">
                                    <label>Código Secreto:</label>
                                    <input type="number" name="secret_code" class="form-control" min="0" id="id_secret_code" onblur="obtenerAgremiado()">
                                    <!--<span class="text-sm text-cap">Solo para Arquitectos</span>-->
                                </div>

                                
                            </div>
                            
                            <div class="form-row mb-2" data-select2-id="5">

                                <div class="col-md-3 divCap">
                                    <label for="name">Tipo Documento</label>
                                    <input type="text" readonly="readonly" name="tipo_documento" id="tipo_documento" class="form-control" placeholder="Tipo Documento" maxlength="100" autocomplete="numero_documento" />
                                </div>
                                
                                <div class="col-md-3 divColegiatura" style="display:none">
                                    <label for="name">Tipo Documento</label>
                                    <select name="id_tipo_documento" id="id_tipo_documento" class="form-control form-control-sm" type="text">
                            			<option value="">--Seleccionar--</option>
										<?php
										foreach ($tipo_documento as $row) {
										if($row->codigo==78){
										?>
										<option value="<?php echo $row->codigo?>" <?php if($row->codigo==78)echo "selected='selected'"?>><?php echo $row->denominacion?></option>
										<?php 
										}
										}
										?>										        
                                    </select>
                                </div>

                                <div class="col-md-3 ">
                                    <!-- <label>DNI:</label> -->
                                    <label for="">N° Doc:</label>
                                    <input type="text" readonly="readonly" name="numero_documento" id="numero_documento" class="form-control" placeholder="{{ __('Numero de documento') }}" maxlength="100" autocomplete="numero_documento" onchange="obtenerDatosDni()" />
                                    
                                </div>
                                
                            </div>

                            <div class="form-row mb-2" data-select2-id="5">

                                <div class="col-md-4">
                                    <label>Nombres:</label>
                                    <input type="text" readonly="readonly" name="nombre" id="nombre" class="form-control" placeholder="{{ __('Nombres') }}" maxlength="100" autocomplete="numero_documento" />
                                </div>
                                <div class="col-md-4">
                                    <label>Primer Apellido:</label>
                                    <input type="text" readonly="readonly" name="apellido_paterno" id="apellido_paterno" class="form-control" placeholder="Ap. Paterno" maxlength="100" autocomplete="numero_documento" />
                                </div>		
                                <div class="col-md-4">
                                    <label>Segundo Apellido:</label>
                                    <input type="text" readonly="readonly" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="{{ __('Ap. Materno') }}" maxlength="100" autocomplete="numero_documento" />
                                </div>

                            </div>

                            <div class="form-row mb-2">
                                <div class="col-md-4 ">
                                    <label>Teléfono Celular:</label>
                                    <input type="text" name="celular" id="celular" class="form-control" placeholder="{{ __('Teléfono Celular') }}" maxlength="100" autocomplete="numero_documento" />
                                    
                                </div>
                                <div class="col-md-8 ">
                                    <label>Correo Electrónico:</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255"  autocomplete="email" />
                                    
                                </div>
                            </div>

                            <div class="form-row mb-2">
                                <div class="col-md-4 ">
                                    <label>Teléfono Fijo:</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="{{ __('Teléfono Fijo') }}" maxlength="100" autocomplete="numero_documento" />
                                    
                                </div>
                                
                                <div class="col-md-8 ">
                                    <label>Correo Electrónico 2:</label>
                                    <input type="email" name="email2" id="email2" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" autocomplete="email" />
                                    
                                </div>

                            </div>

                            <div class="form-row mb-2">

                                <div class="col-md-8 ">
                                    <label>Dirección:</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="{{ __('Dirección') }}" value="{{ old('email') }}" maxlength="255"  autocomplete="email" />
                                    
                                </div>

                            </div>
                            
                            <div class="form-row mb-2">
                                <div class="col-md-4 ">
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
                                <div class="col-md-8 offset-md-4">
                                    
                                    <span>Suba una imágen escaneada de su sello y firma, los cuales será utilizados como validación de las solicitudes que realice através del portal</span>
                                    
                                </div>
                            </div>
                            
                            <div class="form-row mb-2">
                                <div class="col-md-4 ">
                                    <label>@lang('Password'):</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100"  autocomplete="new-password" />
                                    
                                </div>
                                
                                <div class="col-md-8 ">
                                    <label>Confirmar:</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100"  autocomplete="new-password" />
                                    
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

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" type="submit" id="btnRegister">@lang('RegisterProy')</button>
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
    var numero_cap = $("#numero_cap").val();
    var colegiatura = $("#colegiatura").val();
    var id_profesion = $("#id_profesion").val();
	var celular = $("#celular").val();
	var email = $("#email").val();
    var email2 = $("#email2").val();
    var direccion = $("#direccion").val();
    var password = $("#password").val();
    var password_confirmation = $("#password_confirmation").val();
    var id_agremiado = $("#id_agremiado").val();

    if(id_profesion == "")msg += "Debe ingresar la profesion <br>";
    if(id_agremiado == "" && id_profesion==1)msg += "El codigo secreto es incorrecto <br>";
    if(numero_cap == "" && id_profesion==1)msg += "Debe ingresar el numero de CAP <br>";
    if(colegiatura == "" && id_profesion==2)msg += "Debe ingresar el numero de Colegiatura <br>";
    if(celular == "")msg += "Debe ingresar el celular <br>";
    if(email == "")msg += "Debe ingresar el correo 1 <br>";
    if(direccion == "")msg += "Debe ingresar la direccion <br>";
    if(password == "")msg += "Debe ingresar la contraseña <br>";
	if(password_confirmation == "")msg += "Debe ingresar la confirmacion de la contraseña <br>";

	if (msg != "") {
		bootbox.alert(msg);
		return false;
	}
	
    var buscar = "";
    if(id_profesion==1){
        buscar = numero_cap;
    }

    if(id_profesion==2){
        buscar = colegiatura;
    }

	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/persona/obtener_proyectista/' + id_profesion + '/' + buscar,
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


</script>