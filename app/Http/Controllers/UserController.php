<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show(Request $request, $userid):View 
    {
        $user = User::find($userid);
        return view('users.show',[
            'user' => $user
        ]);
    }
}
