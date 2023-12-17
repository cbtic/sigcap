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

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
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
					
					@if(Gate::check('Nuevo Agremiado') || Gate::check('Consulta de Agremiado') || Gate::check('Multas') || Gate::check('Afiliciacion a Seguro'))
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Agremiado</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								@can('Nuevo Agremiado')
								<a href="/agremiado" class="dropdown-item">Nuevo Agremiado</a>
								@endcan
								@can('Consulta de Agremiado')
								<a href="/agremiado/consulta_agremiado" class="dropdown-item">Consulta de Agremiado</a>
								@endcan
								@can('Multas')
                                <a href="/multa/consulta_multa" class="dropdown-item">Multas</a>
								@endcan
								@can('Afiliciacion a Seguro')
                                <a href="/afiliacion_seguro/consulta_afiliacion_seguro" class="dropdown-item">Afiliciaci&oacute;n a Seguro</a>
								@endcan
								<a href="/derecho_revision/consulta_solicitud_derecho_revision" class="dropdown-item">Solicitud de Derecho Revisi&oacute;n</a>
								
                                
						   </div>
					</li>
					@endif
					
					@if(Gate::check('Concurso Postula'))
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Colegiado</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
						   		@can('Concurso Postula')
								<a href="/concurso/create" class="dropdown-item">Concurso</a>
								@endcan
						   </div>
					</li>
					@endif

                    @if(Gate::check('Concurso') || Gate::check('Resultado de Concurso') || Gate::check('Consulta de Resultado de Concurso') || Gate::check('Comisiones') || Gate::check('Consulta de Comisiones') || Gate::check('Programacion de Sesiones'))
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Asuntos Tecnicos</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
                           		@can('Concurso')
								<a href="/concurso" class="dropdown-item">Concurso</a>
						   		@endcan
								@can('Resultado de Concurso')
								<a href="/concurso/create_resultado" class="dropdown-item">Resultado de Concurso</a>
								@endcan
								@can('Consulta de Resultado de Concurso')
								<a href="/concurso/consulta_resultado" class="dropdown-item">Consulta de Resultado de Concurso</a>
								@endcan
								@can('Comisiones')
								<a href="/comision/consulta_comision" class="dropdown-item">Comisiones</a>
								@endcan
								@can('Consulta de Comisiones')
								<a href="/comision/lista_comision" class="dropdown-item">Consulta de Comisiones</a>
								@endcan
								@can('Programacion de Sesiones')
								<a href="/sesion/lista_programacion_sesion" class="dropdown-item">Programaci&oacute;n de Sesiones</a>
								@endcan
								<a href="/derecho_revision/consulta_derecho_revision" class="dropdown-item">Derecho Revisi&oacute;n</a>
								
								<a href="/revisorUrbano/consulta_revisorUrbano" class="dropdown-item">Registro Revisor Urbano</a>

								<a href="/sesion/consulta_calendarioComputo" class="dropdown-item">Calendario de C&oacute;mputo de Sesiones</a>
								
								<a href="/sesion/consulta_computoSesion" class="dropdown-item">C&oacute;mputo de Sesiones</a>

						   </div>
					</li>
					@endif

                    @if(Gate::check('Empresas') || Gate::check('Municipalidades') || Gate::check('Conceptos') || Gate::check('Tipo de Conceptos') || Gate::check('Seguros') || Gate::check('Periodo Comision') || Gate::check('Movilidad') || Gate::check('Persona') || Gate::check('Profesion') || Gate::check('Otros Profesionales'))
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Mantenimiento</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
								@can('Empresas')
								<a href="/empresa/consulta_empresa" class="dropdown-item">Empresas</a>
								@endcan
								@can('Municipalidades')
                                <a href="/municipalidad/consulta_municipalidad" class="dropdown-item">Municipalidades</a>
								@endcan
								@can('Conceptos')
								<a href="/concepto/consulta_concepto" class="dropdown-item">Conceptos</a>
								@endcan
								@can('Tipo de Conceptos')
                                <a href="/TipoConcepto/consulta_tipoConcepto" class="dropdown-item">Tipo de Conceptos</a>
								@endcan
								@can('Seguros')
                                <a href="/seguro/consulta_seguro" class="dropdown-item">Seguros</a>
								@endcan
								@can('Periodo Comision')
                                <a href="/periodoComision/consulta_periodoComision" class="dropdown-item">Periodo Comisi&oacute;n</a>
								@endcan
								@can('Movilidad')
                                <a href="/movilidad/consulta_movilidad" class="dropdown-item">Movilidad</a>
								@endcan
								@can('Persona')
                                <a href="/persona/consulta_persona" class="dropdown-item">Persona</a>
								@endcan
								@can('Profesion')
								<a href="/profesion/consulta_profesion" class="dropdown-item">Profesi&oacute;n</a>
								@endcan
								@can('Otros Profesionales')
                                <a href="/profesionalesOtro/consulta_profesionalesOtro" class="dropdown-item">Otros Profesionales</a>
								@endcan
								<a href="/parametro/consulta_parametro" class="dropdown-item">Par&aacute;metros</a>
								<!--<a href="/concurso" class="dropdown-item">Concurso</a>-->
						   </div>
					</li>
					@endif
					
					@if(Gate::check('Estado de Cuenta') || Gate::check('Certificado Tipo 4') || Gate::check('Consulta de Facturas'))
                    <li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Caja</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
						   		@can('Estado de Cuenta')
								<a href="/ingreso/create" class="dropdown-item">Estado de Cuenta</a>
								@endcan
								@can('Certificado Tipo 4')
                                <a href="/certificado/consultar_certificado" class="dropdown-item">Certificado Tipo 4</a>
								@endcan
								@can('Consulta de Facturas')
                                <a href="{{route('frontend.comprobante.all')}}" class="dropdown-item">Consulta de Facturas </a>
								@endcan

						   </div>
					</li>
					@endif

                    @if(Gate::check('Pronto Pago'))
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Gesti&oacute;n</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
						   		@can('Pronto Pago')
								<a href="/prontoPago/consulta_prontoPago" class="dropdown-item">Pronto Pago</a>
								@endcan

						   </div>
					</li>
					@endif
					
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
