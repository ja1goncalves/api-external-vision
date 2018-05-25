<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Phone;

/**
 * Class PhoneTransformer.
 *
 * @package namespace App\Transformers;
 */
class PhoneTransformer extends TransformerAbstract
{
    /**
     * Transform the Phone entity.
     *
     * @param \App\Entities\Phone $model
     *
     * @return array
     */
    public function transform(Phone $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
