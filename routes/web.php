<?php

use App\Http\Controllers\AtividadeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified']);

Route::get('dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('posts', PostController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::resource('comments', CommentController::class)
    ->only(['index','store','edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::post('/like/liketoggle/{post}', [LikeController::class, 'likeToggle'])
    ->name('like.toggle')
    ->middleware(['auth', 'verified']);

});

Route::get('/atividades/posts', [AtividadeController::class, 'posts'])
    ->name('atividades.posts')
    ->middleware(['auth','verified']);

Route::get('/atividades/likes', [AtividadeController::class, 'likes'])
    ->name('atividades.likes')
    ->middleware(['auth','verified']);

Route::get('/atividades/comments', [AtividadeController::class, 'comments'])
    ->name('atividades.comments')
    ->middleware(['auth','verified']);

require __DIR__.'/auth.php';
