<?php

namespace App\Services;

use App\AppHelper;

class CnpjService
{
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

}