<?php

namespace App\Services;

/**
 * Class ReceitaService
 * @package App\Services
 */
class ReceitaService
{

    /**
     * ReceitaService constructor.
     */
    public function __construct(){

    }

    /**
     * Busca de informações de um Cnpj informado, api da receita
     *
     * @param $cnpj
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj($cnpj)
    {
        try{
            if (empty($cnpj) or is_null($cnpj)){
                throw new \Exception('Cnpj inválido!');
            } else{
                $url = 'https://www.receitaws.com.br/v1/cnpj/';
                $cnpj = preg_replace("/[.\/-]/", '', $cnpj);
                $endpoint = $url . $cnpj;
                $res = Service::httpClient()->request('GET', $endpoint);
                $data = json_decode($res->getBody(), true);
                $data =(object) $data;
                return [
                    'cnpj'            => $cnpj,
                    'created'         => $data->abertura,
                    'status'          => $data->situacao,
                    'status_date'     => $data->data_situacao,
                    'name'            => $data->nome,
                    'email'           => $data->email,
                    'phone'           => $data->telefone,
                    'associates'      => $data->qsa,
                    'activities'      => $data->atividades_secundarias,
                    'activity'        => $data->atividade_principal,
                    'share_capital'   => $data->capital_social,
                    'address'     => [
                        'zip_code'    => $data->cep,
                        'number'      => $data->numero,
                        'street'      => $data->logradouro,
                        'district'    => $data->bairro,
                        'city'        => $data->municipio,
                        'uf'          => $data->uf,
                        'complement'  => $data->complemento
                    ],
                ];
            }
        } catch (\Exception $e){
            return response()->json([
                'error' => true,
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'message' => $e->getMessage(),
            ], 401);
        }
    }

}
