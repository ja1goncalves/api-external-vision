<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ApiLogRepository;
use App\Entities\ApiLog;
use App\Validators\ApiLogValidator;

/**
 * Class ApiLogRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ApiLogRepositoryEloquent extends BaseRepository implements ApiLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ApiLog::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ApiLogValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
