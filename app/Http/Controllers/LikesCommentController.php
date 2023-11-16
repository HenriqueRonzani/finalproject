<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\LikeComments;
use App\Models\User;
use Illuminate\Http\Request;

class LikesCommentController extends Controller
{
    public function likeToggle(Request $request, Comment $comment)
    {
        $userid = auth()->user()->id;
        $user = User::find($userid);
        
        $liked = $request->input('liked');

        if($liked == 'true'){
            
            $user->likescomments->where('comment_id', $comment->id)->each->delete();
            $asset = asset('img/not-liked.svg');
        } else{
            $user->likescomments()->create(['comment_id' => $comment->id]);
            $asset = asset('img/liked.svg');
        }
        $data = [
            "count" => count($comment->likes),
            "asset" => $asset
        ];
        return response()->json($data);
    }
}
