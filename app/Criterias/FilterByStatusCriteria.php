<?php

namespace App\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterByAgencyCriteria
 * @package namespace App\Criteria;
 */
class FilterByStatusCriteria extends AppCriteria implements CriteriaInterface
{

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $status = $this->request->query->get('status');
<<<<<<< HEAD

=======
>>>>>>> 6311573cbe000baed31aeb6197f5390f3bd34e89
        if (is_numeric($status)) {
            $model = $model->where('status', $status);
        }
        return $model;
    }
}
