<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 02/05/18
 * Time: 11:44
 */

namespace App\Http\Controllers;
use App\Consults;
use App\Email;
use App\Services\Service;
use App\Streets;
use http\Env\Request;

/**
 * Class AssertivaController
 * @package App\Http\Controllers
 */
class AssertivaController
{

    /**
     * AssertivaController constructor.
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->service->index($request->get('cpf'));
    }


}