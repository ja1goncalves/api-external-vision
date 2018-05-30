<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 16/05/18
 * Time: 12:15
 */

namespace App\Services;

use App\AppHelper;

class CepService
{
    /**
     * Busca de Enderreço via cep, api viacep
     *
     * @param $cep
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCep($cep)
    {
        try{
            if (empty($cep) or is_null($cep)){
                throw new \Exception('Cep inválido!');
            } else {
                $url = config("acess.urls.cep");
                $cep = AppHelper::removeCharacters($cep);
                $res = PersonService::getInstance()->request('GET', $url.$cep . '/json/');
                $json = json_decode($res->getBody(), true);

                return $json;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
    }


}