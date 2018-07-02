<?php

namespace App\Http\Controllers;


use App\Http\Requests\AddressCreateRequest;
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

    
    protected $createRequest = AddressCreateRequest::class;

    /**
     * AddressesController constructor.
     * @param AddressService $service
     */
    public function __construct(AddressService $service)
    {
        parent::__construct();
        $this->service   = $service;
    }

}
