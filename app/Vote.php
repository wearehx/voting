<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['candidate_id', 'user_id', 'term_id'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
