<?php

namespace App\Services;


use App\Repositories\PersonRepository;

class PersonService extends AppService
{
    use CrudMethods;

    /**
     * @var AddressRepository
     */
    protected $repository;

    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }

}