<?php

namespace App\Console\Commands;

use App\User;
use Facebook\Facebook;
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
        
        $fb = new Facebook();

        foreach ($users as $user) {
            try {
                $fb->post("/{$user->facebook_id}/notifications", ['href' => $link, 'template' => $message]);
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                echo "Caught exception {$e->getMessage()}.".PHP_EOL;
            }
        }
    }
}
