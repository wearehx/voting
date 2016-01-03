<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $dates = ['starts_at', 'ends_at'];
    protected $fillable = ['starts_at', 'ends_at'];

    public function candidates()
    {
        return $this->hasMany("App\Candidate");
    }

    public function scopeActive($query)
    {
        return $query->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>', Carbon::now())
            ->orderBy('starts_at', 'asc');
    }

    public function scopeNext($query)
    {
        return $query->where('starts_at', '>', Carbon::now())
            ->orderBy('starts_at', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('starts_at', '<=', Carbon::now())
            ->orderBy('starts_at', 'asc');
    }
}
