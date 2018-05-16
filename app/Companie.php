<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:21
 */

namespace App;


class Companie extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'cnpj',
        'corporate',
        'cnae',
        'description_cnae',
        'participation',
        'date_entry',
        'consult_id'
    ];

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * Relationships
     */

    /**
     * Uma Empresa pode ter varios socios
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function copartners()
    {
        return $this->hasMany(Copartner::class);
    }

    /**
     * Relacionamento Polimorfico com a entidade Phone.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    /**
     * Uma empresa pode ser apenas associado a uma consulta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consults()
    {
        return $this->belongsTo(Consult::class);
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