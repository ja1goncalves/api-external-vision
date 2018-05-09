<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 09/05/18
 * Time: 11:30
 */


return
[
    /*
    |--------------------------------------------------------------------------
    | asertiva credentials
    |--------------------------------------------------------------------------
    |
    | Laravel supports both SMTP and PHP's "asertiva" function as drivers for the
    | sending of e-mail. You may specify which one you're using throughout
    | your application here. By default, Laravel is setup for SMTP asertiva.
    |
    | Supported: "smtp"
    |
    */

    'credentials' =>
    [
        'company'  => env('company' , 'PSV-TURISMO'),
        'user'     => env('user'    , 'PSV-WS'),
        'password' => env('password', '99694807'),
    ]
];
