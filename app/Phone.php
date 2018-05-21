<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:24
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * @var string
     */
    protected $table = 'phones';

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
       // return $this->morphTo();

        return Relation::morphMap([
            'consult'   => 'App\Consult',
            'mothers'   => 'App\Mothers',
            'copartner' => 'App\Copartner',
        ]);
    }





}