<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Occupation.
 *
 * @package namespace App\Entities;
 */
class Occupation extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
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

}
