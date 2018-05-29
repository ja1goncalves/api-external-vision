<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Companie.
 *
 * @package namespace App\Entities;
 */
class Companie extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cnpj',
        'corporate',
        'cnae',
        'description_cnae',
        'participation',
        'date_entry',
        'consult_id'
    ];

    //se precisar ocultar alguma informação colocar no hidden
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
