<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function likeToggle(Request $request, Post $post)
    {
        $userid = auth()->user()->id;
        $user = User::find($userid);
        
        $liked = $request->input('liked');

        if($liked == 'true'){
            $user->likes->where('post_id', $post->id)->each->delete();
            $asset = asset('img/not-liked.svg');
        } else{
            $user->likes()->create(['post_id' => $post->id]);
            $asset = asset('img/liked.svg');
        }

        $data = [
            "count" => count($post->likes),
            "asset" => $asset
        ];
        

        return response()->json($data);
    }
}
 