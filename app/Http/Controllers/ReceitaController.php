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
    protected $receitaService; $log = new ApiLog();
            $log->log('SPC', 'New SPC Mix Mais', 'Document: ' . $doc);

    /**
     * ReceitaController constructor.
     * @param ReceitaService $receitaService
     */
    public function __construct(ReceitaService $receitaService)
    {
        $this->receitaService = $receitaService;
    }

    /**
     * @param $cnpj
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCnpj($cnpj)
    {
        return $this->receitaService->findCnpj($cnpj);
    }

}