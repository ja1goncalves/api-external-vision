<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:26
 */

namespace App;


class Vehicles  extends Model
{
    /**
     * Variavel $aux recebe objeto de criação do método Store de sua Instância
     *
     * @var array
     */
    public static $aux = [];
    /**
     * @var array
     */
    protected $fillable = [
        'board',
        'brand_model',
        'manufacturing_year',
        'model_year',
        'consult_id'
    ];

    /**
     * @var string
     */
    protected $table = 'vehicles';

}