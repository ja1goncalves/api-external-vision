<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Repositories\PersonRepository;
use App\Services\Parsers\AssertivaParser;
use App\Services\Traits\CrudMethods;

/**
 * Class PersonService
 * @package App\Services
 */
class PersonService extends AppService
{
    use CrudMethods;

    /**
     * @var PersonRepository
     */
    protected $repository;
    /**
     * @var
     */
    private $assertivaParser;

    /**
     * PersonService constructor.
     * @param PersonRepository $repository
     * @param AssertivaParser $assertivaParser
     */
    public function __construct(PersonRepository $repository,
                                AssertivaParser  $assertivaParser)
    {
        $this->repository      = $repository;
        $this->assertivaParser = $assertivaParser;
    }


    /**
     * @param $cpf
     * @return mixed
     */
    public function searchCpf($cpf)
    {
        $response = Cache::remember($cpf, 172800, function () use ($cpf) {
            $response = $this->accessAssertiva($cpf);
            $ZeroPerson = $this->formatString($response['PF']['DADOS']['CPF']);
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
            'empresa'   => config("assertiva.credentials.company"),
            'usuario'   => config("assertiva.credentials.user"),
            'senha'     => config("assertiva.credentials.password"),
            'documento' => $cpf
        ];

        $response = Service::httpClient()->request('GET', config("assertiva.url_cpf"), [
            'query' => $query,
            'proxy' => config("assertiva.proxy"),
        ]);

        $response = json_decode($response->getBody(), true);

        return $response;
    }

}