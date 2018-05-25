<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConsultRepository;
use App\Entities\Consult;
use App\Validators\ConsultValidator;

/**
 * Class ConsultRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConsultRepositoryEloquent extends BaseRepository implements ConsultRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Consult::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ConsultValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
