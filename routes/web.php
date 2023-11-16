<?php

use App\Http\Controllers\AtividadeController;
use App\Http\Controllers\DirectMessageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LikesCommentController;
use App\Http\Controllers\LikesPostController;
use App\Http\Controllers\UserController;
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




/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified']);

Route::get('dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Post Routes
|--------------------------------------------------------------------------
*/

Route::resource('posts', PostController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});

Route::post('profile/picture', [ProfileController::class, 'picture'])
    ->name('profile.picture')
    ->middleware(['auth', 'verified']);

Route::get('profile/picturedelete', [ProfileController::class, 'picdelete'])
    ->name('profile.picdelete')
    ->middleware(['auth', 'verified']);
    
Route::get('
admindelete/{user}', [ProfileController::class,'admindelete'])
    ->name('profile.admindelete')
    ->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/


Route::get('user/{user}', [UserController::class, 'show'])
    ->name('user.show')
    ->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| Comment Routes
|--------------------------------------------------------------------------
*/

Route::resource('comments', CommentController::class)
    ->only(['index','store','edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| Like Routes
|--------------------------------------------------------------------------
*/

Route::post('like/liketoggle/{post}', [LikesPostController::class, 'likeToggle'])
    ->name('like.toggle')
    ->middleware(['auth', 'verified']);

Route::post('like/likecomment/{comment}', [LikesCommentController::class, 'likeToggle'])
    ->name('like.comment')
    ->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| Atividades Routes
|--------------------------------------------------------------------------
*/

Route::get('atividades/posts', [AtividadeController::class, 'posts'])
    ->name('atividades.posts')
    ->middleware(['auth','verified']);

Route::get('atividades/likes', [AtividadeController::class, 'likes'])
    ->name('atividades.likes')
    ->middleware(['auth','verified']);

Route::get('atividades/comments', [AtividadeController::class, 'comments'])
    ->name('atividades.comments')
    ->middleware(['auth','verified']);

/*
|--------------------------------------------------------------------------
| DirectMessage Routes
|--------------------------------------------------------------------------
*/

Route::get('/directmessage/show', [DirectMessageController::class, 'show'])
    ->name('message.show')
    ->middleware(['auth','verified']);

Route::post('directmessage/send', [DirectMessageController::class, 'sendmessage'])
    ->name('message.send')
    ->middleware(['auth', 'verified']);

Route::get('directmessage/new', [DirectMessageController::class, 'newconversation'])
    ->name('message.new')
    ->middleware(['auth', 'verified']);

Route::get('directmessage/deletechat', [DirectMessageController::class, 'deleteconversation'])
    ->name('chat.delete')
    ->middleware(['auth', 'verified']);

    Route::resource('directmessage', DirectMessageController::class)
    ->only(['index'])
    ->middleware(['auth', 'verified']);


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('admin/page', [AdminController::class, 'index'])
    ->name('admin.index')
    ->middleware(['auth', 'verified']);

Route::get('admin/search', [AdminController::class,'search'])
    ->name('search.search')
    ->middleware(['auth', 'verified']);

Route::get('admin/ban', [AdminController::class,'ban'])
    ->name('admin.ban')
    ->middleware(['auth', 'verified']);


    
require __DIR__.'/auth.php';
