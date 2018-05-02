<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 02/05/18
 * Time: 11:58
 */

namespace App;


class Api extends Model
{
    /**
     * @var string table Api Config
     */
    protected $table = 'config';

    /**
     * @var array 'name','url','company','user','password'
     */
    protected $fillable =
    [
        'name',
        'url',
        'company',
        'user',
        'password'
    ];

    /**
     * retorna tabela de configuração da APICredit Se Status For ativado = 1
     *
     * @return mixed
     */
    public function scopeData($query)
    {
        return $query->where('status', '1')->first();
    }
}