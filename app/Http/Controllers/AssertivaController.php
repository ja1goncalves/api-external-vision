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
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AssertivaController
 * @package App\Http\Controllers
 */
class AssertivaController
{

    public function __construct(Service $service)
    {
        $this->service = $service;
    }


    public function findCpf(AssertivaCpfRequest $request)
    {
        try {

            $result = $this->service->findCpf($request->get('cpf'));

            return response()->json([
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

    }


}