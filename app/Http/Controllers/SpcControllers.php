<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 04/05/18
 * Time: 11:09
 */

namespace App\Http\Controllers;


use http\Env\Request;
use App\Services\SpcService;

class SpcControllers
{

    /**
     * SpcControllers constructor.
     * @param SpcService $service
     */
    public function __construct(SpcService $service)
    {
        $this->service = $service;
    }

    /**
     * Consulta de
     *
     * @param Request $request
     * @return mixed
     */
    public function consultCpfOrCnpj(Request $request)
    {
        return $this->service->consultSpc($request);
    }


}