<?php



namespace App\Services;


use GuzzleHttp\Client;
use Fideloper\Proxy\TrustProxies as Middleware;

/**
 * Class Service
 * @package App\Services
 */
class Service
{

    private $client;


    public function __construct(Client $client)
    {

        $this->client = $client;
    }


    /**
     * Busca de Enderreço via cep
     *
     * @param $cep
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCep($cep)
    {
        $cep = preg_replace("/[.\/-]/",'',$cep);
        $res = $this->client->request('GET', 'https://viacep.com.br/ws/'. $cep .'/json/');
        $res = json_decode($res->getBody(), true);

        return $res;
    }

    /**
     * Busca de informações de um Cnpj informado
     *
     * @param $cnpj
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj($cnpj)
    {
        $cnpj = preg_replace("/[.\/-]/",'',$cnpj);
        $res  = $this->client->request('GET', 'https://www.receitaws.com.br/v1/cnpj/'.$cnpj);
        $data = json_decode( $res->getBody(),true );

        return $data;
    }

    /**
     * @param $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCpf($request)
    {
        $url = 'https://api.assertivasolucoes.com.br/api/1.0.0/localize/json/pf?';

        $cpf = $request->get('cpf');

        $params =
        [
            'empresa'     => config("assertiva.credentials.company"),
            'usuario'      => config("assertiva.credentials.user"),
            'senha'      => config("assertiva.credentials.password"),
            'documento'      => $cpf
        ];

        \Log::debug($params);

        $query = 'empresa='    .$params['empresa'].
                 '&usuario='   .$params['usuario'].
                 '&senha='     .$params['senha'].
                 '&documento=' .$params['documento'];

        \Log::debug($query);

         $res  = $this->client->request('GET', $url.$query,
        [
            'proxy' => 'http://54.207.118.251:6666'
        ]);

         \Log::debug($res);

        $data = json_decode($res->getBody(),true);

        return $data;

    }


}