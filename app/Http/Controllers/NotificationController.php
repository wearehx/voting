<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;

class NotificationController extends Controller
{
    /**
     * @var \App\User
     */
    protected $user;

    /**
     * NotificationController constructor.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getConfigure()
    {
        return view('notification.configure');
    }

    /**
     * @param Request $request
     * @return Redirect
     */
    public function postConfigure(Request $request)
    {
        $this->user->update([
            'notifications' => $this->processConfigureRequest($request),
        ]);

        $this->success('Your notification preferences were successfully updated.');

        return redirect('/notification/configure');
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function processConfigureRequest(Request $request)
    {
        return [
            'running' => $request->get('running') == 'on' ? true : false,
            'nominating' => $request->get('nominating') == 'on' ? true : false,
            'voting' => $request->get('voting') == 'on' ? true : false,
        ];
    }
}
