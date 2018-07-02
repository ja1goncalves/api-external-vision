<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use App\Services\CepService;

class CorreiosController extends AppController
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
        parent::__construct();
        $this->cepService = $cepService;
    }

    /**
     * @param $cep
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCep($cep)
    {
        return $this->cepService->findCep($cep);
    }

}