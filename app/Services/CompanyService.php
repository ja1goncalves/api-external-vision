<?php
/**
 * Created by PhpStorm.
 * User: evamarla
 * Date: 31/05/18
 * Time: 09:13
 */

namespace App\Services;


use App\Repositories\CompanyRepository;

class CompanyService extends AppService
{
    use CrudMethods;

    /**
     * @var AddressRepository
     */
    protected $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

}