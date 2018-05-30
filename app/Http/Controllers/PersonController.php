<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 02/05/18
 * Time: 11:44
 */

namespace App\Http\Controllers;

use App\Http\Requests\AssertivaCpfRequest;
use App\Services\PersonService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class PersonController
 * @package App\Http\Controllers
 */
class PersonController
{
    /**
     * @var PersonService
     */
    private $personService;

    /**
     * PersonController constructor.
     * @param PersonService $personService
     */
    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    /**
     * /**
     * @param AssertivaCpfRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findCpf(AssertivaCpfRequest $request)
    {
         try {
            // valida se cpf é valido
             $cpf = $this->personService->validateCpf($request->get('cpf'));

             if(empty($cpf)){
                 return response()->json(['data' => $cpf]);
             }
             else{
                 // busca dados do cpf informado
                $result = $this->personService->searchCpf($request->get('cpf'));
             }
            return response()->json(['data' => $result]);

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}