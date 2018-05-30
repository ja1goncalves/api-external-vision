<?php

namespace App\Http\Controllers;


use App\Validators\AddressValidator;
use App\Http\Controllers\Traits\CrudMethods;
use App\Services\AddressService;
use App\Http\Requests\AddressCreateRequestuse\Illuminate\Http\Request;

/**
 * Class AddressesController.
 *
 * @package namespace App\Http\Controllers;
 */
class AddressesController extends AppController
{
    use CrudMethods;
  
    /**
     * @var AddressService
     */
    protected $service;

    /**
     * @var AddressValidator
     */
    protected $validator;

    /**
     * AddressesController constructor.
     * @param AddressService $service
     * @param AddressValidator $validator
     */
    public function __construct(AddressService $service, AddressValidator $validator)
    {
        $this->service   = $service;
        $this->validator = $validator;
    }


    public function store(AddressCreateRequest $request)
    {

    }
}
