<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function likeToggle(Request $request, Post $post)
    {
        $user = $request->user();
        $liked = $request->input('liked');
    
        if($liked == 'true'){
            $like = $user->likes->where('post_id', $post->id);
            $like->each(function ($item) {
            $item->delete();
            });     
        } else{
            $user->likes()->create(['post_id' => $post->id]);
        }
       
        return back();
    }
}
