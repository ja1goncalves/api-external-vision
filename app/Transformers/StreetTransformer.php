<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Street;

/**
 * Class StreetTransformer.
 *
 * @package namespace App\Transformers;
 */
class StreetTransformer extends TransformerAbstract
{
    /**
     * Transform the Street entity.
     *
     * @param \App\Entities\Street $model
     *
     * @return array
     */
    public function transform(Street $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
