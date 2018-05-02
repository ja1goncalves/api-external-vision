<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 02/05/18
 * Time: 11:44
 */

namespace App\Http\Controllers;

/**
 * Class AssertivaController
 * @package App\Http\Controllers
 */
class AssertivaController
{

    /**
     * FormatTrait, Método para Validar E Formatar CPF
     *
     */
   // use FormatTrait;

    /**
     * @var Consult
     */
    private $consult;

    /**
     * @var Assertiva
     */
    private $assertiva;

    /**
     * @var Phone
     */
    private $phones;

    /**
     * @var Mother
     */
    private $mother;

    /**
     * @var
     */
    private $street;

    /**
     * @var
     */
    private $email;

    /**
     * @var Vehicles
     */
    private $vehicles;

    /**
     * @var Occupation
     */
    private $occupation;

    /**
     * @var Copartner
     */
    private $copartner;

    /**
     * @var Companie,
     */
    private $companie;

    /**
     * @var
     */
    protected $companieId;

    /**
     * Injeção de dependência com Modelo Consult, Construtor inicializa Consult
     *
     * ApiController constructor.
     * @param Consult $consult
     * @param Phone $phone
     * @param Assertiva $assertiva
     * @param Mother $mother
     * @param Street $street
     * @param Email $email
     * @param Vehicles $vehicles
     * @param Occupation $occupation
     * @param Copartner $copartner
     * @param Companie $companie
     */
    public function __construct(Consult $consult, Phone $phone, Assertiva $assertiva,
                                Mother $mother, Street $street, Email $email,
                                Vehicles $vehicles,Occupation $occupation,
                                Copartner $copartner, Companie $companie)
    {
        $this->assertiva    = $assertiva;
        $this->consult      = $consult;
        $this->phones       = $phone;
        $this->mother       = $mother;
        $this->street       = $street;
        $this->email        = $email;
        $this->vehicles     = $vehicles;
        $this->occupation   = $occupation;
        $this->copartner    = $copartner;
        $this->companie     = $companie;
    }

}