<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->group(function ()
{
    Route::get('/cep/{cep}',    'CepController@findCep');
    Route::get('/cnpj/{cnpj}',  'CnpjController@findCnpj');
    Route::get('/spc/consulta', 'SpcControllers@consultCpfOrCnpj');
    Route::get('/assertiva',    'PersonController@findCpf');
});