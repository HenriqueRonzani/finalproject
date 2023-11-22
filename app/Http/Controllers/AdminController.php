<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function reportedPosts(){
        if (! Gate::allows("hasPowers", auth()->user())){
            abort(403);
        }

        $pendingreports = Report::where('status','pending')->where('reportable_type','App\Models\Post')->get();
        $pendingposts = Post::whereIn('id', $pendingreports->pluck('reportable_id'))->get();
        
        return view("admin.posts",[
            "reports" => $pendingposts,
        ]);
    }

    public function reportedComments(){
        if (! Gate::allows("hasPowers", auth()->user())){
            abort(403);
        }

        $pendingreports = Report::where('status','pending')->where('reportable_type','App\Models\Comment')->get();
        $pendingcomments = Comment::whereIn('id', $pendingreports->pluck('reportable_id'))->get();
        
        return view("admin.comments",[
            "reports" => $pendingcomments,
        ]);
    }

    public function userList()
    {
        if (! Gate::allows("isAdmin", auth()->user())){
            abort(403);
        }

        return view("admin.search",[
            "users" => User::all(),
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
