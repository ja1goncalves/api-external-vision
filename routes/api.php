<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/cep/{cep}',    'CepController@findCep');
    Route::get('/cnpj/{cnpj}',  'CnpjController@findCnpj');
    Route::get('/spc/consulta', 'SpcControllers@consultCpfOrCnpj');
    Route::get('/assertiva',    'PersonController@findCpf');

});