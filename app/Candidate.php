<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['user_id', 'term_id', 'about'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function term()
    {
        return $this->belongsTo("App\Term");
    }
}
