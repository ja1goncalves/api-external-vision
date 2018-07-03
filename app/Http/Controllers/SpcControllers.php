<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 04/05/18
 * Time: 11:09
 */

namespace App\Http\Controllers;


use App\Services\SpcConsultService;
use App\Services\SpcService;
use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class SpcControllers extends AppController
{
    protected $spcConsultService;

    /**
     * SpcControllers constructor.
     * @param SpcService $spcService
     */
    public function __construct(SpcConsultService $spcConsultService)
    {
        $this->spcConsultService = $spcConsultService;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function consultCpfOrCnpj(Request $request)
    {
        return $this->spcConsultService->consultSpc($request->get('document-consumer'));
    }


}