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

        $schedule->call(function ($members = []) {
            $fb = new Facebook();
            $users = User::all();
            $edge = $fb->get('/1659221770989008/members?limit=999999999999&fields=id', User::where('facebook_id', env('MAINTAINER_UID', 10153385491939685)->first()->token()))->getGraphEdge();
            foreach ($edge as $node) {
                $members[] = $node['id'];
            }

            foreach ($users as $user) {
                $user->update([
                    'can_vote' => in_array($user->facebook_id, $members) ? true : false,
                ]);
            }
        })->daily();
    }
}
