<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VisaService
{
    private $config;

    public function __construct()
    {
        $this->config = config('visa.' . (config('visa.development') ? 'dev' : 'prd'));
    }

    public function generateToken()
    {
        $response = Http::withHeaders([
            'Accept' => '*/*',
            'Authorization' => 'Basic ' . base64_encode($this->config['user'] . ":" . $this->config['pwd']),
        ])->post($this->config['url_security']);

        return $response->body();
    }

    public function generateSession($amount, $token, $datos_usuario)
    {
        $session = [
            'channel' => 'web',
            'amount' => $amount,
            'antifraud' => [
                'clientIp' => request()->ip(),
                'merchantDefineData' => [
                    /*
                    'MDD4' => "integraciones.guillermo@necomplus.com",//correo electronico del cliente
                    'MDD32' => '250376',//id_cliente  dni o correo  //id_persona
                    'MDD75' => 'Registrado',//registrado, invitado, empleado
                    'MDD77' => '7'//fecha actual - fecha colegiatura
                    */
                    'MDD4' => $datos_usuario->email,
                    'MDD32' => $datos_usuario->id_persona,
                    'MDD75' => 'Registrado',
                    'MDD77' => $datos_usuario->dias
                ],
            ],
            //comentar
            'dataMap' => [
                'cardholderCity' => $datos_usuario->departamento,//'Lima',
                'cardholderCountry' => 'PE',
                'cardholderAddress' => $datos_usuario->direccion,//'Av Principal A-5. Campoy',//direccion del agremiado
                'cardholderPostalCode' => '150113',//'15046',
                'cardholderState' => substr($datos_usuario->departamento,0,3),//'LIM',
                'cardholderPhoneNumber' => preg_replace('/\D/', '', $datos_usuario->celular1)//'986322205'//telefono del agremiado
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ])->post($this->config['url_session'] /*. $this->config['merchant_id']*/, $session);
            //print_r($response);
        return $response->json()['sessionKey'] ?? null;
        //\Log::info('Respuesta sesión Niubiz: '.$response->body());
    }

    public function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token, $datos_usuario)
    {
        $data = [
            'captureType' => 'manual',
            'channel' => 'web',
            'countable' => true,
            'order' => [
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken
            ],
            'dataMap' => [
                'urlAddress' => request()->fullUrl(),
                'partnerIdCode' => '',
                'serviceLocationCityName' => $datos_usuario->departamento,//'LIMA',
                'serviceLocationCountrySubdivisionCode' => substr($datos_usuario->departamento,0,3),//'LIM',
                'serviceLocationCountryCode' => 'PE',
                'serviceLocationPostalCode' => '150113'//'15074'
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ])->post($this->config['url_authorization'] /*. $this->config['merchant_id']*/, $data);

        //return $response->json();
        return json_decode($response->body());
    }

    public function generatePurchaseNumber()
    {
        $file = storage_path('app/purchaseNumber.txt');
        $purchaseNumber = file_exists($file) ? (int) file_get_contents($file) : 222;
        $purchaseNumber++;
        file_put_contents($file, $purchaseNumber);
        return $purchaseNumber;
    }
}