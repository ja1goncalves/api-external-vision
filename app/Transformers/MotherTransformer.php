<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Mother;

/**
 * Class MotherTransformer.
 *
 * @package namespace App\Transformers;
 */
class MotherTransformer extends TransformerAbstract
{
    /**
     * Transform the Mother entity.
     *
     * @param \App\Entities\Mother $model
     *
     * @return array
     */
    public function transform(Mother $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
