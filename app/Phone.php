<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    /**
     * Array GLobal
     *
     * @var array
     */
    public $array = [];

    /**
     * Validate, filtros.
     *
     * @var array
     */
    protected $fillable =
    [
        'phone',
        'consult_id',
        'phoneable_id',
        'phoneable_type'
    ];


    /**
     * Relationships
     */


    /**
     * Relacionamento Polimorfico, Essa entidade pertence a varias entendidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function phoneable()
    {
        return $this->morphTo();
    }


    /**
     * Scopes
     */


    /**
     * Get Attributes
     */


    /**
     * Set Attributes
     */
}
