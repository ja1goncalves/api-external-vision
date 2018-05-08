<?php
/**
 * Created by PhpStorm.
 * User: laisvidoto
 * Date: 02/05/18
 * Time: 11:44
 */

namespace App\Http\Controllers;

use App\Services\Service;
use Illuminate\Http\Request;

/**
 * Class AssertivaController
 * @package App\Http\Controllers
 */
class AssertivaController
{

    public function __construct(Service $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        return $this->service->findCpf($request);
    }


}