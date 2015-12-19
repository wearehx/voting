<?php

namespace App\Console;

use App\Term;
use Carbon;
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
            $term->ends_at = $date->addMonths(3);
            $term->save();
        })->daily()->when(function () {
            return term()->ends_at->diffInDays() == 15 && nextTerm() === null;
        });
    }
}
