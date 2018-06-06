<?php

namespace App\Http\Controllers;


use App\Http\Requests\AddressUpdateRequest;
use App\Validators\AddressValidator;
use App\Http\Controllers\Traits\CrudMethods;
use App\Services\AddressService;
use App\Http\Requests\AddressCreateRequest;
use \Illuminate\Http\Request;

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


    //public function __construct(AddressService $service, AddressValidator $validator)
   // {
   //     $this->service   = $service;
    //    $this->validator = $validator;
    //}


    public function store(AddressCreateRequest $request)
    {
        \Log::debug('EU');
         return $request->validated();
        echo 'Store';
    }

}
