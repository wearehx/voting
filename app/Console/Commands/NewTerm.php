<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Term;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class NewTerm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'term:create {year} {month} {day}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new term.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::createFromDate($this->argument("year"), $this->argument("month"), $this->argument("day"), 'GMT');
        $term = new Term;
        $term->starts_at = $date;
        $term->ends_at = $date->addMonths(3);
        $term->save();
        $this->info('Term created successfully.');
    }
}
