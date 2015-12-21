<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getUsers()
    {
        return view('data.users')
            ->withUsers(User::all()->orderBy('name', 'asc'));
    }
}
