<?php

Route::get('/usercreate',function (){
    $data = [
        'name'      => 'apigateway',
        'email'     => 'apivision@mangue3.com',
        'active'     => 1,
        'api_token' => bcrypt('zinabrevisionapi'),
        'password'  => bcrypt('zinabrevisionapi'),
    ];
    return \App\User::create($data);
});
Route::group(['middleware' => ['auth:api']], function () {
    
    Route::get('/cep/{cep}',    'CorreiosController@findCep');
    Route::get('/cnpj/{cnpj}',  'ReceitaController@findCnpj');
    Route::get('/spc/consulta', 'SpcControllers@consultCpfOrCnpj');
    Route::get('/assertiva',    'AssertivaController@findCpf');
});