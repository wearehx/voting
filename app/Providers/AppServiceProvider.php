<?php

namespace App\Providers;

use App\Candidate;
use Auth;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('vote_count', function ($attribute, $value, $parameters, $validator) {
            return count($value) <= env('NUM_ADMINS') && count($value) > 0;
        });
        Validator::extend('vote_unique', function ($attribute, $value, $parameters, $validator) {
            return Auth::user()->canVote();
        });
        Validator::extend('sane_votes', function ($attribute, $value, $parameters, $validator) {
            $can = [];
            foreach ($value as $candidate) {
                if (Candidate::findOrFail($candidate)->term_id !== nextTerm()->id || in_array($candidate, $can)) {
                    return false;
                }
                $can[] = $candidate;
            }

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
