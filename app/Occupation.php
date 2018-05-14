<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:24
 */

namespace App;


class Occupation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
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
     * @var string
     */
    protected $table = 'occupations';

}