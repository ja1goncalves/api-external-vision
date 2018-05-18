<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:23
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * Variavel $aux recebe objeto de criação do método Store de sua Instância
     *
     * @var array
     */
    public static $aux = [];
    /**
     * @var array
     */

    protected $fillable = [
        'email',
        'consult_id'
    ];

    /**
     * @var string
     */
    protected $table = 'emails';


    /**
     * Relationships
     */

    /**
     * Um email pode ter apenas uma pessoa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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