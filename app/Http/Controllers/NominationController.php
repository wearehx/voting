<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Nomination;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "facebook_id" => "required|integer|exists:users,facebook_id"
        ]);
        Nomination::create([
            "facebook_id" => $request->get("facebook_id"),
            "user_id" => Auth::user()->id,
            "term_id" => nextTerm()->id
        ]);
        Session::flash('message', 'You successfully nominated a user.');

        return redirect("/");
    }
}
