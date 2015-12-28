<?php

function canNominate($checkUser = true)
{
    try {
        return Carbon\Carbon::now()->between(nextTerm()->starts_at->subDays(14), nextTerm()->starts_at->subDays(7)) && (Auth::check() && $checkUser ? Auth::user()->canNominate() : true);
    } catch (Exception $e) {
        return false;
    }
}

function canVote($checkUser = true)
{
    try {
        return Carbon\Carbon::now()->between(nextTerm()->starts_at->subDays(7), nextTerm()->starts_at) && (Auth::check() && $checkUser ? Auth::user()->canVote() : true);
    } catch (Exception $e) {
        return false;
    }
}

function term()
{
    return App\Term::active()->get()->first();
}

function nextTerm()
{
    return App\Term::next()->get()->first();
}

function uuid()
{
    return Ramsey\Uuid\Uuid::uuid4()->toString();
}
