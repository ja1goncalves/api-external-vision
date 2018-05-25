<?php

namespace App\Presenters;

use App\Transformers\VehiclesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class VehiclesPresenter.
 *
 * @package namespace App\Presenters;
 */
class VehiclesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VehiclesTransformer();
    }
}
