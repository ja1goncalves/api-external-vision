<?php

return [
    /*
    |--------------------------------------------------------------------------
    | URLS de Acesso á API Externas
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    /**
    * URLs de acesso as apis externas
    */
    'urls' => [
        'cep'  => env('CEP_URL'    , 'https://viacep.com.br/ws/'),
        'cnpj' => env('RECEITA_URL', 'https://www.receitaws.com.br/v1/cnpj/'),

        // urls de acesso á api do Assertiva
        'cpf' => env('ASSERTIVA_CPF_URL', 'https://api.assertivasolucoes.com.br/api/1.0.0/localize/json/pf'),

        // urls de acesso á api do SPC (producao/treinamento)
        'producao'    => env('SPC_PRODUCAO_URL'   , 'https://servicos.spc.org.br:443/spc/remoting/ws/consulta/consultaWebService?wsdl'),
        'treinamento' => env('SPC_TREINAMENTO_URL', 'https://treina.spc.org.br:443/spc/remoting/ws/consulta/consultaWebService?wsdl'),
    ],


    /**
    * Auth de acesso e proxy da api do Assertiva
    */

    'credentials' => [
        'company'  => env('ASSERTIVA_COMPANY' , 'PSV-TURISMO'),
        'user'     => env('ASSERTIVA_USER'    , 'PSV-WS'),
        'password' => env('ASSERTIVA_PASSWORD', '99694807'),
    ],
    'proxy'   => env('ASSERTIVA_PROXY','http://54.207.118.251:6666'),


    /**
    * Auth de acesso á api do SPC
    */

    'auth_producao' => [
        'login'    => env('SPC_PRODUCAO_LOGIN'    ,'1577427'),
        'password' => env('SPC_PRODUCAO_PASSWORD' ,'10455423'),
        'trace'    => env('SPC_PRODUCAO_TRACE'    ,'1'),
    ],
    'auth_treinamento' => [
        'login'    => env('SPC_TREINAMENTO_LOGIN'    ,'398759'),
        'password' => env('SPC_TREINAMENTO_PASSWORD' ,'09052018'),
        'trace'    => env('SPC_TREINAMENTO_TRACE'    ,'1'),
    ],

];
