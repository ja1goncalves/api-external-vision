<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 02/05/18
 * Time: 11:44
 */

namespace App\Http\Controllers;

use App\Http\Requests\AssertivaCpfRequest;
use GuzzleHttp\Client;
use App\Services\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
     * @param AssertivaCpfRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCpf(AssertivaCpfRequest $request)
    {
         try {
             //$cpf = $this->service->validateCpf($request);




            $result = $this->service->findCpf($request->get('cpf'));

            return response()->json(['data' => $result]);

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}