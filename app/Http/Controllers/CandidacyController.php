<?php

namespace App\Http\Controllers;

use App\Candidate;
use Auth;
use Illuminate\Http\Request;
use Session;

class CandidacyController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * TODO: Refactor.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('candidate.'.(Auth::user()->isRunning() ? 'success' : (Auth::user()->canRun() ? 'accept' : 'waiting')));
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
            'consent' => 'accepted',
            'text'    => 'required|max:250|min:10',
        ]);

        if (!Auth::user()->canRun()) {
            abort(403);
        }

        Candidate::create([
            'user_id' => Auth::user()->id,
            'about'   => $request->get('text'),
            'term_id' => nextTerm()->id,
        ]);

        Session::flash('message', 'You successfully marked yourself as running.');

        return redirect('/');
    }
}
