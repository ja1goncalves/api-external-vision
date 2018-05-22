<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 02/05/18
 * Time: 11:44
 */

namespace App\Http\Controllers;

use App\Http\Requests\AssertivaCpfRequest;
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
     * @var Service
     */
    private $service;


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
     */
    public function findCpf(AssertivaCpfRequest $request)
    {
         try {
            // valida se cpf é valido
             $cpf = $this->service->validateCpf($request->get('cpf'));

             if(empty($cpf)){
                 return response()->json(['data' => $cpf]);
             }
             else{
                 // busca dados do cpf informado
                $result = $this->service->searchCpf($request->get('cpf'));
             }
            return response()->json(['data' => $result]);

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}