@extends('frontend.layouts.app')

@section('title', __('Register'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Register')
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.register')">
                            
							
							<div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Tipo Documento</label>

                                <div class="col-md-6">
									
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
                            </div><!--form-group-->
							
							<div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Numero Documento</label>

                                <div class="col-md-6">
                                    <input type="text" name="numero_documento" id="numero_documento" class="form-control" placeholder="{{ __('Numero de documento') }}" maxlength="100" required autofocus autocomplete="numero_documento" onblur="obtenerPersona()" />
                                </div>
                            </div><!--form-group-->
							
							<div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nombre y Apellidos</label>

                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nombre y Apellidos" maxlength="100" required autofocus autocomplete="name" readonly="readonly" />
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('E-mail Address')</label>

                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required autocomplete="email" />
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('Password')</label>

                                <div class="col-md-6">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="new-password" />
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('Password Confirmation')</label>

                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100" required autocomplete="new-password" />
                                </div>
                            </div><!--form-group-->

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" required>
                                        <label class="form-check-label" for="terms">
                                            @lang('I agree to the') <a href="{{ route('frontend.pages.terms') }}" target="_blank">@lang('Terms & Conditions')</a>
                                        </label>
                                    </div>
                                </div>
                            </div><!--form-group-->

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
                                    <button class="btn btn-primary" type="submit" id="btnRegister">@lang('Register')</button>
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