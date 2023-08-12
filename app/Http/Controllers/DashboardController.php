<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class DashboardController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard', [
            'posts' => Post::with('user')->latest()->get()
        ]);
    }
}
