<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PersonRepository;
use App\Entities\Person;
use App\Validators\PersonValidator;

/**
 * Class PersonRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PersonRepositoryEloquent extends BaseRepository implements PersonRepository
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'              ,
        'protocol'           => 'like',
        'cpf'                => 'like',
        'name'               => 'like',
        'sex'                => 'like',
        'signo_zodiacal'     => 'like',
        'date_birth'         => 'like',
        'age'                => 'like',
        'estimated_income'   => 'like',
    ];

    /**
     * @var array
     */
    protected $fieldsRules = [
        'id'                => ['numeric', 'max:2147483647'],
        'protocol'          => ['max:1000'],
        'cpf'               => ['max:4'],
        'name'              => ['max:50'],
        'sex'                 => ['max:100'],
        'signo_zodiacal'     => ['max:100'],
        'age'                => ['max:100'],
        'estimated_income'   => ['max:100'],
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Person::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PersonValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
