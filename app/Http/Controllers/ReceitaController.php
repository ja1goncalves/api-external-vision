<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 27/04/18
 * Time: 11:11
 */

namespace App\Http\Controllers;

use App\Services\ReceitaService;
use Illuminate\Http\Request;

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
        $this->$receitaService = $receitaService;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj(Request $request)
    {
        return $this->receitaService->findCnpj($request->get('cnpj'));
    }

}