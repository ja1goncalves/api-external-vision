<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 04/05/18
 * Time: 11:09
 */

namespace App\Http\Controllers;


use App\Services\SpcService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class SpcControllers extends AppController
{
    protected $spcService;

    /**
     * SpcControllers constructor.
     * @param SpcService $spcService
     */
    public function __construct(SpcService $spcService)
    {
        $this->spcService = $spcService;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function consultCpfOrCnpj(Request $request)
    {
        return $this->spcService->consultSpc($request);
    }


}