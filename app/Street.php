<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:25
 */

namespace App;


class Street  extends Model
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


}