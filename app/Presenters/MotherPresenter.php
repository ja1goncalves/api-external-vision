<?php

namespace App\Presenters;

use App\Transformers\MotherTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MotherPresenter.
 *
 * @package namespace App\Presenters;
 */
class MotherPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MotherTransformer();
    }
}
