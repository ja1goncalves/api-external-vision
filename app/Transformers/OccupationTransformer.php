<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Occupation;

/**
 * Class OccupationTransformer.
 *
 * @package namespace App\Transformers;
 */
class OccupationTransformer extends TransformerAbstract
{
    /**
     * Transform the Occupation entity.
     *
     * @param \App\Entities\Occupation $model
     *
     * @return array
     */
    public function transform(Occupation $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
