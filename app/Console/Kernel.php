<?php

namespace App\Console;

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
        Commands\NotifyAll::class,
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
            $fb = new Facebook();

            $users = User::all();
            $facebookUsers = [];

            $edge = $fb->get('/1659221770989008/members?limit=999999999999&fields=id', User::where('facebook_id', env('MAINTAINER_UID', 10153385491939685)->first()->token()))->getGraphEdge();

            foreach ($edge as $node) {
                $facebookUsers[] = $node['id'];
            }

            foreach ($users as $user) {
                $user->can_vote = in_array($user->facebook_id, $facebookUsers) ? true : false;
                $user->save();
            }
        })->daily();
    }
}
