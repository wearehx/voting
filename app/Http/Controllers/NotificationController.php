<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

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
     *
     * @return Redirect
     */
    public function postConfigure(Request $request)
    {
        $this->user->update($this->processConfigureRequest($request));
        $this->success('Your notification preferences were successfully updated.');

        return redirect('/notification/configure');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function processConfigureRequest(Request $request)
    {
        return [
            'should_notify_about_running'    => $request->get('should_notify_about_running') == 'on' ? true : false,
            'should_notify_about_nominating' => $request->get('should_notify_about_nominating') == 'on' ? true : false,
            'should_notify_about_voting'     => $request->get('should_notify_about_voting') == 'on' ? true : false,
        ];
    }
}
