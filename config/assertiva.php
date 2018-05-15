<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Parametros de Acesso á api Assertiva
    |--------------------------------------------------------------------------
    */

     'credentials' => [
        'company'  => env('ASSERTIVA_COMPANY' , 'PSV-TURISMO'),
        'user'     => env('ASSERTIVA_USER'    , 'PSV-WS'),
        'password' => env('ASSERTIVA_PASSWORD', '99694807'),
     ],

    'url_cpf' => env('ASSERTIVA_CPF_URL', 'https://api.assertivasolucoes.com.br/api/1.0.0/localize/json/pf'),
    'proxy'   => env('ASSERTIVA_PROXY'),

];
