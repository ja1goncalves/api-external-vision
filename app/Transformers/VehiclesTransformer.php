<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Vehicles;

/**
 * Class VehiclesTransformer.
 *
 * @package namespace App\Transformers;
 */
class VehiclesTransformer extends TransformerAbstract
{
    /**
     * Transform the Vehicles entity.
     *
     * @param \App\Entities\Vehicles $model
     *
     * @return array
     */
    public function transform(Vehicles $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
