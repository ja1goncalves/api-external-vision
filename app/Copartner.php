<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:22
 */

namespace App;


class Copartner extends Model
{
    /**
     * @var array
     */
    protected $fillable =
    [
        'cpf',
        'name',
        'companie_id'
    ];

    /**
     * Relationships
     */

    /**
     * Uma socio pode ser apenas associado a uma consulta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consults() {
        return $this->belongsTo(Consult::class);
    }

    /**
     * Um socio pertence a uma empresa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companies() {
        return $this->belongsTo(Companie::class);
    }

    /**
     * Relacionamento Polimorfico com a entidade Phone.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones() {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método store, chama para gravar no banco de dados
     *
     * @param $result
     * @param $companieId
     */
    public function request($result, $companieId)
    {
        if (isset($result->PF->DADOS->SOCIEDADES->SOCIEDADE->SOCIOS))
        {
            if ($companieId)
            {
                $copartner = $this->store($result->PF->DADOS->SOCIEDADES->SOCIEDADE->SOCIOS, $companieId);
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
     * Método store grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $companieId
     * @return static
     */
    public function store($result, $companieId)
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
     * Scopes
     */


    /**
     * Get Attributes
     */


    /**
     * Set Attributes
     */
}