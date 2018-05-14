<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:23
 */

namespace App;


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
     * Relationships
     */


    /**
     *  Um email pode ter apenas uma pessoa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consults()
    {
        return $this->belongsTo(Consult::class);
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
            // Se StdClass Existe Model Email è disparado e chama método store e grava dados da email
        if (isset($result->PF->DADOS->EMAILS))
        {
            $this->store($result->PF->DADOS->EMAILS, $consultId);
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
        foreach ((array)$result as $s)
        {
                    $arrayList = null;

                    if (isset($s))
                        {
                            $arrayList['email'] = $s;
                        }
            if (isset($s))
                        {
                            $arrayList['consult_id'] = $consultId;
                        }
            $this->create($arrayList);
        }
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