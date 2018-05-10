<?php

namespace App\Services\Parsers;


class AssertivaParser
{
    public function parse($result){

        $mother = null;

        if(!empty($result['PF']['DADOS']['MAE'])){
            $mother = [
                'name' => $result['PF']['DADOS']['MAE']['NOME'],
                'phone' => $result['PF']['DADOS']['MAE']['TELEFONE'] ?? null,
//                'phone' => !empty($result['PF']['DADOS']['MAE']['TELEFONE']) ? $result['PF']['DADOS']['MAE']['TELEFONE'] : null
            ];
        }

        return [
            'name' => $result['PF']['DADOS']['NOME'],
            'mother' => $mother
        ];
    }
}