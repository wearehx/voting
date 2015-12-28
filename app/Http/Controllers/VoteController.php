<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Vote;
use Auth;
use Illuminate\Http\Request;
use Session;

class VoteController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $candidates = nextTerm()->candidates()->get()->all();
        shuffle($candidates);

        return view('vote.cast')
            ->withCandidates($candidates)
            ->withCount(0);
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
            'vote' => 'required|array|vote_count|vote_unique|sane_votes',
        ]);
        $user = Auth::user();
        if ($user->uuid === null) {
            $user->uuid = uuid();
            $user->save();
        }
        foreach ($request->get('vote') as $vote) {
            Vote::create([
                'candidate_id' => Candidate::findOrFail($vote)->id,
                'user_id'      => $user->id,
                'term_id'      => nextTerm()->id,
            ]);
        }

        Session::flash('message', 'Your votes were successfully counted.');

        return redirect('/');
    }
}
