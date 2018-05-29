<?php

namespace App\Repositories;

use App\Presenters\AddressPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AddressRepository;
use App\Entities\Address;
use App\Validators\AddressValidator;

/**
 * Class AddressRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AddressRepositoryEloquent extends AppRepository implements AddressRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'              ,
        'zip_code' => 'ilike',
        'country'  => 'ilike',
        'state'    => 'ilike',
        'city'     => 'ilike',
        'district' => 'ilike',
        'street'   => 'ilike',
    ];

    /**
     * @var array
     */
    protected $fieldsRules = [
        'id'       => ['numeric', 'max:2147483647'],
        'zip_code' => ['max:1000'],
        'state'    => ['max:4'],
        'city'     => ['max:50'],
        'district' => ['max:100'],
        'street'   => ['max:100'],
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Address::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AddressValidator::class;
    }


    /**
     * @return mixed
     */
    public function presenter()
    {
        return AddressPresenter::class;
    }
    
}
