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
						<!--
                        <li class="nav-item">
                            <x-utils.link
                                :href="route('frontend.auth.register')"
                                :active="activeClass(Route::is('frontend.auth.register'))"
                                :text="__('Register')"
                                class="nav-link" />

                        </li>
						
						<li class="nav-item">
                            <x-utils.link
                                :href="route('frontend.auth.registerProy')"
                                :active="activeClass(Route::is('frontend.auth.registerProy'))"
                                :text="__('RegisterProy')"
                                class="nav-link" />

                        </li>
						-->
                    @endif
                @else
					
					@if(Gate::check('Nuevo Agremiado') || Gate::check('Consulta de Agremiado') || Gate::check('Multas') || Gate::check('Afiliciacion a Seguro') || Gate::check('Reporte Deudas'))
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
								@can('Reporte Deudas')
                                <a href="/agremiado/consulta_reporte_deuda" class="dropdown-item">Reporte Deudas Seguros</a>
								@endcan
								
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

					@if(Gate::check('Licencias'))
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Data Licencias</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
						   		@can('Licencias')
								<a href="/derecho_revision/create_solicitud" class="dropdown-item">Registrar Solicitud de Derecho de Revisi&oacute;n</a>
								@endcan
						   </div>
					</li>
					@endif

                    @if(Gate::check('Concurso') || Gate::check('Resultado de Concurso') || Gate::check('Consulta de Resultado de Concurso') || Gate::check('Coordinador Zonal') || Gate::check('Comisiones') || Gate::check('Consulta de Comisiones') || Gate::check('Programacion de Sesiones') || Gate::check('Derecho de Revision') || Gate::check('Registro Revisor Urbano') || Gate::check('Computo de Sesiones') || Gate::check('Consulta Derecho de Revision') || Gate::check('Registro Derecho de Revision') || Gate::check('Agremiado Rol'))
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
								@can('Coordinador Zonal')
								<a href="/coordinador_zonal/consulta_coordinadorZonal" class="dropdown-item">Coordinador Zonal</a>
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
								@can('Derecho de Revision')
								<a href="/derecho_revision/consulta_derecho_revision" class="dropdown-item">Derecho Revisi&oacute;n - Edificaciones</a>
								@endcan
								@can('Registro Revisor Urbano')
								<a href="/revisorUrbano/consulta_revisorUrbano" class="dropdown-item">Registro Revisor Urbano</a>
								@endcan
								<!--
								@can('Calendario de Computo de Sesiones')
								<a href="/sesion/consulta_calendarioComputo" class="dropdown-item">Calendario de C&oacute;mputo de Sesiones</a>
								@endcan
								-->
								@can('Computo de Sesiones')
								<a href="/sesion/consulta_computoSesion" class="dropdown-item">C&oacute;mputo de Sesiones</a>
								@endcan
								@can('Consulta Derecho de Revision')
								<a href="/derecho_revision/consulta_solicitud_derecho_revision" class="dropdown-item">Derecho Revisi&oacute;n - HU</a>
								@endcan
								@can('Registro Derecho de Revision')
								<a href="/derecho_revision/consulta_derecho_revision_nuevo" class="dropdown-item">Registro Solicitud de Derecho Revisi&oacute;n</a>
								@endcan
								@can('Agremiado Rol')
								<a href="/agremiado_rol/consulta_agremiado_rol" class="dropdown-item">Agremiado Rol</a>
								@endcan
						   </div>
					</li>
					@endif

					@if(Gate::check('Estado de Cuenta') || Gate::check('Certificado Tipo 4') || Gate::check('Certificado Tipo 3') || Gate::check('Consulta de Facturas') || Gate::check('Liquidacion de Caja') || Gate::check('Concepto Beneficiario'))
                    <li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Caja</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
						   		@can('Estado de Cuenta')
								<a href="/ingreso/create" class="dropdown-item">Estado de Cuenta</a>
								@endcan
								@can('Certificado Tipo 4')
                                <a href="/certificado/consultar_certificado" class="dropdown-item">Certificados</a>
								@endcan
								@can('Certificado Tipo 3')
								<a href="/certificado/consultar_certificado_tipo3" class="dropdown-item">Registro de Proyectos</a>
								@endcan
								@can('Consulta de Facturas')
                                <a href="/comprobante" class="dropdown-item">Consulta de Facturas </a>
								@endcan

								@can('Liquidacion de Caja')
                                <a href="/ingreso/liquidacion_caja" class="dropdown-item">Liquidacion de Caja</a>								
								@endcan

								@can('Concepto Beneficiario')
                                <a href="/beneficiario/consulta_beneficiario" class="dropdown-item">Concepto Beneficiario</a>								
								@endcan

								@can('Resumen de Caja')
                                <a href="/ingreso/caja_total" class="dropdown-item">Resumen de Caja</a>
								@endcan	

								@can('Resumen Efectivo')
                                <a href="/ingreso/create_efectivo" class="dropdown-item">Resumen de Efectivo</a>
								@endcan	

						   </div>
					</li>
					@endif
 
					@if(Gate::check('Fondo Comun Planilla') || Gate::check('Adelantos y Descuentos Delegados') || Gate::check('Consulta Reintegro') || Gate::check('Asignacion de Cuentas') || Gate::check('Planilla Delegados') || Gate::check('Registro Recibos por Honorarios') || Gate::check('Asiento Planilla Delegados'))
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Contabilidad</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
						   	@can('Fondo Comun Planilla')
						   	<a href="/fondoComun/consulta_fondo_comun" class="dropdown-item">Fondo Com&uacute;n Planilla</a>
							@endcan
							@can('Adelantos y Descuentos Delegados')
							<a href="/adelanto/consulta_adelanto" class="dropdown-item">Adelantos y Descuentos Delegado</a>
							@endcan
							@can('Consulta Reintegro')
						   	<a href="/planillaDelegado/consulta_reintegro" class="dropdown-item">Delegado Reintegro</a>
							@endcan
							@can('Asignacion de Cuentas')
							<a href="/asignacion" class="dropdown-item">Asignacion de Cuentas</a>
							@endcan

							@can('Planilla Delegados')
						   	<a href="/planillaDelegado/consulta_planilla_delegado" class="dropdown-item">Planilla Delegados</a>
							@endcan
							@can('Registro Recibos por Honorarios')
						   	<a href="/planillaDelegado/consulta_planilla_recibos_honorario" class="dropdown-item">Registro Recibos por Honorarios</a>
							@endcan

							@can('Asiento Planilla Delegados')
							<a href="/asiento" class="dropdown-item">Asiento Planilla Delegados</a>
							@endcan

							@can('Delegado Tributo')
							<a href="/delegadoTributo/consulta_delegadoTributo" class="dropdown-item">Delegado Tributo RH</a>
							@endcan

						   </div>
					</li>
					@endif

					@if(Gate::check('Empresas') || Gate::check('Municipalidades') || Gate::check('Conceptos') || Gate::check('Tipo de Conceptos') || Gate::check('Seguros') || Gate::check('Periodo Comision') || Gate::check('Movilidad') || Gate::check('Persona') || Gate::check('Plan contable') || Gate::check('Partida Presupuestal') || Gate::check('Centro de costos') || Gate::check('Multas Mantenimiento') || Gate::check('Tabla Maestra') || Gate::check('Zonales'))
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
								@can('Plan contable')
                                <a href="/plan_contable/consulta_plan_contable" class="dropdown-item">Plan Contable</a>
								@endcan
								@can('Partida Presupuestal')
                                <a href="/partida_presupuestal/consulta_partida_presupuestal" class="dropdown-item">Partida Presupuestal</a>
								@endcan
								@can('Centro de costos')
                                <a href="/centro_costo/consulta_centro_costo" class="dropdown-item">Centro de Costos</a>
								@endcan
								@can('Multas Mantenimiento')
                                <a href="/multa/consulta_multa_mantenimiento" class="dropdown-item">Multa</a>
								@endcan
								@can('Tabla Maestra')
                                <a href="/tabla_maestra/consulta_tabla_maestra" class="dropdown-item">Tabla Maestra</a>
								@endcan
								@can('Zonales')
                                <a href="/coordinador_zonal/consulta_coordinador_detalle" class="dropdown-item">Zonales</a>
								@endcan
								<!--@can('Profesion')
								<a href="/profesion/consulta_profesion" class="dropdown-item">Profesi&oacute;n</a>
								@endcan
								@can('Otros Profesionales')
                                <a href="/profesionalesOtro/consulta_profesionalesOtro" class="dropdown-item">Otros Profesionales</a>
								@endcan-->
								
						   </div>	
					</li>
					@endif
 
                    @if(Gate::check('Pronto Pago') || Gate::check('Parametros') || Gate::check('Tipo Cambio') || Gate::check('Reporte Ventas') || Gate::check('Reporte Cajas') || Gate::check('Reporte Deudas Gestion'))
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownPrueba" data-toggle="dropdown"
						   aria-haspopup="true" aria-expanded="false">Gesti&oacute;n</a>
						   <div class="dropdown-menu" aria-labelledby="navbarDropdownPrueba">
						   		@can('Pronto Pago')
								<a href="/prontoPago/consulta_prontoPago" class="dropdown-item">Pronto Pago</a>
								@endcan
								@can('Parametros')
								<a href="/parametro/consulta_parametro" class="dropdown-item">Par&aacute;metros</a>
								@endcan
								@can('Reporte Ventas')
								<a href="/reporte/1" class="dropdown-item">Reportes Ventas</a>
								@endcan
								@can('Reporte Cajas')
								<a href="/reporte/2" class="dropdown-item">Reportes Cajas</a>
								@endcan	
								@can('Reporte Deudas Gestion')
								<a href="/reporte/3" class="dropdown-item">Reportes Deudas</a>
								@endcan	
								@can('Tipo Cambio')
								<a href="/tipo_cambio/consulta_tipo_cambio" class="dropdown-item">Tipo Cambio</a>
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
