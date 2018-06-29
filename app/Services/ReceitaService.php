<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\AppHelper;

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
     * Busca de informaçõeacess.s de um Cnpj informado, api da receita
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
                $cnpj = AppHelper::removeCharacters($cnpj);
                $url = config("acess.urls.cnpj");
                $res = PersonService::getInstance()->request('GET', $url.$cnpj);
                $data = json_decode($res->getBody(), true);

                return $data;
            }
        } catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
    }


    public function validateCnpj($cnpj)
    {
        $cnpj = AppHelper::removeCharacters($cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }

}