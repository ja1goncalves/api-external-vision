<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:24
 */

namespace App;


class Phone extends Model
{
    /**
     * Validate, filtros.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'consult_id',
        'phoneable_id',
        'phoneable_type'
    ];

    /**
     * Array GLobal
     *
     * @var array
     */
    public $array = [];


}