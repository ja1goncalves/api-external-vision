<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:24
 */

namespace App;


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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consults()  {
        return $this->belongsTo(Consult::class);
    }

    /**
     * Relacionamento Polimorfico com a entidade Phone.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones(){
        return $this->morphMany(Phone::class, 'phoneable');
    }

    /**
     * Esse método recebe uma request do controller com response da api assertiva
     * Método store, chama para gravar no banco de dados
     *
     * @param $result
     * @param $consultId
     */
    public function request($result, $consultId)
    {
        // Se StdClass Existe Model Mother è disparado e chama método store e grava dados da mother
        if (isset($result->PF->DADOS->MAE)){
            $mother = $this->store($result->PF->DADOS->MAE, $consultId);
            foreach ((array)$result->PF->DADOS->TELEFONES_MOVEIS->TELEFONE as $tel){
                if($tel != '' || !empty($tel)){
                    $mother->phones()->create(['phone' => $tel]);
                }
            }
        }
    }

    /**
     * Método store grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @param $consultId
     * @return static
     */
    public function store($result, $consultId)
    {
        $arrayList = null;

        if (isset($result->NOME)){
            $arrayList['name'] = $result->NOME;
        }
        if (isset($result->CPF)) {
            $arrayList['cpf'] = $result->CPF;
        }
        if (isset($consultId)){
            $arrayList['consult_id'] = $consultId;
        }
        if($mother = $this->create($arrayList)){
            return $mother;
        }
    }


    /**
     * Scopes
     */


    /**
     * Get Attributes
     */


-    /**
     * Set Attributes
     */

}