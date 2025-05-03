<?php

namespace App\Http\Controllers;
use App\Models\user;

use Illuminate\Http\Request;

class userController extends Controller
{
    //show user
    public function index() {
        $users = user::all();
        return view('user', compact('users'));
    }

    //create
    public function create() {
        return view('user-add');
    }
}
