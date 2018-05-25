<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompanieRepository;
use App\Entities\Companie;
use App\Validators\CompanieValidator;

/**
 * Class CompanieRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompanieRepositoryEloquent extends BaseRepository implements CompanieRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Companie::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CompanieValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
