<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Email;

/**
 * Class EmailTransformer.
 *
 * @package namespace App\Transformers;
 */
class EmailTransformer extends TransformerAbstract
{
    /**
     * Transform the Email entity.
     *
     * @param \App\Entities\Email $model
     *
     * @return array
     */
    public function transform(Email $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
