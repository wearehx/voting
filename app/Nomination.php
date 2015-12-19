<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomination extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['facebook_id', 'user_id', 'term_id'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
