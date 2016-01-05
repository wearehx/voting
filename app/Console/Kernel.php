<?php

namespace App\Console;

use App\Term;
use App\User;
use Carbon;
use Facebook\Facebook;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\NewTerm::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $term = new Term();
            $date = Carbon::now()->addDays(15);
            $term->starts_at = $date;
            $term->ends_at = $date->addMonths(3)->subDays(1);
            $term->save();
        })->daily()->when(function () {
            return term()->ends_at->diffInDays() == 15 && nextTerm() === null;
        });

        $schedule->call(function () {
            $fb = new Facebook();
            $users = User::all();
            $uids = [];
            $edge = $fb->get('/1659221770989008/members?limit=999999999999&fields=id', User::where('facebook_id', env('MAINTAINER_UID', 10153385491939685)->first()->token()))->getGraphEdge();
            foreach ($edge as $node) {
                $uids[] = $node['id'];
            }

            foreach ($users as $user) {
                $user->can_vote = in_array($user->facebook_id, $uids) ? true : false;
                $user->save();
            }
        })->daily();

        $schedule->call(function () {
            User::notifyRunning()->get()->each(function ($user) {
                $user->notify("You've been nominated by two people to run for an admin position.");
            });
        })->hourly()->when(function () {
            return canNominate();
        });

        $schedule->call(function () {
            User::notifyNominating()->get()->each(function ($user) {
                $user->notify('You can now nominate three people to run for an admin position.');
            });
        })->hourly()->when(function () {
            return canNominate();
        });

        $schedule->call(function () {
            User::notifyVoting()->get()->each(function ($user) {
                $user->notify('You can now vote in the HX admin election.');
            });
        })->hourly()->when(function () {
            return canVote();
        });
    }
}
