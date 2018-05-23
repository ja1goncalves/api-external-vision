<?php

namespace App\Services;

use GuzzleHttp\Client;

class ReceitaService
{

    /**
     * @var Client
     */
    private $client;

    /**
     * Service constructor.
     * @param Client $client
     */
    public function __construct(Client $client){
        $this->client = $client;
    }

    /**
     * Busca de informações de um Cnpj informado, api da receita
     *
     * @param $cnpj
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj($cnpj)
    {
        try{
            if (empty($cnpj) or is_null($cnpj)){
                throw new \Exception('Cnpj inválido!');
            } else{
                $url = 'https://www.receitaws.com.br/v1/cnpj/';
                $cnpj = preg_replace("/[.\/-]/", '', $cnpj);
                $endpoint = $url . $cnpj;
                $res = $this->client->request('GET', $endpoint);
                $data = json_decode($res->getBody(), true);

                return $data;
            }
        } catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
    }

}