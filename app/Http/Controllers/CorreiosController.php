<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use App\Services\Service;
use Illuminate\Http\Request;

class CorreiosController extends AppController
{
    /**
     * @var Service
     */
    protected $service;


    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCep(Request $request)
    {
        return $this->service->findCep($request->get('cep'));
    }

}