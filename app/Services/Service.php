<?php

namespace App\Services;

use App\AppHelper;
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
    private $client;
    private $assertivaParser;
    private $consultsParser;

    /**
     * Service constructor.
     * @param Client $client
     * @param AssertivaParser $assertivaParser
     */
    public function __construct(Client $client, AssertivaParser $assertivaParser){
        $this->client          = $client;
        $this->assertivaParser = $assertivaParser;
    }

    /**
     * @param $cpf
     * @return mixed
     */
    public function searchCpf($cpf)
    {
        $response = Cache::remember($cpf, 43200, function () use ($cpf) {
            $response = $this->accessAssertiva($cpf);
            $ZeroPerson = AppHelper::formatString($response['PF']['DADOS']['CPF']);
            $parsers = $this->assertivaParser->parseData($response,$ZeroPerson);
            return $parsers;
        });
        return $response;
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

        $response = $this->client->request('GET', config("acess.urls.cpf"), [
            'query' => $query,
            'proxy' => config("acess.proxy"),
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
        $formatCpf = AppHelper::formatCpf($pess);
        $parsers['cpf'] = $formatCpf;

        $mother = $parsers['mother']['cpf'];
        $formatCpfMother = AppHelper::formatCpf($mother);
        $parsers['mother']['cpf'] = $formatCpfMother;

        $copartner = $parsers['copartner']['cpf'];
        $formatCpfCopartner = AppHelper::formatCpf($copartner);
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
        $cpf = AppHelper::removeSpecificCharacters($cpf);

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
     * @param bool $id
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