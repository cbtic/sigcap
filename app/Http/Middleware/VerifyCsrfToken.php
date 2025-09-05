<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * Class VerifyCsrfToken.
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'operacion/consulta',
        'operacion/pago',
        'operacion/extorno_pago',
        'operacion/anulacion',
        'operacion/extorno_anulacion',
        'operacion/req_consulta',
        'operacion/req_pago',
        'operacion/req_anulacion',
        'operacion/ext_pago',
        'operacion/ext_anulacion',
        'asiento_planilla/enviar_planilla_siscont',

        'carrito/finalizar',
        'test-ruta',
        'enviar_planilla',
         
    ];
}