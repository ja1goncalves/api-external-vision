<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Consult;

/**
 * Class ConsultTransformer.
 *
 * @package namespace App\Transformers;
 */
class ConsultTransformer extends TransformerAbstract
{
    /**
     * Transform the Consult entity.
     *
     * @param \App\Entities\Consult $model
     *
     * @return array
     */
    public function transform(Consult $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
