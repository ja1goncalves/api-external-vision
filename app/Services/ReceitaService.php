<?php

namespace App\Services;

/**
 * Class ReceitaService
 * @package App\Services
 */
class ReceitaService
{

    /**
     * ReceitaService constructor.
     */
    public function __construct(){

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
                $res = Service::httpClient()->request('GET', $endpoint);
                $data = json_decode($res->getBody(), true);

                return $data;
            }
        } catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
    }

}