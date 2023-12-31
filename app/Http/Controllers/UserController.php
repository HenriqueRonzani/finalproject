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

        if( !preg_match('/\/user\/\d+/', url()->previous())){
            
            session(['previous-user-back' => url()->previous()]);
        }
    
        return view('users.show',[
            'user' => $user
        ]);
    }

    
}
