<?php

namespace App\Presenters;

use App\Transformers\ApiLogTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ApiLogPresenter.
 *
 * @package namespace App\Presenters;
 */
class ApiLogPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ApiLogTransformer();
    }
}
