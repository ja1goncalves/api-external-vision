<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccupationRepository;
use App\Entities\Occupation;
use App\Validators\OccupationValidator;

/**
 * Class OccupationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccupationRepositoryEloquent extends BaseRepository implements OccupationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Occupation::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OccupationValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
