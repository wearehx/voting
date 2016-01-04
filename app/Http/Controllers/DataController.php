<?php

namespace App\Http\Controllers;

use App\Term;
use App\User;

class DataController extends Controller
{
    /**
     * Show all users and their app-scoped UID.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers()
    {
        return view('data.users')
            ->withUsers(User::orderBy('name', 'asc')->get());
    }

    /**
     * Show all votes in JSON form.
     * TODO: There should be a better way to do this.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVotes()
    {
        $terms = [];
        Term::past()->get()->each(function ($term) use (&$terms) {
            $candidates = [];
            $term->candidates()->get()->each(function ($candidate) use (&$candidates) {
                $candidates[] = [
                    'id'      => $candidate->id,
                    'user_id' => $candidate->user()->get()->first()->id,
                    'name'    => $candidate->user()->get()->first()->name,
                ];
            });

            $votes = [];
            $term->votes()->get()->each(function ($vote) use (&$votes) {
                $votes[] = [
                    'id'           => $vote->id,
                    'candidate_id' => $vote->candidate()->get()->first()->id,
                    'uuid'         => $vote->user()->get()->first()->uuid,
                ];
            });

            $terms[] = [
                'id'         => $term,
                'start'      => $term->starts_at->toDateString(),
                'end'        => $term->ends_at->toDateString(),
                'candidates' => $candidates,
                'votes'      => $votes,
            ];
        });

        return response()->json([
            'terms' => $terms,
        ]);
    }
}
