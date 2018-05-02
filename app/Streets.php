<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Streets
 * @package App
 */
class Streets extends Model
{
    /**
     * @var string
     */
    protected $table = 'streets';

    /**
     * Variavel $aux recebe objeto de criação do método Store de sua Instância
     *
     * @var array
     */
    public static $aux = [];

    /**
     * @var array
     */
    protected $fillable =
    [
        'type_street',
        'public_place',
        'number',
        'complement',
        'neighborhood',
        'city',
        'uf',
        'zipcode',
        'score',
        'consult_id'
    ];

    /**
     * Relationships
     */

    /**
     * Um endereço pode ser associado apenas a uma pessoa
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
        if (isset($result->PF->DADOS->ENDERECOS->ENDERECO))
        {
            $this->store($result->PF->DADOS->ENDERECOS->ENDERECO, $consultId);
        }
    }

    /**
     * Método store grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     * @return array
     */
    public function store($result, $consultId)
    {
        $arrayList = null;
        if (is_array($result))
        {
            for ($i = 0; $i < count($result); $i++)
            {
                if (isset($result[$i]->TIPO_LOGRADOURO))
                {
                    $arrayList['type_street'] = $result[$i]->TIPO_LOGRADOURO;
                }
                if (isset($result[$i]->LOGRADOURO))
                {
                    $arrayList['public_place'] = $result[$i]->LOGRADOURO;
                }
                if (isset($result[$i]->NUMERO))
                {
                    $arrayList['number'] = $result[$i]->NUMERO;
                }
                if (isset($result[$i]->COMPLEMENTO))
                {
                    $arrayList['complement'] = $result[$i]->COMPLEMENTO;
                }
                if (isset($result[$i]->BAIRRO))
                {
                    $arrayList['neighborhood'] = $result[$i]->BAIRRO;
                }
                if (isset($result[$i]->CIDADE))
                {
                    $arrayList['city'] = $result[$i]->CIDADE;
                }
                if (isset($result[$i]->UF))
                {
                    $arrayList['uf'] = $result[$i]->UF;
                }
                if (isset($result[$i]->CEP))
                {
                    $arrayList['zipcode'] = $result[$i]->CEP;
                }
                if (isset($result[$i]->SCORE))
                {
                    $arrayList['score'] = $result[$i]->SCORE;
                }
                if (isset($consultId))
                {
                    $arrayList['consult_id'] = $consultId;
                }
                $this->create($arrayList);
            }
        } else
         {
            if (isset($result->TIPO_LOGRADOURO))
            {
                $arrayList['type_street'] = $result->TIPO_LOGRADOURO;
            }
            if (isset($result->LOGRADOURO))
            {
                $arrayList['public_place'] = $result->LOGRADOURO;
            }
            if (isset($result->NUMERO))
            {
                $arrayList['number'] = $result->NUMERO;
            }
            if (isset($result->COMPLEMENTO))
            {
                $arrayList['complement'] = $result->COMPLEMENTO;
            }
            if (isset($result->BAIRRO))
            {
                $arrayList['neighborhood'] = $result->BAIRRO;
            }
            if (isset($result->CIDADE))
            {
                $arrayList['city'] = $result->CIDADE;
            }
            if (isset($result->UF))
            {
                $arrayList['uf'] = $result->UF;
            }
            if (isset($result->CEP))
            {
                $arrayList['zipcode'] = $result->CEP;
            }
            if (isset($result->SCORE))
            {
                $arrayList['score'] = $result->SCORE;
            }
            if (isset($consultId))
            {
                $arrayList['consult_id'] = $consultId;
            }
            $this->create($arrayList);
        }

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
