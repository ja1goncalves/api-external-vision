<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle
 * @package App
 */
class Vehicle extends Model
{
    /**
     * @var string
     */
    protected $table = 'vehicles';

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
        'board',
        'brand_model',
        'manufacturing_year',
        'model_year',
        'consult_id'
    ];

    /**
     * Relationships
     */

    /**
     * Um veiculo pode ser associado apenas a uma pessoa
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
        if (isset($result->PF->DADOS->VEICULOS->VEICULO))
        {
            $this->store($result->PF->DADOS->VEICULOS->VEICULO, $consultId);
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
        foreach ((array)$result as $v)
        {
            $arrayList = null;

            if (isset($v->PLACA))
            {
                $arrayList['board'] = $v->PLACA;
            }
            if (isset($v->MARCA_MODELO))
            {
                $arrayList['brand_model'] = $v->MARCA_MODELO;
            }
            if (isset($v->ANO_MODELO))
            {
                $arrayList['model_year'] = $v->ANO_MODELO;
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
