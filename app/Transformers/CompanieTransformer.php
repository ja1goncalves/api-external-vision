<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Companie;

/**
 * Class CompanieTransformer.
 *
 * @package namespace App\Transformers;
 */
class CompanieTransformer extends TransformerAbstract
{
    /**
     * Transform the Companie entity.
     *
     * @param \App\Entities\Companie $model
     *
     * @return array
     */
    public function transform(Companie $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
