<?php

namespace App\Console\Commands;

use App\User;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
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

        $users = User::all();

        foreach ($users as $user) {
            $request = new FacebookRequest(null, $user->token, 'POST', "/{$user->facebook_id}/notifications", ['href' => $link, 'template' => $message]);

            $response = $request->execute();
        }
    }
}
