<?php



namespace App\Services;


use GuzzleHttp\Client;

/**
 * Class Service
 * @package App\Services
 */
class Service
{

    private $client;


    public function __construct( Client $client)
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
//{{localhost}}/api/cpf?empresa=PSV-TURISMO&usuario=PSV-WS&senha=99694807&cpf=089.677.014-11

        $url='https://api.assertivasolucoes.com.br/api/1.0.0/localize/json/pf?';
/*
        $empresa   = $request->get('empresa');
        $usuario   = $request->get('usuario');
        $senha     = $request->get('senha');
        $documento = $request->get('documento');
*/

        $empresa   = 'PSV-TURISMO';
        $usuario   = 'PSV-WS';
        $senha     = '99694807';
        $documento = $request->get('documento');
        //$documento = '089.677.014-11';

        $urlFin = $url.  'empresa='   .$empresa.
                         '&usuario='  .$usuario.
                         '&senha='    .$senha.
                         '&documento='.$documento;

        \Log::debug($urlFin);

        $res  = $this->client->request('GET',$urlFin );

        \Log::debug($res);

        $data = json_decode( $res->getBody(),true );

        return $data;
    }


}