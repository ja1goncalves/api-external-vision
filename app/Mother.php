<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:24
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mother extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'cpf', 'consult_id'];

    /**
     * @var string
     */
    protected $table = 'mothers';

    /**
     * Relationships
     */

    /**
     * Uma mãe pode ter varias pessoa ou consultas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consults()
    {
        return $this->belongsTo(Consult::class);
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