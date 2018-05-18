<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:26
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicles  extends Model
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
        'board',
        'brand_model',
        'manufacturing_year',
        'model_year',
        'consult_id'
    ];

    /**
     * @var string
     */
    protected $table = 'vehicles';


    /**
     * Relationships
     */

    /**
     * Um veiculo pode ser associado apenas a uma pessoa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consults()
    {
        return $this->belongsTo(Consult::class);
    }

}