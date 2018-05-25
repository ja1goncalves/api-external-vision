<?php

namespace App\Presenters;

use App\Transformers\ConsultTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ConsultPresenter.
 *
 * @package namespace App\Presenters;
 */
class ConsultPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ConsultTransformer();
    }
}
