<?php



namespace App\Services;

use App\User;
use GuzzleHttp\Client;
use App\Http\Controllers\ReceitaController;

/**

 * Class Service

 * @package App\Services

 */

class Service
{

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param $cep
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCep($cep){
        $cep = preg_replace("/[.\/-]/",'',$cep);
        $res = $this->client->request('GET', 'https://viacep.com.br/ws/'. $cep .'/json/');
        $res = json_decode($res->getBody(), true);
        return $res;
    }

    /**
     * @param $cnpj
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj($cnpj)
    {
        $cnpj = preg_replace("/[.\/-]/",'',$cnpj);
        $res = $this->client->request('GET', 'https://www.receitaws.com.br/v1/cnpj/'.$cnpj);
        $data = json_decode( $res->getBody(),true );

        return $data;
    }


}