<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 27/04/18
 * Time: 11:11
 */

namespace App\Http\Controllers;

use App\Services\CnpjService;

class CnpjController
{
    /**
     * @var CnpjService
     */
    protected $cnpjService;
    // $log = new ApiLog();
    // $log->log('SPC', 'New SPC Mix Mais', 'Document: '.$doc);

    /**
     * CnpjController constructor.
     * @param CnpjService $cnpjService
     */
    public function __construct(CnpjService $cnpjService)
    {
        $this->cnpjService = $cnpjService;
    }

    /**
     * @param $cnpj
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj($cnpj)
    {
        return $this->cnpjService->findCnpj($cnpj);
    }

}