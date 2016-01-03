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
        foreach (Term::past()->get() as $term) {
            $candidates = [];
            foreach ($term->candidates()->get() as $candidate) {
                $candidates[] = [
                    "id" => $candidate->id,
                    "user_id" => $candidate->user()->id,
                    "name" => $candidate->user()->name,
                ];
            }
            $votes = [];
            foreach ($term->votes()->get() as $vote) {
                $votes[] = [
                    "candidate_id" => $vote->candidate()->id,
                    "uuid" => $vote->user()->uuid,
                ];
            }
            $terms[] = [
                "id" => $term,
                "start" => $term->starts_at->toDateString(),
                "end" => $term->ends_at->toDateString(),
                "candidates" => $candidates,
                "votes" => $votes,
            ];
        }
        return response()->json([
            "terms" => $terms
        ]);
    }
}
