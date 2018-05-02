<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 02/05/18
 * Time: 11:09
 */

namespace App;


class AbstractModulesModel extends Model
{
    /**
     * Exclusão Lógica
     * @var SoftDeletes
     */
    use SoftDeletes;

    /**
     * Mutators [Modificadores]
     * @var array
     */
    protected $dates =
    [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Obtém o model com Namespace
     * @param $model
     * @return string
     */
    protected function getModel($model)
    {
        return __NAMESPACE__ . "\\" . $model;
    }

    /**
     * Obtém todos os dados ativos
     *
     * @param $query AbstractModulesModel
     * @return mixed
     */
    public function scopeAllActive($query)
    {
        return $query->where('status', '=', ATIVO)->get();
    }

    public function isActive()
    {
        return (boolean) ((int) $this->status == 1);
    }

    /**
     * Scopes
     */


    /**
     * Get Attributes
     */

    /**
     * Obtém a data convertendo-a em \DateTime
     *
     * @param $value
     * @return \DateTime
     */
    public function getCreatedAtAttribute($value)
    {
        $date = new \DateTime($value);
        return $date->format('d/m/Y H:i');
    }


    /**
     * Obtém a data convertendo-a em \DateTime
     *
     * @param $value
     * @return \DateTime
     */
    public  function getDeletedAtAttribute($value)
    {
        return new \DateTime($value);
    }

    /**
     * Obtém a data convertendo-a em \DateTime
     *
     * @param $value
     * @return \DateTime
     */

    public function getUpdatedAtAttribute($value)
    {
        $date = new \DateTime($value);
        return $date->format('d/m/Y H:i');
    }

    /**
     * Set Attributes
     */
}