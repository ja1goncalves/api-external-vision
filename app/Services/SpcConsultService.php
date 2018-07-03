<?php
/**
 * Created by PhpStorm.
 * User: diegoferreira
 * Date: 03/07/18
 * Time: 14:36
 */

namespace App\Services;


use GuzzleHttp\Client;
use Spatie\ArrayToXml\ArrayToXml;

class SpcConsultService
{

    protected $client;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function consultSpc($document){

        try{

            $data = [

                'url'               => config("acess.urls.treinamento"),
                'login'             => config("acess.auth_treinamento.login"),
                'password'          => config("acess.auth_treinamento.password"),
                'code-product'      => 227,
                'document-consumer' => $document,
                'type-consumer'     => 'F'

            ];

            $test = json_encode($data);


            $flightData = [

                'nr_arquivo'            => '1284139122',
                'data_geracao'          => '01/05/2012',
                'hora_geracao'          => '14:00',
                'nome_agencia'          => 'Digirotas Informática',
                'ticket'                => [
                    'idv_externo'           => '8565',
                    'data_lancamento'       => '11/09/2017',
                    'codigo_produto'        => 'TKT',
                    'fornecedor'            => 'AV',
                    'num_bilhete'           => '1224674767',
                    'prestador_svc'         => 'AV',
                    'forma_de_pagamento'    => 'CA',
                    'moeda'                 => 'BRL',
                    'emissor'               => 'Diego',
                    'cliente'               => 'PETROBRAS',
                    'localizador'           => 'XYZXYZ',
                    'passageiro'            => 'FERNANDES/PAULA',
                    'tipo_domest_inter'     => 'D',
                    'tipo_roteiro'          => '1',
                ],
                'bilhetes_conjugados'   => [

                    'item'              => '1224674768',
                ],
                'valores'               => [
                    'item'              => [
                        'codigo'            => 'tarifa',
                        'valor'             => '400.00',
                    ],
                    'item'              => [
                        'codigo'            => 'taxa',
                        'valor'             => '19.62',
                    ],
                    'item'              => [
                        'codigo'            => 'taxa_du',
                        'valor'             => '40.00',
                    ],
                ],

                'roteiro'               => [
                    'aereo'             => [
                        'cia_iata'          => 'AV',
                        'numero_voo'        => '1234',
                        'aeroporto_origem'  => 'GIG',
                        'aeroporto_destino' => 'GRU',
                        'data_partida'      => '20/09/2018',
                        'hora_partida'      => '11:00',
                        'data_chegada'      => '25/09/2018',
                        'hora_chegada'      => '16:00',
                        'classe'            => 'Y',

                    ],
                ],
                'info_adicionais'           => 'Bilhete de ida R$ 200.00'



            ];

            return $result = ArrayToXml::convert($flightData);


        }catch(\Exception $e){

            return response()->json([

                'erro' => true,
                'message' => $e->getMessage()
            ]);

        }

    }

}