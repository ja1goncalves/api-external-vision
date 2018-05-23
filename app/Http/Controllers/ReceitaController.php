<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 27/04/18
 * Time: 11:11
 */

namespace App\Http\Controllers;

use App\Services\Service;
use Illuminate\Http\Request;

class ReceitaController 
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * ReceitaController constructor.
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function findCnpj(Request $request)
    {
        return $this->service->findCnpj($request->get('cnpj'));
    }

}