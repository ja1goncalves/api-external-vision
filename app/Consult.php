<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 14/05/18
 * Time: 09:22
 */

namespace App;


class Consult extends Model
{
    /**
     * FormatTrait, Método para Validar E Formatar CPF
     *
     */
    use FormatTrait;

    protected $fillable = [
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
    public function __construct(array $attributes = array(), Assertiva $client = null) {
        parent::__construct($attributes);
    }


    /**
     * Relationships
     */

    /**
     * Uma pessoa pode ter apenas uma mãe
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mothers() {
        return $this->hasOne(Mother::class);
    }

    /**
     * Uma Pessoa pode ter varios endereços
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function streets() {
        return $this->hasMany(Street::class);
    }

    /**
     * Relacionamento Polimorfico com a entidade Phone.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones() {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    /**
     * Uma pessoa pode ter varios Emails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails() {
            return $this->hasMany(Email::class);
    }

    /**
     * Uma pessoa pode ter varias Ocupações
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function occupations() {
           return $this->hasMany(Occupation::class);
    }

    /**
     * Uma pessoa pode ter varias sociedades
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies() {
        return $this->hasMany(Companie::class);
    }

    /**
     * Uma pessoa pode ter varios socios
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function copartners() {
        return $this->hasMany(Copartner::class);
    }

    /**
     * Uma pessoa pode ter varios veiculos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles() {
        return $this->hasMany(Vehicles::class);
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