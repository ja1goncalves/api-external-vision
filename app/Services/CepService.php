<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 16/05/18
 * Time: 12:15
 */

namespace App\Services;

use GuzzleHttp\Client;

class CepService
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
                $url = 'https://viacep.com.br/ws/';
                $cep = preg_replace("/[.\/-]/", '', $cep);
                $res = $this->client->request('GET', $url.$cep . '/json/');
                $response =(object) json_decode($res->getBody(), true);

                if(empty($response)){
                    if (!$response) {
                        throw new \Exception('Invalid response');
                    }else{
                        throw new \Exception("CEP Inválido!");
                    }
                }

                if(isset($response->erro) && $response->erro){
                    throw new \Exception("CEP não encontrado!");
                }

                return [
                    'zip_code'    => $cep,
                    'street'      => $response->logradouro,
                    'district'    => $response->bairro,
                    'city'        => $response->localidade,
                    'uf'          => $response->uf,
                    'street_view' => 'maps.google.co.in/maps?q='.$cep
                ];
            }
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 401);
        }
    }


}