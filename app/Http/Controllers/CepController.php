<?php

namespace App\Http\Controllers;

use App\Services\CepService;
use App\Http\Requests\CorreiosCepRequest;
use Illuminate\Http\Response;

class CepController extends AppController
{
    /**
     * @var CepService
     */
    protected $cepService;

    /**
     * CorreiosController constructor.
     * @param CepService $cepService
     */
    public function __construct(CepService $cepService)
    {
        $this->cepService = $cepService;
    }

    /**
     * @param CorreiosCepRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findCep(CorreiosCepRequest $request)
    {
        try {
            if(!$this->cepService->validarCep($request->get('cep'))) throw new \Exception("CEP invalido!");
                return response()->json(['data' => $this->cepService->findCep($request->get('cep'))]);

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}