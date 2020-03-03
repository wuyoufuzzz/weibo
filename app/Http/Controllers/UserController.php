<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //用户操作
    public function create()
    {
        return view('users.create');
    }
}
