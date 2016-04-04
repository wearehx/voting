<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Vote;
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

        $this->shuffle($candidates);

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

        $user = $request->user();

        if ($user->uuid === null) {
            $user->update([
                'uuid' => uuid(),
            ]);
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

    /**
     * Randomize the given array.
     *
     * @param array $candidates
     *
     * @return array
     */
    protected function shuffle(array &$candidates)
    {
        for ($index = count($candidates) - 1; $index > 0; $index--) {
            /* Pick a random number within the untouched bounds of the array. */
            $int = random_int(0, $index);

            /* Set $old to the current $index. */
            $old = $candidates[$index];

            /* Set $candidates[$index] to a random value from $items that has an index of < $index. */
            $candidates[$index] = $candidates[$int];

            /* Set the randomized key's value ($candidates[$int]) to the old value from the iterated index ($index). */
            $candidates[$int] = $old;
        }
    }
}
