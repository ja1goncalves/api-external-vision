<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:22
 */

namespace App;


class Copartner extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cpf', 'name', 'companie_id'];

    /**
     * @var string
     */
    protected $table = 'copartners';


    /**
     * Relationships
     */

    /**
     * Uma socio pode ser apenas associado a uma consulta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consults()
    {
        return $this->belongsTo(Consult::class);
    }

    /**
     * Um socio pertence a uma empresa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companies()
    {
        return $this->belongsTo(Companie::class);
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
     * Scopes
     */


    /**
     * Get Attributes
     */


    /**
     * Set Attributes
     */
}