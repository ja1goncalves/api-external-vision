<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Copartner;

/**
 * Class CopartnerTransformer.
 *
 * @package namespace App\Transformers;
 */
class CopartnerTransformer extends TransformerAbstract
{
    /**
     * Transform the Copartner entity.
     *
     * @param \App\Entities\Copartner $model
     *
     * @return array
     */
    public function transform(Copartner $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
