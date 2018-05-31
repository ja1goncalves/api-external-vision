<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Company;

/**
 * Class CompanyTransformer.
 *
 * @package namespace App\Transformers;
 */
class CompanyTransformer extends TransformerAbstract
{
    /**
     * Transform the Company entity.
     *
     * @param \App\Entities\Company $model
     *
     * @return array
     */
    public function transform(Company $model)
    {
        return [
            'id'         => (int) $model->id,
            'cnpj' => $model->cnpj,
            'corporate'  => $model->corporate,
            'cnae'    => $model->cnae,
            'discription_cnae'     => $model->discription_cnae,
            'participation' => $model->participation,
            'date_entry'   => $model->date_entry,
            'people_id'   => $model->people_id,
            'created_at' => $model->created_at->toDateTimeString(),
            'updated_at' => $model->updated_at->toDateTimeString()
        ];
    }
}
