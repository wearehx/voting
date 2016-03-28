<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    * Flash a success message to the user.
    *
    * @param $message
    */
    protected function success($message)
    {
        Session::flash('message', $message);
    }

    /**
     * Flash a failure message to the user.
     *
     * @param $message
     */
    protected function failure($message)
    {
        Session::flash('message', $message);
    }
}
