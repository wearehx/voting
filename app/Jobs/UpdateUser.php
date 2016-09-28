<?php

namespace App\Jobs;

use App\User;
use Facebook\Exceptions\FacebookAuthenticationException;
use Facebook\Facebook;

class UpdateUser extends Job
{
    /**
     * The Facebook UID of the user to update.
     *
     * @var int
     */
    private $uid;

    /**
     * The fields to pull from the Graph API and update.
     *
     * @var array
     */
    private $changedFields;

    /**
     * The user in our database.
     *
     * @var App\User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uid, $changedFields)
    {
        $this->uid = $uid;

        $this->changedFields = $changedFields;

        $this->user = User::where('facebook_id', $this->uid)->get()->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Facebook $fb)
    {
        try {
            $response = $fb->get('/me?fields='.implode($this->changedFields, ','), $this->user->token)->getGraphUser();
        } catch (FacebookAuthenticationException $e) {
            return false;
        }

        foreach ($response as $field => $value) {
            if (in_array($field, $this->changedFields)) {
                $this->user->{$field} = $value;
            }
        }

        $this->user->save();
    }
}
