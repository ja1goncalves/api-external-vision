<?php

namespace App\Services;

use App\Consult;
use App\ApiLog;
use App\Services\Parsers\AssertivaParser;
use App\Services\Parsers\DataParser;
use GuzzleHttp\Client;
use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Support\Facades\Log;
use function Psy\debug;
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

    public function searchCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string)$cpf);
        $searchConsult = $this->consultsParser->searchConsult($cpf);

        $serch = $this->findCpf($cpf);
        return $serch;

        /*
        if(empty($searchConsult))
        {
            $serch = $this->findCpf($cpf);
            return $serch;
        }
        else
        {
            //retorna dados da consulta no banco de dados
            return $searchConsult;
        }
        */

    }

    /**
     * Pesquisa de informações pessoais pelo Cpf, api assertiva
     *
     * @param $cpf
     * @return array|null|void
     * @throws \Exception
     */
    public function findCpf($cpf)
    {
        //acceso á api assertiva com o seu retorno
        $response = $this->accessAssertiva($cpf);

        //verifica se cpf possue 0 na frente
        $ZeroPerson    = $this->formatString($response['PF']['DADOS']['CPF']);
        //$ZeroMather    = $this->formatString($response['PF']['DADOS']['MAE']['CPF']);
       // $ZeroCopartner = $this->formatString($response['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['SOCIOS']['CPF']);

        //tratamento json
        //$parsers = $this->assertivaParser->parseData($response,$ZeroPerson,$ZeroMather,$ZeroCopartner);
        $parsers = $this->assertivaParser->parseData($response,$ZeroPerson);

        /**
         * Salvar dados no banco de dados
         */

            //$dataParser  = new DataParser();
            //$dataparsers = $dataParser->searchAlls($parsers);
















            return $parsers;

    }


    /**
     * Acesso á Api Assertiva e retorno de dados da mesma
     *
     * @param $cpf
     * @return mixed
     */
    public function accessAssertiva($cpf)
    {


        $query = [
            'empresa'   => config("assertiva.credentials.company"),
            'usuario'   => config("assertiva.credentials.user"),
            'senha'     => config("assertiva.credentials.password"),
            'documento' => $cpf
        ];

        /*
            $response = $this->client->request('GET', config("assertiva.url_cpf"), [
                'query' => $query,
                'proxy' => config("assertiva.proxy"),
            ]);

            //\Log::info($response->getBody());
            $response = json_decode($response->getBody(), true);
            return $response;
        */

        //exemplos de retorno
        //$response = json_decode("{\"PF\":{\"DADOS\":{\"SIGNO\":\"TOURO\",\"PROBABILIDADE_OBITO\":0,\"PROTOCOLO\":\"b843c678-bdd4-4f67-ae2b-0ebf6bea13bf\",\"IDADE\":24,\"MAE\":{\"TELEFONES\":{\"TELEFONE\":[81992589969,81988240540]},\"CPF\":16988221468,\"NOME\":\"EDNA SOARES DE SOUZA\"},\"RENDA_ESTIMADA\":1033.92,\"ENDERECOS\":{\"ENDERECO\":{\"BAIRRO\":\"JARDIM SAO PAULO\",\"TIPO_LOGRADOURO\":\"R\",\"COMPLEMENTO\":\"BL 2 AP 2\",\"CEP\":50790901,\"NUMERO\":355,\"LOGRADOURO\":\"LEANDRO BARRETO\",\"UF\":\"PE\",\"CIDADE\":\"RECIFE\"}},\"TELEFONES_MOVEIS\":{\"TELEFONE\":[81992589969,81988240540,\"\",81981546043,\"\",\"\"]},\"SITUACAO_RECEITA_FEDERAL\":{\"DATACONSULTA\":\"\"},\"NOME\":\"LAIS INGRID SOARES DE SOUZA VIDOTO\",\"FAIXA_RENDA_ESTIMADA\":\"E\",\"DATA_NASC\":\"1994-04-25\",\"VALOR_BENEFICIO\":\"Até 2 SM\",\"CPF\":8967701411,\"SEXO\":\"F\"}}}", true);
        $response = json_decode("{\"PF\":{\"DADOS\":{\"DATA_NASC\":\"1994-01-08\",\"SIGNO\":\"CAPRICÓRNIO\",\"PROBABILIDADE_OBITO\":0,\"MAE\":{\"NOME\":\"MARIA GISELIA MENDES COUTINHO VASCONCELOS\"},\"IDADE\":24,\"PROTOCOLO\":\"fc093348-4f9b-4275-b9c1-8f73cf912db9\",\"ENDERECOS\":{\"ENDERECO\":{\"BAIRRO\":\"TIMBAUBINHA\",\"CEP\":55870000,\"NUMERO\":52,\"LOGRADOURO\":\"VITAL BRASIL\",\"UF\":\"PE\",\"CIDADE\":\"TIMBAUBA\"}},\"CPF\":7082187416,\"TELEFONES_MOVEIS\":{\"TELEFONE\":[\"\",\"\",\"\",\"\",\"\",\"\",\"\"]},\"SEXO\":\"M\",\"SITUACAO_RECEITA_FEDERAL\":{\"DATACONSULTA\":\"\"},\"NOME\":\"LOURIVALDO JOSE FLAVIO COUTINHO VASCONCELOS\"}}}", true);

        $log_assertiva = new ApiLog();
        $log_assertiva->log('Assertiva', 'Log CPF', 'CPF: ' . $cpf);

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
     * Pegar consulta se CPF existe na base dados
     *
     * @param $query
     * @param $cpf
     * @return mixed
     */
    public function scopeCpf($query, $cpf)
    {
        return $query->where('cpf', $cpf);
    }

    /**
     * Pegar consulta se CPF existe na base dados
     *
     * @param $data
     * @return mixed
     */
    public function getCpf($data)
    {
        $earliestdate = DB::table('consults')
            ->select('*')
            ->where(['cpf' => $data])->first();
        if ($earliestdate) {
            $data = (object)$earliestdate;
            return $data;
        }
    }

    /**
     * Verifica se dados cadastrados existem a mais de meses e retorna sua entidade
     *
     * @param $data
     * @return mixed
     */
    public function getMonths($data)
    {
        $mostDate = DB::table('consults')
            ->select('*')
            ->where('cpf', '=', $data)
            ->where('updated_at', '>=', new \DateTime('-6 months'))
            ->first();
        if ($mostDate) {
            return $mostDate;
        } else {
            return false;
        }
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
     * @return string
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

}