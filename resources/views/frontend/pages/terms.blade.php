@extends('frontend.layouts.app')

@section('title', __('Terms & Conditions'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Terms & Conditions')
                    </x-slot>

                    <x-slot name="body">
                        <article class="contenido">
                    <h6 class="subtitulo">1. Aceptación de los Términos</h6>
                    <p>El uso del carrito de compras en línea del Colegio Profesional COLEGIO DE ARQUITECTOS DEL PERU REGIONAL LIMA implica la aceptación plena y sin reservas de los presentes Términos y Condiciones. El usuario reconoce haber leído, comprendido y aceptado la presente política antes de realizar cualquier pago.</p>
                    <h6 class="subtitulo">2. Definiciones</h6>
                    <p>Usuario: Profesional colegiado o tercero autorizado que utiliza la plataforma.</p>
                    <p>Plataforma: Sitio web y sistema de carrito de compras en línea del Colegio Profesional.</p>
                    <p>Servicios: Pago de cuotas ordinarias, extraordinarias, derechos de trámites, certificaciones y demás servicios que el Colegio Profesional disponga.</p>
                    <h6 class="subtitulo">3. Registro y Autenticación</h6>
                    <p>El acceso al carrito de compras requiere autenticación mediante credenciales únicas e intransferibles del usuario.</p>
                    <p>El usuario es responsable de la confidencialidad de sus credenciales y del uso indebido que terceros pudieran hacer de ellas.</p>
                    <h6 class="subtitulo">4. Métodos de Pago</h6>
                    <p>Se aceptan únicamente los medios de pago habilitados en la plataforma (tarjetas de crédito/débito, transferencias en línea, billeteras digitales u otros autorizados).</p>
                    <p>Las transacciones son procesadas a través de pasarelas de pago certificadas con estándares de seguridad (PCI DSS, TLS/SSL).</p>
                    <p>El Colegio Profesional no almacena ni gestiona datos sensibles de las tarjetas de crédito/débito.</p>
                    <h6 class="subtitulo">5. Seguridad de la Información</h6>
                    <p>La plataforma utiliza cifrado SSL/TLS para proteger la confidencialidad de las comunicaciones.</p>
                    <p>Los datos personales y financieros son tratados conforme a la Ley N.° 29733 de Protección de Datos Personales.</p>
                    <p>Se realizan auditorías periódicas de seguridad para mitigar riesgos de fraude, robo de identidad o accesos no autorizados.</p>
                    <h6 class="subtitulo">6. Responsabilidad del Usuario</h6>
                    <p>El usuario se compromete a:</p>
                    <ul>
                        <li>Utilizar la plataforma únicamente para fines lícitos y autorizados.</li>
                        <li>No realizar fraudes, intentos de acceso indebido ni actividades que comprometan la seguridad del sistema.</li>
                        <li>Verificar la exactitud de la información ingresada antes de efectuar un pago.</li>
                </ul>
                    <h6 class="subtitulo">7. Confirmación de Pagos y Comprobantes</h6>
                    <p>Una vez confirmado el pago, el usuario recibirá un comprobante electrónico (boleta o factura, según corresponda) en el correo electrónico registrado.</p>
                    <p>El Colegio Profesional no se responsabiliza por errores en los datos ingresados por el usuario que afecten la emisión de comprobantes.</p>
                    <h6 class="subtitulo">8. Política de Reembolsos</h6>
                    <p>Los pagos efectuados no son reembolsables, salvo error imputable al Colegio Profesional o cobro indebido.</p>
                    <p>Todo reclamo deberá presentarse por escrito a través de los canales oficiales en un plazo máximo de 7 días hábiles después de la operación.</p>
                    <h6 class="subtitulo">9. Protección de Datos Personales</h6>
                    <p>Los datos recopilados serán utilizados exclusivamente para la gestión administrativa, financiera y colegiada.</p>
                    <p>El usuario puede ejercer sus derechos de acceso, rectificación, cancelación y oposición (ARCO) mediante solicitud escrita dirigida al Colegio Profesional.</p>
                    <h6 class="subtitulo">10. Limitación de Responsabilidad</h6>
                    <p>El Colegio Profesional no será responsable por fallas técnicas, interrupciones del servicio o problemas ajenos a su control (fallas de Internet, pasarelas de pago externas, etc.).</p>
                    <p>El Colegio Profesional tampoco garantiza la disponibilidad continua del sistema, aunque hará sus mejores esfuerzos por mantenerlo activo y seguro.</p>
                    <h6 class="subtitulo">11. Modificaciones de los Términos</h6>
                    <p>El Colegio Profesional podrá modificar los presentes Términos y Condiciones en cualquier momento, comunicando los cambios a través de la plataforma. El uso continuado del servicio implica la aceptación de las modificaciones.</p>
                    <h6 class="subtitulo">12. Jurisdicción y Ley Aplicable</h6>
                    <p>Los presentes Términos y Condiciones se rigen por las leyes de la República del Perú. Cualquier controversia será resuelta en los tribunales competentes del distrito judicial de Lima Cercado.</p>
                    <h6 class="subtitulo" style="text-align:right">Colegio de Arquitectos del Perú - Regional Lima</h6>
                </article>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
