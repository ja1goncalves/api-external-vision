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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::middleware(['auth:api'])->group(function ()
{
    Route::post('/cep', 'CorreiosController@findCep');
    Route::post('/cnpj', 'ReceitaController@findCnpj');

    Route::get('/spc', 'SpcControllers@consultCpfOrCnpj');
    Route::get('/assertiva', 'AssertivaController@index');
});