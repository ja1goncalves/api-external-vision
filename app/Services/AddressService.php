<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Services\Traits\CrudMethods;
use App\Validators\AddressValidator;
/**
 * Class BankAccountService
 * @package App\Services
 */
class AddressService extends AppService
{
    use CrudMethods;

    /**
     * @var AddressRepository
     */
    protected $repository;

    /** @var $validator */
    protected $validator;

    public function __construct(AddressRepository $repository, AddressValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    
}