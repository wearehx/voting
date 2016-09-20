<?php

namespace App\Http\Controllers;

use App\Nomination;
use Auth;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Session;

class NominationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nominate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'facebook_id' => 'required|integer|exists:users,facebook_id|not_in:'.env('MAINTAINER_UID', '10153385491939685'),
        ]);

        if (Nomination::where([
            'facebook_id' => $request->get('facebook_id'),
            'term_id' => nextTerm()->id,
        ])->count() >= env('MIN_NOMINATIONS')) {
            Session::flash('message', 'That user already has enough nominations.');

            return redirect('/nominate');
        }

        if (Nomination::where([
            'facebook_id' => $request->get('facebook_id'),
            'term_id' => nextTerm()->id,
            'user_id' => Auth::user()->id,
        ])->count() != 0) {
            Session::flash('message', 'You\'ve already nominated that user.');

            return redirect('/nominate');
        }
        
        Nomination::create([
            'facebook_id' => $request->get('facebook_id'),
            'user_id'     => Auth::user()->id,
            'term_id'     => nextTerm()->id,
        ]);
        Session::flash('message', 'You successfully nominated a user.');

        static::notify($request->get('facebook_id'));

        return redirect('/');
    }
    
    protected static function notify(string $facebook_id)
    {
        $fb = new Facebook();
        $fb->post("/{$facebook_id}/notifications", ['href' => 'https://hackers-voting.herokuapp.com/candidacy', 'template' => 'You have been nominated for the HX admin election. Click here to register yourself as a candidate.'], env('FACEBOOK_APP_ID').'|'.env('FACEBOOK_APP_SECRET'));
    }
}
