<?php

namespace App\Presenters;

use App\Transformers\EmailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class EmailPresenter.
 *
 * @package namespace App\Presenters;
 */
class EmailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new EmailTransformer();
    }
}
