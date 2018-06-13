<?php

namespace App\Services;

use App\Consult;
use App\ApiLog;
use App\Services\Parsers\AssertivaParser;
use App\Services\Parsers\DataParser;
use GuzzleHttp\Client;
use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\Parsers\ConsultsParser;

/**
 * Class Service
 * @package App\Services
 */
class Service
{
    /**
     * @var Client
     */
    private $client;

    private $assertivaParser;

    private $consultsParser;

    /**
     * Service constructor.
     * @param Client $client
     */
    public function __construct(Client $client,
                                AssertivaParser $assertivaParser,
                                ConsultsParser $consultsParser){
        $this->client = $client;
        $this->assertivaParser = $assertivaParser;
        $this->consultsParser = $consultsParser;
    }

    /**
     * @param $cpf
     * @return mixed
     */
    public function searchCpf($cpf)
    {
        return Cache::remember($cpf, 43200, function ($cpf) {
            $response = $this->accessAssertiva($cpf);
            \Log::debug('entrou');
            $ZeroPerson = $this->formatString($response['PF']['DADOS']['CPF']);
            $parsers = $this->assertivaParser->parseData($response,$ZeroPerson);
            return $parsers;
        });
        
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
            'empresa'   => config("assertiva.credentials.company"),
            'usuario'   => config("assertiva.credentials.user"),
            'senha'     => config("assertiva.credentials.password"),
            'documento' => $cpf
        ];

        $response = $this->client->request('GET', config("assertiva.url_cpf"), [
            'query' => $query,
            'proxy' => config("assertiva.proxy"),
        ]);

        $response = json_decode($response->getBody(), true);

        return $response;
    }


    /**
     * @param array $parsers
     * @return array
     */
    public function formattingCpf(array $parsers)
    {
        $pess = $parsers['cpf'];
        $formatCpf = $this->formatCpf($pess);
        $parsers['cpf'] = $formatCpf;

        $mother = $parsers['mother']['cpf'];
        $formatCpfMother = $this->formatCpf($mother);
        $parsers['mother']['cpf'] = $formatCpfMother;

        $copartner = $parsers['copartner']['cpf'];
        $formatCpfCopartner = $this->formatCpf($copartner);
        $parsers['copartner']['cpf'] = $formatCpfCopartner;

        return $parsers;
    }

     /**
     * Método Valida Tamanho, Confere Primeiro Digito Verificador, Calcula Segundo dígido Verificador
     *
     * @param $cpf
     * @return bool
     */
    public function validateCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string)$cpf);

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
     * Método recebe CPF e Formatar no Padrão xxx.xxx.xxx-xx, caso já seja formatado
     * ele retorna ele mesmo
     *
     * @param $cpf
     * @return string
     */
    public function formatCpf($cpf)
    {
        if (strlen($cpf) == 14){
                return $cpf;
        } else{
            if (strlen($cpf) == 10){
                $zero = '0'.$cpf;
                $partOne    = substr($zero, 0, 3);
                $partTwo    = substr($zero, 3, 3);
                $partThree  = substr($zero, 6, 3);
                $partFour   = substr($zero, 9, 2);
                $mountCPF   = "$partOne.$partTwo.$partThree-$partFour";

                return $mountCPF;
            }
            else{
                $partOne    = substr($cpf, 0, 3);
                $partTwo    = substr($cpf, 3, 3);
                $partThree  = substr($cpf, 6, 3);
                $partFour   = substr($cpf, 9, 2);
                $mountCPF   = "$partOne.$partTwo.$partThree-$partFour";

                return $mountCPF;
            }
        }
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

    /**
     * @return mixed
     */
    public static function authorizationUser($id = false)
    {
        $user = Auth::user();
        if ($id) {
            return $user->id;
        }
        return $user->email;
    }

}