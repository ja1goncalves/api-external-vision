<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Street.
 *
 * @package namespace App\Entities;
 */
class Street extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
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
