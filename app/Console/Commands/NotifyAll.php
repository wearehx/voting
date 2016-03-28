<?php

namespace App\Console\Commands;

use App\User;
use Facebook\FacebookRequest;
use Illuminate\Console\Command;

class NotifyAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify {link} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all users.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $link = $this->argument('link');
        $message = $this->argument('message');

        User::all()->each(function ($user) use ($link, $message) {
            $request = new FacebookRequest(
                $session,
                'POST',
                '/'.$user->facebook_id.'/notifications',
                [
                    'href' => $link,
                    'template' => $message,
                ],
            );
            $response = $request->execute();
        });
    }
}
