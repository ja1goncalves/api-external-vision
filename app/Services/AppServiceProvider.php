<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 21/05/18
 * Time: 11:23
 */

namespace App\Services;

use App\Phone;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider  extends ServiceProvider
{

    /**
     * @return array
     */
    public function provides()
    {
        return [Phone::class];
    }

}