<?php

namespace App\Providers;

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
        Validator::extend('voteCount', function ($attribute, $value, $parameters, $validator) {
            return count($value) == env('NUM_ADMINS');
        });
        Validator::extend('voteUnique', function ($attribute, $value, $parameters, $validator) {
            return Auth::user()->canVote();
        });
        Validator::extend('saneVotes', function ($attribute, $value, $parameters, $validator) {
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
