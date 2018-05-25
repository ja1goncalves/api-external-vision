<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Vehicles.
 *
 * @package namespace App\Entities;
 */
class Vehicles extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board',
        'brand_model',
        'manufacturing_year',
        'model_year',
        'consult_id'
    ];

}
