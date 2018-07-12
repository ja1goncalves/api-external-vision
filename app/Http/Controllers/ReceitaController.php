<?php

namespace App\Http\Controllers;

use App\Services\ReceitaService;

/**
 * Class ReceitaController
 * @package App\Http\Controllers
 */
class ReceitaController
{
    /**
     * @var ReceitaService
     */
    protected $receitaService;


    /**
     * ReceitaController constructor.
     * @param ReceitaService $receitaService
     */
    public function __construct(ReceitaService $receitaService)
    {
        $this->receitaService = $receitaService;
    }

    /**
     * @param $cnpj
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj($cnpj)
    {
        return response()->json(['data' => $this->receitaService->findCnpj($cnpj)]);
    }

}