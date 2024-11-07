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
                        <x-forms.post :action="route('frontend.auth.registerProy')" onsubmit="return validacion()">
                            
							
							<div class="form-group row">
								
								<label for="name" class="col-md-1 col-form-label text-md-right">N&deg; CAP</label>

                                <div class="col-md-2">
                                    <input type="text" name="numero_cap" id="numero_cap" class="form-control" placeholder="{{ __('Numero de CAP') }}" maxlength="100"  autofocus autocomplete="numero_documento" onblur="obtenerAgremiado()" />
                                </div>
								
                                <label for="name" class="col-md-2 col-form-label text-md-right">Tipo Documento</label>

                                <div class="col-md-3">
                                    <input type="text" readonly="readonly" name="tipo_documento" id="tipo_documento" class="form-control" placeholder="Tipo Documento" maxlength="100"  autofocus autocomplete="numero_documento" />
                                </div>
								
								<label for="name" class="col-md-1 col-form-label text-md-right" style="padding-right:0px">N&deg; Documento</label>

                                <div class="col-md-3">
                                    <input type="text" readonly="readonly" name="numero_documento" id="numero_documento" class="form-control" placeholder="{{ __('Numero de documento') }}" maxlength="100"  autofocus autocomplete="numero_documento" onblur="obtenerPersona()" />
                                </div>
								
                            </div><!--form-group-->
							
							<div class="form-group row">
                                
								<label for="name" class="col-md-1 col-form-label text-md-right">Ap. Paterno</label>

                                <div class="col-md-3">
                                    <input type="text" readonly="readonly" name="apellido_paterno" id="apellido_paterno" class="form-control" placeholder="Ap. Paterno" maxlength="100"  autofocus autocomplete="numero_documento" />
                                </div>
								
								<label for="name" class="col-md-1 col-form-label text-md-right">Ap. Materno</label>
								
								<div class="col-md-3">
                                    <input type="text" readonly="readonly" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="{{ __('Ap. Materno') }}" maxlength="100"  autofocus autocomplete="numero_documento" />
                                </div>
								
								<label for="name" class="col-md-1 col-form-label text-md-right">Nombres</label>
								
								<div class="col-md-3">
                                    <input type="text" readonly="readonly" name="nombre" id="nombre" class="form-control" placeholder="{{ __('Nombres') }}" maxlength="100"  autofocus autocomplete="numero_documento" />
                                </div>
								
                            </div><!--form-group-->
							
							<!--
							<div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre y Apellidos</label>

                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nombre y Apellidos" maxlength="100" required autofocus autocomplete="name" readonly="readonly" />
                                </div>
                            </div>
							-->

                            <div class="form-group row">
								
								<label for="name" class="col-md-1 col-form-label text-md-right">Profesi&oacute;n</label>
								
								<div class="col-md-3">
									<select name="id_tipo_profesional" id="id_tipo_profesional" class="form-control form-control-sm" type="text">
                            			<option value="">--Seleccionar--</option>
										<?php
										foreach ($tipo_documento as $row) {
										?>
										<option value="<?php echo $row->codigo?>"><?php echo $row->denominacion?></option>
										<?php 
										}
										?>										        
                                    </select>
								</div>
								
								<label for="name" class="col-md-1 col-form-label text-md-right">Celular</label>
								
								<div class="col-md-3">
                                    <input type="text" name="celular" id="celular" class="form-control" placeholder="{{ __('Numero de documento') }}" maxlength="100"  autofocus autocomplete="numero_documento" />
                                </div>
                                
                                <label for="name" class="col-md-1 col-form-label text-md-right">Tel&eacute;fono</label>
								
								<div class="col-md-3">
                                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="{{ __('Numero de documento') }}" maxlength="100"  autofocus autocomplete="numero_documento" />
                                </div>
								
                            </div><!--form-group-->

                            <div class="form-group row">
							
                                <label for="name" class="col-md-1 col-form-label text-md-right">Correo 1</label>

                                <div class="col-md-3">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255"  autocomplete="email" />
                                </div>

                                <label for="name" class="col-md-1 col-form-label text-md-right">Correo 2</label>

                                <div class="col-md-3">
                                    <input type="email" name="email2" id="email2" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" autocomplete="email" />
                                </div>
							
                                <label for="name" class="col-md-1 col-form-label text-md-right">Direcci&oacute;n</label>

                                <div class="col-md-3">
                                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="{{ __('Direccion') }}" value="{{ old('email') }}" maxlength="255"  autocomplete="email" />
                                </div>
							
							
							</div>
							
							<div class="form-group row">
							
                                <label for="name" class="col-md-1 col-form-label text-md-right">@lang('Password')</label>

                                <div class="col-md-3">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100"  autocomplete="new-password" />
                                </div>
                            
                                <label for="name" class="col-md-1 col-form-label text-md-right">Confirmar</label>

                                <div class="col-md-3">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100"  autocomplete="new-password" />
                                </div>
                            </div><!--form-group-->

							<!--
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" required>
                                        <label class="form-check-label" for="terms">
                                            @lang('I agree to the') <a href="{{ route('frontend.pages.terms') }}" target="_blank">@lang('Terms & Conditions')</a>
                                        </label>
                                    </div>
                                </div>
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

function validacion(){

    var msg = "";
    var numero_cap = $("#numero_cap").val();
    var id_tipo_profesional = $("#id_tipo_profesional").val();
	var celular = $("#celular").val();
	var email = $("#email").val();
    var email2 = $("#email2").val();
    var direccion = $("#direccion").val();
    var password = $("#password").val();
    var password_confirmation = $("#password_confirmation").val();

	if(numero_cap == "")msg += "Debe ingresar el numero de CAP <br>";
    if(id_tipo_profesional == "")msg += "Debe ingresar la profesion <br>";
    if(celular == "")msg += "Debe ingresar el celular <br>";
    if(email == "")msg += "Debe ingresar el correo 1 <br>";
    if(direccion == "")msg += "Debe ingresar la direccion <br>";
    if(password == "")msg += "Debe ingresar la contraseña <br>";
	if(password_confirmation == "")msg += "Debe ingresar la confirmacion de la contraseña <br>";

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
		url: '/persona/obtener_proyectista/' + numero_cap,
		dataType: "json",
		success: function(result){
			
            var cantidad = result.cantidad;
            if (cantidad > 0) {
                bootbox.alert("Usted ya se encuentra inscrito. En caso de haber olvidado su contraseña seguir los pasos dando clic en ¿Olvidaste tu contraseña?");
                return false;
            }
			$('.loader').hide();

		}
		
	});

    return false;

}

function obtenerAgremiado(){
		
	var numero_cap = $("#numero_cap").val();
	var msg = "";
	
	if(numero_cap == "")msg += "Debe ingresar el numero de CAP <br>";
	
	if (msg != "") {
		//bootbox.alert(msg);
		return false;
	}
	
	var msgLoader = "";
	msgLoader = "Procesando, espere un momento por favor";
	var heightBrowser = $(window).width()/2;
	$('.loader').css("opacity","0.8").css("height",heightBrowser).html("<div id='Grd1_wrapper' class='dataTables_wrapper'><div id='Grd1_processing' class='dataTables_processing panel-default'>"+msgLoader+"</div></div>");
    $('.loader').show();
	
	$.ajax({
		url: '/persona/obtener_agremiado_login/' + numero_cap,
		dataType: "json",
		success: function(result){
			
			var agremiado = result.agremiado;
			$('#tipo_documento').val(agremiado.tipo_documento);
			$('#numero_documento').val(agremiado.numero_documento);
			$('#apellido_paterno').val(agremiado.apellido_paterno);
			$('#apellido_materno').val(agremiado.apellido_materno);
			$('#nombre').val(agremiado.nombres);
			//$('#telefono').val(persona.telefono);
			//$('#email').val(persona.email);
			
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


</script>