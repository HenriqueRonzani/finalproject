<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Rules\NoLinks;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Type;    
use App\Rules;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $category = Type::all();
        return view('posts.index', [
            'category' => $category
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
        $validated = $request->validate([
            'title' => ['required','string','max:30', new NoLinks],
            'message' => ['required','string'],
            'type_id' => 'required|integer|exists:types,id',
        ]);

        $request->user()->posts()->create($validated);

        return redirect(route('dashboard'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post):View
    {
        $this->authorize('update', $post);

        $category = Type::whereNotIn('id', [$post->type_id])->get();

        return view('posts.edit', [
            'post' => $post,
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:30',
            'message' => 'required|string',
            'type_id' => 'required|integer|exists:types,id',
        ]);

        $post->update($validated);

        return redirect(route('dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect(route('dashboard'));
    }



}
