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
            $phones = array_filter($phoneData['TELEFONE'], function ($value){
                return strlen($value) >= 8;
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
     * Tratamento do retorno de Enderreço
     *
     * @param $addressesData
     * @param string $type
     * @return array
     */
    private function parseAddresses($addressesData, $type = 'address'){

        $result = [];

                if(!empty($addressesData['ENDERECO'])){

                    $address = array_filter($addressesData['ENDERECO'], function ($value){
                         return strlen($value) == !empty($addressesData);
                    });

                    $result = array_map(function ($p) use ($type) {
                        return [
                            'type'   => $type
                        ];
                    }, $address);

                }

        $test = $addressesData['ENDERECO'];
        count($test, COUNT_RECURSIVE);

        return $result;
    }


    /**
     * Tratamento dos dados vindos da API Assertiva e transformando em json.
     *
     * @param $result
     * @return array|null
     */
    public function parse($result){

        $person = null;

        if(!empty($result['PF']['DADOS'])){

            $phones = [];
            if(!empty($result['PF']['DADOS']['TELEFONES_MOVEIS'])){
                $phones = array_values($this->parsePhones($result['PF']['DADOS']['TELEFONES_MOVEIS']));
            }

            $person = [
                'probability_obit'       => $result['PF']['DADOS']['PROBABILIDADE_OBITO'] ?? null,
                'protocol'               => $result['PF']['DADOS']['PROTOCOLO'] ?? null,
                'name'                   => $result['PF']['DADOS']['NOME'] ?? null,
                'salary_range'           => $result['PF']['DADOS']['FAIXA_RENDA_ESTIMADA'] ?? null,
                'birth_date'             => $result['PF']['DADOS']['DATA_NASC'] ?? null,
                'benefit_value'          => $result['PF']['DADOS']['VALOR_BENEFICIO'] ?? null,
                'cpf'                    => $result['PF']['DADOS']['CPF'] ?? null,
                'gender'                 => $result['PF']['DADOS']['SEXO'] ?? null,
                'salary'                 => $result['PF']['DADOS']['RENDA_ESTIMADA'] ?? null,
                'date_query'             => $result['PF']['DADOS']['SITUACAO_RECEITA_FEDERAL']['DATACONSULTA'] ?? null,
                'phones'                 => $phones,
            ];

            if(!empty($result['PF']['DADOS']['ENDERECOS']['ENDERECO'])){

                $person['addresses'][] = [
                    'neighborhood'   => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['BAIRRO'] ?? null,
                    'type_of_street' => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['TIPO_LOGRADOURO'] ?? null,
                    'complement'     => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['COMPLEMENTO'] ?? null,
                    'cep'            => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['CEP'] ?? null,
                    'number'         => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['NUMERO'] ?? null,
                    'public_place'   => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['LOGRADOURO'] ?? null,
                    'uf'             => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['UF'] ?? null,
                    'city'           => $result['PF']['DADOS']['ENDERECOS']['ENDERECO']['CIDADE'] ?? null,
                ];
            }

            if(!empty($result['PF']['DADOS']['MAE'])){

                $phones = [];
                if(!empty($result['PF']['DADOS']['MAE']['TELEFONES'])){
                    $phones = array_values($this->parsePhones($result['PF']['DADOS']['MAE']['TELEFONES']));
                }

                $person['mother'] = [
                    'name'   => $result['PF']['DADOS']['MAE']['NOME'] ?? null,
                    'cpf'    => $result['PF']['DADOS']['MAE']['CPF'] ?? null,
                    'phones' => $phones
                ];
            }
        }

        if(!empty($result['PF']['DADOS']['VEICULOS']['VEICULO'])){

            $person['vehicles'][] = [
                'board'              => $result['PF']['DADOS']['VEICULOS']['VEICULO']['PLACA'] ?? null,
                'brand_model'        => $result['PF']['DADOS']['VEICULOS']['VEICULO']['MARCA_MODELO'] ?? null,
                'model_year'         => $result['PF']['DADOS']['VEICULOS']['VEICULO']['ANO_MODELO'] ?? null,
                'manufacturing_year' => $result['PF']['DADOS']['VEICULOS']['VEICULO']['ANO_FABRICACAO'] ?? null,
            ];
        }

        if(!empty($result['PF']['DADOS']['EMAILS'])){

            $person['email'][] = [
                'board' => $result['PF']['DADOS']['EMAILS'] ?? null,
            ];
        }

        if(!empty($result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE'])){

            $person['companie'][] = [
                'cnpj'             => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE'] ['CNPJ']?? null,
                'corporate'        => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE'] ['RAZAO_SOCIAL']?? null,
                'cnae'             => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE'] ['CNAE']?? null,
                'description_cnae' => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE'] ['DESCRICAO_CNAE']?? null,
                'participation'    => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE'] ['PARTICIPACAO']?? null,
                'date_entry'       => $result['PF']['DADOS']['SOCIEDADES']['SOCIEDADE'] ['DATA_ENTRADA']?? null,
            ];
        }

        return $person;
    }
}