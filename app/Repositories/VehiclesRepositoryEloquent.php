<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VehiclesRepository;
use App\Entities\Vehicles;
use App\Validators\VehiclesValidator;

/**
 * Class VehiclesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class VehiclesRepositoryEloquent extends BaseRepository implements VehiclesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vehicles::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return VehiclesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
