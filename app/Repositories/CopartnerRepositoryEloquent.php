<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CopartnerRepository;
use App\Entities\Copartner;
use App\Validators\CopartnerValidator;

/**
 * Class CopartnerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CopartnerRepositoryEloquent extends BaseRepository implements CopartnerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Copartner::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CopartnerValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
