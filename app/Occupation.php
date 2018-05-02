<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    /**
     * @var string
     */
    protected $table = 'occupations';

    /**
     * @var array
     */
    protected $fillable =
    [
        'code',
        'description',
        'cnpj',
        'corporate',
        'cnae',
        'description_cnae',
        'postage',
        'salary',
        'salary_range',
        'consult_id'
    ];


    /**
     * Relationships
     */

    /**
     * Uma pessoa pode ser associado apenas a uma ocupação
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consults()
    {
        return $this->belongsTo(Consult::class);
    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método store, chama para gravar no banco de dados
     *
     * @param $result
     * @param $consultId
     */
    public function request($result, $consultId)
    {
        // Se StdClass Ocupaçao Existe Model Occupation é disparado e chama método store e grava dados da occupation
        if (isset($result->PF->DADOS->OCUPACOES->OCUPACAO))
        {
            $this->store($result->PF->DADOS->OCUPACOES->OCUPACAO, $consultId);
        }
    }

    /**
     * Método store grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     */
    public function store($result, $consultId)
    {
        $arrayList = null;

        if (isset($result->CODIGO))
        {
            $arrayList['code'] = $result->CODIGO;
        }
        if (isset($result->DESCRICAO))
        {
            $arrayList['description'] = $result->DESCRICAO;
        }
        if (isset($result->CNPJ))
        {
            $arrayList['cnpj'] = $result->CNPJ;
        }
        if (isset($result->RAZAO_SOCIAL))
        {
            $arrayList['corporate'] = $result->RAZAO_SOCIAL;
        }
        if (isset($result->CNAE))
        {
            $arrayList['cnae'] = $result->CNAE;
        }
        if (isset($result->DESCRICAO_CNAE))
        {
            $arrayList['description_cnae'] = $result->DESCRICAO_CNAE;
        }
        if (isset($result->PORTE))
        {
            $arrayList['postage'] = $result->PORTE;
        }
        if (isset($result->SALARIO))
        {
            $arrayList['salary'] = $result->SALARIO;
        }
        if (isset($result->FAIXA_SALARIO))
        {
            $arrayList['salary_range'] = $result->FAIXA_SALARIO;
        }
        if (isset($consultId))
        {
            $arrayList['consult_id'] = $consultId;
        }
        $this->create($arrayList);
    }


    /**
     * Scopes
     */


    /**
     * Get Attributes
     */


    /**
     * Set Attributes
     */
}
