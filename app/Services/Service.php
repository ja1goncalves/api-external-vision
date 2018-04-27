<?php



namespace App\Services;

use App\User;
use GuzzleHttp\Client;

/**

 * Class Service

 * @package App\Services

 */

class Service
{
    /**
     * @param $cep
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCep($cep){
        $client = new Client;

        $res = $client->request('GET', 'https://viacep.com.br/ws/'. $cep .'/json/');
        $res = json_decode($res->getBody(), true);
        return $res;
    }
}