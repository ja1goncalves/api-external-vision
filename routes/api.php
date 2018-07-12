<?php

Route::group(['middleware' => ['auth:api']], function () {
    
    Route::get('/cep/{cep}',    'CorreiosController@findCep');
    Route::get('/cnpj/{cnpj}',  'ReceitaController@findCnpj');
    Route::get('/spc/consulta', 'SpcControllers@consultCpfOrCnpj');
    Route::get('/cpf/{cpf}',    'AssertivaController@findCpf');
});