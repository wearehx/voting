<?php

namespace App;

use App\Nomination;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
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
    protected $fillable = ['name', 'email', 'token', 'facebook_id', 'verified'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['token', 'remember_token'];

    public function nominations()
    {
        return $this->hasMany("App\Nomination");
    }

    public function candidates()
    {
        return $this->hasMany("App\Candidate");
    }

    public function votes()
    {
        return $this->hasMany("App\Vote");
    }

    public function canVote()
    {
        return (bool) ! $this->votes()->where('term_id', nextTerm()->id)->get()->count();
    }

    public function canNominate()
    {
        return (bool) ! $this->nominations()->where('term_id', nextTerm()->id)->get()->count();
    }

    public function canRun()
    {
        return Nomination::where([
            "facebook_id" => $this->facebook_id,
            "term_id" => nextTerm()->id
        ])->count() > 2 && ! $this->candidates()->where("term_id", nextTerm()->id)->count();
    }

    public function isRunning()
    {
        return (bool) $this->candidates()->where('term_id', nextTerm()->id)->get()->count();
    }
}
