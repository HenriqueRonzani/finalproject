<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Like;

class AtividadeController extends Controller
{   
    public function posts(): View
    {
        $userid = auth()->user()->id;

        return view('atividades.posts',[
            'posts' => Post::where('user_id', $userid)->latest()->get()
        ]);
    }

    public function likes(){
        $userid = auth()->user()->id;
        
        $likes = Like::where('user_id', $userid);

        $likesid = $likes->pluck('post_id')->toArray();

        $posts = Post::whereIn('id', $likesid)->get();

        return view('atividades.likes',[
            'posts' => $posts
        ]);
    }

    public function comments(){
        $userid = auth()->user()->id;

        $comments = Comment::where('user_id', $userid);

        $commentsid = $comments->pluck('post_id')->toArray();

        $posts = Post::whereIn('id', $commentsid)->get();

        return view('atividades.comments',[
            'posts' => $posts
        ]);
    }
}
