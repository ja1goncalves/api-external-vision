<?php

namespace App\Presenters;

use App\Transformers\CopartnerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CopartnerPresenter.
 *
 * @package namespace App\Presenters;
 */
class CopartnerPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CopartnerTransformer();
    }
}
