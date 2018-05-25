<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ApiLog;

/**
 * Class ApiLogTransformer.
 *
 * @package namespace App\Transformers;
 */
class ApiLogTransformer extends TransformerAbstract
{
    /**
     * Transform the ApiLog entity.
     *
     * @param \App\Entities\ApiLog $model
     *
     * @return array
     */
    public function transform(ApiLog $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
