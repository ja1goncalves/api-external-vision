<?php

namespace App\Presenters;

use App\Transformers\StreetTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StreetPresenter.
 *
 * @package namespace App\Presenters;
 */
class StreetPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StreetTransformer();
    }
}
