<?php

namespace App\Presenters;

use App\Transformers\OccupationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OccupationPresenter.
 *
 * @package namespace App\Presenters;
 */
class OccupationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OccupationTransformer();
    }
}
