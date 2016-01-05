<?php

namespace App;

use Facebook\Facebook;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements
AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'token', 'facebook_id', 'verified', 'should_notify_about_running', 'should_notify_about_nominating', 'should_notify_about_voting'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['token', 'remember_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nominations()
    {
        return $this->hasMany('App\Nomination');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    /**
     * @return bool
     */
    public function canVote()
    {
        return (bool) !$this->votes()->where('term_id', nextTerm()->id)->get()->count();
    }

    /**
     * @return bool
     */
    public function canNominate()
    {
        return $this->nominations()->where('term_id', nextTerm()->id)->get()->count() < env('NUM_ADMINS');
    }

    /**
     * @return bool
     */
    public function canRun()
    {
        return Nomination::where([
            'facebook_id' => $this->facebook_id,
            'term_id'     => nextTerm()->id,
        ])->count() > 1 && !$this->candidates()->where('term_id', nextTerm()->id)->count();
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        return (bool) $this->candidates()->where('term_id', nextTerm()->id)->get()->count();
    }

    /**
     * @param $query
     * 
     * @return mixed
     */
    public function scopeNotifyRunning($query)
    {
        return $query->where('should_notify_about_running', true);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotifyNominating($query)
    {
        return $query->where('should_notify_about_nominating', true);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotifyVoting($query)
    {
        return $query->where('should_notify_about_voting', true);
    }

    /**
     * Send a notification to the user's Facebook account.
     *
     * @param $message
     *
     * @return \Facebook\FacebookResponse
     */
    public function notify($message)
    {
        return (new Facebook)->post($this->facebook_id.'/notifications', [
            'href' => 'candidacy',
            'template' => $message,
        ]);
    }

}
