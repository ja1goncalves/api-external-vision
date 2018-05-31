<?php
/**
 * Created by PhpStorm.
 * User: evamarla
 * Date: 31/05/18
 * Time: 09:15
 */

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