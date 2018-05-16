<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 16/05/18
 * Time: 12:18
 */

namespace App\Services\Parsers;


class DataParser
{
    /**
     * Metodo contem todas as consultas ao banco de dados
     *
     * @param $parsers
     */
    public function searchAlls($parsers)
    {
        //gravando consulta
        $consult = $this->searchConsult($parsers);
        //gravando companhia
        $this->searchCompanie($parsers,$consult);
        //gravando socios
        $this->searchCopartner($parsers,$consult);
        //gravando email
        $this->searchEmail($parsers,$consult);
        //gravando mae
        $this->searchMother($parsers,$consult);
        //gravando ocupação
        $this->searchOccupation($parsers,$consult);
        //gravando enderreço
        $this->searchStreet($parsers,$consult);
        //gravando veiculos
        $this->searchVehicles($parsers,$consult);
    }

    /**
     * Esse método salva a primeira consulta e todos telefones na tabela polimorfica
     *
     * @param $result
     * @return mixed
     */
    public function searchConsult($result)
    {
        $result = $this->sendFormatDb($result);

        if(!$result)
            return [];

        if ($consult = $this->store($result->PF->DADOS)) {
            $consultId = $consult->id;
            if (isset($result->PF->DADOS->TELEFONES_MOVEIS)) {
                foreach ((array)$result->PF->DADOS->TELEFONES_MOVEIS->TELEFONE as $tel) {
                    if($tel != '' || !empty($tel))
                        $consult->phones()->create(['phone' => $tel]);
                }
            }
            return $consultId;
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
            return [];

        $CPF    = $result->PF->DADOS->CPF;
        $string = $this->formatString($CPF);
        $new    = $this->formatCpf($string);

        $result->PF->DADOS->CPF = $new;

        return $result;
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
            $array = $format[0] . $format[1] . $format[2] . $format[3] . $format[4] . $format[5] . $format[6] . $format[7] .
                $format[8] . $format[9] . $format[10];
            return $array;
        } else {
            if (strlen($format) == 14) {
                return $format;
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
            $data = $this->formatCpf($cpf);
            return $data;
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
     * Esse método recebe uma request do controller com response da api assertiva
     * Método saveCopartner, chama para gravar no banco de dados
     *
     * @param $result
     * @param $companieId
     */
    public function searchCopartner($result, $companieId)
    {
        if (isset($result->PF->DADOS->SOCIEDADES->SOCIEDADE->SOCIOS))
        {
            if ($companieId)
            {
                $copartner = $this->saveCopartner($result->PF->DADOS->SOCIEDADES->SOCIEDADE->SOCIOS, $companieId);
                foreach ((array)$result->PF->DADOS->TELEFONES_MOVEIS->TELEFONE as $tel)
                {
                    if ($tel != '' || !empty($tel))
                    {
                        $copartner->phones()->create(['phone' => $tel]);
                    }
                }
            }
        }
    }

    /**
     * Grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $companieId
     * @return static
     */
    public function saveCopartner($result, $companieId)
    {
        $arrayList = null;

        if (isset($result->CPF))
        {
            $arrayList['cpf'] = $result->CPF;
        }
        if (isset($result->NOME))
        {
            $arrayList['name'] = $result->NOME;
        }
        if (isset($result->NOME))
        {
            $arrayList['companie_id'] = $companieId;
        }
        if ($copartner = $this->create($arrayList))
        {
            return $copartner;
        }
    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método saveEmail, chama para gravar no banco de dados
     * @param $result
     * @param $consultId
     */
    public function searchEmail($result, $consultId)
    {
        // Se StdClass Existe Model Email è disparado e chama método saveEmail e grava dados da email
        if (isset($result->PF->DADOS->EMAILS)) {
            $this->saveEmail($result->PF->DADOS->EMAILS, $consultId);
        }
    }

    /**
     * Método store grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     * @return static
     */
    public function saveEmail($result, $consultId)
    {
        foreach ((array)$result as $s) {
            $arrayList = null;

            if (isset($s)) {
                $arrayList['email'] = $s;
            }

            if (isset($s)) {
                $arrayList['consult_id'] = $consultId;
            }

            $this->create($arrayList);
        }
    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método saveMother, chama para gravar no banco de dados
     *
     * @param $result
     * @param $consultId
     */
    public function searchMother($result, $consultId)
    {
        // Se StdClass Existe Model Mother è disparado e chama método store e grava dados da mother
        if (isset($result->PF->DADOS->MAE)){
            $mother = $this->store($result->PF->DADOS->MAE, $consultId);
            foreach ((array)$result->PF->DADOS->TELEFONES_MOVEIS->TELEFONE as $tel){
                if($tel != '' || !empty($tel)){
                    $mother->phones()->create(['phone' => $tel]);
                }
            }
        }
    }

    /**
     * Método saveMother grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     * @return static
     */
    public function saveMother($result, $consultId)
    {
        $arrayList = null;

        if (isset($result->NOME)){
            $arrayList['name'] = $result->NOME;
        }
        if (isset($result->CPF)) {
            $arrayList['cpf'] = $result->CPF;
        }
        if (isset($consultId)){
            $arrayList['consult_id'] = $consultId;
        }
        if($mother = $this->create($arrayList)){
            return $mother;
        }
    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método saveOccupation, chama para gravar no banco de dados
     *
     * @param $result
     * @param $consultId
     */
    public function searchOccupation($result, $consultId)
    {
        if (isset($result->PF->DADOS->OCUPACOES->OCUPACAO)) {
            $this->store($result->PF->DADOS->OCUPACOES->OCUPACAO, $consultId);
        }
    }

    /**
     * Método saveOccupation grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     */
    public function saveOccupation($result, $consultId)
    {
        $arrayList = null;

        if (isset($result->CODIGO)) {
            $arrayList['code'] = $result->CODIGO;
        }
        if (isset($result->DESCRICAO)) {
            $arrayList['description'] = $result->DESCRICAO;
        }
        if (isset($result->CNPJ)) {
            $arrayList['cnpj'] = $result->CNPJ;
        }
        if (isset($result->RAZAO_SOCIAL)) {
            $arrayList['corporate'] = $result->RAZAO_SOCIAL;
        }
        if (isset($result->CNAE)) {
            $arrayList['cnae'] = $result->CNAE;
        }
        if (isset($result->DESCRICAO_CNAE)) {
            $arrayList['description_cnae'] = $result->DESCRICAO_CNAE;
        }
        if (isset($result->PORTE)) {
            $arrayList['postage'] = $result->PORTE;
        }
        if (isset($result->SALARIO)) {
            $arrayList['salary'] = $result->SALARIO;
        }
        if (isset($result->FAIXA_SALARIO)) {
            $arrayList['salary_range'] = $result->FAIXA_SALARIO;
        }
        if (isset($consultId)) {
            $arrayList['consult_id'] = $consultId;
        }

        $this->create($arrayList);
    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método saveCompanie, chama para gravar no banco de dados
     *
     * @param $result
     * @param $consultId
     * @return mixed
     */
    public function searchCompanie($result, $consultId)
    {
        if (isset($result->PF->DADOS->SOCIEDADES->SOCIEDADE)){
            $companie = $this->saveCompanie($result->PF->DADOS->SOCIEDADES->SOCIEDADE, $consultId);
            $companieId = $companie->id;

            return $companieId;
        }
    }

    /**
     * Método grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     * @return array
     */
    public function saveCompanie($result, $consultId)
    {
        $arrayList = null;

        if (isset($result->CNPJ)){
            $arrayList['cnpj'] = $result->CNPJ;
        }
        if (isset($result->CNPJ)) {
            $arrayList['corporate'] = $result->RAZAO_SOCIAL;
        }
        if (isset($result->CNAE)){
            $arrayList['cnae'] = $result->CNAE;
        }
        if (isset($result->DESCRICAO_CNAE)){
            $arrayList['description_cnae'] = $result->DESCRICAO_CNAE;
        }
        if (isset($result->DESCRICAO_CNAE)){
            $arrayList['participation'] = $result->PARTICIPACAO;
        }
        if (isset($result->DESCRICAO_CNAE)){
            $arrayList['date_entry'] = $result->DATA_ENTRADA;
        }
        if (isset($consultId)){
            $arrayList['consult_id'] = $consultId;
        }
        $data = $this->create($arrayList);

        return $data;
    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método saveStreet, chama para gravar no banco de dados
     *
     * @param $result
     * @param $consultId
     */
    public function searchStreet($result, $consultId)
    {
        if (isset($result->PF->DADOS->ENDERECOS->ENDERECO)) {
            $this->saveStreet($result->PF->DADOS->ENDERECOS->ENDERECO, $consultId);
        }
    }

    /**
     * Método saveStreet grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     * @return array
     */
    public function saveStreet($result, $consultId)
    {
        $arrayList = null;
        if (is_array($result)) {
            for ($i = 0; $i < count($result); $i++) {
                if (isset($result[$i]->TIPO_LOGRADOURO)) {
                    $arrayList['type_street'] = $result[$i]->TIPO_LOGRADOURO;
                }
                if (isset($result[$i]->LOGRADOURO)) {
                    $arrayList['public_place'] = $result[$i]->LOGRADOURO;
                }
                if (isset($result[$i]->NUMERO)) {
                    $arrayList['number'] = $result[$i]->NUMERO;
                }
                if (isset($result[$i]->COMPLEMENTO)) {
                    $arrayList['complement'] = $result[$i]->COMPLEMENTO;
                }
                if (isset($result[$i]->BAIRRO)) {
                    $arrayList['neighborhood'] = $result[$i]->BAIRRO;
                }
                if (isset($result[$i]->CIDADE)) {
                    $arrayList['city'] = $result[$i]->CIDADE;
                }
                if (isset($result[$i]->UF)) {
                    $arrayList['uf'] = $result[$i]->UF;
                }
                if (isset($result[$i]->CEP)) {
                    $arrayList['zipcode'] = $result[$i]->CEP;
                }
                if (isset($result[$i]->SCORE)) {
                    $arrayList['score'] = $result[$i]->SCORE;
                }
                if (isset($consultId)) {
                    $arrayList['consult_id'] = $consultId;
                }
                $this->create($arrayList);
            }
        } else {
            if (isset($result->TIPO_LOGRADOURO)) {
                $arrayList['type_street'] = $result->TIPO_LOGRADOURO;
            }
            if (isset($result->LOGRADOURO)) {
                $arrayList['public_place'] = $result->LOGRADOURO;
            }
            if (isset($result->NUMERO)) {
                $arrayList['number'] = $result->NUMERO;
            }
            if (isset($result->COMPLEMENTO)) {
                $arrayList['complement'] = $result->COMPLEMENTO;
            }
            if (isset($result->BAIRRO)) {
                $arrayList['neighborhood'] = $result->BAIRRO;
            }
            if (isset($result->CIDADE)) {
                $arrayList['city'] = $result->CIDADE;
            }
            if (isset($result->UF)) {
                $arrayList['uf'] = $result->UF;
            }
            if (isset($result->CEP)) {
                $arrayList['zipcode'] = $result->CEP;
            }
            if (isset($result->SCORE)) {
                $arrayList['score'] = $result->SCORE;
            }
            if (isset($consultId)) {
                $arrayList['consult_id'] = $consultId;

            }
            $this->create($arrayList);
        }

    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método saveVehicles, chama para gravar no banco de dados
     *
     * @param $result
     * @param $consultId
     */
    public function searchVehicles($result, $consultId)
    {
        if (isset($result->PF->DADOS->VEICULOS->VEICULO)) {
            $this->saveVehicles($result->PF->DADOS->VEICULOS->VEICULO, $consultId);
        }
    }

    /**
     * Método saveVehicles grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     * @return array
     */
    public function saveVehicles($result, $consultId)
    {
        foreach ((array)$result as $v) {

            $arrayList = null;

            if (isset($v->PLACA)) {
                $arrayList['board'] = $v->PLACA;
            }
            if (isset($v->MARCA_MODELO)) {
                $arrayList['brand_model'] = $v->MARCA_MODELO;
            }
            if (isset($v->ANO_MODELO)) {
                $arrayList['model_year'] = $v->ANO_MODELO;
            }
            if (isset($consultId)) {
                $arrayList['consult_id'] = $consultId;
            }

            $this->create($arrayList);
        }
    }


}