<?php

namespace App\Presenters;

use App\Transformers\PhoneTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PhonePresenter.
 *
 * @package namespace App\Presenters;
 */
class PhonePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PhoneTransformer();
    }
}
