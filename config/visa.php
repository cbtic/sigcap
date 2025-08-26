<?php

return [

    'development' => env('VISA_DEVELOPMENT', true),

    'dev' => [
        'merchant_id' => env('VISA_DEV_MERCHANT_ID'),
        'user' => env('VISA_DEV_USER'),
        'pwd' => env('VISA_DEV_PWD'),
        'url_security' => env('VISA_DEV_URL_SECURITY'),
        'url_session' => env('VISA_DEV_URL_SESSION'),
        'url_js' => env('VISA_DEV_URL_JS'),
        'url_authorization' => env('VISA_DEV_URL_AUTHORIZATION'),
    ],

    'prd' => [
        'merchant_id' => env('VISA_PRD_MERCHANT_ID'),
        'user' => env('VISA_PRD_USER'),
        'pwd' => env('VISA_PRD_PWD'),
        'url_security' => env('VISA_PRD_URL_SECURITY'),
        'url_session' => env('VISA_PRD_URL_SESSION'),
        'url_js' => env('VISA_PRD_URL_JS'),
        'url_authorization' => env('VISA_PRD_URL_AUTHORIZATION'),
    ],

];