<?php

namespace App\Services;

use App\AppHelper;
use App\Services\Parsers\AssertivaParser;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\Parsers\ConsultsParser;

/**
 * Class PersonService
 * @package App\Services
 */
class PersonService
{
    /**
     * @var Client
     */
    //private $client;

    /**
     * @var AssertivaParser
     */
    private $assertivaParser;

    /**
     * @var AppHelper
     */
    private $appHelper;

    /**
     * @var
     */
    public static $instance;

    /**
     * PersonService constructor.
     * @param AssertivaParser $assertivaParser
     * @param AppHelper $appHelper
     */
    public function __construct( AssertivaParser $assertivaParser, AppHelper $appHelper){
        $this->assertivaParser = $assertivaParser;
        $this->appHelper       = $appHelper;
    }

    /**
     * singleton GuzzleHttp\Client
     *
     * @return Client
     */
    public function getInstance(){
        if (!isset(self::$instance)) {
            self::$instance = new Client();
        }
        return self::$instance;
    }

    /**
     * @param $cpf
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchCpf($cpf)
    {
         $cpf = AppHelper::removeSpecificCharacters($cpf);

        $serch = $this->findCpf($cpf);

        return $serch;
    }

    /**
     * Pesquisa de informações pessoais pelo Cpf, api assertiva
     *
     * @param $cpf
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCpf($cpf)
    {
        //acceso á api assertiva com o seu retorno
        $response = $this->accessAssertiva($cpf);

        //verifica se cpf possue 0 na frente
        $ZeroPerson = $this->formatString($response['PF']['DADOS']['CPF']);

        //tratamento json
        $parsers = $this->assertivaParser->parseData($response,$ZeroPerson);

        return $parsers;
    }


    /**
     * Acesso á Api Assertiva e retorno de dados da mesma
     *
     * @param $cpf
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accessAssertiva($cpf)
    {
        $query = [
            'empresa'   => config("acess.credentials.company"),
            'usuario'   => config("acess.credentials.user"),
            'senha'     => config("acess.credentials.password"),
            'documento' => $cpf
        ];

        $response = $this->getInstance()->request('GET', config("acess.urls.cpf"), [
            'query' => $query,
            'proxy' => config("acess.proxy"),
        ]);;

/*
        $response = $this->client->request('GET', config("acess.urls.cpf"), [
            'query' => $query,
            'proxy' => config("acess.proxy"),
        ]);
*/

        $response = json_decode($response->getBody(), true);
/*
        $log_assertiva = new ApiLog();
        $log_assertiva->log('Assertiva', 'Log CPF', 'CPF: ' . $cpf);
*/
        return $response;
    }


     /**
     * Método Valida Tamanho, Confere Primeiro Digito Verificador, Calcula Segundo dígido Verificador
     *
     * @param $cpf
     * @return bool
     */
    public function validateCpf($cpf)
    {
       $cpf = $this->appHelper->removeSpecificCharacters((string)$cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--){
            $soma += $cpf{$i} * $j;
        }
        $resto = $soma % 11;

        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto)){
            return false;
        }

        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--){
            $soma += $cpf{$i} * $j;
        }
        $resto = $soma % 11;

        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }



    /**
     * Verifica se dados cadastrados existem a mais de meses e retorna sua entidade
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function scopeMonths($query, $data)
    {
        return $query->where('cpf', $data)
            ->where('updated_at', '>=', new \DateTime('-6 months'))
            ->first();
    }

    /**
     * Método para verificar se tem cpf nao tem zero inicial
     *
     * @param $cpf
     * @return array
     */
    public function verificarZero($cpf)
    {
        if (strlen($cpf) == 10) {
            $array = str_split($cpf, 1);
            $string = $this->add($array);
            return $string;
        } else {
            return $cpf;
        }
    }

    /**
     * Método converte cpf em string adicionando zero na frente
     *
     * @param $cpf
     * @return array|string
     */
    public function formatString($cpf)
    {
        $format = $this->verificarZero($cpf);
        if (is_array($format)) {
            $array = $format[0] . $format[1] . $format[2] . $format[3] . $format[4] . $format[5] .
                     $format[6] . $format[7] .  $format[8] . $format[9] . $format[10];
            return $array;
        } else {
            if (strlen($format) == 11) {
                return $format;
            }
        }
    }

    /**
     * Adiciona um array em um Lista
     *
     * @param array $obj
     * @return array
     */
    public function add($obj = [])
    {
        $array = [1 => '0'];
        $newArray = array_merge($array , $obj);
        return $newArray;
    }

    /**
     * @param bool $object
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function getUser($object = false)
    {
        if ($object) {
            return Auth::user();
        } else {
            $user = Auth::user();
            return $user->email;
        }
    }

    /**
     * @return mixed
     */
    public static function logout()
    {
        $user = self::getUser(true);
        $accessToken = DB::table('oauth_access_tokens')
            ->where('user_id', '=', $user->id)
            ->latest()->get();

        return DB::table('oauth_access_tokens')
            ->where('id', '=', $accessToken[0]->id)
            ->delete();
    }


}