<?php

namespace App\Http\Controllers;

use App\Services\ReceitaService;
use App\Http\Requests\ReceitaCnpjRequest;
use Illuminate\Http\Response;

class CnpjController
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
     * @param ReceitaCnpjRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj(ReceitaCnpjRequest $request)
    {
        try {
            if(!$this->receitaService->validateCnpj($request->get('cnpj'))) throw new \Exception("CNPJ invalido!");
            return response()->json(['data' => $this->receitaService->findCnpj($request->get('cnpj'))]);

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}