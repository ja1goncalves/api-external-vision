<?php

namespace App\Presenters;

use App\Transformers\CompanieTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompaniePresenter.
 *
 * @package namespace App\Presenters;
 */
class CompaniePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanieTransformer();
    }
}
