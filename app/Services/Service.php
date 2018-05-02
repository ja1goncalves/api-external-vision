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

    /**
     * @var Client
     */
    private $client;

    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
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
     * Action Index, Recebe todas request de uma consulta via API e Delega para seu Modelo, tratar a Informação;
     *
     * @param $cpf
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($cpf)
    {
        // Método formatCPF retorna um CPF válido
        $cpf = $this->formatCpf($cpf);

        if(is_null($cpf))
        {
            return ['message' => 'Cpf inválido!'];
        }

        // Método getMonths verifica se cadastro existe a de menos 6 meses
        // Método getCpf retorna uma consulta do Banco de Dados, se CPF existir
        if ($this->consult->getMonths($cpf))
        {
            $consult = $this->formatJson($cpf);

            return $consult;
        } else {
            // Caso CPF exista a mais de 6 meses, Método NewConsultSimples è executado
            // Método newConsultSimples Retorna uma consulta da API
            $assertiva = $this->assertiva->newConsultSimple($cpf);

            $data = $this->consult->getCpf($cpf);

            // Método getConsult verifica se CPF existe no banco, e retorna todas instancias,
            // recupera o id e destroy todas instancia do banco
            // Método DispachesModels envia para model seus dados recpectivos para gravar no banco
            // Método MontarJson, retorna estrutura de dados do json

            if($data)
            {
                $this->update($cpf, $assertiva);
                $consult = $this->formatJson($cpf);

                return $consult;
            }
            // Método dispatchesModel Chama método store de cada modelo para gravar sua entidade
            $this->sendRequestModel($assertiva);

            // Retorna a nova consulta em um JSON
            $consult = $this->formatJson($cpf);

            return $consult;
        }
    }

    /**
     * Método Upadte, Atuliza novamente a consulta no Banco de dados
     *
     * @param $cpf
     * @param $assertiva
     * @return array
     */
    public function update($cpf, $assertiva)
    {
        //Destroi Tudo do Banco de dados
        $this->destroy($cpf);

        // Envia Request para os Model
        $allResult = $this->sendRequestModel($assertiva);
        if(!$allResult)
        {
            return [];
        }
    }

    /**
     * Método destroy exclui todas instância do Banco de dados
     *
     */
    public function destroy($cpf)
    {
        $consult    = $this->consult->getCpf($cpf);
        $companie   = $this->consult->find($consult->id)->companies[0];
        $mother     = $this->consult->find($consult->id)->mothers;
        $copartner  = $this->companie->find($companie->id)->copartners;

        $this->consult->find($consult->id)->vehicles()->delete();
        $this->consult->find($consult->id)->streets()->delete();
        $this->consult->find($consult->id)->occupations()->delete();
        $this->consult->find($consult->id)->phones()->delete();
        $this->mother->find($mother->id)->phones()->delete();
        $this->copartner->find($copartner[0]->id)->phones()->delete();
        $this->consult->find($consult->id)->mothers()->delete();
        $this->consult->find($consult->id)->emails()->delete();
        $this->companie->find($companie->id)->copartners()->delete();
        $this->consult->find($consult->id)->companies()->delete();
        $this->consult->find($consult->id)->delete();
    }

    /**
     * Método Store Relationships, acessa cada instância de cada relacionamento e grava sua entidade
     *
     * @param $result
     */
    public function sendRequestModel($result)
    {
        // Var $consultId Recupera o id da consulta
        if ($consultId = $this->consult->request($result))
        {
            $this->street->request($result, $consultId);
            $this->mother->request($result, $consultId);
            $this->email->request($result, $consultId);
            $companieId = $this->companie->request($result, $consultId);
            $this->copartner->request($result, $companieId);
            $this->occupation->request($result, $consultId);
            $this->vehicles->request($result, $consultId);
        }
    }

    public  $array = [];

    /**
     * Método FormatJson recebe cpf, chama seus relacionamentos e retorna um array de json
     *
     * @param $cpf
     * @return object
     */
    public function formatJson($cpf)
    {
        // Recebe Consulta do banco
        $consult = $this->consult->getCpf($cpf);

        if (isset($consult->id))
        {
            $this->array['CONSULT'] = $consult;
        }
        if (isset($consult->id))
        {
            $street  = $this->consult->find($consult->id)->streets;
            $this->array['STREET'] = $street;
        }
        if (isset($consult->id))
        {
            $mother        = $this->consult->find($consult->id)->mothers;
            $this->array['MOTHER'] = $mother;
        }
        if (isset($consult->id))
        {
            $occupation       = $this->consult->find($consult->id)->occupations;
            $this->array['OCCUPATION']  = $occupation;
        }
        if (isset($consult->id))
        {
            $email         = $this->consult->find($consult->id)->emails;
            $this->array['EMAIL'] = $email;
        }
        if (isset($consult->id))
        {
            $vehicle       = $this->consult->find($consult->id)->vehicles;
            $this->array['VEHICLE'] = $vehicle;
        }
        if (isset($consult->id))
        {
            $companie       = $this->consult->find($consult->id)->companies;
            $this->array['COMPANIE']  = $companie;
            $true = $companie->first();

            if (isset($true))
            {
                $copartner         = $this->companie->find($companie[0]->id)->copartners;

                if($copartner->count() > 0)
                {
                    $this->array['COPARTNER']  = $copartner;
                    $phone         = $copartner->find($copartner[0]['id'])->phones;

                    if($phone->count() > 0)
                    {
                        $this->array['COPARTNER_PHONE'] =  $phone;
                    }
                }
            }
        }
        if(isset($consult->id))
        {
            $phone                = $this->consult->find($consult->id)->phones;
            $this->array['PHONE'] =  $phone;
        }
        if(isset($mother['id']))
        {
            $phone                       = $this->mother->find($mother['id'])->phones;
            $this->array['MOTHER_PHONE'] =  $phone;
        }
        // cast para object
        $json = (object)$this->array;

        // cast para json
        $json = json_encode($json);

        return $json;
    }

    /**
     * Método Valida Tamanho, Confere Primeiro Digito Verificador, Calcula Segundo dígido Verificador
     *
     * @param $cpf
     * @return bool
     */
    public function validateCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
        if (strlen($cpf) != 11)
            return false;
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;

        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

    /**
     * Método recebe CPF e Formatar no Padrão xxx.xxx.xxx-xx, caso já seja formatado
     * ele Retorna ele mesmo
     *
     * @param $cpf
     * @return string
     */
    public function formatCpf($cpf)
    {
        if($true = $this->validateCpf($cpf))
        {
            if (strlen($cpf) == 14)
            {
                return $cpf;
            } else
            {
                $partOne     = substr($cpf, 0, 3);
                $partTwo     = substr($cpf, 3, 3);
                $partThree   = substr($cpf, 6, 3);
                $partFour    = substr($cpf, 9, 2);
                $mountCPF = "$partOne.$partTwo.$partThree-$partFour";

                return $mountCPF;
            }
        } else
        {
            return null;
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
     * Método para verificar se tem cpf nao tem zero inicial
     *
     * @param $cpf
     * @return array
     */
    public function verificarZero($cpf)
    {
        if (strlen($cpf) == 10)
        {
            $array = str_split($cpf, 1);
            $string = $this->add($array);

            return $string;
        } else
        {
            $data = $this->formatCpf($cpf);

            return $data;
        }
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
        if (is_array($format))
        {
            $array = $format[0] . $format[1] . $format[2] . $format[3] . $format[4]
                   . $format[5] . $format[6] . $format[7] .$format[8]  . $format[9] . $format[10];

            return $array;
        } else
        {
            if (strlen($format) == 14)
            {
                return $format;
            }
        }
    }

    /**
     * Método Formata o CPF que vem da consulta da API para colocar no padrão xxx.xxx.xxx-xx
     *
     * @param $result
     * @return mixed
     */
    public function sendFormatDb($result)
    {
        if(isset($result->ERRORS))
        {
            return [];
        }

        $CPF    = $result->PF->DADOS->CPF;
        $string = $this->formatString($CPF);
        $new    = $this->formatCpf($string);
        $result->PF->DADOS->CPF = $new;

        return $result;
    }

}