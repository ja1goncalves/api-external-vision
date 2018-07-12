<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssertivaCpfRequest;
use App\Services\PersonService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class AssertivaController
 * @package App\Http\Controllers
 */
class AssertivaController
{
    /**
     * @var PersonService
     */
    private $service;


    /**
     * AssertivaController constructor.
     * @param PersonService $service
     */
    public function __construct(PersonService $service)
    {
        $this->service = $service;
    }


    /**
     * @param AssertivaCpfRequest $request
     * @return mixed
     */
    public function findCpf(AssertivaCpfRequest $request, $cpf)
    {
         try {
            if(!$this->service->validateCpf($cpf)) throw new \Exception("CPF invalido!");
             $result = $this->service->searchCpf($request->get('cpf'));
             $person = [
                 'cpf'       => $result['cpf'],
                 'birthday'  => $result['date_birth'],
                 'name'      => $result['name'],
                 'age'       => $result['age'],
                 'gender'    => $result['gender'],
                 'emails'    => $result['email'],
                 'phones'    => $result['phones'],
                 'parents'   => $result['mother'],
                 'addresses' => $result['addresses'],
             ];
            return response()->json(['data' => $person]);

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}