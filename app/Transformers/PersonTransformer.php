<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Person;

/**
 * Class PersonTransformer.
 *
 * @package namespace App\Transformers;
 */
class PersonTransformer extends TransformerAbstract
{
    /**
     * Transform the Person entity.
     *
     * @param \App\Entities\Person $model
     *
     * @return array
     */
    public function transform(Person $model)
    {
        return [
            'id'         => (int) $model->id,
            'protocol' => $model->protocol,
            'cpf'  => $model->cpf,
            'name'    => $model->name,
            'sex'     => $model->sex,
            'signo_zodiacal' => $model->signo_zodiacal,
            'date_birth'   => $model->date_birth,
            'age'   => $model->age,
            'estimated_income'   => $model->estimated_income,
            'created_at' => $model->created_at->toDateTimeString(),
            'updated_at' => $model->updated_at->toDateTimeString()
        ];
    }
}
