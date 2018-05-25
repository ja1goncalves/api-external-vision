<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Consult.
 *
 * @package namespace App\Entities;
 */
class Consult extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'protocol',
        'cpf',
        'name',
        'sex',
        'signo_zodiacal',
        'date_birth',
        'age',
        'estimated_income'
    ];

}
