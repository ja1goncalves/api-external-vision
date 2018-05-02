<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Consults
 * @package App
 */
class Consults extends Model
{
    /**
     * FormatTrait, Método para Validar E Formatar CPF
     *
     */
    use FormatTrait;

    protected $fillable =
    [
        'protocol',
        'cpf',
        'name',
        'sex',
        'signo_zodiacal',
        'date_birth',
        'age',
        'estimated_income'
    ];

    /**
     * @var string
     */
    protected $table = 'consults';

    /**
     * Consults constructor.
     * @param array $attributes
     * @param Assertiva|null $client
     */
    public function __construct(array $attributes = array(), Assertiva $client = null)
    {
        parent::__construct($attributes);
    }


    /**
     * Relationships
     */

    /**
     * Uma pessoa pode ter apenas uma mãe
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mothers()
    {
        return $this->hasOne(Mother::class);
    }

    /**
     * Uma Pessoa pode ter varios endereços
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function streets()
    {
        return $this->hasMany(Street::class);
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
     * Uma pessoa pode ter varios Emails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Uma pessoa pode ter varias Ocupações
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function occupations()
    {
        return $this->hasMany(Occupation::class);
    }

    /**
     * Uma pessoa pode ter varias sociedades
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Companie::class);
    }

    /**
     * Uma pessoa pode ter varios socios
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function copartners()
    {
        return $this->hasMany(Copartner::class);
    }

    /**
     * Uma pessoa pode ter varios veiculos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicles::class);
    }

    /**
     * método salva á primeira consulta e todos telefones na tabela polimorfica
     *
     * @param $result
     * @return mixed
     */
    public function request($result)
    {
        $result = $this->sendFormatDb($result);

        if(!$result)
            return [];

        if ($consult = $this->store($result->PF->DADOS))
        {
            $consultId = $consult->id;
            if (isset($result->PF->DADOS->TELEFONES_MOVEIS))
            {
                foreach ((array)$result->PF->DADOS->TELEFONES_MOVEIS->TELEFONE as $tel)
                {
                    if($tel != '' || !empty($tel))
                        $consult->phones()->create(['phone' => $tel]);
                }
            }
            return $consultId;
        }
    }

    /**
     * Método store grava no banco de dados seus dados respectivos
     *
     * @param $result
     * @return static
     */
    public function store($result)
    {
        $arrayList = null;

        if (isset($result->PROTOCOLO))
        {
            $arrayList['protocol'] = $result->PROTOCOLO;
        }
        if (isset($result->CPF))
        {
            $arrayList['cpf'] = $result->CPF;
        }
        if (isset($result->NOME))
        {
            $arrayList['name'] = $result->NOME;
        }
        if (isset($result->SEXO))
        {
            $arrayList['sex'] = $result->SEXO;
        }
        if (isset($result->SIGNO))
        {
            $arrayList['signo_zodiacal'] = $result->SIGNO;
        }
        if (isset($result->DATA_NASC))
        {
            $arrayList['date_birth'] = $result->DATA_NASC;
        }
        if (isset($result->IDADE))
        {
            $arrayList['age'] = $result->IDADE;
        }
        if (isset($result->RENDA_ESTIMADA))
        {
            $arrayList['estimated_income'] = $result->RENDA_ESTIMADA;
        }

        if ($consult = $this->create($arrayList))
        {

            return $consult;
        }
    }

    /**
     * Pegar consulta se CPF existe na base dados
     *
     * @param $query
     * @param $cpf
     * @return mixed
     */
    public function scopeCpf($query, $cpf)
    {
        return $query->where('cpf', $cpf);
    }

    /**
     * Pegar consulta se CPF existe na base dados
     *
     * @param $data
     * @return mixed
     */
    public function getCpf($data)
    {
        $earliestdate = DB::table('consults')
            ->select('*')
            ->where(['cpf' => $data])->first();
        if ($earliestdate)
        {
            $data = (object)$earliestdate;
            return $data;
        }
    }

    /**
     * Verifica se dados cadastrados existem a mais de meses e retorna sua entidade
     *
     * @param $data
     * @return mixed
     */
    public function getMonths($data)
    {
        $mostDate = DB::table('consults')
            ->select('*')
            ->where('cpf', '=', $data)
            ->where('updated_at', '>=', new \DateTime('-6 months'))
            ->first();
        if ($mostDate)
        {
            return $mostDate;
        } else
        {
            return false;
        }
    }

    /**
     * Verifica se dados cadastrados existem a mais de meses e retorna sua entidade
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function scopeMonths($query, $data)
    {
        return $query->where('cpf', $data)
            ->where('updated_at', '>=', new \DateTime('-6 months'))
            ->first();
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
