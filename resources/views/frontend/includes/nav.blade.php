<nav class="navbar navbar-expand-md navbar-dark bg-primary mb-0" style="background:#1C77B9!important">
    <!--<div class="container">
        <x-utils.link
            :href="route('frontend.index')"
            :text="appName()"
           o class="navbar-brand" />
	-->
	
		<a href="{{ route('frontend.index') }}" class="navbar-brand">
			<img src="<?php echo URL::to('/') ?>/img/logo-sin-fondo2.png" alt="" width="180" height="70" style="padding:0px;margin:0px">
		</a>
		<br>
		
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('Toggle navigation')">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav col-lg-9 col-md-9 col-sm-12 col-xs-12">
                @if(config('boilerplate.locale.status') && count(config('boilerplate.locale.languages')) > 1)
                    <li class="nav-item dropdown">
                        <x-utils.link
                            :text="__(getLocaleName(app()->getLocale()))"
                            class="nav-link dropdown-toggle"
                            id="navbarDropdownLanguageLink"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false" />

                        @include('includes.partials.lang')
                    </li>
                @endif

                @guest
                    <li class="nav-item">
                        <x-utils.link
                            :href="route('frontend.auth.login')"
                            :active="activeClass(Route::is('frontend.auth.login'))"
                            :text="__('Login')"
                            class="nav-link" />
                    </li>

                    @if (config('boilerplate.access.user.registration'))
                        <li class="nav-item">
                            <x-utils.link
                                :href="route('frontend.auth.register')"
                                :active="activeClass(Route::is('frontend.auth.register'))"
                                :text="__('Register')"
                                class="nav-link" />

                        </li>
                    @endif
                @else
				
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Agremiado</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								<!--<a href="/agremiado" class="dropdown-item">Registro de Agremiado</a>-->
								<a href="/agremiado/consulta_agremiado" class="dropdown-item">Consulta de Agremiado</a>
                                <a href="/multa/consulta_multa" class="dropdown-item">Multas</a>
                                <a href="/afiliacion_seguro/consulta_afiliacion_seguro" class="dropdown-item">Afiliciaci&oacute;n a Seguro</a>
                                <a href="/concurso" class="dropdown-item">Concurso</a>
								<a href="/concurso/create_resultado" class="dropdown-item">Resultado de Concurso</a>
								<a href="/concurso/consulta_resultado" class="dropdown-item">Consulta de Concurso</a>
						   </div>
					</li>
					
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Colegiado</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								<a href="/concurso/create" class="dropdown-item">Concurso</a>
						   </div>
					</li>

                    <li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Asuntos Tecnicos</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								<a href="/comision/consulta_comision" class="dropdown-item">Comisiones</a>
						   </div>
					</li>

                    <li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Mantenimiento</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								<a href="/empresa/consulta_empresa" class="dropdown-item">Consulta de Empresa</a>
								<a href="/concepto/consulta_concepto" class="dropdown-item">Consulta de Concepto</a>
                                <a href="/TipoConcepto/consulta_tipoConcepto" class="dropdown-item">Consulta de Tipo de Concepto</a>
                                <a href="/municipalidad/consulta_municipalidad" class="dropdown-item">Municipalidades</a>
								
								<a href="/empresa/consulta_empresa" class="dropdown-item">Empresas</a>
                                <a href="/municipalidad/consulta_municipalidad" class="dropdown-item">Municipalidades</a>
								<a href="/concepto/consulta_concepto" class="dropdown-item">Conceptos</a>
                                <a href="/TipoConcepto/consulta_tipoConcepto" class="dropdown-item">Tipo de Conceptos</a>
                                <a href="/seguro/consulta_seguro" class="dropdown-item">Seguros</a>
								
								<!--<a href="/concurso" class="dropdown-item">Concurso</a>-->
						   </div>
					</li>
				
                    <li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Caja</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								<a href="/ingreso/create" class="dropdown-item">Estado de Cuenta</a>
                                <a href="/certificado/consulta_certificado" class="dropdown-item">Certificado tipo 4</a>

						   </div>
					</li>

                    <li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Gesti&oacute;n</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								<a href="/prontoPago/consulta_prontoPago" class="dropdown-item">Pronto Pago</a>

						   </div>
					</li>
                    <li class="nav-item dropdown">
                        <x-utils.link
                            href="#"
                            id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            v-pre
                        >
                            <x-slot name="text">
                                <img class="rounded-circle" style="max-height: 20px" src="{{ $logged_in_user->avatar }}" />
                                {{ $logged_in_user->name }} <span class="caret"></span>
                            </x-slot>
                        </x-utils.link>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if ($logged_in_user->isAdmin())
                                <x-utils.link
                                    :href="route('admin.dashboard')"
                                    :text="__('Administration')"
                                    class="dropdown-item" />
                            @endif

                            @if ($logged_in_user->isUser())
                                <x-utils.link
                                    :href="route('frontend.user.dashboard')"
                                    :active="activeClass(Route::is('frontend.user.dashboard'))"
                                    :text="__('Dashboard')"
                                    class="dropdown-item"/>
                            @endif

                            <x-utils.link
                                :href="route('frontend.user.account')"
                                :active="activeClass(Route::is('frontend.user.account'))"
                                :text="__('My Account')"
                                class="dropdown-item" />

                            <x-utils.link
                                :text="__('Logout')"
                                class="dropdown-item"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <x-slot name="text">
                                    @lang('Logout')
                                    <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none" />
                                </x-slot>
                            </x-utils.link>
                        </div>
                    </li>
                @endguest
            </ul>
        </div><!--navbar-collapse-->
    </div><!--container-->
</nav>

@if (config('boilerplate.frontend_breadcrumbs'))
    @include('frontend.includes.partials.breadcrumbs')
@endif
