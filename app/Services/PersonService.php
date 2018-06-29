<?php

namespace App\Services;

use App\Repositories\PersonRepository;

class PersonService extends AppService
{
    use CrudMethods;

    /**
     * @var PersonRepository
     */
    protected $repository;

    /**
     * PersonService constructor.
     * @param PersonRepository $repository
     */
    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }

}