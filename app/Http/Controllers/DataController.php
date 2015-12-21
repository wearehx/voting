<?php

namespace App\Http\Controllers;

use App\User;

class DataController extends Controller
{
    public function getUsers()
    {
        return view('data.users')
            ->withUsers(User::orderBy('name', 'asc')->get());
    }
}
