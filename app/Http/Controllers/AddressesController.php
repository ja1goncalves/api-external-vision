<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Validators\AddressValidator;
use App\Http\Controllers\Traits\CrudMethods;
use App\Services\AddressService;

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
}
