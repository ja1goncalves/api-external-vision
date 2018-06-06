<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompanyRepository;
use App\Entities\Company;
use App\Validators\CompanyValidator;

/**
 * Class CompanyRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompanyRepositoryEloquent extends BaseRepository implements CompanyRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'              ,
        'cnpj' => 'like',
        'corporate'  => 'like',
        'cnae'    => 'like',
        'discription_cnae'     => 'like',
        'participation' => 'like',
        'date_entry'   => 'like',
        'people_id'   => 'like',
    ];

    /**
     * @var array
     */
    protected $fieldsRules = [
        'id'       => ['numeric', 'max:2147483647'],
        'cnpj' => ['max:1000'],
        'corporate'    => ['max:4'],
        'cnae'     => ['max:50'],
        'discription_cnae' => ['max:100'],
        'participation'   => ['max:100'],
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Company::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CompanyValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
