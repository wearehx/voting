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
    public function getVotes($terms = [])
    {
        Term::past()->get()->each(function ($term, $candidates = [], $votes = []) use (&$terms) {
            $terms[] = [
                'id'         => $term,
                'start'      => $term->starts_at->toDateString(),
                'end'        => $term->ends_at->toDateString(),
                'candidates' => $term->candidates()->select(['id', 'user_id', 'name'])->get(),
                'votes'      => $term->votes()->select(['id', 'candidate_id', 'uuid'])->get(),
            ];
        });

        return response()->json([
            'terms' => $terms,
        ]);
    }
}
