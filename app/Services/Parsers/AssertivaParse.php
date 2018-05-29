<?php

namespace App\Services\Parsers;


class AssertivaParser
{
    /**
     * Tratamento do retorno de telefone
     *
     * @param $phoneData
     * @param string $type
     * @return array
     */
    private function parsePhones($phoneData, $type = 'mobile'){

        $result = [];

        if(!empty($phoneData['TELEFONE'])){

            //array_filter->filtra telefones apenas maior ou igual á 8, se estiver vazio desconsidera á listagem
            if(is_string($phoneData['TELEFONE']) || is_numeric($phoneData['TELEFONE'])){
                $result = [
                    'number' => (string) $phoneData['TELEFONE'],
                    'type'   => $type
                ];
                return $result;
            }

            $phones = array_filter($phoneData['TELEFONE'], function ($value){

                $result = strlen($value) >= 8;
                return $result;
            });

            // array_map-> formata no padrão informada abaixo, á informação vinda de $phones.
            $result = array_map(function ($p) use ($type) {
                return [
                    'number' => $p,
                    'type'   => $type
                ];
            }, $phones);
        }
        return $result;
    }

    /**
     * Tratamento dos dados vindos da API Assertiva e transformando em json.
     *
     * @param $result
     * @return array|null
     */
    public function parseData($result,$ZeroPerson ){

        $person = null;

        if(!empty($result['PF']['DADOS'])){

            $phones = [];
            if(!empty($result['PF']['DADOS']['TELEFONES_MOVEIS'])){
                $phones = array_values($this->parsePhones($result['PF']['DADOS']['TELEFONES_MOVEIS']));
            }
            else{
                $phones = [];
            }

            if(empty($ZeroPerson))
            {
                $cpf = $result['PF']['DADOS']['CPF'];
            }
            else
            {
                $cpf = $ZeroPerson;
            }

            $person = [
                'probability_obit' => $result['PF']['DADOS']['PROBABILIDADE_OBITO'] ?? null,
                'zodiac_sign'      => $result['PF']['DADOS']['SIGNO'] ?? null,
                'age'              => $result['PF']['DADOS']['IDADE'] ?? null,
                'protocol'         => $result['PF']['DADOS']['PROTOCOLO'] ?? null,
                'name'             => $result['PF']['DADOS']['NOME'] ?? null,
                'salary_range'     => $result['PF']['DADOS']['FAIXA_RENDA_ESTIMADA'] ?? null,
                'estimated_income' => $result['PF']['DADOS']['RENDA_ESTIMADA'] ?? null,
                'date_birth'       => $result['PF']['DADOS']['DATA_NASC'] ?? null,
                'benefit_value'    => $result['PF']['DADOS']['VALOR_BENEFICIO'] ?? null,
                //'cpf'              => $result['PF']['DADOS']['CPF'] ?? null,
                'cpf'              => $cpf ?? null,
                'gender'           => $result['PF']['DADOS']['SEXO'] ?? null,
                'phones'           => $phones,
            ];

            if(!empty($result['PF']['DADOS']['EMAILS'])){

                if(!empty($result['PF']['DADOS']['EMAILS'])) {
                    $person['email'] = [
                        $result['PF']['DADOS']['EMAILS'] ?? null,
                    ];
                }
                else{
                    $person['email'] = [];
                }
            }
            else{
                $person['email'] = [];
            }

            if(!empty($result['PF']['DADOS']['SITUACAO_RECEITA_FEDERAL'])){

                if(!empty($result['PF']['DADOS']['SITUACAO_RECEITA_FEDERAL']['DATACONSULTA'])){

                    $person['situation_federal_revenue'][] = [
                        'date_query' => $result['PF']['DADOS']['SITUACAO_RECEITA_FEDERAL']['DATACONSULTA'] ?? null,
                    ];
                }
                else{
                    $person['situation_federal_revenue'] = [];
                }
            }
            else{
                $person['situation_federal_revenue'] = [];
            }

            if(!empty($result['PF']['DADOS']['ENDERECOS'])){

                if(!empty($result['PF']['DADOS']['ENDERECOS']['ENDERECO'])){

                    $person['addresses'][] = [
                        'type_street'  => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['TIPO_LOGRADOURO'] ?? null,
                        'public_place' => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['LOGRADOURO'] ?? null,
                        'number'       => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['NUMERO'] ?? null,
                        'complement'   => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['COMPLEMENTO'] ?? null,
                        'neighborhood' => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['BAIRRO'] ?? null,
                        'city'         => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['CIDADE'] ?? null,
                        'uf'           => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['UF'] ?? null,
                        'zipcode'      => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['CEP'] ?? null,
                        'score'        => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['SCORE'] ?? null,
                    ];
                }
                else{
                    $person['addresses'] = [];
                }
            }
            else{
                $person['addresses'] = [];
            }

            if(!empty($result['PF']['DADOS']['VEICULOS'])){

                if(!empty($result['PF']['DADOS']['VEICULOS']['VEICULO'])){

                    $person['vehicles'] = [
                        'board'              => $result['PF']['DADOS']['VEICULOS']['VEICULO']['PLACA'] ?? null,
                        'brand_model'        => $result['PF']['DADOS']['VEICULOS']['VEICULO']['MARCA_MODELO'] ?? null,
                        'manufacturing_year' => $result['PF']['DADOS']['VEICULOS']['VEICULO']['ANO_FABRICACAO'] ?? null,
                        'model_year'         => $result['PF']['DADOS']['VEICULOS']['VEICULO']['ANO_MODELO'] ?? null,
                    ];
                }
                else{
                    $person['vehicles'] = [];
                }
            }
            else{
                $person['vehicles'] = [];
            }

            if(!empty($result['PF']['DADOS']['OCUPACOES'])){

                if(!empty($result['PF']['DADOS']['OCUPACOES']['OCUPACAO'])){

                    $person['occupation'] = [
                        'code'             => $result['PF']['DADOS']['OCUPACOES']['OCUPACAO']['CODIGO']?? null,
                        'description'      => $result['PF']['DADOS']['OCUPACOES']['OCUPACAO']['DESCRICAO']?? null,
                        'cnpj'             => $result['PF']['DADOS']['OCUPACOES']['OCUPACAO']['CNPJ']?? null,
                        'corporate'        => $result['PF']['DADOS']['OCUPACOES']['OCUPACAO']['CNAE']?? null,
                        'description_cnae' => $result['PF']['DADOS']['OCUPACOES']['OCUPACAO']['DESCRICAO_CNAE']?? null,
                        'postage'          => $result['PF']['DADOS']['OCUPACOES']['OCUPACAO']['PORTE']?? null,
                        'salary'           => $result['PF']['DADOS']['OCUPACOES']['OCUPACAO']['SALARIO']?? null,
                        'salary_range'     => $result['PF']['DADOS']['OCUPACOES']['OCUPACAO']['FAIXA_SALARIO']?? null,
                    ];
                }
                else{
                    $person['occupation'] = [];
                }
            }
            else{
                $person['occupation'] = [];
            }

            if(!empty($result['PF']['DADOS']['SOCIEDADES'])) {

                if (!empty($result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE'])) {

                    $person['companie'] = [
                        'cnpj'             => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['CNPJ'] ?? null,
                        'corporate'        => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['RAZAO_SOCIAL'] ?? null,
                        'cnae'             => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['CNAE'] ?? null,
                        'description_cnae' => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['DESCRICAO_CNAE'] ?? null,
                        'participation'    => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['PARTICIPACAO'] ?? null,
                        'date_entry'       => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['DATA_ENTRADA'] ?? null,
                    ];
                }
                else{
                    $person['companie'] = [];
                }

                if (!empty($result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['SOCIOS'])) {

                    $person['copartner'] = [
                        'name' => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['SOCIOS']['NOME'] ?? null,
                        'cpf'  => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE']['SOCIOS']['CPF'] ?? null,
                    ];
                }
                else{
                    $person['copartner'] = [];
                }
            }
            else{
                $person['society'] = [];
            }

            if(!empty($result['PF']['DADOS']['MAE'])){

                $phones = [];
                if(!empty($result['PF']['DADOS']['MAE']['TELEFONES'])){

                    $test = $this->parsePhones($result['PF']['DADOS']['MAE']['TELEFONES']);
                    if(count($test) == 2){
                        $phones = $test;
                    }
                    if(count($test) >= 3){
                        //$phones = array_values($this->parsePhones($result['PF']['DADOS']['MAE']['TELEFONES']));
                        $phones = array_values($test);
                    }
                }

                $person['mother'] = [
                    'name'   => $result['PF']['DADOS']['MAE']['NOME'] ?? null,
                    'cpf'    => $result['PF']['DADOS']['MAE']['CPF'] ?? null,
                    'phones' => $phones
                ];
            }
            else{
                $person['mother'] = [];
            }
        }
        return $person;
    }
}