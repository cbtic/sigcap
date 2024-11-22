@extends('frontend.layouts.app')

@section('title', __('Login'))
<style>
.nav-login {
    display: flex;
    justify-content: center;
    align-content: center;
    flex-wrap: wrap;
    padding-left: 10%;
    padding-right: 10%;
    background-color: white;
}
.nav-pills {
    padding-bottom: 35px;
}
.nav {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}
.login-div .nav-item {
    width: 50%;
    text-align: center;
}
.login-div .nav-tab.active {
    color: var(--blue);
    border-bottom: 3px var(--blue) solid;
}
.login-div .nav-tab {
    display: block;
    width: 100%;
    padding-bottom: .5em;
    border-bottom: 3px gray solid;
}

a, a:hover, a:focus {
    color: inherit;
    text-decoration: none!important;
    transition: all 0.3s;
}

</style>

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Login')
                    </x-slot>

                    <x-slot name="body">


                        <div class="login-div">
                
                            <ul class="nav nav-pills nav-login" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-tab active" id="pills-login-tab" data-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="false">Acceso</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-tab" id="pills-register-tab" data-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="true">Inscribirse</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade active show" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
                                    
                                <x-forms.post :action="route('frontend.auth.login')">
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">@lang('E-mail Address')</label>

                                        <div class="col-md-6">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required autofocus autocomplete="email" />
                                        </div>
                                    </div><!--form-group-->

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">@lang('Password')</label>

                                        <div class="col-md-6">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="current-password" />
                                        </div>
                                    </div><!--form-group-->

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input name="remember" id="remember" class="form-check-input" type="checkbox" {{ old('remember') ? 'checked' : '' }} />

                                                <label class="form-check-label" for="remember">
                                                    @lang('Remember Me')
                                                </label>
                                            </div><!--form-check-->
                                        </div>
                                    </div><!--form-group-->

                                    @if(config('boilerplate.access.captcha.login'))
                                        <div class="row">
                                            <div class="col">
                                                @captcha
                                                <input type="hidden" name="captcha_status" value="true" />
                                            </div><!--col-->
                                        </div><!--row-->
                                    @endif

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button class="btn btn-primary" type="submit">@lang('Login')</button>

                                            <x-utils.link :href="route('frontend.auth.password.request')" class="btn btn-link" :text="__('Forgot Your Password?')" />
                                        </div>
                                    </div><!--form-group-->

                                    <div class="text-center">
                                        @include('frontend.auth.includes.social')
                                    </div>
                                </x-forms.post>
                                            

                                </div>
                                <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
                                        <!--
                                        <a class="btn btn-block btn-primary" href="route('frontend.auth.registerProy')">
                                            <i class="fas fa-pencil-ruler"></i> Proyectistas</a>
                                        -->

                                        <x-utils.link
                                        :href="route('frontend.auth.register')"
                                        :active="activeClass(Route::is('frontend.auth.register'))"
                                        :text="__('Colegiados')"
                                        icon="fas fa-user"
                                        class="btn btn-block btn-primary" />

                                        <x-utils.link
                                        :href="route('frontend.auth.registerProy')"
                                        :active="activeClass(Route::is('frontend.auth.registerProy'))"
                                        :text="__('Proyectistas')"
                                        icon="fas fa-pencil-ruler"
                                        class="btn btn-block btn-primary" />
                                        
                                        <a class="btn btn-block btn-primary" href="/registerResp">
                                            <i class="fas fa-home"></i>
                                            Administrados/Propietarios
                                            <br>
                                            Responsable de Trámite
                                        </a>
                                        
                                        <!--
                                        <x-utils.link
                                        :href="route('frontend.auth.registerProy')"
                                        :active="activeClass(Route::is('frontend.auth.registerProy'))"
                                        :text="__('Administrados/Propietarios Responsable de Trámite')"
                                        icon="fas fa-home"
                                        class="btn btn-block btn-primary" />
                                        -->
                                </div>
                            </div>
                            
                        </div>







                        
                        
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
