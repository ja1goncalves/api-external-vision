<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Companie
 * @package App
 */
class Companie extends Model
{
    /**
     * @var array
     */
    protected $fillable =
    [
        'cnpj',
        'corporate',
        'cnae',
        'description_cnae',
        'participation',
        'date_entry',
        'consult_id'
    ];

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * Relationships
     */

    /**
     * Uma Empresa pode ter varios socios
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function copartners()
    {
        return $this->hasMany(Copartner::class);
    }

    /**
     * Relacionamento Polimorfico com a entidade Phone.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    /**
     * Uma empresa pode ser apenas associado a uma consulta
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
     * @return mixed
     */
    public function request($result, $consultId)
    {
        if (isset($result->PF->DADOS->SOCIEDADES->SOCIEDADE))
        {
            $companie = $this->store($result->PF->DADOS->SOCIEDADES->SOCIEDADE, $consultId);
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
    public function store($result, $consultId)
    {
        $arrayList = null;

        if (isset($result->CNPJ))
        {
            $arrayList['cnpj'] = $result->CNPJ;
        }
        if (isset($result->CNPJ))
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
        if (isset($result->DESCRICAO_CNAE))
        {
            $arrayList['participation'] = $result->PARTICIPACAO;
        }
        if (isset($result->DESCRICAO_CNAE))
        {
            $arrayList['date_entry'] = $result->DATA_ENTRADA;
        }
        if (isset($consultId))
        {
            $arrayList['consult_id'] = $consultId;
        }
        $data = $this->create($arrayList);

        return $data;
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