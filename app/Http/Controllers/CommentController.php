<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $post = $request->get('post');
        $post = Post::find($post);
        $comment = Comment::where('post_id', $post->id)->latest()->get();

        $sortedComments = $comment->sortByDesc(function($comment) {
            return $comment->likes->count();
        });

        $mostLikedComment = $sortedComments->first();

        $category = Type::whereNotIn('id', [1])->get();

        return view('comments.index', [
            'post' => $post,
            'comments' => $comment,
            'mostliked' => $mostLikedComment,
            'category' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $post = $request->get('post');
    
        $post = Post::find($post);
        
        if ($request->get('code') != ''){
            $codetype = $post->type_id == 1 ? $request->get("type_id") : $post->type_id;
            $code = $request->get('code');
        }
        else{
            info('vazio');
            $codetype = null;
            $code = null;
        }

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->comments()->create([
            'message' => $validated['message'],
            'code' => $code,
            'post_id' => $post->id,
            'type_id' => $codetype,
        ]);


        return redirect(route('comments.index', [
            'post' => $post
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment): View
    {
        $this->authorize('update', $comment);

        return view('comments.edit',[
            'comment' => $comment
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $comment->update($validated);

        $post = $comment->post;
        
        return redirect(route('comments.index', [
            'post' => $post
        ]));
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        $post = $comment->post;
        
        return redirect(route('comments.index', [
            'post' => $post
        ]));
    }
}
