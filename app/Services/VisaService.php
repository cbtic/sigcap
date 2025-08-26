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

    public function generateSession($amount, $token)
    {
        $session = [
            'channel' => 'web',
            'amount' => $amount,
            'antifraud' => [
                'clientIp' => request()->ip(),
                'merchantDefineData' => [
                    'MDD4' => "integraciones.guillermo@necomplus.com",
                    'MDD32' => '250376',
                    'MDD75' => 'Registrado',
                    'MDD77' => '7'
                ],
            ],
            'dataMap' => [
                'cardholderCity' => 'Lima',
                'cardholderCountry' => 'PE',
                'cardholderAddress' => 'Av Principal A-5. Campoy',
                'cardholderPostalCode' => '15046',
                'cardholderState' => 'LIM',
                'cardholderPhoneNumber' => '986322205'
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

    public function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token)
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
                'serviceLocationCityName' => 'LIMA',
                'serviceLocationCountrySubdivisionCode' => 'LIMA',
                'serviceLocationCountryCode' => 'PER',
                'serviceLocationPostalCode' => '15074'
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ])->post($this->config['url_auth'] . $this->config['merchant_id'], $data);

        return $response->json();
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