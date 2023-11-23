<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Contracts\View\View;

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
        
        $likes = Like::where('user_id', $userid)->where('likable_type', 'App\Models\Post')->get();
        $likesid = $likes->pluck('likable_id')->toArray();
        $posts = Post::whereIn('id', $likesid)->get();

        $likescomments = Like::where('user_id', $userid)->where('likable_type', 'App\Models\Comment')->get();
        $likescomments = $likescomments->pluck('likable_id')->toArray();
        $comments = Comment::whereIn('id', $likescomments)->get();

        foreach ($comments as $comment){
            $posts = $posts->reject(function ($post) use ($comment) {
                return $post->id === $comment->post->id;
            });
        }

        $combined = $comments->concat($posts);
        
        $sortedcombined = $combined->SortByDesc('created_at');

        return view('atividades.likes',[
            'postsandcomments' => $sortedcombined,
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
