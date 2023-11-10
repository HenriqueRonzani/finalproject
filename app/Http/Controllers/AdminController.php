<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        if (! Gate::allows("viewpage", auth()->user())){
            abort(403);
        }
        
        return view("search.index",[
            "users"=> User::all(),
        ]);
    }

    public function search(Request $request)
    {
        $searchparam = $request->input("search");
        $users = User::search($searchparam)->get();

        $data = [
            "userResults"=> $users,
        ];

        return response()->json($data);
    }

    public function ban(Request $request)
    {
        $user = User::find($request->input("userid"));
        $time = $request->input("banTime");

        if ($time == 'perma') {
            $bantime = now()->addCenturies(10);
        }
        else{
            $bantime = now()->addDays($time);
        }

        $user->update(['bannedUntil' => $bantime]);

        return response()->json(['time' => $time]);
    }
}
