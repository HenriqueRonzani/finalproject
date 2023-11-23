<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likeToggle(Request $request, $likableId)
    {
        $userid = auth()->user()->id;
        $user = User::find($userid);
        
        $likabletype = $request->input('likable');

        $likable = $likabletype == 'post' ? Post::find($likableId) : Comment::find($likableId);

            $user->likes->where('likable_id', $likable->id)
                        ->where('likable_type', get_class($likable))
                        ->each->delete();

            $asset = asset('img/not-liked.svg');

        $data = [
            "count" => count($likable->likes),
            "asset" => $asset,
            "commentId" => $likabletype == 'comment' ? $likable->id : null
        ];
        
        return response()->json($data);
    }

    public function likeRemove(Request $request, $likableId){
    
        $userid = auth()->user()->id;

        $user = User::find($userid);
        
        $likabletype = $request->input('likable');

        $likable = $likabletype == 'post' ? Post::find($likableId) : Comment::find($likableId);

        $user->likes()->create([
            'likable_id' => $likable->id,
            'likable_type' => get_class($likable)
        ]);
        $asset = asset('img/liked.svg');

        $data = [
            "count" => count($likable->likes),
            "asset" => $asset,
            "commentId" => $likabletype == 'comment' ? $likable->id : null
        ];
        
        return response()->json($data);
    }


}
